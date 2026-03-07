<x-mail::message>
    # ⚠️ Tracking Number Correction

    Dear **{{ $order->customer_name }}**,

    We sincerely apologize for the inconvenience. The tracking number we previously provided was incorrect.

    <x-mail::panel>
        ## Updated Tracking Information

        **Order Number:** {{ $order->order_number }}

        ~~**Previous (Incorrect):** {{ $oldTracking }}~~

        ✅ **Correct Tracking Number:** {{ $order->tracking_number }}
    </x-mail::panel>

    Please use the **new tracking number** above to track your package.

    We apologize for any confusion this may have caused and thank you for your understanding.

    If you have any questions, please don't hesitate to contact us.

    Best regards,<br>
    **tattooink12studio.com**
</x-mail::message>