<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            font-size: 8pt;
        }

        body {
            font-family: Arial, sans-serif;
            width: 100%;
            margin: 0;
            padding: 0;
            height: 100vh;
        }

        h2 {
            font-weight: 500;
        }

        .invoice {
            width: 100%;
            /* margin: 10px 0; */
            /* padding: 10px; */
            /*border: 1px solid #ccc;*/
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            height: 98%;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .invoice-header-left {
            flex: 1;
        }

        .invoice-header-right {
            flex: 1;
            text-align: right;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5%;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
        }

        .invoice-table th {
            background-color: #E64A19;
            color: #fff;
            font-weight: bold;
            text-align: center;
        }

        p {
            margin: 0;
        }

        .invoice-total {
            float: right;
        }

        button {
            width: 100px;
            color: aqua;
            border: 1px solid bisque;
            border-radius: 10px;
            padding: 10px;
            margin: auto;
        }

        button a {
            text-decoration: none;
            color: inherit;
        }

        .head-print {
            justify-content: right;
            text-align: right;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="invoice">
        <div class="invoice-header">
            <div class="invoice-header-left">
                <img src="{{ asset('assets/logo/logo8.png') }}" alt="Company Logo" style="width:150px">
                <h3>Siddiqia Publication</h3>
                <p>38/3 Bangla Bazar (1st Floor), Dhaka-1100</p>
                <p>Email: siddiqiap@gmail.com</p>
                <p>Phone: 01686563613, 01912238187</p>
            </div>
            <div class="invoice-header-right">
                <h2>Invoice</h2>
                <p>Invoice Number: {{ $sale->invoiceID }}</p>
                <p>Date: {{ $sale->created_at_formatted }}</p>
                <p>Customer Name : {{ $customer->name }}</p>
                <p>Phone : 0{{ $customer->phone }}</p>
            </div>
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>#sL</th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Unit Price (Taka)</th>
                    <th>Total (Taka)</th>
                </tr>
            </thead>
            <tbody>
                @php $sub_total = 0; @endphp
                @foreach ($details as $key => $item)
                @php
                $item_total = $item->quantity * $item->price;
                $sub_total += $item_total;
                @endphp
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->book->book_bangla_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->subtotal }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @php
        $total = $sale->total_price * ((100 - $sale->discount) / 100);
        $total -= $sale->discount_for_amount;
        $total += $sale->otherCost;
        $discount = ($sale->total_price * $sale->discount / 100) +  $sale->discount_for_amount ;
        @endphp

        <div class="invoice-total">
            <p>Subtotal: {{ $sub_total }} Taka </p>
            <p> Discount:
                @if ($sale->discount == 0)
                {{ $sale->discount_for_amount ?? 0 }} Taka
                @elseif ( $sale->discount > 0 && $sale->discount_for_amount > 0 )
                {{ number_format($discount, 2) }}
                @else 
                {{ number_format($discount, 2) }} ({{ $sale->discount ?? 0 }} %)
                @endif
            </p>
            <p>
                Other Cost: {{$sale->otherCost ?? 0}}
            </p>
            <p>Total: {{ $total ?? 'N/A' }} Taka </p>
        </div>
        
        <div class="invoice-footer"><br>
            <p><b>Total Amount in Words: {{ $totalInWords }} Taka only</b></p>
            <br>
            <p>Thank you for shopping with us!</p>
        </div>

    <script>
        let body = document.body;
        let html = document.documentElement;
        let height = Math.max(
            body.scrollHeight, body.offsetHeight,
            html.clientHeight, html.scrollHeight, html.offsetHeight
        );

        document.cookie = "innerHeight=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "innerHeight=" + ((height + 50) * 0.264583);
    </script>
</body>

</html>