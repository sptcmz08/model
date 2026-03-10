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
                            <img src="https://tattooink12studio.com/images/logo_new.png" alt="tattooink12studio.com" style="max-height:60px; width:auto;">
                            <div style="font-size:14px; color:#999; margin-top:6px;">tattooink12studio.com</div>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td align="center" style="padding: 10px 40px;">
                            <div style="font-size:16px; color:#333;">Hello <strong>{{ $order->customer_name }}</strong>,</div>
                            <div style="font-size:14px; color:#777; margin-top:4px;">we have an update on your order.</div>
                        </td>
                    </tr>

                    <!-- Title -->
                    <tr>
                        <td align="center" style="padding: 20px 40px 30px;">
                            <div style="font-size:28px; font-weight:bold; color:#111;">Order Update</div>
                            <div style="font-size:16px; color:#555; margin-top:6px;">#{{ $order->order_number }}</div>
                        </td>
                    </tr>

                    <!-- Divider -->
                    <tr><td style="padding:0 40px;"><div style="border-top:1px solid #eee;"></div></td></tr>

                    <!-- Note -->
                    <tr>
                        <td style="padding: 25px 40px;">
                            <div style="font-size:14px; color:#333; line-height:1.6; background-color:#fafafa; padding:15px 20px; border-left:3px solid #ddd;">{{ $note }}</div>
                        </td>
                    </tr>

                    <!-- Divider -->
                    <tr><td style="padding:0 40px;"><div style="border-top:1px solid #eee;"></div></td></tr>

                    <!-- Footer Message -->
                    <tr>
                        <td align="center" style="padding: 25px 40px;">
                            <div style="font-size:13px; color:#999;">If you have questions, please contact us.</div>
                        </td>
                    </tr>

                    <!-- Bottom -->
                    <tr>
                        <td align="center" style="padding: 15px 40px 25px; background-color:#fafafa; border-top:1px solid #eee;">
                            <div style="font-size:12px; color:#aaa;">&copy; {{ date('Y') }} tattooink12studio.com. All rights reserved.</div>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>