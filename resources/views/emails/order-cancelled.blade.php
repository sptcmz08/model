<x-mail::message>
    # ❌ Order Cancelled

    Dear **{{ $order->customer_name }}**,

    We regret to inform you that your order has been **cancelled**.

    <x-mail::panel>
        **Order Number:** {{ $order->order_number }}
        **Total:** ${{ number_format($order->total, 2) }}
    </x-mail::panel>

    ## Reason for Cancellation:

    {{ $reason }}

    ---

    If you believe this is a mistake or have any questions, please don't hesitate to contact us at **nattawutkongyod@hotmail.com**.

    We apologize for any inconvenience and hope to serve you again in the future.

    Best regards,<br>
    **tattooink12studio.com**
</x-mail::message>
