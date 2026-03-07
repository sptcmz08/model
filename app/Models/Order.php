<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'billing_address',
        'shipping_address',
        'subtotal',
        'shipping_cost',
        'total',
        'status',
        'paypal_order_id',
        'paypal_capture_id',
        'payment_status',
        'tracking_number',
        'payment_slip',
        'admin_note',
        'payment_method',
        'invoice_email',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'TI12';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -4));
        return $prefix . $date . $random;
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => '<span class="badge bg-warning">Wait for Payment</span>',
            'waiting_invoice' => '<span class="badge bg-info"><i class="fas fa-file-invoice"></i> Waiting for Invoice</span>',
            'paid' => '<span class="badge bg-info">Paid - Wait for Shipping</span>',
            'processing' => '<span class="badge bg-primary">Processing</span>',
            'shipped' => '<span class="badge bg-success">Paid - Shipped</span>',
            'completed' => '<span class="badge bg-success">Completed</span>',
            'cancelled' => '<span class="badge bg-danger">Cancelled</span>',
            default => '<span class="badge bg-dark">Unknown</span>',
        };
    }

    public function getPaymentStatusBadgeAttribute(): string
    {
        return match ($this->payment_status) {
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'waiting_invoice' => '<span class="badge bg-primary"><i class="fas fa-file-invoice"></i> Waiting Invoice</span>',
            'completed' => '<span class="badge bg-success">Paid</span>',
            'failed' => '<span class="badge bg-danger">Failed</span>',
            'refunded' => '<span class="badge bg-info">Refunded</span>',
            'awaiting_verification' => '<span class="badge bg-info">Awaiting Verification</span>',
            default => '<span class="badge bg-dark">Unknown</span>',
        };
    }
}
