@component('mail::message')
# 📩 Payment Receipt Received

Dear **{{ $order->customer_name }}**,

We have received your payment receipt for **Order #{{ $order->order_number }}**.

@component('mail::panel')
**Order Number:** {{ $order->order_number }}

**Amount:** ${{ number_format($order->total, 2) }}

**Status:** Awaiting Verification
@endcomponent

Our team is now reviewing your payment. We will confirm it shortly and notify you via email once your payment has been
verified.

## What's Next?

1. ✅ Payment receipt received
2. 🔍 **We are verifying your payment** ← You are here
3. 📦 Order will be processed and shipped

If you have any questions, please don't hesitate to contact us.

Thank you for your patience! 🙏

Best regards,
**tattooink12studio.com**

@component('mail::subcopy')
You received this email because you submitted a payment receipt for your order at tattooink12studio.com.
@endcomponent
@endcomponent