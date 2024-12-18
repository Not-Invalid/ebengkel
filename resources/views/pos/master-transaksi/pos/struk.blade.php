<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .header {
            text-align: center;
            padding: 20px;
            border-bottom: 2px solid #000;
        }

        .header img {
            max-width: 120px;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            text-transform: uppercase;
        }

        .header p {
            margin: 5px 0;
            font-size: 14px;
        }

        .content {
            padding: 20px;
        }

        .content h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 20px;
            text-transform: uppercase;
            color: #000;
        }

        .content p {
            margin: 5px 0;
            font-size: 14px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            font-size: 14px;
        }

        .table th {
            background-color: #f4f4f4;
            text-transform: uppercase;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }

        .print-button {
            display: none;
        }

        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <!-- Header -->
    <div class="header">
        <h1>{{ $order->bengkel->nama_bengkel }}</h1>
        <p>{{ $order->bengkel->alamat }}</p>
    </div>

    <!-- Content -->
    <div class="content">
        <h2>Struk Pembelian</h2>
        <p><strong>Kode Order:</strong> {{ $order->kode_order }}</p>
        <p><strong>Nama Customer:</strong> {{ $order->nama_customer }}</p>
        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($order->tanggal)->format('d-m-Y H:i') }}</p>
        <p><strong>Metode Pembayaran:</strong> {{ $order->jenis_pembayaran }}</p>

        <!-- Table Produk/Sparepart -->
        <table class="table">
            <thead>
                <tr>
                    <th>Produk / Sparepart</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $item)
                    <tr>
                        <td>
                            @if ($item->id_produk)
                                {{ $item->produk->nama_produk }}
                            @elseif($item->id_spare_part)
                                {{ $item->sparePart->nama_spare_part }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ formatRupiah($item->harga) }}</td>
                        <td>{{ formatRupiah($item->subtotal) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary -->
        <p><strong>Total Qty:</strong> {{ $order->total_qty }}</p>
        <p><strong>Total Harga:</strong> {{ formatRupiah($order->total_harga) }}</p>
        <p><strong>Diskon:</strong> {{ $order->diskon }}%</p>
        <p><strong>PPN:</strong> {{ $order->ppn }}%</p>
        <p><strong>Total Bayar:</strong> {{ formatRupiah($order->total_harga) }}</p>
        <p><strong>Nominal Bayar:</strong> {{ formatRupiah($order->nominal_bayar) }}</p>
        <p><strong>Kembali:</strong> {{ formatRupiah($order->kembali) }}</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Terima kasih telah berbelanja di {{ $order->bengkel->nama_bengkel }}</p>
    </div>

    <!-- Print Button -->
    <div class="print-button" style="text-align: center; margin: 20px;">
        <button onclick="window.print()"
            style="padding: 10px 20px; background: #007bff; color: #fff; border: none; cursor: pointer;">Cetak
            Ulang</button>
    </div>

</body>

</html>
