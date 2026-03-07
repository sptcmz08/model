<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(private CartService $cartService)
    {
    }

    public function index(): View
    {
        $items = $this->cartService->getItems();
        $subtotal = $this->cartService->getSubtotal();
        $shippingTotal = $this->cartService->getShippingTotal();
        $total = $this->cartService->getTotal();

        return view('cart.index', compact('items', 'subtotal', 'shippingTotal', 'total'));
    }

    public function add(Request $request, int $productId): JsonResponse|RedirectResponse
    {
        $product = Product::findOrFail($productId);
        $quantity = max(1, (int) $request->get('quantity', 1));

        // Ensure variant is passed to the service if needed
        // For now, valid logic assumes the service handles it or ignores it if not implemented
        $attributes = [];
        if ($request->has('variant')) {
            $attributes['variant'] = $request->get('variant');
        }

        $this->cartService->add($product, $quantity, $attributes);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cart_count' => $this->cartService->getItemCount(),
                'cart_total' => number_format($this->cartService->getTotal(), 2),
                'product_name' => $product->name,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, int $productId): JsonResponse|RedirectResponse
    {
        $quantity = max(0, (int) $request->get('quantity', 1));

        $this->cartService->update($productId, $quantity);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated!',
                'cart_count' => $this->cartService->getItemCount(),
                'cart_total' => number_format($this->cartService->getTotal(), 2),
            ]);
        }

        return redirect()->back()->with('success', 'Cart updated!');
    }

    public function remove(int $productId): JsonResponse|RedirectResponse
    {
        $this->cartService->remove($productId);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product removed from cart!',
                'cart_count' => $this->cartService->getItemCount(),
                'cart_total' => number_format($this->cartService->getTotal(), 2),
            ]);
        }

        return redirect()->back()->with('success', 'Product removed from cart!');
    }
}
