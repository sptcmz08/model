@extends('admin.layouts.app')

@section('title', 'Orders')
@section('page-title', 'Order Management')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Orders</h3>
            <div style="display: flex; gap: 1rem;">
                <select class="form-control" style="width: auto;" onchange="filterByStatus(this.value)">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Payment</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <select class="form-control" style="width: auto;" onchange="filterByMethod(this.value)">
                    <option value="">All Methods</option>
                    <option value="direct" {{ request('method') == 'direct' ? 'selected' : '' }}>Direct Transfer</option>
                    <option value="invoice" {{ request('method') == 'invoice' ? 'selected' : '' }}>Invoice</option>
                </select>
            </div>
        </div>

        @if($orders->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Method</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td><strong>{{ $order->order_number }}</strong></td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ $order->customer_email }}</td>
                            <td style="color: var(--gold-primary);">${{ number_format($order->total, 2) }}</td>
                            <td>{!! $order->status_badge !!}</td>
                            <td>{!! $order->payment_status_badge !!}</td>
                            <td>
                                @if($order->payment_method === 'invoice')
                                    <span class="badge bg-primary"><i class="fas fa-file-invoice"></i> Invoice</span>
                                @else
                                    <span class="badge bg-info"><i class="fab fa-paypal"></i> Direct</span>
                                @endif
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td style="white-space: nowrap;">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-view">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <button class="btn btn-sm btn-danger" onclick="deleteOrder({{ $order->id }}, '{{ $order->order_number }}')" style="margin-left:4px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $order->id }}" action="{{ route('admin.orders.destroy', $order) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="padding: 1rem;">
                {{ $orders->links() }}
            </div>
        @else
            <p style="text-align: center; color: var(--text-muted); padding: 3rem;">No orders found</p>
        @endif
    </div>

    <script>
        function filterByStatus(status) {
            const url = new URL(window.location.href);
            if (status) {
                url.searchParams.set('status', status);
            } else {
                url.searchParams.delete('status');
            }
            window.location.href = url.toString();
        }

        function filterByMethod(method) {
            const url = new URL(window.location.href);
            if (method) {
                url.searchParams.set('method', method);
            } else {
                url.searchParams.delete('method');
            }
            window.location.href = url.toString();
        }

        function deleteOrder(orderId, orderNumber) {
            if (confirm('Delete order #' + orderNumber + '? This cannot be undone.')) {
                document.getElementById('delete-form-' + orderId).submit();
            }
        }
    </script>
@endsection