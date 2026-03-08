@extends('admin.layouts.app')

@section('title', 'Invoice #' . $order->order_number)
@section('page-title', 'Invoice Preview')

@section('content')
    <!-- Action Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <a href="{{ route('admin.invoices.index') }}" class="btn btn-sm"
            style="background: var(--primary-dark); color: var(--text-muted);">
            <i class="fas fa-arrow-left"></i> Back to Invoices
        </a>
        <div style="display: flex; gap: 0.75rem;">
            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm"
                style="background: var(--gold-primary); color: #000;">
                <i class="fas fa-eye"></i> View Order
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 380px; gap: 1.5rem; align-items: start;">
        <!-- Invoice Preview -->
        <div class="card" id="invoicePreview">
            <div style="padding: 2.5rem;">
                <!-- Invoice Header -->
                <div
                    style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 3px solid var(--gold-primary);">
                    <div>
                        <h1
                            style="font-size: 1.8rem; font-weight: 700; color: #fff; letter-spacing: 2px; margin-bottom: 0.25rem;">
                            tattooink12studio.com</h1>
                        <p style="color: var(--text-muted); font-size: 0.85rem;">Custom Model Figures & Collectibles</p>
                    </div>
                    <div style="text-align: right;">
                        <div
                            style="font-size: 1.5rem; font-weight: 700; color: var(--gold-primary); letter-spacing: 1px; margin-bottom: 0.5rem;">
                            INVOICE</div>
                        <div style="color: var(--text-secondary); font-size: 0.9rem;">
                            <strong>#{{ $order->order_number }}</strong>
                        </div>
                        <div style="color: var(--text-muted); font-size: 0.8rem; margin-top: 0.25rem;">
                            Date: {{ $order->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>

                <!-- Status Badge -->
                <div style="margin-bottom: 2rem; text-align: right;">
                    @if($order->payment_status === 'completed')
                        <span
                            style="background: #28a745; color: #fff; padding: 0.4rem 1.5rem; border-radius: 4px; font-weight: 700; font-size: 0.9rem; letter-spacing: 1px;">
                            PAID
                        </span>
                    @elseif($order->payment_status === 'waiting_invoice')
                        <span
                            style="background: #FFC107; color: #000; padding: 0.4rem 1.5rem; border-radius: 4px; font-weight: 700; font-size: 0.9rem; letter-spacing: 1px;">
                            AWAITING PAYMENT
                        </span>
                    @else
                        <span
                            style="background: #E60914; color: #fff; padding: 0.4rem 1.5rem; border-radius: 4px; font-weight: 700; font-size: 0.9rem; letter-spacing: 1px;">
                            PENDING
                        </span>
                    @endif
                </div>

                <!-- Billing & Shipping -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                    <div>
                        <h3
                            style="color: var(--gold-primary); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.75rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border-color);">
                            <i class="fas fa-file-invoice"></i> Bill To
                        </h3>
                        <div style="color: var(--text-secondary); font-size: 0.9rem; line-height: 1.8;">
                            <div style="font-weight: 600; color: #fff; font-size: 1rem;">{{ $order->customer_name }}</div>
                            <div><i class="fas fa-envelope" style="width: 16px; color: var(--text-muted);"></i>
                                {{ $order->customer_email }}</div>
                            <div><i class="fas fa-phone" style="width: 16px; color: var(--text-muted);"></i>
                                {{ $order->customer_phone }}</div>
                            @if($order->billing_address)
                                <div style="margin-top: 0.5rem; white-space: pre-line; color: var(--text-muted);">
                                    {{ $order->billing_address }}</div>
                            @endif
                        </div>
                    </div>
                    <div>
                        <h3
                            style="color: var(--gold-primary); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.75rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border-color);">
                            <i class="fas fa-shipping-fast"></i> Ship To
                        </h3>
                        <div
                            style="color: var(--text-secondary); font-size: 0.9rem; line-height: 1.8; white-space: pre-line;">
                            {{ $order->shipping_address }}</div>
                    </div>
                </div>

                @if($order->invoice_email && $order->invoice_email !== $order->customer_email)
                    <div
                        style="background: rgba(255, 193, 7, 0.1); border: 1px solid rgba(255, 193, 7, 0.3); border-radius: 8px; padding: 0.75rem 1rem; margin-bottom: 1.5rem; font-size: 0.85rem;">
                        <i class="fas fa-envelope" style="color: #FFC107;"></i>
                        <strong style="color: #FFC107;">Invoice Email:</strong>
                        <span style="color: var(--text-secondary);">{{ $order->invoice_email }}</span>
                    </div>
                @endif

                <!-- Items Table -->
                <table class="table" style="margin-bottom: 0;">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th style="text-align: right; width: 100px;">Price</th>
                            <th style="text-align: center; width: 60px;">Qty</th>
                            <th style="text-align: right; width: 120px;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td style="color: var(--text-secondary);">{{ $item->product_name }}</td>
                                <td style="text-align: right; color: var(--text-muted);">${{ number_format($item->price, 2) }}
                                </td>
                                <td style="text-align: center;">{{ $item->quantity }}</td>
                                <td style="text-align: right; font-weight: 600; color: var(--text-secondary);">
                                    ${{ number_format($item->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Totals -->
                <div style="margin-top: 1.5rem; border-top: 2px solid var(--border-color); padding-top: 1rem;">
                    <div style="display: flex; justify-content: flex-end;">
                        <div style="width: 280px;">
                            <div
                                style="display: flex; justify-content: space-between; padding: 0.5rem 0; color: var(--text-muted); font-size: 0.9rem;">
                                <span>Subtotal</span>
                                <span>${{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div
                                style="display: flex; justify-content: space-between; padding: 0.5rem 0; color: var(--text-muted); font-size: 0.9rem;">
                                <span>Shipping</span>
                                <span>${{ number_format($order->shipping_cost, 2) }}</span>
                            </div>
                            <div
                                style="display: flex; justify-content: space-between; padding: 0.75rem 0; margin-top: 0.5rem; border-top: 2px solid var(--gold-primary); font-size: 1.3rem; font-weight: 700;">
                                <span style="color: #fff;">Grand Total</span>
                                <span style="color: var(--gold-primary);">${{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Info -->
                <div
                    style="margin-top: 2rem; background: rgba(200, 164, 90, 0.08); border: 1px solid rgba(200, 164, 90, 0.2); border-radius: 8px; padding: 1.25rem;">
                    <h4
                        style="color: var(--gold-primary); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.75rem;">
                        <i class="fab fa-paypal"></i> Payment Instructions
                    </h4>
                    <p style="color: var(--text-secondary); font-size: 0.9rem;">
                        Please transfer the total amount to our PayPal: <strong
                            style="color: #FFC107;">nattawutkongyod@hotmail.com</strong>
                    </p>
                </div>

                <!-- Admin Note Preview -->
                @if($order->admin_note)
                    <div
                        style="margin-top: 1.5rem; background: rgba(59, 130, 246, 0.08); border-left: 4px solid #3b82f6; padding: 1rem 1.25rem; border-radius: 0 8px 8px 0;">
                        <h4
                            style="color: #3b82f6; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">
                            Note</h4>
                        <p style="color: var(--text-secondary); font-size: 0.9rem; white-space: pre-line;">
                            {{ $order->admin_note }}</p>
                    </div>
                @endif

                <!-- Footer -->
                <div
                    style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid var(--border-color); text-align: center; color: var(--text-muted); font-size: 0.8rem;">
                    <p>Thank you for your business!</p>
                    <p>tattooink12studio.com &bull; Generated on {{ now()->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Send Invoice Panel -->
        <div>
            <div class="card" style="position: sticky; top: 80px;">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-paper-plane"></i> Send Invoice</h3>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; color: var(--text-muted); font-size: 0.8rem; margin-bottom: 0.4rem;">Send
                        To</label>
                    <div
                        style="background: var(--primary-dark); padding: 0.75rem 1rem; border-radius: 6px; border: 1px solid var(--border-color);">
                        <i class="fas fa-envelope" style="color: var(--gold-primary); margin-right: 0.5rem;"></i>
                        <span
                            style="color: #FFC107; font-weight: 600;">{{ $order->invoice_email ?? $order->customer_email }}</span>
                    </div>
                </div>

                <form action="{{ route('admin.invoices.send', $order) }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 1.25rem;">
                        <label
                            style="display: block; color: var(--text-muted); font-size: 0.8rem; margin-bottom: 0.4rem;">Note
                            / Message (optional)</label>
                        <textarea name="invoice_note" class="form-control" rows="5"
                            placeholder="Add notes or payment instructions for the customer..."
                            style="resize: vertical;">{{ $order->admin_note }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.9rem; font-size: 1rem;">
                        <i class="fas fa-paper-plane"></i> Send Invoice Email
                    </button>
                </form>

                @if($order->payment_status === 'waiting_invoice')
                    <div
                        style="margin-top: 1rem; padding: 0.75rem; background: rgba(255, 193, 7, 0.1); border: 1px solid rgba(255, 193, 7, 0.2); border-radius: 6px; text-align: center; font-size: 0.8rem; color: #FFC107;">
                        <i class="fas fa-info-circle"></i> Sending will update status to "Pending Payment"
                    </div>
                @endif

                <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
                    <h4 style="color: var(--text-muted); font-size: 0.8rem; margin-bottom: 0.75rem;">Order Info</h4>
                    <div style="display: grid; gap: 0.5rem; font-size: 0.85rem;">
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--text-muted);">Order #</span>
                            <span style="font-weight: 600; color: var(--gold-primary);">{{ $order->order_number }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--text-muted);">Status</span>
                            {!! $order->payment_status_badge !!}
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--text-muted);">Total</span>
                            <span
                                style="font-weight: 700; color: var(--gold-primary);">${{ number_format($order->total, 2) }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--text-muted);">Date</span>
                            <span style="color: var(--text-secondary);">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection