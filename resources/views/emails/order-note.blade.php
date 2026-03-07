<x-mail::message>
    # 📋 Order Update

    Dear **{{ $order->customer_name }}**,

    We have an update regarding your order:

    <x-mail::panel>
        **Order Number:** {{ $order->order_number }}
    </x-mail::panel>

    ## Message from our team:

    {{ $note }}

    ---

    If you have any questions, please don't hesitate to contact us.

    Best regards,<br>
    **tattooink12studio.com**
</x-mail::message>