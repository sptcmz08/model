@extends('admin.layouts.app')

@section('title', 'Invoice Management')
@section('page-title', 'Invoice Management')

@section('content')
    <!-- Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
        <div class="card" style="text-align: center; padding: 1.5rem;">
            <div style="font-size: 2rem; font-weight: 700; color: var(--gold-primary);">{{ $stats['total'] }}</div>
            <div style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.25rem;">Total Invoices</div>
        </div>
        <div class="card" style="text-align: center; padding: 1.5rem;">
            <div style="font-size: 2rem; font-weight: 700; color: #FFC107;">{{ $stats['waiting'] }}</div>
            <div style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.25rem;">Waiting to Send</div>
        </div>
        <div class="card" style="text-align: center; padding: 1.5rem;">
            <div style="font-size: 2rem; font-weight: 700; color: #28a745;">{{ $stats['paid'] }}</div>
            <div style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.25rem;">Paid</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card" style="margin-bottom: 1.5rem;">
        <form action="{{ route('admin.invoices.index') }}" method="GET" style="display: flex; gap: 1rem; align-items: end; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; color: var(--text-muted); font-size: 0.8rem; margin-bottom: 0.4rem;">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Order #, name, email..."
                    value="{{ request('search') }}">
            </div>
            <div style="min-width: 180px;">
                <label style="display: block; color: var(--text-muted); font-size: 0.8rem; margin-bottom: 0.4rem;">Status</label>
                <select name="payment_status" class="form-control">
                    <option value="">All Status</option>
                    <option value="waiting_invoice" {{ request('payment_status') == 'waiting_invoice' ? 'selected' : '' }}>Waiting Invoice</option>
                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending Payment</option>
                    <option value="awaiting_verification" {{ request('payment_status') == 'awaiting_verification' ? 'selected' : '' }}>Awaiting Verification</option>
                    <option value="completed" {{ request('payment_status') == 'completed' ? 'selected' : '' }}>Paid</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="height: 42px;">
                <i class="fas fa-search"></i> Filter
            </button>
            @if(request()->hasAny(['search', 'payment_status']))
                <a href="{{ route('admin.invoices.index') }}" class="btn btn-sm" style="background: var(--primary-dark); color: var(--text-muted); height: 42px; display: flex; align-items: center;">
                    <i class="fas fa-times"></i> Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Invoice List -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-file-invoice"></i> Invoice Orders</h3>
            <span class="badge bg-primary">{{ $invoices->total() }} records</span>
        </div>

        @if($invoices->count() > 0)
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Invoice Email</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.orders.show', $invoice) }}" style="color: var(--gold-primary); font-weight: 600; text-decoration: none;">
                                        {{ $invoice->order_number }}
                                    </a>
                                </td>
                                <td>
                                    <div>
                                        <strong style="color: var(--text-secondary);">{{ $invoice->customer_name }}</strong>
                                        <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $invoice->customer_email }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <span style="color: #FFC107; font-weight: 600;">{{ $invoice->invoice_email }}</span>
                                        <button onclick="navigator.clipboard.writeText('{{ $invoice->invoice_email }}'); this.innerHTML='<i class=\'fas fa-check\'></i>'; setTimeout(() => this.innerHTML='<i class=\'fas fa-copy\'></i>', 1500);"
                                                style="background: none; border: 1px solid var(--border-color); color: var(--text-muted); padding: 0.15rem 0.4rem; border-radius: 4px; cursor: pointer; font-size: 0.75rem;">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </td>
                                <td style="color: var(--gold-primary); font-weight: 600;">${{ number_format($invoice->total, 2) }}</td>
                                <td>{!! $invoice->payment_status_badge !!}</td>
                                <td style="color: var(--text-muted); font-size: 0.85rem;">{{ $invoice->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.4rem;">
                                        <a href="{{ route('admin.invoices.show', $invoice) }}" class="btn btn-sm"
                                            style="background: #E60914; color: #fff; font-size: 0.8rem; padding: 0.3rem 0.75rem;">
                                            <i class="fas fa-file-invoice"></i> Invoice
                                        </a>
                                        <a href="{{ route('admin.orders.show', $invoice) }}" class="btn btn-sm"
                                            style="background: var(--gold-primary); color: #000; font-size: 0.8rem; padding: 0.3rem 0.75rem;">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($invoices->hasPages())
                <div style="padding: 1rem; display: flex; justify-content: center;">
                    {{ $invoices->links() }}
                </div>
            @endif
        @else
            <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
                <i class="fas fa-file-invoice" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                <p>No invoice orders found</p>
            </div>
        @endif
    </div>
@endsection
