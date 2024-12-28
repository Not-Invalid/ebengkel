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

              // Periksa apakah produk ada
              if ($item->produk) {
                  $type = 'product';
                  $id = $item->produk->id_produk; // Ambil ID produk
              }
              // Periksa apakah sparepart ada
              elseif ($item->sparepart) {
                  $type = 'sparepart';
                  $id = $item->sparepart->id_spare_part; // Ambil ID sparepart
              }
            @endphp

            @if ($type && $id)
              <!-- Buat link hanya jika produk atau sparepart ada -->
              <a href="{{ route('Detail-ProductSparePart', ['type' => $type, 'id' => $id]) }}"
                class="text-decoration-none">
                <div
                  class="cart-item d-flex flex-column flex-sm-row align-items-center justify-content-between mb-3 p-3 border rounded shadow-sm">
                  <!-- Gambar produk atau sparepart -->
                  <div class="cart-item-image flex-shrink-0 mb-3 mb-sm-0 me-3">
                    <img src="{{ $item->imageUrl }}" class="rounded"
                      alt="{{ $item->produk->nama_produk ?? ($item->sparepart->nama_spare_part ?? 'Default Image') }}">
                  </div>

                  <div class="cart-item-details d-flex flex-column flex-grow-1">
                    <h6 class="mb-2">
                      {{ $item->produk->nama_produk ?? ($item->sparepart->nama_spare_part ?? 'Produk / Spare Part Tidak Ditemukan') }}
                    </h6>

                    <div
                      class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center">
                      <p class="text-muted mb-1">{{ $order->bengkel->nama_bengkel ?? 'Workshop' }}</p>
                      <p class="product-quantity fw-semibold mb-0">Total {{ $order->orderItems->sum('qty') }} Produk</p>
                    </div>

                    <div
                      class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mt-2">
                      <p class="text-primary fw-bold mb-1">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                      <p class="fw-bold mb-1">Total: Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                  </div>
                </div>
              </a>
            @else
              <!-- Tampilkan pesan jika produk atau sparepart tidak ada -->
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
          <div class="row">
            <div class="col-6">
              <p><strong>ID Order</strong></p>
            </div>
            <div class="col-6 text-end">
              <p id="orderIdText">{{ $order->order_id }}
                <span>
                  <a href="javascript:void(0);" id="copyButton" class="btn btn-custom-2"
                    style="padding: 1px 5px !important; background-color:white !important; border-color:grey !important; color:black !important;">
                    Salin
                  </a>
                </span>
              </p>
            </div>
          </div>

          <div class="row">
            <div class="col-6">
              <p class="info-p">Payment Method</p>
            </div>
            <div class="col-6 text-end">
              <p class="info-p">{{ $order->invoice->jenis_pembayaran ?? '' }}</p>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <p class="info-p">Proof of Payment</p>
            </div>
            <div class="col-6 text-end">
              <p class="info-p d-flex align-items-center justify-content-end">
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#paymentProofModal"
                  style="text-decoration: none; display: flex; align-items: center;">
                  Lihat <span class="fs-5 ms-2">></span>
                </a>
              </p>
            </div>
          </div>

          <div class="collapse" id="additionalInfo">
            <hr>
            <div class="row">
              <div class="col-6">
                <p class="info-p">Order Time</p>
              </div>
              <div class="col-6 text-end">
                <p class="info-p">{{ $order->tanggal }}</p>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <p class="info-p">Payment Time</p>
              </div>
              <div class="col-6 text-end">
                <p class="info-p">{{ $order->invoice->tanggal_bayar }}</p>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <p class="info-p">Shipping Time</p>
              </div>
              <div class="col-6 text-end">
                <p class="info-p">{{ $order->tanggal_kirim }}</p>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <p class="info-p">Completed Order Time</p>
              </div>
              <div class="col-6 text-end">
                <p class="info-p">{{ $order->tanggal_diterima }}</p>
              </div>
            </div>
          </div>
          <div class="text-center mt-2">
            <hr>
            <button class="btn btn-link" style="text-decoration: none;" type="button" data-bs-toggle="collapse"
              data-bs-target="#additionalInfo" aria-expanded="false" aria-controls="additionalInfo" id="toggleButton">
              Lihat Semua
            </button>
          </div>
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
            <img src="{{ $order->invoice->bukti_bayar }}" class="img-fluid" alt="Bukti Pembayaran" id="paymentImage"
              style="max-width: 100%; max-height: 400px; cursor: zoom-in;">
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('copyButton').addEventListener('click', function() {
      // Ambil teks ID Order dari elemen dengan id 'orderIdText', kecuali tombol "Salin"
      const orderId = document.getElementById('orderIdText').textContent.trim().split(" ")[0];

      // Salin teks ID Order ke clipboard
      navigator.clipboard.writeText(orderId).then(function() {
        // Tampilkan Toastr sukses jika berhasil menyalin
        toastr.success('ID Order telah disalin ke clipboard!', '', {
          positionClass: 'toast-top-right', // Posisi toast
          closeButton: true, // Tombol close
          progressBar: true, // Menampilkan progress bar
          timeOut: 3000, // Waktu tampil
        });
      }).catch(function(err) {
        // Tampilkan Toastr error jika gagal
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
      // Ambil nilai transform saat ini
      const currentTransform = window.getComputedStyle(paymentImage).getPropertyValue('transform');

      // Jika belum ada transformasi, anggap scale=1
      const currentZoom = currentTransform === 'none' ? 1 : parseFloat(currentTransform.split(',')[3]);

      // Tentukan zoom baru (zoom in jika scale 1, zoom out jika sudah lebih dari 1)
      const newZoom = currentZoom === 1 ? 2 : 1;

      // Terapkan transformasi dengan zoom baru
      paymentImage.style.transform = `scale(${newZoom})`;
      paymentImage.style.transition = 'transform 0.3s ease'; // Animasi halus saat zoom
    });
  </script>
@endsection
