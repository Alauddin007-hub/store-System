<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Reports</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        * {
            font-size: medium;
        }
        body {
            font-family: Arial, sans-serif;
        }
        h2 {
            font-weight: 500;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group button {
            padding: 10px 20px;
            background-color: #E64A19;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #E64A19;
            color: #fff;
        }
        .print-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Generate Reports</h1>
        <form action="{{ route('reports.generate') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="date_from">Date From:</label>
                <input type="date" name="date_from" id="date_from">
            </div>
            <div class="form-group">
                <label for="date_to">Date To:</label>
                <input type="date" name="date_to" id="date_to">
            </div>
            <div class="form-group">
                <label for="product">Product Name:</label>
                <input type="text" name="book" id="product">
            </div>
            <div class="form-group">
                <label for="invoice_id">Invoice ID:</label>
                <input type="text" name="invoice_id" id="invoice_id">
            </div>
            <div class="form-group">
                <button type="submit">Generate Report</button>
            </div>
        </form>

        @if(!empty($sales))
            <h2>Report Results</h2>
            <table>
                <thead>
                    <tr>
                        <th>Invoice ID</th>
                        <th>Customer Name</th>
                        <th>Date</th>
                        <th>Total Price</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                        <tr>
                            <td>{{ $sale->id }}</td>
                            <td>{{ $sale->customer->name }}</td>
                            <td>{{ $sale->created_at }}</td>
                            <td>{{ $sale->total_price }}</td>
                            <td>
                                <ul>
                                    @foreach($sale->details as $detail)
                                        <li>{{ $detail->book->book_bangla_name }} - {{ $detail->quantity }} x {{ $detail->price }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button class="print-button" onclick="window.print()">Print Report</button>
        @else
            <p>No records found.</p>
        @endif
    </div>
</body>
</html>
