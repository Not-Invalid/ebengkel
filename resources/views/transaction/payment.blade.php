@extends('layouts.app')

@section('title')
    eBengkelku | Payment
@stop

@section('content')

    <section class="section section-white"
        style="position: relative; overflow: hidden; padding-top: 100px; padding-bottom: 20px;">
        <div
        style="background-image: url('{{ asset('assets/images/bg/wallpaper.png') }}'); background-size: cover; background-position: center; background-attachment: fixed; background-repeat: no-repeat; position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0;">
        </div>
        <div class="bg-white" style="position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0; opacity: 0.7;">
        </div>
        <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
            <h4 class="title-header">What's In The Cart</h4>
            </div>
        </div>
        </div>
    </section>

    <section>
        <!-- Kontainer untuk Payment -->
        <div class="container py-5" style="position: relative; z-index: 2;">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow">
                        <div class="card-body">
                            <!-- Header -->
                            <div class="text-center mb-4">
                                <div class="col-auto">
                                    <img src="{{ asset('assets/images/logo/icon.png') }}" alt="Produk" class="img-fluid rounded" style="width: 80px; height: 80px;">
                                </div>
                                <h3>Pembayaran eBengkelku</h3>
                            </div>
                            <div class="card-body">
                                <!-- Shipping Address Section -->
                                <div class="checkout-section">
                                    <h6 class="d-flex justify-content-between align-items-center">
                                        <span>Informasi Pengiriman</span>
                                    </h6>
                                    <p class="mt-2">
                                        <strong>{{ $order->atas_nama }}</strong> {{ $order->no_telp }}
                                    </p>
                                    <p class="mb-0">{{ $order->alamat_pengiriman }}</p>
                                </div>
                                <hr>

                                <!-- Order Details Section -->
                                <div class="checkout-section">
                                    @foreach ($orderItems as $item)
                                    <div class="row align-items-center bg-light p-2 rounded">
                                        <h6 class="text-start mb-1">
                                            <i class="bi bi-shop me-2"></i>{{ $item->nama_produk ?? $item->nama_spare_part }}
                                        </h6>
                                        <div class="col-auto">
                                            @if ($item->produk)
                                                <img src="{{ optional($item->produk)->foto_produk ? url($item->produk->foto_produk) : asset('assets/images/components/image.png') }}" alt="Gambar Produk" class="img-fluid rounded" style="width: 60px; height: 65px; object-fit: cover;">
                                            @elseif($item->spare_part)
                                                <img src="{{ optional($item->spare_part)->foto_spare_part ? url($item->spare_part->foto_spare_part) : asset('assets/images/components/image.png') }}" alt="Gambar SparePart" class="img-fluid rounded" style="width: 60px; height: 65px; object-fit: cover;">
                                            @endif
                                            </div>
                                        <div class="col">
                                            <p class="mb-0 fw-bold">{{ $item->nama_produk ?? $item->nama_spare_part }}</p>
                                            <p class="mb-0 text-danger">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="col-auto">
                                            <p class="mb-0 text-muted">{{ $item->total_qty }}x</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <hr>

                                <!-- Shipping Method Section -->
                                <div class="checkout-section">
                                    <h6 class="mb-3">Opsi Pengiriman</h6>
                                    <div class="dropdown">
                                        <button class="btn btn-outline-border dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center" type="button" id="shippingOptionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <div>
                                                <p class="mb-0 fw-bold" id="selectedShippingName">{{ $order->jenis_pengiriman }}</p>
                                                <p class="mb-0 text-muted" id="selectedShippingCourier">{{ $order->kurir }}</p>
                                                <p class="mb-0 text-muted" style="font-size: 12px;" id="deliveryDate">Akan diterima pada {{ \Carbon\Carbon::parse($order->tanggal_kirim)->format('d M Y') }}</p>
                                            </div>
                                            <div class="text-end">
                                                <p class="mb-0 fw-bold" id="selectedShippingPrice">Rp {{ number_format($order->biaya_pengiriman, 0, ',', '.') }}</p>
                                            </div>
                                        </button>
                                    </div>
                                </div>

                                <hr>

                                <!-- Ringkasan Total Biaya -->
                                <div class="checkout-section">
                                    <h6>Ringkasan Total Biaya</h6>
                                    <p><strong>Subtotal:</strong> <span id="subtotal">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span></p>
                                    <p><strong>Biaya Pengiriman:</strong> <span id="shippingFee">Rp {{ number_format($order->biaya_pengiriman, 0, ',', '.') }}</span></p>
                                    <p><strong>Diskon:</strong> <span id="discount">Rp 0</span></p>
                                    <p><strong>Total:</strong> <span id="total">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span></p>
                                </div>
                            </div>

                            <!-- Tombol Bayar -->
                            <button id="payButton" class="btn btn-dark btn-block btn-lg mt-4">Bayar Sekarang</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Script untuk menghitung ulang total jika ada perubahan pada opsi pengiriman atau diskon (jika diperlukan)
        // Sudah dijelaskan di atas
    </script>
@endsection
