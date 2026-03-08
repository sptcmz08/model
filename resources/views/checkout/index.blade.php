@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <!-- Hero Banner -->
    <section class="page-hero-sm">
        <div class="page-hero-content">
            <h1>Checkout</h1>
            <p>Complete your purchase securely</p>
        </div>
    </section>

    <!-- Checkout Section -->
    <section class="checkout-section">
        <div class="container">
            <form action="{{ route('checkout.process') }}" method="POST" class="checkout-form" id="checkoutForm">
                @csrf
                <!-- Shipping rates from DB (JSON for JS) -->
                <input type="hidden" id="calculated_shipping_cost" name="shipping_cost" value="0">

                <div class="checkout-grid">
                    <!-- Billing & Shipping Details -->
                    <div class="form-columns">
                        <!-- Billing Details -->
                        <div class="details-section">
                            <h2>BILLING DETAILS</h2>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="billing_first_name">First Name <span class="required">*</span></label>
                                    <input type="text" id="billing_first_name" name="billing_first_name"
                                        value="{{ old('billing_first_name') }}" required>
                                    @error('billing_first_name') <span
                                    style="color:red; font-size: 0.8rem;">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label for="billing_last_name">Last Name <span class="required">*</span></label>
                                    <input type="text" id="billing_last_name" name="billing_last_name"
                                        value="{{ old('billing_last_name') }}" required>
                                    @error('billing_last_name') <span
                                    style="color:red; font-size: 0.8rem;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="billing_company">Company Name (optional)</label>
                                <input type="text" id="billing_company" name="billing_company"
                                    value="{{ old('billing_company') }}">
                            </div>

                            <!-- Continent Selection -->
                            <div class="form-group">
                                <label for="billing_continent">Continent <span class="required">*</span></label>
                                <select id="billing_continent" name="billing_continent" required>
                                    <option value="">Select a continent...</option>
                                    <option value="asia" {{ old('billing_continent') == 'asia' ? 'selected' : '' }}>Asia
                                    </option>
                                    <option value="europe" {{ old('billing_continent') == 'europe' ? 'selected' : '' }}>Europe
                                    </option>
                                    <option value="americas" {{ old('billing_continent') == 'americas' ? 'selected' : '' }}>
                                        Americas</option>
                                    <option value="oceania" {{ old('billing_continent') == 'oceania' ? 'selected' : '' }}>
                                        Oceania</option>
                                </select>
                                @error('billing_continent') <span
                                style="color:red; font-size: 0.8rem;">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="billing_country">Country / Region <span class="required">*</span></label>
                                <select id="billing_country" name="billing_country" required
                                    data-old="{{ old('billing_country') }}" class="country-select">
                                    <option value="">Select a continent first...</option>
                                </select>
                                @error('billing_country') <span style="color:red; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="billing_address_1">Street address <span class="required">*</span></label>
                                <input type="text" id="billing_address_1" name="billing_address_1"
                                    placeholder="House number and street name" value="{{ old('billing_address_1') }}"
                                    required>
                                <input type="text" id="billing_address_2" name="billing_address_2"
                                    placeholder="Apartment, suite, unit, etc. (optional)"
                                    value="{{ old('billing_address_2') }}" style="margin-top: 10px;">
                            </div>

                            <div class="form-group">
                                <label for="billing_city">Town / City <span class="required">*</span></label>
                                <input type="text" id="billing_city" name="billing_city" value="{{ old('billing_city') }}"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="billing_state">State / County <span class="required">*</span></label>
                                <input type="text" id="billing_state" name="billing_state"
                                    value="{{ old('billing_state') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="billing_postcode">Postcode / ZIP <span class="required">*</span></label>
                                <input type="text" id="billing_postcode" name="billing_postcode"
                                    value="{{ old('billing_postcode') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="billing_phone">Phone <span class="required">*</span></label>
                                <input type="tel" id="billing_phone" name="billing_phone" value="{{ old('billing_phone') }}"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="billing_email">Email Address <span class="required">*</span></label>
                                <input type="email" id="billing_email" name="billing_email"
                                    value="{{ old('billing_email') }}" required>
                                @error('billing_email') <span style="color:red; font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Shipping Section Toggle -->
                        <div class="shipping-toggle">
                            <label class="checkbox-container">
                                <input type="checkbox" id="same_as_billing" name="same_as_billing" value="1" checked>
                                <span class="checkmark"></span>
                                <span class="toggle-text">SHIP TO BILLING ADDRESS</span>
                            </label>
                        </div>

                        <!-- Shipping Details (Hidden by Default) -->
                        <div class="details-section shipping-details" id="shipping-details-form">
                            <h2>SHIPPING DETAILS</h2>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="shipping_first_name">First Name <span class="required">*</span></label>
                                    <input type="text" id="shipping_first_name" name="shipping_first_name"
                                        value="{{ old('shipping_first_name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="shipping_last_name">Last Name <span class="required">*</span></label>
                                    <input type="text" id="shipping_last_name" name="shipping_last_name"
                                        value="{{ old('shipping_last_name') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="shipping_company">Company Name (optional)</label>
                                <input type="text" id="shipping_company" name="shipping_company"
                                    value="{{ old('shipping_company') }}">
                            </div>

                            <!-- Continent Selection (Shipping) -->
                            <div class="form-group">
                                <label for="shipping_continent">Continent <span class="required">*</span></label>
                                <select id="shipping_continent" name="shipping_continent">
                                    <option value="">Select a continent...</option>
                                    <option value="asia">Asia</option>
                                    <option value="europe">Europe</option>
                                    <option value="americas">Americas</option>
                                    <option value="oceania">Oceania</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="shipping_country">Country / Region <span class="required">*</span></label>
                                <select id="shipping_country" name="shipping_country" class="country-select">
                                    <option value="">Select a continent first...</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="shipping_address_1">Street address <span class="required">*</span></label>
                                <input type="text" id="shipping_address_1" name="shipping_address_1"
                                    placeholder="House number and street name" value="{{ old('shipping_address_1') }}">
                                <input type="text" id="shipping_address_2" name="shipping_address_2"
                                    placeholder="Apartment, suite, unit, etc. (optional)"
                                    value="{{ old('shipping_address_2') }}" style="margin-top: 10px;">
                            </div>

                            <div class="form-group">
                                <label for="shipping_city">Town / City <span class="required">*</span></label>
                                <input type="text" id="shipping_city" name="shipping_city"
                                    value="{{ old('shipping_city') }}">
                            </div>

                            <div class="form-group">
                                <label for="shipping_state">State / County <span class="required">*</span></label>
                                <input type="text" id="shipping_state" name="shipping_state"
                                    value="{{ old('shipping_state') }}">
                            </div>

                            <div class="form-group">
                                <label for="shipping_postcode">Postcode / ZIP <span class="required">*</span></label>
                                <input type="text" id="shipping_postcode" name="shipping_postcode"
                                    value="{{ old('shipping_postcode') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="order-summary glass">
                        <h2>ORDER SUMMARY</h2>

                        <div class="summary-table">
                            <div class="summary-header">
                                <span>PRODUCT</span>
                                <span>SUBTOTAL</span>
                            </div>
                            <div class="summary-body">
                                @foreach($items as $item)
                                    <div class="summary-item">
                                        <div class="prod-name">
                                            {{ $item['name'] }} <strong class="qty">× {{ $item['quantity'] }}</strong>
                                            @if(isset($item['attributes']['variant']))
                                                <div class="prod-variant">Color: {{ $item['attributes']['variant'] }}</div>
                                            @endif
                                        </div>
                                        <div class="prod-total">${{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="summary-footer">
                                <div class="summary-row">
                                    <span>Subtotal</span>
                                    <span id="summary-subtotal"
                                        data-amount="{{ $subtotal }}">${{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="summary-row">
                                    <span>Shipping</span>
                                    <span id="summary-shipping" style="font-style: italic; font-size: 0.85rem; color: var(--text-muted);">Select a continent</span>
                                </div>
                                <div class="summary-row total">
                                    <span>Total (USD)</span>
                                    <span id="summary-total">${{ number_format($subtotal, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="payment-section">
                            <div class="payment-method">
                                <input type="radio" id="payment_paypal" name="payment_method" value="paypal" checked
                                    onchange="togglePaymentMethod()">
                                <label for="payment_paypal">
                                    PayPal <i class="fab fa-paypal"></i>
                                    <img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg"
                                        alt="PayPal Acceptance Mark" class="paypal-mark">
                                </label>
                                <div class="payment-desc" id="paypal-desc">
                                    Transfer to our PayPal: <strong>nattawutkongyod@hotmail.com</strong>. <br>
                                    You will be asked to upload the payment receipt on the next page.
                                </div>
                            </div>
                            <div class="payment-method" style="margin-top: 0.75rem;">
                                <input type="radio" id="payment_invoice" name="payment_method" value="invoice"
                                    onchange="togglePaymentMethod()">
                                <label for="payment_invoice">
                                    <i class="fas fa-file-invoice" style="color: #E60914;"></i> Request Invoice
                                </label>
                                <div class="payment-desc" id="invoice-desc" style="display: none;">
                                    <p style="margin-bottom: 0.75rem; color: #555;">We will send a PayPal invoice to your
                                        email. Pay directly through the invoice link.</p>
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label for="invoice_email" style="font-size: 0.85rem;">Invoice Email <span
                                                class="required">*</span></label>
                                        <input type="email" id="invoice_email" name="invoice_email"
                                            placeholder="Enter email to receive invoice"
                                            style="border: 1px solid #ddd; padding: 10px; width: 100%; font-size: 0.95rem;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            function togglePaymentMethod() {
                                const isInvoice = document.getElementById('payment_invoice').checked;
                                document.getElementById('paypal-desc').style.display = isInvoice ? 'none' : 'block';
                                document.getElementById('invoice-desc').style.display = isInvoice ? 'block' : 'none';
                                document.getElementById('invoice_email').required = isInvoice;
                            }
                        </script>

                        <button type="submit" class="btn btn-primary place-order-btn">
                            PLACE ORDER
                        </button>

                        <div class="secure-badge">
                            <i class="fas fa-info-circle"></i>
                            <span>Place order first, then transfer and upload receipt manually.</span>
                        </div>

                        <a href="{{ route('cart.index') }}" class="back-to-cart">
                            <i class="fas fa-arrow-left"></i> Back to Cart
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- Payment Slip Upload Modal -->
    <div id="paymentSlipModal" class="slip-modal-overlay">
        <div class="slip-modal-content">
            <!-- Close Button -->
            <button type="button" class="slip-modal-close" onclick="closeSlipModal()">
                <i class="fas fa-times"></i>
            </button>

            <!-- Header -->
            <div class="slip-modal-header">
                <div class="slip-modal-icon">
                    <i class="fab fa-paypal"></i>
                </div>
                <h2>UPLOAD PAYMENT RECEIPT</h2>
                <p>Complete your order by uploading payment proof</p>
            </div>

            <!-- Payment Info -->
            <div class="slip-payment-info">
                <div class="slip-info-row">
                    <span class="slip-info-label"><i class="fas fa-envelope"></i> Transfer to PayPal:</span>
                    <span class="slip-info-value email">nattawutkongyod@hotmail.com</span>
                </div>
                <div class="slip-info-divider"></div>
                <div class="slip-info-row">
                    <span class="slip-info-label"><i class="fas fa-receipt"></i> Total Amount:</span>
                    <span class="slip-info-value amount" id="modalOrderTotal">$0.00</span>
                </div>
            </div>

            <!-- Upload Form -->
            <form id="slipUploadForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="modalOrderData" name="order_data">

                <div class="slip-upload-area" id="dropZone" onclick="document.getElementById('payment_slip_input').click()">
                    <div class="slip-upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div class="slip-upload-text">
                        <strong>Click to upload receipt</strong>
                        <span>or drag and drop</span>
                        <small>JPG, PNG (MAX 2MB)</small>
                    </div>
                    <input type="file" name="payment_slip" id="payment_slip_input" accept="image/*" required
                        style="display: none;" onchange="previewSlip(this)">
                </div>

                <div id="slip-preview-container" class="slip-preview-container">
                    <img id="slip-preview" src="#" alt="Receipt Preview">
                    <button type="button" class="slip-preview-remove" onclick="removePreview()">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>

                <div id="uploadProgress" class="slip-progress">
                    <div class="slip-progress-bar">
                        <div id="progressBar" class="slip-progress-fill"></div>
                    </div>
                    <p><i class="fas fa-spinner fa-spin"></i> Processing your order...</p>
                </div>

                <div class="slip-modal-actions">
                    <button type="submit" class="slip-btn-confirm">
                        <i class="fas fa-check-circle"></i> CONFIRM PAYMENT
                    </button>
                    <button type="button" class="slip-btn-cancel" onclick="closeSlipModal()">
                        <i class="fas fa-arrow-left"></i> CANCEL
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Modal Overlay */
        .slip-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Modal Content */
        .slip-modal-content {
            background: linear-gradient(145deg, #1a1a1a 0%, #0d0d0d 100%);
            border: 2px solid #E60914;
            border-radius: 20px;
            max-width: 520px;
            width: 95%;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            padding: 2.5rem;
            box-shadow: 0 25px 80px rgba(230, 9, 20, 0.3), 0 0 40px rgba(230, 9, 20, 0.1);
            animation: slideUp 0.4s ease;
        }

        /* Close Button */
        .slip-modal-close {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            border: none;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.2rem;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slip-modal-close:hover {
            background: #E60914;
            transform: rotate(90deg);
        }

        /* Header */
        .slip-modal-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .slip-modal-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #E60914 0%, #b30000 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #fff;
            box-shadow: 0 10px 30px rgba(230, 9, 20, 0.4);
        }

        .slip-modal-header h2 {
            font-family: 'Inter', sans-serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: #111;
            margin-bottom: 0.5rem;
            letter-spacing: 1px;
        }

        .slip-modal-header p {
            color: #888;
            font-size: 0.95rem;
        }

        /* Payment Info */
        .slip-payment-info {
            background: rgba(230, 9, 20, 0.1);
            border: 1px solid rgba(230, 9, 20, 0.3);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .slip-info-row {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
        }

        .slip-info-label {
            font-size: 0.85rem;
            color: #888;
        }

        .slip-info-label i {
            color: #E60914;
            margin-right: 0.5rem;
        }

        .slip-info-value {
            font-weight: 700;
            color: #111;
        }

        .slip-info-value.email {
            font-size: 1.1rem;
            color: #E60914;
            word-break: break-all;
        }

        .slip-info-value.amount {
            font-size: 1.8rem;
            color: #E60914;
            font-family: 'Inter', sans-serif;
            font-weight: 700;
        }

        .slip-info-divider {
            height: 1px;
            background: rgba(230, 9, 20, 0.3);
            margin: 1rem 0;
        }

        /* Upload Area */
        .slip-upload-area {
            border: 2px dashed rgba(230, 9, 20, 0.5);
            border-radius: 15px;
            padding: 2.5rem 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: rgba(0, 0, 0, 0.3);
            margin-bottom: 1.5rem;
        }

        .slip-upload-area:hover {
            border-color: #E60914;
            background: rgba(230, 9, 20, 0.05);
        }

        .slip-upload-area.dragover {
            border-color: #E60914;
            background: rgba(230, 9, 20, 0.1);
            transform: scale(1.02);
        }

        .slip-upload-icon {
            font-size: 3rem;
            color: #E60914;
            margin-bottom: 1rem;
        }

        .slip-upload-text {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
        }

        .slip-upload-text strong {
            color: #111;
            font-size: 1.1rem;
        }

        .slip-upload-text span {
            color: #888;
            font-size: 0.9rem;
        }

        .slip-upload-text small {
            color: #555;
            font-size: 0.8rem;
            margin-top: 0.5rem;
        }

        /* Preview */
        .slip-preview-container {
            display: none;
            text-align: center;
            margin-bottom: 1.5rem;
            animation: fadeIn 0.3s ease;
        }

        .slip-preview-container img {
            max-width: 100%;
            max-height: 250px;
            border-radius: 12px;
            border: 3px solid #E60914;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .slip-preview-remove {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.5rem 1.5rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.3s;
        }

        .slip-preview-remove:hover {
            background: #E60914;
            border-color: #E60914;
        }

        /* Progress */
        .slip-progress {
            display: none;
            margin-bottom: 1.5rem;
        }

        .slip-progress-bar {
            background: #333;
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 0.8rem;
        }

        .slip-progress-fill {
            background: linear-gradient(90deg, #E60914, #ff4444);
            height: 100%;
            width: 0%;
            transition: width 0.3s ease;
            border-radius: 4px;
        }

        .slip-progress p {
            color: #E60914;
            font-size: 0.9rem;
            text-align: center;
        }

        /* Actions */
        .slip-modal-actions {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }

        .slip-btn-confirm {
            width: 100%;
            padding: 1.2rem;
            background: linear-gradient(135deg, #E60914 0%, #b30000 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 5px 20px rgba(230, 9, 20, 0.4);
        }

        .slip-btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(230, 9, 20, 0.5);
        }

        .slip-btn-confirm i {
            margin-right: 0.5rem;
        }

        .slip-btn-cancel {
            width: 100%;
            padding: 1rem;
            background: transparent;
            color: #888;
            border: 1px solid #444;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s;
        }

        .slip-btn-cancel:hover {
            border-color: #888;
            color: #fff;
        }

        .slip-btn-cancel i {
            margin-right: 0.5rem;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .slip-modal-content {
                padding: 1.5rem;
                margin: 1rem;
            }

            .slip-modal-icon {
                width: 60px;
                height: 60px;
                font-size: 1.8rem;
            }

            .slip-modal-header h2 {
                font-size: 1.4rem;
            }

            .slip-info-value.amount {
                font-size: 1.5rem;
            }

            .slip-upload-area {
                padding: 1.5rem 1rem;
            }

            .slip-upload-icon {
                font-size: 2rem;
            }
        }
    </style>
@endsection

@push('styles')
    <style>
        .page-hero-sm {
            height: 20vh;
            min-height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: var(--secondary-dark);
            border-bottom: 1px solid var(--border-color);
        }

        .page-hero-sm .page-hero-content h1 {
            font-family: 'Inter', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: #111;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .checkout-section {
            padding: 4rem 0;
            background: #fff;
            min-height: 80vh;
        }

        /* Ensure container has proper width and spacing */
        .checkout-section .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .checkout-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 4rem;
            align-items: start;
        }

        .details-section h2,
        .order-summary h2 {
            font-family: 'Inter', sans-serif;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #111;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #111;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .form-group label .required {
            color: var(--brand-red);
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 0;
            color: #333;
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--brand-red);
            box-shadow: 0 0 0 2px rgba(230, 9, 20, 0.1);
        }

        .form-group select:disabled,
        .form-group select.country-select:not(:has(option:not([value=""]))) {
            background-color: #eee;
            cursor: not-allowed;
        }

        .country-select.disabled-style {
            background-color: #eee;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Checkbox Style */
        .shipping-toggle {
            margin: 2rem 0;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            position: relative;
            padding-left: 30px;
            cursor: pointer;
            font-weight: 600;
            color: #111;
            user-select: none;
        }

        .checkbox-container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .checkbox-container .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            width: 20px;
            background-color: #eee;
            transition: all 0.2s;
        }

        .checkbox-container:hover input~.checkmark {
            background-color: #ccc;
        }

        .checkbox-container input:checked~.checkmark {
            background-color: var(--brand-red);
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .checkbox-container input:checked~.checkmark:after {
            display: block;
        }

        .checkbox-container .checkmark:after {
            left: 7px;
            top: 3px;
            width: 6px;
            height: 12px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .toggle-text {
            font-size: 1.1rem;
            font-weight: 700;
            text-transform: uppercase;
        }


        /* Order Summary Box */
        .order-summary {
            background: var(--secondary-dark);
            padding: 2rem;
            border: 2px solid var(--brand-red);
        }

        .summary-table {
            margin-bottom: 2rem;
        }

        .summary-header {
            display: flex;
            justify-content: space-between;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
            font-weight: 700;
            color: #111;
            text-transform: uppercase;
        }

        .summary-body {
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            font-size: 0.95rem;
            color: #bbb;
        }

        .summary-item .prod-name {
            padding-right: 1rem;
        }

        .summary-item .prod-variant {
            font-size: 0.8rem;
            color: #777;
            margin-top: 4px;
        }

        .summary-item .qty {
            color: #111;
        }

        .summary-item .prod-total {
            font-weight: 600;
            color: var(--brand-red);
            white-space: nowrap;
        }

        .summary-footer {
            padding-top: 1rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.8rem;
            color: #111;
        }

        .summary-row.total {
            border-top: 1px solid var(--border-color);
            padding-top: 1rem;
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        .summary-row.total span:last-child {
            color: var(--brand-red);
        }

        .payment-section {
            margin: 2rem 0;
            background: var(--secondary-dark);
            padding: 1rem;
        }

        .payment-method label {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #111;
            font-weight: 600;
            margin-bottom: 1rem;
            cursor: pointer;
        }

        .paypal-mark {
            height: 24px;
        }

        .payment-desc {
            background: #fff;
            padding: 1rem;
            font-size: 0.85rem;
            color: var(--text-secondary);
            position: relative;
        }

        .payment-desc:before {
            content: "";
            position: absolute;
            top: -10px;
            left: 20px;
            border-width: 0 10px 10px 10px;
            border-style: solid;
            border-color: transparent transparent #fff transparent;
        }

        .place-order-btn {
            width: 100%;
            padding: 1.25rem;
            background: var(--brand-red);
            color: #fff;
            border: none;
            font-weight: 700;
            font-size: 1.1rem;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.3s;
        }

        .place-order-btn:hover {
            background: #cc0812;
        }

        .secure-badge {
            text-align: center;
            margin-top: 1rem;
            color: #666;
            font-size: 0.8rem;
        }

        .back-to-cart {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: #888;
            text-decoration: none;
            transition: color 0.3s;
        }

        .back-to-cart:hover {
            color: #111;
        }

        @media (max-width: 991px) {
            .checkout-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .order-summary {
                margin-top: 2rem;
            }
        }

        @media (max-width: 576px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- 1. Continent & Country Data ---
            // Comprehensive list of countries by continent
            const countriesByContinent = {
                'asia': [
                    'Bhutan', 'China', 'Hong Kong', 'Indonesia', 'Japan', 'Laos',
                    'Malaysia', 'Singapore', 'South Korea', 'Taiwan', 'Vietnam'
                ],
                'europe': [
                    'Austria', 'Belgium', 'Denmark', 'Finland', 'France', 'Germany', 'Greece',
                    'Italy', 'Netherlands', 'Norway', 'Poland', 'Portugal', 'Russia',
                    'Spain', 'Sweden', 'Switzerland', 'Turkey', 'United Kingdom'
                ],
                'americas': [
                    'Brazil', 'Canada', 'United States'
                ],
                'oceania': [
                    'Australia'
                ]
            };

            // Shipping rates from DB (continent => USD rate)
            const shippingRatesUSD = @json($shippingRates ?? []);

            // --- 2. Element References ---
            const shipToggle = document.getElementById('same_as_billing');
            const shippingForm = document.getElementById('shipping-details-form');
            const shippingInputs = shippingForm.querySelectorAll('input, select');

            // Billing Elements
            const billingContinent = document.getElementById('billing_continent');
            const billingCountry = document.getElementById('billing_country');

            // Shipping Elements
            const shippingContinent = document.getElementById('shipping_continent');
            const shippingCountry = document.getElementById('shipping_country');

            // Summary Elements
            const summaryShipping = document.getElementById('summary-shipping');
            const summaryTotal = document.getElementById('summary-total');
            const subtotalEl = document.getElementById('summary-subtotal');
            const hiddenShippingCost = document.getElementById('calculated_shipping_cost');

            const subtotal = parseFloat(subtotalEl.dataset.amount);

            // --- 3. Functions ---

            // Populate Countries based on Continent
            function populateCountries(continentSelect, countrySelect) {
                const continent = continentSelect.value;
                countrySelect.innerHTML = '<option value="">Select a country...</option>';

                if (continent && countriesByContinent[continent]) {
                    countrySelect.classList.remove('disabled-style');
                    countriesByContinent[continent].forEach(country => {
                        const option = document.createElement('option');
                        option.value = country;
                        option.textContent = country;
                        countrySelect.appendChild(option);
                    });
                } else {
                    countrySelect.classList.add('disabled-style');
                    countrySelect.innerHTML = '<option value="">Select a continent first...</option>';
                }
            }

            // Calculate and Update Total based on selected continent
            function updateOrderSummary() {
                // Determine which continent to use for shipping
                let continent = billingContinent.value;
                if (!shipToggle.checked && shippingContinent.value) {
                    continent = shippingContinent.value;
                }

                let shippingUSD = 0;
                if (continent && shippingRatesUSD[continent] !== undefined) {
                    shippingUSD = parseFloat(shippingRatesUSD[continent]);
                }

                const total = subtotal + shippingUSD;

                // Update UI
                if (continent && shippingRatesUSD[continent] !== undefined) {
                    summaryShipping.textContent = '$' + shippingUSD.toFixed(2);
                    summaryShipping.style.fontStyle = 'normal';
                    summaryShipping.style.fontSize = '';
                } else {
                    summaryShipping.textContent = 'Select a continent';
                    summaryShipping.style.fontStyle = 'italic';
                    summaryShipping.style.fontSize = '0.85rem';
                }
                summaryTotal.textContent = '$' + total.toFixed(2);
                hiddenShippingCost.value = shippingUSD.toFixed(2);
            }

            function toggleShipping() {
                if (shipToggle.checked) {
                    shippingForm.style.display = 'none';
                    shippingInputs.forEach(input => input.required = false);
                } else {
                    shippingForm.style.display = 'block';
                    shippingInputs.forEach(input => {
                        // Basic Required Check for Shipping Fields
                        if (input.id.includes('shipping_first_name') ||
                            input.id.includes('shipping_last_name') ||
                            input.id.includes('shipping_continent') ||
                            input.id.includes('shipping_country') ||
                            input.id.includes('shipping_address_1') ||
                            input.id.includes('shipping_city') ||
                            input.id.includes('shipping_state') ||
                            input.id.includes('shipping_postcode')) {
                            input.required = true;
                        }
                    });
                }
                updateOrderSummary();
            }

            // --- 4. Event Listeners ---

            // Billing Continent Change
            billingContinent.addEventListener('change', function () {
                populateCountries(this, billingCountry);
                updateOrderSummary();
            });

            // Shipping Continent Change
            shippingContinent.addEventListener('change', function () {
                populateCountries(this, shippingCountry);
                updateOrderSummary();
            });

            // Toggle Change
            shipToggle.addEventListener('change', toggleShipping);

            // --- 5. Initial Init ---
            toggleShipping(); // Sets initial visibility and required state logic

            // Restore state if old values exist
            if (billingContinent.value) {
                populateCountries(billingContinent, billingCountry);
                const oldCountry = billingCountry.dataset.old;
                if (oldCountry) {
                    billingCountry.value = oldCountry;
                }
                updateOrderSummary();
            }

            // --- 6. Form Submit Handler ---
            const checkoutForm = document.getElementById('checkoutForm');
            if (checkoutForm) {
                checkoutForm.addEventListener('submit', function (e) {
                    e.preventDefault(); // Prevent normal form submission

                    console.log('Form submitting...');
                    console.log('Billing country value:', billingCountry.value);
                    console.log('Shipping country value:', shippingCountry.value);
                    console.log('Same as billing:', shipToggle.checked);

                    // Validate billing country is selected
                    if (!billingCountry.value) {
                        alert('Please select a country');
                        return false;
                    }

                    // If using separate shipping, validate shipping country
                    if (!shipToggle.checked && !shippingCountry.value) {
                        alert('Please select a shipping country');
                        return false;
                    }

                    // Check payment method
                    const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

                    if (paymentMethod === 'invoice') {
                        // Validate invoice email
                        const invoiceEmail = document.getElementById('invoice_email').value;
                        if (!invoiceEmail) {
                            alert('Please enter your email to receive the invoice');
                            return false;
                        }

                        // Submit directly for invoice (no slip needed)
                        const formData = new FormData(document.getElementById('checkoutForm'));

                        fetch('{{ route("checkout.process") }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Order Placed!',
                                        html: `
                                                <div style="text-align: center;">
                                                    <p style="font-size: 1.1rem; margin-bottom: 1rem;">Thank you for your order!</p>
                                                    <p style="margin-bottom: 1rem; color: #666;">We will send an invoice to your email shortly.</p>
                                                    <p style="background: #f0f0f0; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                                                        <strong style="color: #E60914;"><i class="fas fa-file-invoice"></i> Invoice Email:</strong><br>
                                                        <span style="font-size: 1.2rem; font-weight: bold; color: #333;">${invoiceEmail}</span>
                                                    </p>
                                                    <p style="color: #888; font-size: 0.9rem;">Please check your email for the invoice and payment instructions.</p>
                                                </div>
                                            `,
                                        confirmButtonColor: '#E60914',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        window.location.href = '{{ route("products.index") }}';
                                    });
                                } else {
                                    throw new Error(data.message || 'Order creation failed');
                                }
                            })
                            .catch(error => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops!',
                                    text: error.message || 'An error occurred. Please try again.',
                                    confirmButtonColor: '#E60914'
                                });
                            });
                    } else {
                        // Show the payment slip modal for direct transfer
                        openSlipModal();
                    }
                });
            }
        });

        // Modal Functions
        function openSlipModal() {
            const modal = document.getElementById('paymentSlipModal');
            const total = document.getElementById('summary-total').textContent;
            document.getElementById('modalOrderTotal').textContent = total;
            modal.style.display = 'flex';
        }

        function closeSlipModal() {
            const modal = document.getElementById('paymentSlipModal');
            modal.style.display = 'none';
            document.getElementById('payment_slip_input').value = '';
            document.getElementById('slip-preview-container').style.display = 'none';
            document.getElementById('dropZone').style.display = 'block';
            document.getElementById('uploadProgress').style.display = 'none';
            document.getElementById('progressBar').style.width = '0%';
        }

        function previewSlip(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('slip-preview').src = e.target.result;
                    document.getElementById('slip-preview-container').style.display = 'block';
                    document.getElementById('dropZone').style.display = 'none';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removePreview() {
            document.getElementById('payment_slip_input').value = '';
            document.getElementById('slip-preview-container').style.display = 'none';
            document.getElementById('dropZone').style.display = 'block';
        }

        // Handle slip upload form submission
        document.getElementById('slipUploadForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const slipFile = document.getElementById('payment_slip_input').files[0];
            if (!slipFile) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No File Selected',
                    text: 'Please select a payment slip image',
                    confirmButtonColor: '#E60914'
                });
                return;
            }

            // Show progress
            document.getElementById('uploadProgress').style.display = 'block';
            document.getElementById('progressBar').style.width = '30%';

            // Create FormData with checkout form data + slip
            const formData = new FormData(document.getElementById('checkoutForm'));
            formData.append('payment_slip', slipFile);

            console.log('Sending order request...');

            // AJAX submission
            fetch('{{ route("checkout.process") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    document.getElementById('progressBar').style.width = '70%';
                    console.log('Response status:', response.status);

                    if (!response.ok) {
                        return response.text().then(text => {
                            console.error('Error response:', text);
                            throw new Error('Server error: ' + response.status);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    document.getElementById('progressBar').style.width = '100%';

                    if (data.success) {
                        // Success!
                        closeSlipModal();

                        Swal.fire({
                            icon: 'success',
                            title: 'Order Confirmed!',
                            html: `
                                                            <div style="text-align: center;">
                                                                <p style="font-size: 1.1rem; margin-bottom: 1rem;">Thank you for your order!</p>
                                                                <p style="margin-bottom: 1rem; color: #666;">We will contact you at your email once payment is verified.</p>
                                                                <p style="background: #f0f0f0; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                                                                    <strong style="color: #E60914;"><i class="fas fa-envelope"></i> E-mail:</strong><br>
                                                                    <span style="font-size: 1.2rem; font-weight: bold; color: #333;">${data.customer_email}</span>
                                                                </p>
                                                                <p style="color: #888; font-size: 0.9rem;">Please check your email for order confirmation and shipping updates.</p>
                                                            </div>
                                                        `,
                            confirmButtonColor: '#E60914',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = '{{ route("products.index") }}';
                        });
                    } else {
                        throw new Error(data.message || 'Order creation failed');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('uploadProgress').style.display = 'none';
                    document.getElementById('progressBar').style.width = '0%';

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops! Something went wrong',
                        text: error.message || 'An error occurred while processing your order. Please try again.',
                        confirmButtonColor: '#E60914'
                    });
                });
        });
    </script>

    @if($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Please check your inputs',
                    html: `
                                                                                        <ul style="text-align: left;">
                                                                                            @foreach($errors->all() as $error)
                                                                                                <li>{{ $error }}</li>
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    `,
                    confirmButtonColor: '#E60914'
                });
            });
        </script>
    @endif
@endpush