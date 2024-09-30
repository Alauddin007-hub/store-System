<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Results</title>
</head>
<body>
    <h1>Report Results</h1>
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
</body>
</html>
