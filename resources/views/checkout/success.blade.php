@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('content')
    <section class="success-section">
        <div class="container">
            <div class="success-card glass">
                <div class="success-icon">
                    <i class="fas fa-check"></i>
                </div>
                <h1>Thank You for Your Order!</h1>
                <p class="success-message">Your payment was successful and your order has been confirmed.</p>

                <div class="order-details">
                    <div class="detail-row">
                        <span>Order Number</span>
                        <strong>{{ $order->order_number }}</strong>
                    </div>
                    <div class="detail-row">
                        <span>Email</span>
                        <strong>{{ $order->customer_email }}</strong>
                    </div>
                    <div class="detail-row">
                        <span>Total Amount</span>
                        <strong class="gold">${{ number_format($order->total, 2) }} USD</strong>
                    </div>
                    <div class="detail-row">
                        <span>Payment Status</span>
                        <strong class="status-paid"><i class="fas fa-check-circle"></i> Paid</strong>
                    </div>
                </div>

                <div class="order-items-summary">
                    <h3>Order Items</h3>
                    @foreach($order->items as $item)
                        <div class="item-row">
                            <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                            <span>${{ number_format($item->total, 2) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="shipping-info-summary">
                    <h3>Shipping To</h3>
                    <p>{{ $order->customer_name }}</p>
                    <p>{{ $order->shipping_address }}</p>
                    @if($order->customer_phone)
                        <p>{{ $order->customer_phone }}</p>
                    @endif
                </div>

                <div class="next-steps">
                    <h3>What's Next?</h3>
                    <ul>
                        <li><i class="fas fa-envelope"></i> A confirmation email has been sent to
                            {{ $order->customer_email }}</li>
                        <li><i class="fas fa-box"></i> We will process your order within 1-2 business days</li>
                        <li><i class="fas fa-shipping-fast"></i> You will receive tracking information once your order ships
                        </li>
                    </ul>
                </div>

                <a href="{{ route('products.index') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-bag"></i> Continue Shopping
                </a>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .success-section {
            padding: 6rem 0;
            min-height: calc(100vh - 80px);
            display: flex;
            align-items: center;
        }

        .success-card {
            max-width: 600px;
            margin: 0 auto;
            padding: 3rem;
            border-radius: 20px;
            text-align: center;
        }

        .success-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
            animation: scaleIn 0.5s ease;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
            }

            to {
                transform: scale(1);
            }
        }

        .success-card h1 {
            font-family: 'Inter', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #111;
        }

        .success-message {
            color: var(--text-secondary);
            margin-bottom: 2rem;
        }

        .order-details {
            background: var(--secondary-dark);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-row span {
            color: var(--text-muted);
        }

        .detail-row .gold {
            color: var(--brand-red);
        }

        .detail-row .status-paid {
            color: #22c55e;
        }

        .order-items-summary,
        .shipping-info-summary,
        .next-steps {
            text-align: left;
            margin-bottom: 2rem;
        }

        .order-items-summary h3,
        .shipping-info-summary h3,
        .next-steps h3 {
            font-size: 1rem;
            color: var(--brand-red);
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            color: var(--text-secondary);
        }

        .shipping-info-summary p {
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .next-steps ul {
            list-style: none;
        }

        .next-steps li {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 0;
            color: var(--text-secondary);
        }

        .next-steps li i {
            color: var(--brand-red);
            width: 20px;
        }
    </style>
@endpush