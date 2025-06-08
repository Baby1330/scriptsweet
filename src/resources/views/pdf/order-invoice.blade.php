<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->order_code }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #daf3d9;
            padding: 40px;
            font-size: 14px;
            color: #111;
        }

        h1, h2, h3, h4 {
            margin: 0;
        }

        .header, .footer {
            margin-bottom: 30px;
        }

        .header-flex {
            display: flex;
            justify-content: space-between;
        }

        .company-info {
            width: 60%;
        }

        .invoice-info {
            width: 35%;
            text-align: right;
        }

        .client-flex {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .client-details {
            width: 60%;
        }

        .invoice-details {
            width: 35%;
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table thead {
            background-color: #f0f0f0;
        }

        table, th, td {
            border: 1px solid #333;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        .totals-box {
            margin-top: 20px;
            width: 300px;
            background: #c8e6c9;
            padding: 15px;
            border-radius: 8px;
            float: right;
        }

        .totals-box table {
            width: 100%;
            border: none;
        }

        .totals-box td {
            border: none;
            padding: 4px 8px;
        }

        .footer {
            margin-top: 60px;
            text-align: left;
        }

        .footer small {
            display: block;
            margin-top: 10px;
        }

        .clear {
            clear: both;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header-flex">
        <div class="company-info">
            <h2>PT LAPI LABORATORIES</h2>
            <p>Jalan Gedong Panjang No.32<br>
            ptlapilaboratories@gmail.com<br>
            (+62 21 6902626)</p>
        </div>
        <div class="invoice-info">
            <h3>INVOICE #{{ $order->order_code }}</h3>
        </div>
    </div>

    {{-- Client Info --}}
    <div class="client-flex">
        <div class="client-details">
            <p><strong>Ap.</strong> {{ $order->client->user->name }}<br>
            {{ $order->client->address ?? 'Alamat tidak tersedia' }}</p>
        </div>
        <div class="invoice-details">
            <p>
                <strong>INVOICE NUMBER:</strong> {{ $order->order_code }}<br>
                <strong>INVOICE DATE:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}
            </p>
        </div>
    </div>

    {{-- Table Order --}}
    <table>
        <thead>
            <tr>
                <th>Item Description</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $order->product->name }}</td>
                <td>{{ $order->qty }}</td>
                <td>{{ number_format($order->product->price, 0, ',', '.') }}</td>
                <td>{{ number_format($order->grand_total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Totals --}}
    @php
        $subtotal = $order->grand_total;
        $taxRate = 0.05;
        $tax = $subtotal * $taxRate;
        $grandTotal = $subtotal + $tax;
    @endphp

    <div class="totals-box">
        <table>
            <tr>
                <td>Sub total (excl. Tax)</td>
                <td>{{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Tax (5%)</td>
                <td>{{ number_format($tax, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Grand Total</strong></td>
                <td><strong>{{ number_format($grandTotal, 2, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td>Payment</td>
                <td>{{ ucfirst($order->payment_method ?? 'Cash') }}</td>
            </tr>
        </table>
    </div>

    <div class="clear"></div>

    {{-- Footer --}}
    <div class="footer">
        <p><strong>THANK YOU FOR ORDERED</strong></p>
        <small>Please use {{ $order->order_code }} as a further reference number</small>
        <small>Website: www.lapilaboratories.com</small>
    </div>

</body>
</html>
