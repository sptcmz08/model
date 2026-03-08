@component('mail::message')
# Invoice #{{ $order->order_number }}

<div style="text-align: right; margin-bottom: 20px;">
    <strong>Date:</strong> {{ $order->created_at->format('d M Y') }}
</div>

---

## Bill To

**{{ $order->customer_name }}**
{{ $order->customer_email }}
{{ $order->customer_phone }}

@if($order->billing_address)
    {{ $order->billing_address }}
@endif

---

## Ship To

{{ $order->shipping_address }}

---

## Order Items

@component('mail::table')
| Item | Price | Qty | Total |
|:-----|------:|:---:|------:|
@foreach($order->items as $item)
    | {{ $item->product_name }} | ${{ number_format($item->price, 2) }} | {{ $item->quantity }} |
    ${{ number_format($item->total, 2) }} |
@endforeach
@endcomponent

@component('mail::table')
| | |
|---:|---:|
| **Subtotal** | ${{ number_format($order->subtotal, 2) }} |
| **Shipping** | ${{ number_format($order->shipping_cost, 2) }} |
| **Grand Total** | **${{ number_format($order->total, 2) }}** |
@endcomponent

---

## Payment Instructions

Please transfer the total amount of **${{ number_format($order->total, 2) }}** to our PayPal:

**nattawutkongyod@hotmail.com**

After payment, please reply to this email with your payment receipt/screenshot so we can process your order promptly.

@if($invoiceNote)
    ---

    ## Note from Admin

    {{ $invoiceNote }}
@endif

---

Thank you for your business!

Regards,
**tattooink12studio.com**
@endcomponent