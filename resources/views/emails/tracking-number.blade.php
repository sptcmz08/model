<x-mail::message>
    # 📦 Your Order Has Been Shipped!

    Dear **{{ $order->customer_name }}**,

    Great news! Your order has been shipped and is on its way to you.

    <x-mail::panel>
        ## Tracking Information

        **Order Number:** {{ $order->order_number }}

        **Tracking Number:** {{ $order->tracking_number }}

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
        | **Total** | | **${{ number_format($order->total, 2) }}** |
    </x-mail::table>

    ---

    If you have any questions about your order, please don't hesitate to contact us.

    Thank you for shopping with us! 🙏

    Best regards,<br>
    **tattooink12studio.com**

    <x-mail::subcopy>
        You received this email because you placed an order with tattooink12studio.com.
    </x-mail::subcopy>
</x-mail::message>