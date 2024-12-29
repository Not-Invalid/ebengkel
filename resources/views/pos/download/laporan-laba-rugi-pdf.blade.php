<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Laba Rugi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Laporan Laba Rugi</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Nominal Debit</th>
                <th>Nominal Kredit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($labarugi as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>{{ formatRupiah($item->nominal_debit) }}</td>
                    <td>{{ formatRupiah($item->nominal_kredit) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="font-weight: bold; text-align: right;">Total</td>
                <td>{{ formatRupiah($totalDebit) }}</td>
                <td>{{ formatRupiah($totalKredit) }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
