<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Struk Pembelian &mdash; Stisla</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('template_pos/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template_pos/modules/fontawesome/css/all.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('template_pos/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('template_pos/css/components.css') }}">
</head>

<body onload="window.print()">
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <section class="section">
                <div class="section-body">
                    <div class="invoice">
                        <div class="invoice-print">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="invoice-title">
                                        <h2>Invoice</h2>
                                        <div class="invoice-number">Order #{{ $order->kode_order }}</div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col">
                                            <address>
                                                <strong>Billed To</strong><br>
                                                {{ $order->nama_customer }}<br>
                                            </address>
                                        </div>
                                        <div class="col text-right">
                                            <address>
                                                <strong>Order Date</strong><br>
                                                {{ \Carbon\Carbon::parse($order->tanggal)->format('d-m-Y H:i') }}<br><br>
                                            </address>
                                        </div>
                                    </div>
                                    <div class="row mt-0">
                                        <div class="col">
                                            <address>
                                                <strong>Payment Method</strong><br>
                                                {{ $order->jenis_pembayaran }}
                                            </address>
                                        </div>
                                        <div class="col text-right">
                                            <address>
                                                <strong>Staff</strong><br>
                                                {{ $order->input_by }}<br>
                                            </address>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="section-title">Order Summary</div>
                                    <p class="section-lead">Detail pembelian.</p>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-md">
                                            <tr>
                                                <th>#</th>
                                                <th>Produk / Sparepart</th>
                                                <th class="text-center">Harga</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-right">Subtotal</th>
                                            </tr>
                                            @foreach ($order->orderItems as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>
                                                        @if ($item->id_produk)
                                                            {{ $item->produk->nama_produk }}
                                                        @elseif($item->id_spare_part)
                                                            {{ $item->sparePart->nama_spare_part }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ formatRupiah($item->harga) }}</td>
                                                    <td class="text-center">{{ $item->qty }}</td>
                                                    <td class="text-right">{{ formatRupiah($item->subtotal) }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col text-left">
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">Subtotal</div>
                                                <div class="invoice-detail-value">
                                                    {{ formatRupiah($order->harga) }}</div>
                                            </div>
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">Diskon</div>
                                                <div class="invoice-detail-value">{{ $order->diskon }}%</div>
                                            </div>
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">PPN</div>
                                                <div class="invoice-detail-value">{{ $order->ppn }}%</div>
                                            </div>
                                        </div>
                                        <hr class="mt-2 mb-2">
                                        <div class="col text-right">
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">Total </div>
                                                <div class="invoice-detail-value invoice-detail-value-lg">
                                                    {{ formatRupiah($order->total_harga) }}
                                                </div>
                                            </div>
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">Nominal Bayar</div>
                                                <div class="invoice-detail-value">
                                                    {{ formatRupiah($order->nominal_bayar) }}</div>
                                            </div>
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">Kembali</div>
                                                <div class="invoice-detail-value">
                                                    {{ formatRupiah($order->kembali) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <p>Terima kasih telah berbelanja di {{ $order->bengkel->nama_bengkel }}</p>
                    </div>
                </div>
        </div>
        </section>
    </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('template_pos/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('template_pos/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('template_pos/js/stisla.js') }}"></script>
    <script src="{{ asset('template_pos/js/scripts.js') }}"></script>
    <script src="{{ asset('template_pos/js/custom.js') }}"></script>
</body>

</html>
