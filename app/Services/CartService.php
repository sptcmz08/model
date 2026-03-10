<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    private const CART_KEY = 'shopping_cart';

    public function getCart(): array
    {
        return Session::get(self::CART_KEY, []);
    }

    public function add(Product $product, int $quantity = 1, array $attributes = []): void
    {
        $cart = $this->getCart();

        // Generate a unique cart key based on product ID + variant
        $variant = $attributes['variant'] ?? null;
        $cartKey = $variant ? $product->id . '_' . $variant : (string) $product->id;

        // Check stock availability
        $currentQty = isset($cart[$cartKey]) ? $cart[$cartKey]['quantity'] : 0;
        $requestedQty = $currentQty + $quantity;

        if ($requestedQty > $product->stock) {
            $requestedQty = $product->stock; // Cap at available stock
        }

        if ($requestedQty <= 0) {
            return; // No stock available
        }

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] = $requestedQty;
        } else {
            $cart[$cartKey] = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->price,
                'shipping_cost' => $product->shipping_cost ?? 0,
                'image' => $product->main_image,
                'quantity' => $requestedQty,
                'attributes' => $attributes,
            ];
        }

        Session::put(self::CART_KEY, $cart);
    }

    public function update(int $productId, int $quantity): void
    {
        $cart = $this->getCart();

        // Search for matching cart key (could be productId or productId_variant)
        $matchingKey = null;
        foreach ($cart as $key => $item) {
            if ($item['id'] == $productId) {
                $matchingKey = $key;
                break;
            }
        }

        if ($matchingKey !== null) {
            if ($quantity <= 0) {
                unset($cart[$matchingKey]);
            } else {
                // Check stock
                $product = Product::find($productId);
                if ($product && $quantity > $product->stock) {
                    $quantity = $product->stock;
                }
                $cart[$matchingKey]['quantity'] = $quantity;
            }
            Session::put(self::CART_KEY, $cart);
        }
    }

    public function remove(int $productId): void
    {
        $cart = $this->getCart();

        // Search for matching cart key
        foreach ($cart as $key => $item) {
            if ($item['id'] == $productId) {
                unset($cart[$key]);
                break;
            }
        }

        Session::put(self::CART_KEY, $cart);
    }

    public function clear(): void
    {
        Session::forget(self::CART_KEY);
    }

    public function getSubtotal(): float
    {
        $cart = $this->getCart();
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }

    public function getShippingTotal(): float
    {
        $cart = $this->getCart();
        $shipping = 0;

        foreach ($cart as $item) {
            $shipping += ($item['shipping_cost'] ?? 0) * $item['quantity'];
        }

        return $shipping;
    }

    public function getTotal(): float
    {
        // Shipping is calculated at checkout via region-based ShippingRate,
        // so cart total should only reflect subtotal (product prices).
        return $this->getSubtotal();
    }

    public function getItemCount(): int
    {
        $cart = $this->getCart();
        $count = 0;

        foreach ($cart as $item) {
            $count += $item['quantity'];
        }

        return $count;
    }

    public function getItems(): array
    {
        return array_values($this->getCart());
    }
}
