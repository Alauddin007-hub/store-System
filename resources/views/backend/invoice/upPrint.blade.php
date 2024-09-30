<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            text-align: center;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ asset('assets/logo/logo.jpeg') }}" style="width:100%; max-width:300px;">
                            </td>
                            <td class="center">
                                <h2>Siddiqia Publication</h2>
                                38/3 Bangla Bazar (1st Floor), Dhaka-1100<br>
                                Email: siddiqap@gmail.com<br>
                                Phone: 01912238187<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <div>
                                <td>
                                    Invoice Number: {{$sale->invoiceID ?? 'N/A'}}<br>
                                    Date: {{ $sale->created_at_formatted }}
                                </td>
                            </div>
                            <div>
                                <td>
                                    Customer Name: {{ $customer->name }}<br>
                                    Phone: 0{{ $customer->phone }}
                                </td>
                            </div>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>ক্রম</td>
                <td>বইয়ের নাম</td>
                <td>পরিমাণ (কপি)</td>
                <td>একক মূল্য (টাকা)</td>
                <td>মোট মূল্য (টাকা)</td>
            </tr>
            <!-- Loop starts here -->
            @php $sub_total = 0; @endphp
            @foreach ($details as $key => $item)
            @php
            $item_total = ($item->quantity * $item->price) * ((100 - $item->discount) / 100);
            $sub_total += $item_total;
            @endphp
            <tr class="item">
                <td>{{ $key + 1 }}</td>
                <td>{{ $item['name'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ number_format($item['price'], 2) }}</td>
                <td>{{ number_format($item['subtotal'], 2) }}</td>
            </tr>
            @endforeach
            <!-- Loop ends here -->

            @php
            $total = $sale->total_price * ((100 - $sale->discount) / 100)
            @endphp

            <tr class="total">
                <td colspan="4">Subtotal:</td>
                <td>{{ $sub_total }} Taka </td>
            </tr>
            <tr class="total">
                <td colspan="4">Discount:</td>
                <td>{{ $sale->discount ?? 0 }}% Taka </td>
            </tr>
            <tr class="total">
                <td colspan="4">Total:</td>
                <td>{{ $total ?? 'N/A' }} Taka</td>
            </tr>
        </table>
        <p class="center">Thank you for shopping with us!</p>
    </div>
</body>

</html>