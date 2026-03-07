<x-mail::message>
    # 🎉 Order Confirmation

    Dear **{{ $order->customer_name }}**,

    Thank you for your order! We have received your payment and your order is now being processed.

    <x-mail::panel>
        ## Order Details

        **Order Number:** {{ $order->order_number }}

        **Order Date:** {{ $order->created_at->format('M d, Y H:i') }}

        **Shipping Address:**
        {{ $order->shipping_address }}
    </x-mail::panel>

    ## Order Summary

    <x-mail::table>
        | Product | Qty | Price |
        |:--------|:---:|------:|
        @foreach($order->items as $item)
            | {{ $item->product_name }} | {{ $item->quantity }} | ${{ number_format($item->total, 2) }} |
        @endforeach
        | | | |
        | **Subtotal** | | ${{ number_format($order->subtotal, 2) }} |
        | **Shipping** | | ${{ number_format($order->shipping_cost, 2) }} |
        | **Total** | | **${{ number_format($order->total, 2) }}** |
    </x-mail::table>

    ---

    ## What's Next?

    We will verify your payment and process your order shortly. You will receive another email with tracking information
    once your order has been shipped.

    If you have any questions, please don't hesitate to contact us.

    Thank you for shopping with us! 🙏

    Best regards,<br>
    **tattooink12studio.com**

    <x-mail::subcopy>
        You received this email because you placed an order with tattooink12studio.com.
    </x-mail::subcopy>
</x-mail::message>