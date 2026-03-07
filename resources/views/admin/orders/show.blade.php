@extends('admin.layouts.app')

@section('title', 'Order Details')
@section('page-title', 'Order Details')

@section('content')
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
        <!-- Order Details -->
        <div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Order #{{ $order->order_number }}</h3>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm"
                        style="background: var(--primary-dark); color: var(--text-secondary);">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                    <div>
                        <h4 style="color: var(--gold-primary); margin-bottom: 1rem; font-size: 0.9rem;">Billing Address</h4>
                        <p style="color: var(--text-secondary); white-space: pre-line;">
                            {{ $order->billing_address ?? $order->shipping_address }}</p>
                        <div style="margin-top: 1rem; color: var(--text-muted); font-size: 0.85rem;">
                            <p><i class="fas fa-user"></i> {{ $order->customer_name }}</p>
                            <p><i class="fas fa-envelope"></i> {{ $order->customer_email }}</p>
                            <p><i class="fas fa-phone"></i> {{ $order->customer_phone }}</p>
                        </div>
                    </div>
                    <div>
                        <h4 style="color: var(--gold-primary); margin-bottom: 1rem; font-size: 0.9rem;">Shipping Address</h4>
                        <p style="color: var(--text-secondary); white-space: pre-line;">{{ $order->shipping_address }}</p>
                    </div>
                </div>

                <h4 style="color: var(--gold-primary); margin-bottom: 1rem; font-size: 0.9rem;">Order Items</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        @if($item->product)
                                            <img src="{{ $item->product->main_image }}" alt="{{ $item->product_name }}"
                                                class="product-thumb">
                                        @endif
                                        <span>{{ $item->product_name }}</span>
                                    </div>
                                </td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td style="color: var(--gold-primary);">${{ number_format($item->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: right;"><strong>Subtotal</strong></td>
                            <td>${{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: right;"><strong>Shipping</strong></td>
                            <td>${{ number_format($order->shipping_cost, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: right;"><strong style="font-size: 1.1rem;">Grand Total</strong>
                            </td>
                            <td style="color: var(--gold-primary); font-size: 1.25rem; font-weight: 700;">
                                ${{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Order Status -->
        <div>
            <div class="card">
                <h4 style="color: var(--gold-primary); margin-bottom: 1.5rem;">Order Status</h4>

                <div style="margin-bottom: 1.5rem;">
                    <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 0.5rem;">Current Status</p>
                    <div>{!! $order->status_badge !!}</div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 0.5rem;">Payment Status</p>
                    <div>{!! $order->payment_status_badge !!}</div>
                </div>

                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="form-group mb-4">
                        <label for="tracking_number" class="form-label">Tracking Number</label>
                        
                        @if($order->tracking_number)
                            <div id="tracking-display" style="background: rgba(40, 167, 69, 0.1); border: 1px solid #28a745; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-weight: 600; color: #28a745;"><i class="fas fa-truck"></i> {{ $order->tracking_number }}</span>
                                    <button type="button" onclick="document.getElementById('tracking-display').style.display='none'; document.getElementById('tracking-edit').style.display='block';" 
                                            style="background: var(--gold-primary); border: none; color: #000; padding: 0.3rem 0.8rem; border-radius: 4px; font-size: 0.8rem; cursor: pointer;">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                </div>
                            </div>
                            <div id="tracking-edit" style="display: none;">
                                <input type="text" class="form-control" id="tracking_number"
                                    name="tracking_number" value="{{ old('tracking_number', $order->tracking_number) }}"
                                    placeholder="Enter new tracking number">
                                <small style="color: var(--warning); display: block; margin-top: 0.5rem;"><i class="fas fa-exclamation-triangle"></i> Editing will send an email to the customer</small>
                                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 0.75rem;">
                                    <i class="fas fa-save"></i> Save New Tracking
                                </button>
                            </div>
                        @else
                            <input type="text" class="form-control" id="tracking_number"
                                name="tracking_number" value="{{ old('tracking_number') }}"
                                placeholder="Enter tracking number">
                            <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">* Adding a tracking number will auto-change status to "Shipped"</small>
                            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 0.75rem;">
                                <i class="fas fa-save"></i> Save
                            </button>
                        @endif
                    </div>
                </form>
            </div>

            <div class="card">
                <h4 style="color: var(--gold-primary); margin-bottom: 1rem;">Payment Receipt</h4>

                @if($order->payment_slip)
                    <div style="margin-bottom: 1rem; text-align: center;">
                        <a href="{{ Storage::disk('public')->url($order->payment_slip) }}" target="_blank">
                            <img src="{{ Storage::disk('public')->url($order->payment_slip) }}" 
                                 alt="Payment Slip" 
                                 style="max-width: 100%; border: 1px solid var(--border-color); border-radius: 8px;">
                        </a>
                        <p style="color: var(--text-muted); font-size: 0.8rem; margin-top: 0.5rem;">Click image to enlarge</p>
                    </div>
                    
                    @if($order->payment_status !== 'completed')
                    <form action="{{ route('admin.orders.confirm-payment', $order) }}" method="POST" style="margin-top: 1rem;">
                        @csrf
                        <button type="submit" class="btn" style="width: 100%; background: linear-gradient(135deg, #28a745, #218838); color: #fff; padding: 0.8rem; font-weight: 600;" 
                                onclick="return confirm('Confirm payment received?')">
                            <i class="fas fa-check-circle"></i> Confirm Payment
                        </button>
                    </form>
                    @else
                    <div style="background: rgba(40, 167, 69, 0.2); border: 1px solid #28a745; padding: 1rem; border-radius: 8px; text-align: center;">
                        <i class="fas fa-check-circle" style="color: #28a745; font-size: 1.5rem;"></i>
                        <p style="color: #28a745; font-weight: 600; margin-top: 0.5rem;">Payment Confirmed</p>
                    </div>
                    @endif
                @else
                    <p style="color: var(--text-muted);">No receipt uploaded yet</p>
                @endif
                
                <hr style="border-color: var(--border-color); margin: 1.5rem 0;">

                <h4 style="color: var(--gold-primary); margin-bottom: 1rem;">Payment Method</h4>
                @if($order->payment_method === 'invoice')
                    <div style="background: rgba(255, 193, 7, 0.15); border: 1px solid #FFC107; padding: 1.25rem; border-radius: 8px; margin-bottom: 1rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                            <span class="badge bg-warning" style="font-size: 0.85rem; padding: 0.4rem 0.75rem;">
                                <i class="fas fa-file-invoice"></i> Invoice Request
                            </span>
                            @if($order->payment_status === 'waiting_invoice')
                                <span class="badge bg-info"><i class="fas fa-clock"></i> Need to send Invoice</span>
                            @endif
                        </div>
                        <p style="color: var(--text-secondary); font-size: 0.85rem; margin-bottom: 0.5rem;">Customer requested invoice to:</p>
                        <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                            <strong style="font-size: 1.1rem; color: #FFC107;" id="invoiceEmail">{{ $order->invoice_email }}</strong>
                            <button onclick="navigator.clipboard.writeText(document.getElementById('invoiceEmail').textContent); this.innerHTML='<i class=\'fas fa-check\'></i> Copied!'; setTimeout(() => this.innerHTML='<i class=\'fas fa-copy\'></i> Copy', 2000);"
                                    style="background: #FFC107; color: #000; border: none; padding: 0.3rem 0.8rem; border-radius: 4px; font-size: 0.8rem; font-weight: 600; cursor: pointer;">
                                <i class="fas fa-copy"></i> Copy
                            </button>
                        </div>
                    </div>
                @else
                    <div style="margin-bottom: 1rem;">
                        <span class="badge bg-primary" style="font-size: 0.85rem; padding: 0.4rem 0.75rem;">
                            <i class="fab fa-paypal"></i> Direct Transfer
                        </span>
                    </div>
                @endif

                <h4 style="color: var(--gold-primary); margin-bottom: 1rem;">PayPal Info</h4>
                <p style="color: var(--text-secondary); font-size: 0.85rem;">
                    <strong>PayPal Email:</strong> nattawutkongyod@hotmail.com
                </p>
            </div>

            <div class="card">
                <h4 style="color: var(--gold-primary); margin-bottom: 1rem;"><i class="fas fa-comment-alt"></i> Send Note to Customer</h4>
                <form action="{{ route('admin.orders.send-note', $order) }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="note" class="form-label" style="color: var(--text-secondary);">Message</label>
                        <textarea class="form-control" 
                                  id="note" name="note" rows="4" 
                                  placeholder="e.g. Order received, your item is being prepared..."
                                  required>{{ old('note', $order->admin_note) }}</textarea>
                        <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">This message will be sent to: {{ $order->customer_email }}</small>
                    </div>
                    <button type="submit" class="btn" style="width: 100%; background: linear-gradient(135deg, #17a2b8, #138496); color: #fff; padding: 0.8rem;">
                        <i class="fas fa-paper-plane"></i> Send Email to Customer
                    </button>
                </form>

                @if($order->admin_note)
                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
                    <a href="{{ route('admin.orders.receipt', $order) }}" target="_blank" 
                       class="btn" style="width: 100%; background: linear-gradient(135deg, #c8a45a, #b8943a); color: #fff; padding: 0.8rem; font-weight: 600; text-decoration: none; display: block; text-align: center;">
                        <i class="fas fa-file-pdf"></i> Print Receipt
                    </a>
                </div>
                @endif
            </div>

            <div class="card">
                <h4 style="color: var(--gold-primary); margin-bottom: 1rem;">Timeline</h4>
                <div style="color: var(--text-secondary); font-size: 0.9rem;">
                    <p><i class="fas fa-calendar" style="margin-right: 0.5rem; color: var(--text-muted);"></i> Created:
                        {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p><i class="fas fa-clock" style="margin-right: 0.5rem; color: var(--text-muted);"></i> Last Updated:
                        {{ $order->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection