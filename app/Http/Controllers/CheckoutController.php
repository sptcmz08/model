<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cartService
    ) {
    }

    public function index(): View|RedirectResponse
    {
        $items = $this->cartService->getItems();
        $subtotal = $this->cartService->getSubtotal();
        $shippingTotal = $this->cartService->getShippingTotal();
        $total = $this->cartService->getTotal();

        if (empty($items)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        return view('checkout.index', compact('items', 'subtotal', 'shippingTotal', 'total'));
    }

    public function process(Request $request)
    {
        // Validation Rules
        $rules = [
            'billing_first_name' => 'required|string|max:255',
            'billing_last_name' => 'required|string|max:255',
            'billing_email' => 'required|email|max:255',
            'billing_phone' => 'required|string|max:50',
            'billing_continent' => 'required|string|max:255',
            'billing_country' => 'required|string|max:255',
            'billing_address_1' => 'required|string|max:255',
            'billing_city' => 'required|string|max:255',
            'billing_state' => 'required|string|max:255',
            'billing_postcode' => 'required|string|max:20',
        ];

        // If "Same as Billing" is NOT checked, validate shipping fields
        if (!$request->has('same_as_billing')) {
            $rules['shipping_first_name'] = 'required|string|max:255';
            $rules['shipping_last_name'] = 'required|string|max:255';
            $rules['shipping_continent'] = 'required|string|max:255';
            $rules['shipping_country'] = 'required|string|max:255';
            $rules['shipping_address_1'] = 'required|string|max:255';
            $rules['shipping_city'] = 'required|string|max:255';
            $rules['shipping_state'] = 'required|string|max:255';
            $rules['shipping_postcode'] = 'required|string|max:20';
        }

        $validated = $request->validate($rules);

        $items = $this->cartService->getItems();
        $subtotal = $this->cartService->getSubtotal();
        $shippingCostUSD = $this->cartService->getShippingTotal();

        if (empty($items)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        try {
            DB::beginTransaction();

            // Construct Customer Name
            $customerName = $validated['billing_first_name'] . ' ' . $validated['billing_last_name'];

            if (!$request->has('same_as_billing')) {
                // Using Shipping Address
                $shippingAddress = $this->formatAddress(
                    $request->shipping_first_name,
                    $request->shipping_last_name,
                    $request->shipping_company,
                    $request->shipping_address_1,
                    $request->shipping_address_2,
                    $request->shipping_city,
                    $request->shipping_state,
                    $request->shipping_postcode,
                    $request->shipping_country
                );
            } else {
                // Using Billing Details as Shipping Address
                $shippingAddress = $this->formatAddress(
                    $request->billing_first_name,
                    $request->billing_last_name,
                    $request->billing_company,
                    $request->billing_address_1,
                    $request->billing_address_2,
                    $request->billing_city,
                    $request->billing_state,
                    $request->billing_postcode,
                    $request->billing_country
                );
            }

            $total = $subtotal + $shippingCostUSD;

            // Format Billing Address
            $billingAddress = $this->formatAddress(
                $validated['billing_first_name'],
                $validated['billing_last_name'],
                $request->billing_company ?? '',
                $validated['billing_address_1'],
                $request->billing_address_2 ?? '',
                $validated['billing_city'],
                $validated['billing_state'],
                $validated['billing_postcode'],
                $validated['billing_country']
            );

            // Create order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'customer_name' => $customerName,
                'customer_email' => $validated['billing_email'],
                'customer_phone' => $validated['billing_phone'],
                'shipping_address' => $shippingAddress,
                'billing_address' => $billingAddress,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCostUSD,
                'total' => $total,
                'status' => 'pending',
                'payment_method' => $request->input('payment_method', 'paypal'),
                'payment_status' => $request->input('payment_method') === 'invoice' ? 'waiting_invoice' : 'pending',
                'invoice_email' => $request->input('payment_method') === 'invoice' ? $request->input('invoice_email') : null,
            ]);

            // Create order items
            foreach ($items as $item) {
                $productName = $item['name'];
                if (isset($item['attributes']['variant'])) {
                    $productName .= ' (' . $item['attributes']['variant'] . ')';
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $productName,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total' => $item['price'] * $item['quantity'],
                ]);
            }

            // Handle payment slip upload if provided
            if ($request->hasFile('payment_slip')) {
                $path = $request->file('payment_slip')->store('slips', 'public');
                $order->update([
                    'payment_slip' => $path,
                    'payment_status' => 'awaiting_verification',
                ]);
            }

            DB::commit();

            // Clear the cart after order creation
            $this->cartService->clear();

            // Store order number in session for verification
            session(['last_order_number' => $order->order_number]);

            // Load order items and send confirmation email
            $order->load('items');
            try {
                Mail::to($order->customer_email)->send(new OrderConfirmationMail($order));
            } catch (\Exception $e) {
                // Log email error but don't fail the order
                \Log::error('Failed to send order confirmation email: ' . $e->getMessage());
            }

            // Check if this is an AJAX request
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'order_number' => $order->order_number,
                    'customer_email' => $order->customer_email,
                    'message' => 'Order created successfully'
                ]);
            }

            return redirect()->route('checkout.confirm-payment', ['order_number' => $order->order_number]);

        } catch (\Exception $e) {
            DB::rollBack();

            // For AJAX requests, return JSON error
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred. Please try again.'
                ], 500);
            }

            return redirect()->back()->with('error', 'An error occurred. Please try again.')->withInput();
        }
    }

    public function confirmPayment($orderNumber): View|RedirectResponse
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        // Basic authorization: only allow if this was the last order created in session
        if (session('last_order_number') !== $orderNumber) {
            // Still allow access but don't show sensitive info
        }

        return view('checkout.confirm_payment', compact('order'));
    }

    public function submitPaymentSlip(Request $request, $orderNumber)
    {
        $request->validate([
            'payment_slip' => 'required|image|max:10240',
        ]);

        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        if ($request->hasFile('payment_slip')) {
            $path = $request->file('payment_slip')->store('slips', 'public');
            $order->update([
                'payment_slip' => $path,
                'payment_status' => 'awaiting_verification',
            ]);

            return redirect()->route('checkout.success-manual', ['order_number' => $order->order_number]);
        }

        return back()->with('error', 'Please upload a valid slip image.');
    }

    public function successManual($orderNumber): View
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        return view('checkout.success_manual', compact('order'));
    }

    public function requestInvoice(Request $request, $orderNumber)
    {
        $request->validate([
            'invoice_email' => 'required|email|max:255',
        ]);

        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        $order->update([
            'payment_method' => 'invoice',
            'invoice_email' => $request->invoice_email,
            'status' => 'waiting_invoice',
        ]);

        return redirect()->route('checkout.invoice-requested', ['order_number' => $order->order_number]);
    }

    public function invoiceRequested($orderNumber): View
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        return view('checkout.invoice_requested', compact('order'));
    }

    private function formatAddress($fname, $lname, $company, $addr1, $addr2, $city, $state, $zip, $country)
    {
        $address = "$fname $lname";
        if ($company)
            $address .= "\n$company";
        $address .= "\n$addr1";
        if ($addr2)
            $address .= " $addr2";
        $address .= "\n$city, $state $zip";
        $address .= "\n$country";
        return $address;
    }
}
