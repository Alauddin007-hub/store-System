<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            /* Adjust font size */
        }

        .invoice {
            width: 100%;
            /* Adjust width to fit within page */
            margin: 10px auto;
            padding: 10px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            page-break-inside: avoid;
            /* Prevent page breaks within invoice */
            height: 100vh;
        }

        /* p {
            display: block;
            margin-block-start: 0;
            margin-block-end: 0;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            unicode-bidi: isolate;
        } */

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .invoice-header-left {
            flex: 1;
            justify-content: left;
            text-align: left;
        }

        .invoice-header-right {
            flex: 1;
            /* float: right; */
            /* justify-content: right; */
            text-align: right;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #000;
            padding: 5px;
            /* Adjust cell padding */
            text-align: center;
        }

        .invoice-table th {
            background-color: #E64A19;
            color: #fff;
            font-weight: bold;
        }

        .invoice-total {
            float: right;
            margin-top: 10px;
        }
    </style>

</head>

<body>
    <div class="invoice">
        <div class="invoice-header">
            <div class="invoice-header-left">
                <img src="{{ asset('assets/logo/logo8.jpg') }}" alt="Company Logo" width="60">
                <h3>Siddiqia Publication</h3>
                <p>38/3 Bangla Bazar (1st Floor), Dhaka-1100</p>
                <p>Email: siddiqiap@gmail.com</p>
                <p>Phone: 002-47122047, 01912238187, 01715339902</p>
            </div>
            <div class="invoice-header-right">
                <h2>Invoice</h2>
                <p>Invoice Number: {{$sale->invoiceID ?? 'N/A'}}</p>
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
                    <th>Unit Price( Taka )</th>
                    <th>Discount( % )</th>
                    <th>Total ( Taka )</th>
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
                                    <td>{{ $item->book->book_english_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->discount }}</td>
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


        <div class="invoice-footer">
            <p><b>Total Amount in Words: {{ $totalInWords }} Taka only</b></p>
            <br>
            <p>Thank you for shopping with us!</p>
        </div>
    </div>
</body>

</html>