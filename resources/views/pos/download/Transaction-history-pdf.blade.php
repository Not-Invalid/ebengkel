<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1,
        h3 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .date {
            text-align: right;
        }
    </style>
</head>

<body>
    <h1>{{ $title }}</h1>
    <p class="date">Date: {{ $date }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Customer Name</th>
                <th>Transaction Type</th>
                <th>Payment Method</th>
                <th>Total Price</th>
                <th>Cashier</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction as $trans)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $trans['customer_name'] }}</td>
                    <td>{{ $trans['transaction_type'] }}</td>
                    <td>{{ $trans['payment_method'] }}</td>
                    <td>{{ number_format($trans['total_price'], 2) }}</td>
                    <td>{{ $trans['cashier'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
