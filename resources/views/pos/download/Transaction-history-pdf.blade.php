<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1,
        h3 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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
    </style>
</head>

<body>
    <h1>{{ $title }}</h1>
    <h3>Date: {{ $date }}</h3>
    <table>
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Transaction Type</th>
                <th>Payment Method</th>
                <th>Total Price</th>
                <th>Cashier</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction as $item)
                <tr>
                    <td>{{ $item['customer_name'] }}</td>
                    <td>{{ $item['transaction_type'] }}</td>
                    <td>{{ $item['payment_method'] }}</td>
                    <td>{{ $item['total_price'] }}</td>
                    <td>{{ $item['cashier'] }}</td>
                    <td>{{ $item['action'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
