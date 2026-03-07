@extends('layouts.app')

@section('title', 'Step Received')

@section('content')
    <section class="success-section" style="padding: 8rem 0; text-align: center;">
        <div class="container">
            <div class="success-icon" style="font-size: 5rem; color: #22c55e; margin-bottom: 2rem;">
                <i class="fas fa-check-circle"></i>
            </div>

            <h1
                style="font-family: 'Inter', sans-serif; font-size: 2.5rem; font-weight: 700; color: #111; margin-bottom: 1rem; text-transform: uppercase;">
                Receipt Submitted!</h1>
            <p
                style="color: var(--text-secondary); font-size: 1.2rem; margin-bottom: 3rem; max-width: 600px; margin-left: auto; margin-right: auto;">
                Thank you! We have received your payment receipt for Order **#{{ $order->order_number }}**.
                Our admin team will verify it within 12-24 hours.
            </p>

            <div class="order-summary-box"
                style="max-width: 500px; margin: 0 auto 3rem; background: var(--secondary-dark); padding: 2rem; border: 1px solid var(--border-color); border-radius: 10px; text-align: left;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                    <span style="color: var(--text-muted);">Order Number:</span>
                    <span style="color: #111; font-weight: 600;">#{{ $order->order_number }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                    <span style="color: var(--text-muted);">Status:</span>
                    <span style="color: var(--brand-red); font-weight: 600;">Awaiting Verification</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-muted);">Total:</span>
                    <span style="color: #111; font-weight: 600;">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="{{ route('products.index') }}" class="btn btn-outline" style="padding: 1rem 2rem;">
                    Continue Shopping
                </a>
                <a href="{{ route('home') }}" class="btn btn-primary" style="padding: 1rem 2rem;">
                    Back to Home
                </a>
            </div>
        </div>
    </section>
@endsection