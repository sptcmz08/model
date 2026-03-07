<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Receipt #{{ $order->order_number }}</title>
    <style>
        @font-face {
            font-family: 'Sarabun';
            src: url('{{ storage_path("fonts/Sarabun-Regular.ttf") }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Sarabun';
            src: url('{{ storage_path("fonts/Sarabun-Bold.ttf") }}') format('truetype');
            font-weight: bold;
            font-style: normal;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Sarabun', 'DejaVu Sans', sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.5;
        }

        .receipt-container {
            max-width: 700px;
            margin: 0 auto;
            padding: 30px;
        }

        /* Header */
        .receipt-header {
            text-align: center;
            border-bottom: 3px solid #c8a45a;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }

        .shop-name {
            font-size: 28px;
            font-weight: bold;
            color: #1a1a2e;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }

        .receipt-title {
            font-size: 20px;
            color: #c8a45a;
            font-weight: bold;
            margin-top: 8px;
        }

        /* Order Info Row */
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .info-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .info-label {
            font-size: 11px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 3px;
        }

        .info-value {
            font-size: 14px;
            font-weight: bold;
            color: #1a1a2e;
        }

        /* Section Title */
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #c8a45a;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 6px;
            margin-bottom: 10px;
            margin-top: 20px;
        }

        /* Customer Info */
        .customer-info p {
            margin-bottom: 3px;
            font-size: 13px;
        }

        .customer-info .label {
            color: #888;
            display: inline-block;
            width: 80px;
        }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .items-table thead th {
            background-color: #1a1a2e;
            color: #fff;
            padding: 10px 12px;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .items-table thead th:last-child,
        .items-table thead th:nth-child(2),
        .items-table thead th:nth-child(3) {
            text-align: right;
        }

        .items-table tbody td {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
            font-size: 13px;
        }

        .items-table tbody td:last-child,
        .items-table tbody td:nth-child(2),
        .items-table tbody td:nth-child(3) {
            text-align: right;
        }

        .items-table tbody tr:nth-child(even) {
            background-color: #fafafa;
        }

        /* Totals */
        .totals-section {
            margin-top: 15px;
            border-top: 2px solid #e0e0e0;
            padding-top: 10px;
        }

        .totals-row {
            display: table;
            width: 100%;
            padding: 4px 0;
        }

        .totals-label {
            display: table-cell;
            text-align: right;
            padding-right: 20px;
            font-size: 13px;
            color: #666;
        }

        .totals-value {
            display: table-cell;
            text-align: right;
            width: 120px;
            font-size: 13px;
        }

        .grand-total {
            border-top: 2px solid #c8a45a;
            margin-top: 8px;
            padding-top: 8px;
        }

        .grand-total .totals-label {
            font-size: 16px;
            font-weight: bold;
            color: #1a1a2e;
        }

        .grand-total .totals-value {
            font-size: 18px;
            font-weight: bold;
            color: #c8a45a;
        }

        /* Note Section */
        .note-section {
            margin-top: 25px;
            background-color: #f8f6f0;
            border: 1px solid #e8e2d0;
            border-left: 4px solid #c8a45a;
            padding: 15px;
            border-radius: 0 6px 6px 0;
        }

        .note-section .note-title {
            font-size: 13px;
            font-weight: bold;
            color: #c8a45a;
            margin-bottom: 6px;
        }

        .note-section .note-content {
            font-size: 13px;
            color: #555;
            white-space: pre-line;
        }

        /* Footer */
        .receipt-footer {
            margin-top: 30px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
            padding-top: 15px;
            color: #999;
            font-size: 11px;
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        {{-- Header --}}
        <div class="receipt-header">
            <div class="shop-name">tattooink12studio.com</div>
            <div class="receipt-title">RECEIPT / ใบเสร็จรับเงิน</div>
        </div>

        {{-- Order Info --}}
        <div class="info-row">
            <div class="info-col">
                <div class="info-label">Order Number</div>
                <div class="info-value">#{{ $order->order_number }}</div>
            </div>
            <div class="info-col" style="text-align: right;">
                <div class="info-label">Date</div>
                <div class="info-value">{{ $order->created_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>

        {{-- Customer Info --}}
        <div class="section-title">Customer Information / ข้อมูลลูกค้า</div>
        <div class="customer-info">
            <p><span class="label">Name:</span> {{ $order->customer_name }}</p>
            <p><span class="label">Email:</span> {{ $order->customer_email }}</p>
            <p><span class="label">Phone:</span> {{ $order->customer_phone }}</p>
        </div>

        {{-- Shipping Address --}}
        <div class="section-title">Shipping Address / ที่อยู่จัดส่ง</div>
        <div class="customer-info">
            <p>{{ $order->shipping_address }}</p>
        </div>

        {{-- Items --}}
        <div class="section-title">Order Items / รายการสินค้า</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Product / สินค้า</th>
                    <th>Price / ราคา</th>
                    <th>Qty / จำนวน</th>
                    <th>Total / รวม</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totals --}}
        <div class="totals-section">
            <div class="totals-row">
                <div class="totals-label">Subtotal / ยอดรวมย่อย</div>
                <div class="totals-value">${{ number_format($order->subtotal, 2) }}</div>
            </div>
            <div class="totals-row">
                <div class="totals-label">Shipping / ค่าจัดส่ง</div>
                <div class="totals-value">${{ number_format($order->shipping_cost, 2) }}</div>
            </div>
            <div class="totals-row grand-total">
                <div class="totals-label">Grand Total / ยอดสุทธิ</div>
                <div class="totals-value">${{ number_format($order->total, 2) }}</div>
            </div>
        </div>

        {{-- Note --}}
        @if($order->admin_note)
            <div class="note-section">
                <div class="note-title">Note / หมายเหตุ</div>
                <div class="note-content">{{ $order->admin_note }}</div>
            </div>
        @endif

        {{-- Footer --}}
        <div class="receipt-footer">
            <p>Thank you for your purchase! / ขอบคุณที่อุดหนุนครับ</p>
            <p>tattooink12studio.com &bull; Generated on {{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>

</html>