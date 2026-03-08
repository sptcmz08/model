<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TrackingNumberMail;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with('items')->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Search by order number or customer
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function invoices(Request $request): View
    {
        $query = Order::with('items')->where('payment_method', 'invoice')->latest();

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%")
                    ->orWhere('invoice_email', 'like', "%{$search}%");
            });
        }

        $invoices = $query->paginate(20)->withQueryString();

        // Stats
        $stats = [
            'total' => Order::where('payment_method', 'invoice')->count(),
            'waiting' => Order::where('payment_method', 'invoice')->where('payment_status', 'waiting_invoice')->count(),
            'paid' => Order::where('payment_method', 'invoice')->where('payment_status', 'completed')->count(),
        ];

        return view('admin.invoices.index', compact('invoices', 'stats'));
    }

    public function show(Order $order): View
    {
        $order->load('items');
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'tracking_number' => 'nullable|string|max:255',
        ]);

        $oldTracking = $order->tracking_number;
        $newTracking = $validated['tracking_number'];
        $isCorrection = !empty($oldTracking) && !empty($newTracking) && $oldTracking !== $newTracking;

        $updateData = ['tracking_number' => $newTracking];

        if (!empty($newTracking)) {
            $updateData['status'] = 'shipped';
        }

        $order->update($updateData);

        // Send email notification
        if (!empty($newTracking) && $order->customer_email) {
            try {
                if ($isCorrection) {
                    // Send correction email with apology
                    Mail::to($order->customer_email)->send(new \App\Mail\TrackingCorrectionMail($order, $oldTracking));
                    return redirect()->route('admin.orders.show', $order)
                        ->with('success', 'Tracking number updated and correction email sent!');
                } else {
                    // Send regular tracking email
                    Mail::to($order->customer_email)->send(new TrackingNumberMail($order));
                    return redirect()->route('admin.orders.show', $order)
                        ->with('success', 'Data saved and email notification sent to customer!');
                }
            } catch (\Exception $e) {
                return redirect()->route('admin.orders.show', $order)
                    ->with('warning', 'Data saved but failed to send email: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Data saved successfully.');
    }

    public function confirmPayment(Order $order): RedirectResponse
    {
        // Load order items with products
        $order->load('items');

        // Reduce stock for each item
        foreach ($order->items as $item) {
            if ($item->product_id) {
                $product = \App\Models\Product::find($item->product_id);
                if ($product && $product->stock >= $item->quantity) {
                    $product->decrement('stock', $item->quantity);
                }
            }
        }

        $order->update([
            'payment_status' => 'completed',
            'status' => 'processing',
        ]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Payment confirmed and stock reduced successfully!');
    }

    public function sendNote(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'note' => 'required|string|max:1000',
        ]);

        // Save note to order
        $order->update(['admin_note' => $validated['note']]);

        try {
            Mail::to($order->customer_email)->send(new \App\Mail\OrderNoteMail($order, $validated['note']));
            return redirect()->route('admin.orders.show', $order)
                ->with('success', 'Note sent to customer email successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.orders.show', $order)
                ->with('warning', 'Note saved but failed to send email: ' . $e->getMessage());
        }
    }

    public function printReceipt(Order $order)
    {
        $order->load('items');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.orders.receipt', compact('order'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream("receipt-{$order->order_number}.pdf");
    }

    public function invoiceShow(Order $order): View
    {
        $order->load('items');
        return view('admin.invoices.show', compact('order'));
    }

    public function sendInvoice(Request $request, Order $order): RedirectResponse
    {
        $note = $request->input('invoice_note');

        // Save note if provided
        if ($note) {
            $order->update(['admin_note' => $note]);
        }

        $targetEmail = $order->invoice_email ?? $order->customer_email;

        try {
            Mail::to($targetEmail)->send(new \App\Mail\InvoiceMail($order, $note));

            // Update status from waiting_invoice to pending
            if ($order->payment_status === 'waiting_invoice') {
                $order->update(['payment_status' => 'pending']);
            }

            return redirect()->route('admin.invoices.show', $order)
                ->with('success', 'Invoice sent to ' . $targetEmail . ' successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.invoices.show', $order)
                ->with('warning', 'Failed to send invoice email: ' . $e->getMessage());
        }
    }
}
