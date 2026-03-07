@extends('layouts.app')

@section('title', 'Confirm Payment')

@section('content')
    <section class="page-hero-sm">
        <div class="page-hero-content">
            <h1>Confirm Payment</h1>
            <p>Order #{{ $order->order_number }}</p>
        </div>
    </section>

    <section class="confirm-payment-section" style="padding: 4rem 0;">
        <div class="container" style="max-width: 800px;">

            <!-- Payment Method Tabs -->
            <div class="payment-tabs" style="display: flex; gap: 0; margin-bottom: 0;">
                <button class="payment-tab active" onclick="switchTab('direct')" id="tab-direct"
                    style="flex: 1; padding: 1.2rem; border: 1px solid rgba(0,0,0,0.1); border-bottom: none; background: #fff; cursor: pointer; font-family: 'Inter', sans-serif; font-weight: 700; font-size: 1rem; color: #111; text-transform: uppercase; letter-spacing: 0.5px; border-radius: 12px 12px 0 0; transition: all 0.3s;">
                    <i class="fab fa-paypal" style="margin-right: 0.5rem;"></i> Transfer Directly
                </button>
                <button class="payment-tab" onclick="switchTab('invoice')" id="tab-invoice"
                    style="flex: 1; padding: 1.2rem; border: 1px solid rgba(0,0,0,0.1); border-bottom: none; background: #f5f5f5; cursor: pointer; font-family: 'Inter', sans-serif; font-weight: 700; font-size: 1rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px; border-radius: 12px 12px 0 0; transition: all 0.3s;">
                    <i class="fas fa-file-invoice" style="margin-right: 0.5rem;"></i> Request Invoice
                </button>
            </div>

            <!-- Tab 1: Direct Transfer -->
            <div id="panel-direct" class="payment-panel"
                style="background: #fff; padding: 3rem; border: 1px solid rgba(0,0,0,0.1); border-radius: 0 0 15px 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                <div class="payment-steps" style="margin-bottom: 3rem;">
                    <h2
                        style="font-family: 'Inter', sans-serif; font-weight: 700; color: #111; margin-bottom: 1.5rem; text-transform: uppercase;">
                        1. Payment Instructions</h2>
                    <p style="color: var(--text-secondary); margin-bottom: 1rem;">Please transfer the total amount to our
                        PayPal account:</p>

                    <div class="paypal-info"
                        style="background: var(--secondary-dark); padding: 2rem; border-radius: 10px; border-left: 4px solid var(--brand-red); margin-bottom: 1.5rem;">
                        <div style="margin-bottom: 1rem;">
                            <span style="color: var(--text-muted); display: block; font-size: 0.9rem;">PayPal Email:</span>
                            <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                                <strong id="paypalEmail"
                                    style="font-size: 1.3rem; color: #111;">nattawutkongyod@hotmail.com</strong>
                                <button onclick="copyPayPalEmail()"
                                    style="background: var(--brand-red); color: #fff; border: none; padding: 0.4rem 1rem; border-radius: 4px; cursor: pointer; font-size: 0.85rem; font-weight: 600; transition: transform 0.2s;"
                                    onmouseover="this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.transform='scale(1)'">
                                    <i class="fas fa-copy"></i> Copy
                                </button>
                            </div>
                        </div>
                        <div>
                            <span style="color: var(--text-muted); display: block; font-size: 0.9rem;">Amount Due:</span>
                            <strong
                                style="font-size: 2rem; color: var(--brand-red);">${{ number_format($order->total, 2) }}</strong>
                        </div>
                    </div>

                    <!-- PayPal Important Note -->
                    <div
                        style="background: #FFF8E1; padding: 1rem 1.25rem; border-radius: 8px; border-left: 4px solid #FFC107; margin-bottom: 1.5rem;">
                        <p style="color: #795600; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.25rem;"><i
                                class="fas fa-exclamation-triangle"></i> Important Note</p>
                        <p style="color: #795600; font-size: 0.9rem; line-height: 1.5;">Please select <strong>"Goods and
                                Services"</strong> as PayPal Thailand only supports this service.</p>
                    </div>

                    <div class="alert-info"
                        style="background: rgba(230, 9, 20, 0.05); padding: 1rem; border-radius: 5px; color: var(--brand-red); font-size: 0.9rem;">
                        <i class="fas fa-info-circle"></i> After payment, please take a screenshot or photo of your receipt.
                    </div>
                </div>

                <div class="upload-section">
                    <h2
                        style="font-family: 'Inter', sans-serif; font-weight: 700; color: #111; margin-bottom: 1.5rem; text-transform: uppercase;">
                        2. Upload Receipt</h2>

                    <form action="{{ route('checkout.submit-slip', $order->order_number) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group" style="margin-bottom: 2rem;">
                            <label for="payment_slip"
                                style="display: block; color: var(--text-secondary); margin-bottom: 1rem;">Select Receipt
                                Image (JPG, PNG)</label>
                            <input type="file" name="payment_slip" id="payment_slip" class="form-control" accept="image/*"
                                required
                                style="background: #fff; border: 1px solid rgba(0,0,0,0.1); color: #111; padding: 1rem; width: 100%; border-radius: 8px;"
                                onchange="previewSlip(this)">
                            @error('payment_slip')
                                <p style="color: #ef4444; margin-top: 0.5rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="slip-preview-container" style="display: none; margin-bottom: 2rem; text-align: center;">
                            <img id="slip-preview" src="#" alt="Receipt Preview"
                                style="max-width: 100%; max-height: 400px; border-radius: 10px; border: 2px solid var(--brand-red);">
                        </div>

                        <button type="submit" class="btn btn-primary"
                            style="width: 100%; padding: 1.2rem; font-weight: 700; text-transform: uppercase; font-size: 1.1rem; letter-spacing: 1px; background: var(--brand-red); color: #fff; border: none; border-radius: 8px; cursor: pointer;">
                            <i class="fas fa-upload"></i> Confirm Payment & Submit
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tab 2: Request Invoice -->
            <div id="panel-invoice" class="payment-panel"
                style="display: none; background: #fff; padding: 3rem; border: 1px solid rgba(0,0,0,0.1); border-radius: 0 0 15px 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                <div style="text-align: center; margin-bottom: 2rem;">
                    <div
                        style="width: 80px; height: 80px; margin: 0 auto 1.5rem; background: linear-gradient(135deg, #E60914 0%, #b30000 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-file-invoice-dollar" style="font-size: 2rem; color: #fff;"></i>
                    </div>
                    <h2
                        style="font-family: 'Inter', sans-serif; font-weight: 700; color: #111; margin-bottom: 0.5rem; text-transform: uppercase;">
                        Request PayPal Invoice</h2>
                    <p style="color: var(--text-secondary); max-width: 450px; margin: 0 auto; line-height: 1.6;">
                        Enter your PayPal email below. We will send you a PayPal invoice for
                        <strong style="color: var(--brand-red);">${{ number_format($order->total, 2) }}</strong>.
                        Once you pay the invoice, come back and upload the receipt.
                    </p>
                </div>

                <div style="background: var(--secondary-dark); padding: 2rem; border-radius: 12px; margin-bottom: 2rem;">
                    <div
                        style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid var(--border-color);">
                        <span style="color: var(--text-muted);">Order Number</span>
                        <strong style="color: #111;">#{{ $order->order_number }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 0.75rem 0;">
                        <span style="color: var(--text-muted);">Amount Due</span>
                        <strong
                            style="color: var(--brand-red); font-size: 1.2rem;">${{ number_format($order->total, 2) }}</strong>
                    </div>
                </div>

                <form action="{{ route('checkout.request-invoice', $order->order_number) }}" method="POST">
                    @csrf
                    <div class="form-group" style="margin-bottom: 2rem;">
                        <label for="invoice_email"
                            style="display: block; color: #111; margin-bottom: 0.75rem; font-weight: 600; font-size: 0.95rem;">
                            <i class="fas fa-envelope" style="color: var(--brand-red); margin-right: 0.5rem;"></i>
                            Your PayPal Email Address
                        </label>
                        <input type="email" name="invoice_email" id="invoice_email" required placeholder="example@email.com"
                            value="{{ $order->customer_email }}"
                            style="width: 100%; padding: 1rem 1.25rem; border: 2px solid rgba(0,0,0,0.1); border-radius: 8px; font-size: 1.1rem; font-family: 'Inter', sans-serif; color: #111; background: #fff; transition: border-color 0.3s;"
                            onfocus="this.style.borderColor='#E60914'" onblur="this.style.borderColor='rgba(0,0,0,0.1)'">
                        @error('invoice_email')
                            <p style="color: #ef4444; margin-top: 0.5rem;">{{ $message }}</p>
                        @enderror
                        <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.5rem;">
                            <i class="fas fa-info-circle"></i> We will send a PayPal invoice to this email address.
                        </p>
                    </div>

                    <!-- PayPal Note -->
                    <div
                        style="background: #FFF8E1; padding: 1rem 1.25rem; border-radius: 8px; border-left: 4px solid #FFC107; margin-bottom: 2rem;">
                        <p style="color: #795600; font-size: 0.9rem; line-height: 1.5;">
                            <i class="fas fa-exclamation-triangle"></i>
                            After receiving the invoice, please pay via <strong>"Goods and Services"</strong>.
                            Then return to this page to upload your payment receipt.
                        </p>
                    </div>

                    <button type="submit" class="btn btn-primary"
                        style="width: 100%; padding: 1.2rem; font-weight: 700; text-transform: uppercase; font-size: 1.1rem; letter-spacing: 1px; background: var(--brand-red); color: #fff; border: none; border-radius: 8px; cursor: pointer;">
                        <i class="fas fa-paper-plane"></i> Request Invoice
                    </button>
                </form>
            </div>

        </div>
    </section>

    <script>
        function switchTab(tab) {
            // Hide all panels
            document.getElementById('panel-direct').style.display = 'none';
            document.getElementById('panel-invoice').style.display = 'none';

            // Reset tabs
            document.getElementById('tab-direct').style.background = '#f5f5f5';
            document.getElementById('tab-direct').style.color = '#888';
            document.getElementById('tab-invoice').style.background = '#f5f5f5';
            document.getElementById('tab-invoice').style.color = '#888';

            // Show selected
            document.getElementById('panel-' + tab).style.display = 'block';
            document.getElementById('tab-' + tab).style.background = '#fff';
            document.getElementById('tab-' + tab).style.color = '#111';
        }

        function previewSlip(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('slip-preview').src = e.target.result;
                    document.getElementById('slip-preview-container').style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function copyPayPalEmail() {
            const email = document.getElementById('paypalEmail').textContent;
            navigator.clipboard.writeText(email).then(function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Copied!',
                    html: '<p>PayPal email copied to clipboard.</p><p style="margin-top: 0.75rem; padding: 0.75rem; background: #FFF8E1; border-radius: 6px; border-left: 3px solid #FFC107; color: #795600; font-size: 0.9rem; text-align: left;"><strong>⚠️ Note:</strong> Please select <strong>"Goods and Services"</strong> as PayPal Thailand only supports this service.</p>',
                    background: '#fff',
                    color: '#111',
                    confirmButtonColor: '#E60914',
                    timer: 5000,
                    timerProgressBar: true
                });
            });
        }
    </script>
@endsection