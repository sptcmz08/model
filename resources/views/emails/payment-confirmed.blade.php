@component('mail::message')
# ✅ Payment Confirmed!

Dear **{{ $order->customer_name }}**,

Great news! Your payment for **Order #{{ $order->order_number }}** has been verified and confirmed.

@component('mail::panel')
**Order Number:** {{ $order->order_number }}

**Amount Paid:** ${{ number_format($order->total, 2) }}

**Status:** Payment Confirmed ✅
@endcomponent

## Order Summary

@component('mail::table')
| Product | Qty | Price |
|:--------|:---:|------:|
@foreach($order->items as $item)
    | {{ $item->product_name }} | {{ $item->quantity }} | ${{ number_format($item->total, 2) }} |
@endforeach
| | | |
| **Subtotal** | | ${{ number_format($order->subtotal, 2) }} |
| **Shipping** | | ${{ number_format($order->shipping_cost, 2) }} |
| **Total** | | **${{ number_format($order->total, 2) }}** |
@endcomponent

## What's Next?

1. ✅ Payment confirmed
2. 📦 **Your order is being prepared for shipping** ← You are here
3. 🚚 You will receive tracking information via email

We will send you another email with your tracking number once your order has been shipped.

Thank you for shopping with us! 🙏

Best regards,
**tattooink12studio.com**

@component('mail::subcopy')
You received this email because your payment was confirmed for your order at tattooink12studio.com.
@endcomponent
@endcomponent