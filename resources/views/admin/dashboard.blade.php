@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon gold">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['total_products'] }}</h3>
                <p>Total Products</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-folder"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['total_categories'] }}</h3>
                <p>Categories</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['total_orders'] }}</h3>
                <p>Total Orders</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-info">
                <h3>${{ number_format($stats['total_revenue'], 2) }}</h3>
                <p>Total Revenue</p>
            </div>
        </div>
    </div>

    <div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['pending_orders'] }}</h3>
                <p>Awaiting Verification</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(139,92,246,0.2); color: #8b5cf6;">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="stat-info">
                <h3>{{ \App\Models\Order::where('payment_method', 'invoice')->where('payment_status', 'waiting_invoice')->count() }}
                </h3>
                <p>Waiting Invoice</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['completed_orders'] }}</h3>
                <p>Completed Orders</p>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Recent Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">View All</a>
        </div>

        @if($recentOrders->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Method</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                        <tr>
                            <td><strong>{{ $order->order_number }}</strong></td>
                            <td>{{ $order->customer_name }}</td>
                            <td>${{ number_format($order->total, 2) }}</td>
                            <td>{!! $order->status_badge !!}</td>
                            <td>{!! $order->payment_status_badge !!}</td>
                            <td>
                                @if($order->payment_method === 'invoice')
                                    <span class="badge bg-primary"><i class="fas fa-file-invoice"></i> Invoice</span>
                                @else
                                    <span class="badge bg-info"><i class="fab fa-paypal"></i> Direct</span>
                                @endif
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-view">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; color: var(--text-muted); padding: 2rem;">No orders found</p>
        @endif
    </div>
@endsection