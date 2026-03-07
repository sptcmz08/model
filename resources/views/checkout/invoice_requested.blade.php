@extends('layouts.app')

@section('title', 'Invoice Requested')

@section('content')
    <section class="success-section" style="padding: 8rem 0; text-align: center;">
        <div class="container">
            <div class="success-icon" style="font-size: 5rem; color: #E60914; margin-bottom: 2rem;">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>

            <h1
                style="font-family: 'Inter', sans-serif; font-size: 2.5rem; font-weight: 700; color: #111; margin-bottom: 1rem; text-transform: uppercase;">
                Invoice Requested!</h1>
            <p
                style="color: var(--text-secondary); font-size: 1.2rem; margin-bottom: 3rem; max-width: 600px; margin-left: auto; margin-right: auto; line-height: 1.6;">
                We will send a PayPal invoice to <strong style="color: #111;">{{ $order->invoice_email }}</strong>.
                Please check your email and complete the payment. After paying, you can upload your receipt.
            </p>

            <div class="order-summary-box"
                style="max-width: 500px; margin: 0 auto 3rem; background: var(--secondary-dark); padding: 2rem; border: 1px solid var(--border-color); border-radius: 10px; text-align: left;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                    <span style="color: var(--text-muted);">Order Number:</span>
                    <span style="color: #111; font-weight: 600;">#{{ $order->order_number }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                    <span style="color: var(--text-muted);">Status:</span>
                    <span style="color: #E60914; font-weight: 600;"><i class="fas fa-file-invoice"></i> Waiting for
                        Invoice</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                    <span style="color: var(--text-muted);">Invoice Email:</span>
                    <span style="color: #111; font-weight: 600;">{{ $order->invoice_email }}</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-muted);">Total:</span>
                    <span style="color: var(--brand-red); font-weight: 600;">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            <!-- Upload Receipt Section -->
            <div
                style="max-width: 500px; margin: 0 auto 3rem; background: #fff; padding: 2rem; border: 1px solid rgba(0,0,0,0.1); border-radius: 10px; text-align: left;">
                <h3
                    style="font-family: 'Inter', sans-serif; font-weight: 700; color: #111; margin-bottom: 1rem; font-size: 1rem; text-transform: uppercase;">
                    <i class="fas fa-upload" style="color: var(--brand-red); margin-right: 0.5rem;"></i> Already Paid?
                    Upload Receipt
                </h3>
                <form action="{{ route('checkout.submit-slip', $order->order_number) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="payment_slip" accept="image/*" required
                        style="width: 100%; padding: 0.75rem; border: 1px solid rgba(0,0,0,0.1); border-radius: 8px; margin-bottom: 1rem; font-family: 'Inter', sans-serif;">
                    <button type="submit" class="btn btn-primary"
                        style="width: 100%; padding: 1rem; font-weight: 700; text-transform: uppercase; background: var(--brand-red); color: #fff; border: none; border-radius: 8px; cursor: pointer;">
                        <i class="fas fa-check"></i> Submit Receipt
                    </button>
                </form>
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