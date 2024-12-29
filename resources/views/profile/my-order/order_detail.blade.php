@extends('layouts.partials.sidebar')

@section('title')
    eBengkelku | Order Detail
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/detail-order.css') }}">
@endpush

@section('content')
    <section class="mt-5">
        <div class="py-3">
            <div class="container">
                <div class="d-flex justify-content-between">
                    <nav class="pt-3"
                        style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                        aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="nav-link d-inline-flex align-items-center"
                                    href="{{ route('my-order.index') }}">My Order</a></li>
                            <li class="breadcrumb-item active d-inline-flex align-items-center" aria-current="page">
                                Order Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <div class="container mt-4">
        <div class="card shadow-lg rounded p-4">
            <h4 class="mb-4 text-center">Order Details</h4>

            <div class="order-details">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Status:</strong>
                            <span class="fw-semibold">
                                {{ $statusNames[$order->status_order] ?? $order->status_order }}
                            </span>
                        </p>
                    </div>

                    <div class="col-md-6 text-md-end">
                        <p><strong>Total Price:</strong> <span class="text-primary fw-bold">Rp
                                {{ number_format(
                                    $order->orderItems->sum(function ($item) {
                                        return $item->harga * $item->qty;
                                    }),
                                    0,
                                    ',',
                                    '.',
                                ) }}</span>
                        </p>
                    </div>

                </div>

                <h6 class="mt-4"><strong>Product Details:</strong></h6>
                <div class="order-items">
                    @foreach ($order->orderItems as $item)
                        @php
                            $type = null;
                            $id = null;

                            if ($item->produk) {
                                $type = 'product';
                                $id = $item->produk->id_produk;
                            }

                            elseif ($item->sparepart) {
                                $type = 'sparepart';
                                $id = $item->sparepart->id_spare_part;
                            }
                        @endphp

                        @if ($type && $id)

                            <a href="{{ route('Detail-ProductSparePart', ['type' => $type, 'id' => $id]) }}"
                                class="text-decoration-none">
                                <div
                                    class="cart-item d-flex flex-column flex-sm-row align-items-center justify-content-between mb-3 p-3 border rounded shadow-sm">

                                    <div class="cart-item-image flex-shrink-0 mb-3 mb-sm-0 me-3">
                                        <img src="{{ $item->imageUrl }}" class="rounded"
                                            alt="{{ $item->produk->nama_produk ?? ($item->sparepart->nama_spare_part ?? 'Default Image') }}">
                                    </div>

                                    <div class="cart-item-details flex-grow-1">
                                        <h6 class="mb-2">
                                            {{ $item->produk->nama_produk ?? ($item->sparepart->nama_spare_part ?? 'Produk / Spare Part Tidak Ditemukan') }}
                                        </h6>

                                        <div
                                            class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
                                            <p class="text-muted mb-1">{{ $order->bengkel->nama_bengkel ?? 'Workshop' }}</p>
                                            <p class="product-quantity fw-semibold mb-0">Total
                                                {{ $order->orderItems->sum('qty') }} Produk</p>
                                        </div>

                                        <div
                                            class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-2">
                                            <p class="text-primary fw-bold mb-1">Rp
                                                {{ number_format($item->harga, 0, ',', '.') }}</p>
                                            <p class="fw-bold mb-1">Total: Rp
                                                {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @else

                            <p>Item unavailable or missing details</p>
                        @endif
                    @endforeach

                </div>

                <div class="mt-4">
                    <h6><strong>Order Notes:</strong></h6>
                    <p>{{ $order->invoice->note ?? '' }}</p>
                </div>

                <div class="mt-4">
                    <div class="p-3 border rounded bg-light mb-3">
                        <p class="mb-0 fw-bold">Info Pengiriman</p>
                        <p class="mb-0 text-muted">{{ $order->jenis_pengiriman }} - {{ $order->kurir }}</p>
                    </div>
                    <div class="p-3 border rounded bg-light mb-3">
                        <p class="mb-0 fw-bold">Alamat Pengiriman</p>
                        <p class="mb-0 text-muted">{{ $order->atas_nama }} - {{ $order->no_telp }}</p>
                        <p class="mb-0 text-muted">{{ $order->alamat_pengiriman }}</p>
                    </div>
                </div>

                <div class="p-3 border rounded bg-light">
                    <div class="row align-items-center">
                        <div class="col-6 col-sm-6">
                            <p class="mb-1"><strong>ID Order</strong></p>
                        </div>
                        <div class="col-6 col-sm-6 text-sm-end">
                            <p id="orderIdText" class="mb-1">
                                {{ $order->order_id }}&nbsp;
                                <span>
                                    <a href="javascript:void(0);" id="copyButton" class="btn btn-custom-2"
                                        style="padding: 1px 5px !important; background-color:white !important; border-color:grey !important; color:black !important;">
                                        <i class="fa-solid fa-copy text-primary"></i>
                                    </a>
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <div class="col-6">
                            <p class="info-p">Payment Method</p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="info-p">{{ $order->invoice->jenis_pembayaran ?? '' }}</p>
                        </div>
                    </div>


                    <div class="row align-items-center">
                        <div class="col-6">
                            <p class="info-p">Proof of Payment</p>
                        </div>
                        @if (!empty($order->invoice->bukti_bayar))
                            <div class="col-6 text-end">
                                <p class="info-p d-flex align-items-center justify-content-end">
                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#paymentProofModal"
                                        style="text-decoration: none; display: flex; align-items: center;">
                                        Lihat <span class="fs-5 ms-2">></span>
                                    </a>
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="collapse" id="additionalInfo">
                        <hr>

                        <div class="row d-flex justify-content-between">
                            <div class="col-6">
                                <p class="info-p">Order Time</p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="info-p">
                                    <span class="date">
                                        {{ $order->tanggal ? \Carbon\Carbon::parse($order->tanggal)->format('d-m-Y H:i') : '-' }}
                                    </span>
                                </p>
                            </div>
                        </div>


                        <div class="row d-flex justify-content-between">
                            <div class="col-6">
                                <p class="info-p">Payment Time</p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="info-p">
                                    <span class="date">
                                        {{ $order->invoice && $order->invoice->tanggal_bayar ? \Carbon\Carbon::parse($order->invoice->tanggal_bayar)->format('d-m-Y H:i') : '-' }}
                                    </span>
                                </p>
                            </div>
                        </div>


                        <div class="row d-flex justify-content-between">
                            <div class="col-6">
                                <p class="info-p">Shipping Time</p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="info-p">
                                    <span class="date">
                                        {{ $order->tanggal_kirim ? \Carbon\Carbon::parse($order->tanggal_kirim)->format('d-m-Y H:i') : '-' }}
                                    </span>
                                </p>
                            </div>
                        </div>


                        <div class="row d-flex justify-content-between">
                            <div class="col-6">
                                <p class="info-p">Completed Order</p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="info-p">
                                    <span class="date">
                                        {{ $order->tanggal_diterima ? \Carbon\Carbon::parse($order->tanggal_diterima)->format('d-m-Y H:i') : '-' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-2">
                        <hr>
                        <button class="btn btn-link" style="text-decoration: none;" type="button"
                            data-bs-toggle="collapse" data-bs-target="#additionalInfo" aria-expanded="false"
                            aria-controls="additionalInfo" id="toggleButton">
                            Lihat Semua
                        </button>
                    </div>


                    <div class="text-center mt-3">
                        @if ($order->status_order == 'PENDING')
                            <a href="{{ route('payment', ['order_id' => $order->order_id, 'id' => $order->invoice->id]) }}"
                                class="btn btn-custom-2 w-100">Bayar Sekarang</a>
                        @elseif ($order->status_order == 'SELESAI')
                            <form action="{{ route('cart.add') }}" method="POST" class="d-flex">
                                @csrf
                                <input type="hidden" name="id_produk"
                                    value="{{ $order->orderItems[0]->id_produk ?? '' }}">
                                <input type="hidden" name="id_spare_part"
                                    value="{{ $order->orderItems[0]->id_spare_part ?? '' }}">
                                <input type="hidden" name="quantity" value="1" id="quantity-input">
                                <button class="btn btn-custom-2 flex-grow-1 py-2" type="button" id="buy-again-btn">
                                    Beli Lagi
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="paymentProofModal" tabindex="-1" aria-labelledby="paymentProofModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentProofModalLabel">Proof of Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-center">
                            <img src="{{ $order->invoice->bukti_bayar }}" class="img-fluid" alt="Bukti Pembayaran"
                                id="paymentImage" style="max-width: 100%; max-height: 400px; cursor: zoom-in;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('copyButton').addEventListener('click', function() {

                const orderId = document.getElementById('orderIdText').textContent.trim().split(" ")[0];

                navigator.clipboard.writeText(orderId).then(function() {

                    toastr.success('ID Order Copied!', '', {
                        positionClass: 'toast-top-right',
                        closeButton: true,
                        progressBar: true,
                        timeOut: 3000,
                    });
                }).catch(function(err) {

                    toastr.error('Gagal menyalin ID Order.', '', {
                        positionClass: 'toast-top-right',
                        closeButton: true,
                        progressBar: true,
                        timeOut: 3000,
                    });
                });
            });

            const paymentImage = document.getElementById('paymentImage');
            paymentImage.addEventListener('click', function() {

                const currentTransform = window.getComputedStyle(paymentImage).getPropertyValue('transform');

                const currentZoom = currentTransform === 'none' ? 1 : parseFloat(currentTransform.split(',')[3]);

                const newZoom = currentZoom === 1 ? 2 : 1;

                paymentImage.style.transform = `scale(${newZoom})`;
                paymentImage.style.transition = 'transform 0.3s ease';
            });
        </script>
        <script>
            document.getElementById('buy-again-btn').addEventListener('click', function() {
                var form = this.closest('form');
                var buyAgainInput = document.createElement('input');
                buyAgainInput.type = 'hidden';
                buyAgainInput.name = 'buy_again';
                buyAgainInput.value = 'true';
                form.appendChild(buyAgainInput);

                var quantityInput = document.getElementById('quantity-input');
                quantityInput.value = quantityInput.value || 1;

                form.submit();
            });
        </script>

    @endsection
