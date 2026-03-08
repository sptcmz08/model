@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
    <!-- Hero Banner -->
    <section class="page-hero-sm">
        <div class="page-hero-content">
            <h1>Shopping Cart</h1>
            <p>Review your items before checkout</p>
        </div>
    </section>

    <!-- Cart Section -->
    <section class="cart-section">
        <div class="container">
            @if(count($items) > 0)
                <div class="cart-grid">
                    <!-- Cart Items -->
                    <div class="cart-items">
                        <div class="cart-header">
                            <span class="col-product">Product</span>
                            <span class="col-price">Price</span>
                            <span class="col-quantity">Qty</span>
                            <span class="col-total">Total</span>
                            <span class="col-action"></span>
                        </div>

                        @foreach($items as $item)
                            <div class="cart-item" id="cart-item-{{ $item['id'] }}">
                                <div class="item-product">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                                    <div class="item-details">
                                        <h3><a href="{{ route('products.show', $item['slug']) }}">{{ $item['name'] }}</a></h3>
                                        @if(isset($item['attributes']['variant']))
                                            <span class="variant-label">Variant: {{ $item['attributes']['variant'] }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="item-price">${{ number_format($item['price'], 2) }}</div>
                                <div class="item-quantity">
                                    <div class="qty-control">
                                        <button onclick="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] - 1 }})" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>-</button>
                                        <span>{{ $item['quantity'] }}</span>
                                        <button onclick="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})">+</button>
                                    </div>
                                </div>
                                <div class="item-total">${{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                                <div class="item-action">
                                    <button class="remove-btn" onclick="removeItem({{ $item['id'] }})">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Cart Summary -->
                    <div class="cart-summary glass">
                        <h2>Order Summary</h2>

                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span id="cart-subtotal">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping</span>
                            <span style="color: var(--text-muted); font-size: 0.85rem; font-style: italic;">Calculated at
                                checkout</span>
                        </div>
                        <div class="summary-divider"></div>
                        <div class="summary-row total">
                            <span>Subtotal</span>
                            <span id="cart-total">${{ number_format($subtotal, 2) }}</span>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="btn btn-primary checkout-btn">
                            <i class="fas fa-lock"></i> Proceed to Checkout
                        </a>

                        <a href="{{ route('products.index') }}" class="continue-shopping">
                            <i class="fas fa-arrow-left"></i> Continue Shopping
                        </a>

                        <div class="payment-methods">
                            <p>Secure payment with</p>
                            <div class="payment-icons">
                                <i class="fab fa-paypal"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-cart">
                    <div class="empty-cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h2>Your Cart is Empty</h2>
                    <p>You have no items in your shopping cart</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-bag"></i> Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .page-hero-sm {
            height: 25vh;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: var(--secondary-dark);
        }

        .page-hero-sm .page-hero-content h1 {
            font-family: 'Inter', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: #111;
            margin-bottom: 0.5rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .page-hero-sm .page-hero-content p {
            color: var(--text-secondary);
            font-family: 'Inter', sans-serif;
        }

        .cart-section {
            padding: 4rem 2rem;
        }

        .cart-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 3rem;
            align-items: start;
        }

        .cart-header {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 50px;
            gap: 1rem;
            padding: 1rem 1.5rem;
            background: var(--secondary-dark);
            border: 1px solid var(--border-color);
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .cart-item {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 50px;
            gap: 1rem;
            align-items: center;
            padding: 1.5rem;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-top: none;
        }

        .item-product {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .item-product img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border: 1px solid var(--border-color);
        }

        .item-details h3 {
            font-size: 1rem;
            margin-bottom: 0.25rem;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            text-transform: uppercase;
        }

        .item-details h3 a {
            color: var(--text-primary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .item-details h3 a:hover {
            color: var(--brand-red);
        }

        .variant-label {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .item-price,
        .item-total {
            font-weight: 600;
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
        }

        .qty-control {
            display: inline-flex;
            align-items: center;
            border: 1px solid var(--border-color);
        }

        .qty-control button {
            width: 30px;
            height: 30px;
            background: var(--secondary-dark);
            border: none;
            color: var(--text-primary);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .qty-control button:hover:not(:disabled) {
            background: var(--brand-red);
            color: #fff;
        }

        .qty-control button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .qty-control span {
            width: 35px;
            text-align: center;
            font-weight: 600;
            font-size: 0.9rem;
            background: #fff;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .remove-btn {
            width: 35px;
            height: 35px;
            border: 1px solid var(--border-color);
            background: transparent;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .remove-btn:hover {
            background: var(--brand-red);
            color: white;
            border-color: var(--brand-red);
        }

        .cart-summary {
            padding: 2rem;
            background: var(--secondary-dark);
            border: 1px solid var(--border-color);
            position: sticky;
            top: 100px;
        }

        .cart-summary h2 {
            font-family: 'Inter', sans-serif;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #111;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            color: var(--text-secondary);
            font-family: 'Inter', sans-serif;
        }

        .summary-divider {
            height: 1px;
            background: var(--border-color);
            margin: 2rem 0;
        }

        .summary-row.total {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            padding-top: 0.5rem;
        }

        .summary-row.total span:last-child {
            color: var(--brand-red);
        }

        .free-shipping {
            color: #22c55e;
            font-weight: 600;
        }

        .checkout-btn {
            width: 100%;
            margin-top: 1rem;
            background: var(--brand-red);
            color: #fff;
            padding: 1.2rem;
            text-align: center;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 1.1rem;
            transition: background 0.3s ease;
        }

        .checkout-btn:hover {
            background: #cc0812;
        }

        .continue-shopping {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .continue-shopping:hover {
            color: var(--brand-red);
        }

        .payment-methods {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
            text-align: center;
        }

        .payment-methods p {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-bottom: 0.75rem;
        }

        .payment-icons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            font-size: 2rem;
            color: var(--text-secondary);
        }

        .empty-cart {
            text-align: center;
            padding: 6rem 2rem;
        }

        .empty-cart-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 2rem;
            background: rgba(0, 0, 0, 0.05);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: var(--brand-red);
        }

        .empty-cart h2 {
            font-family: 'Inter', sans-serif;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #111;
            text-transform: uppercase;
        }

        .empty-cart p {
            color: var(--text-secondary);
            margin-bottom: 2rem;
        }

        @media (max-width: 1200px) {
            .cart-grid {
                grid-template-columns: 1fr;
            }

            .cart-summary {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .cart-header {
                display: none;
            }

            .cart-item {
                grid-template-columns: 1fr;
                gap: 1rem;
                position: relative;
            }

            .item-action {
                position: absolute;
                top: 1rem;
                right: 1rem;
            }

            .item-product {
                flex-direction: column;
                text-align: center;
                align-items: center;
            }

            .item-details {
                text-align: center;
            }

            .item-price::before {
                content: 'Price: ';
                color: var(--text-muted);
            }

            .item-total::before {
                content: 'Total: ';
                color: var(--text-muted);
            }

            .item-quantity,
            .item-total {
                display: flex;
                justify-content: center;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        function updateQuantity(productId, quantity) {
            if (quantity < 1) return;

            // Show loading state (optional)
            Swal.fire({
                title: 'Updating...',
                didOpen: () => {
                    Swal.showLoading()
                },
                background: '#fff',
                color: '#111',
                allowOutsideClick: false,
                showConfirmButton: false
            });

            fetch(`/cart/update/${productId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ quantity: quantity })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Could not update cart',
                            background: '#111',
                            color: '#fff'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong',
                        background: '#111',
                        color: '#fff'
                    });
                });
        }

        function removeItem(productId) {
            Swal.fire({
                title: 'Remove Item?',
                text: "Are you sure you want to remove this item from your cart?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#E60914',
                cancelButtonColor: '#333',
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel',
                background: '#fff',
                color: '#111'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/cart/remove/${productId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Removed!',
                                    text: 'Item has been removed from your cart',
                                    icon: 'success',
                                    background: '#111',
                                    color: '#fff',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        });
                }
            })
        }
    </script>
@endpush