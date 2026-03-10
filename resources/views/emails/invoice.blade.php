<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0; padding:0; background-color:#f4f4f4; font-family: Arial, Helvetica, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4; padding: 30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:4px; overflow:hidden;">

                    <!-- Logo -->
                    <tr>
                        <td align="center" style="padding: 30px 40px 20px;">
                            <img src="https://tattooink12studio.com/images/logo_new.jpg" alt="tattooink12studio.com" style="max-height:60px; width:auto;">
                            <div style="font-size:14px; color:#999; margin-top:6px;">tattooink12studio.com</div>
                        </td>
                    </tr>

                    <!-- Greeting -->
                    <tr>
                        <td align="center" style="padding: 10px 40px;">
                            <div style="font-size:16px; color:#333;">Hello <strong>{{ $order->customer_name }}</strong>,</div>
                            <div style="font-size:14px; color:#777; margin-top:4px;">here is your invoice.</div>
                        </td>
                    </tr>

                    <!-- Invoice Number -->
                    <tr>
                        <td align="center" style="padding: 20px 40px 30px;">
                            <div style="font-size:28px; font-weight:bold; color:#111;">Invoice</div>
                            <div style="font-size:16px; color:#555; margin-top:6px;">#{{ $order->order_number }}</div>
                        </td>
                    </tr>

                    <!-- Divider -->
                    <tr><td style="padding:0 40px;"><div style="border-top:1px solid #eee;"></div></td></tr>

                    <!-- Info -->
                    <tr>
                        <td style="padding: 20px 40px;">
                            <div style="font-size:12px; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:10px;">Invoice information:</div>
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="50%" style="vertical-align:top; padding-bottom:10px;">
                                        <div style="font-size:12px; color:#999;">Date:</div>
                                        <div style="font-size:14px; color:#333;">{{ $order->created_at->format('F d, Y') }}</div>
                                    </td>
                                    <td width="50%" style="vertical-align:top; padding-bottom:10px;">
                                        <div style="font-size:12px; color:#999;">Email:</div>
                                        <div style="font-size:14px; color:#333;">{{ $order->customer_email }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%" style="vertical-align:top; padding-bottom:10px;">
                                        <div style="font-size:12px; color:#999;">Bill to:</div>
                                        <div style="font-size:14px; color:#333;">{{ $order->customer_name }}</div>
                                        @if($order->billing_address)
                                        <div style="font-size:13px; color:#666;">{{ $order->billing_address }}</div>
                                        @endif
                                    </td>
                                    <td width="50%" style="vertical-align:top; padding-bottom:10px;">
                                        <div style="font-size:12px; color:#999;">Ship to:</div>
                                        <div style="font-size:14px; color:#333;">{{ $order->shipping_address }}</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Divider -->
                    <tr><td style="padding:0 40px;"><div style="border-top:1px solid #eee;"></div></td></tr>

                    <!-- Items -->
                    <tr>
                        <td style="padding: 20px 40px;">
                            <div style="font-size:12px; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:10px;">Order items:</div>
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #eee;">
                                <tr style="background-color:#fafafa;">
                                    <td style="padding:8px 10px; font-size:12px; font-weight:bold; color:#666;">Item</td>
                                    <td align="right" style="padding:8px 10px; font-size:12px; font-weight:bold; color:#666;">Price</td>
                                    <td align="center" style="padding:8px 10px; font-size:12px; font-weight:bold; color:#666;">Qty</td>
                                    <td align="right" style="padding:8px 10px; font-size:12px; font-weight:bold; color:#666;">Total</td>
                                </tr>
                                @foreach($order->items as $item)
                                <tr>
                                    <td style="padding:10px; font-size:14px; color:#333; border-top:1px solid #f0f0f0;">{{ $item->product_name }}</td>
                                    <td align="right" style="padding:10px; font-size:14px; color:#333; border-top:1px solid #f0f0f0;">${{ number_format($item->price, 2) }}</td>
                                    <td align="center" style="padding:10px; font-size:14px; color:#333; border-top:1px solid #f0f0f0;">{{ $item->quantity }}</td>
                                    <td align="right" style="padding:10px; font-size:14px; color:#333; border-top:1px solid #f0f0f0;">${{ number_format($item->total, 2) }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>

                    <!-- Totals -->
                    <tr>
                        <td style="padding: 0 40px 20px;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding:6px 10px; font-size:14px; color:#666;">Subtotal</td>
                                    <td align="right" style="padding:6px 10px; font-size:14px; color:#333;">${{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 10px; font-size:14px; color:#666;">Shipping</td>
                                    <td align="right" style="padding:6px 10px; font-size:14px; color:#333;">${{ number_format($order->shipping_cost, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 10px 6px; font-size:16px; font-weight:bold; color:#333; border-top:1px solid #eee;">Grand Total</td>
                                    <td align="right" style="padding:10px 10px 6px; font-size:16px; font-weight:bold; color:#333; border-top:1px solid #eee;">${{ number_format($order->total, 2) }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Divider -->
                    <tr><td style="padding:0 40px;"><div style="border-top:1px solid #eee;"></div></td></tr>

                    <!-- Payment Instructions -->
                    <tr>
                        <td style="padding: 20px 40px;">
                            <div style="font-size:14px; color:#333; margin-bottom:8px;">Please transfer <strong>${{ number_format($order->total, 2) }}</strong> to our PayPal:</div>
                            <div style="font-size:14px; color:#333; font-weight:bold; margin-bottom:15px;">nattawutkongyod@hotmail.com</div>
                            <div style="text-align:center;">
                                <a href="{{ url('/checkout/confirm-payment/' . $order->order_number) }}" style="display:inline-block; padding:12px 30px; background-color:#22c55e; color:#ffffff; text-decoration:none; font-size:14px; font-weight:bold; border-radius:4px;">Upload Payment Receipt</a>
                            </div>
                        </td>
                    </tr>

                    @if($invoiceNote)
                    <!-- Admin Note -->
                    <tr><td style="padding:0 40px;"><div style="border-top:1px solid #eee;"></div></td></tr>
                    <tr>
                        <td style="padding: 20px 40px;">
                            <div style="font-size:12px; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:6px;">Note:</div>
                            <div style="font-size:14px; color:#333;">{{ $invoiceNote }}</div>
                        </td>
                    </tr>
                    @endif

                    <!-- Bottom -->
                    <tr>
                        <td align="center" style="padding: 20px 40px 25px; background-color:#fafafa; border-top:1px solid #eee;">
                            <div style="font-size:12px; color:#aaa;">&copy; {{ date('Y') }} tattooink12studio.com. All rights reserved.</div>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>