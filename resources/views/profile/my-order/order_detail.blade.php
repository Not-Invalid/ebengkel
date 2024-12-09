@extends('layouts.partials.sidebar')

@section('title')
  eBengkelku | Order Detail
@stop

<style>
  .cart-item-details h6 {
    font-size: 1rem;
  }

  .cart-item-details p {
    font-size: 0.9rem;
  }

  .cart-item-image img {
    width: 80px;
    height: 80px;
  }

  .cart-item-details .d-flex.flex-column {
    gap: 10px;
  }

  .product-quantity {
    font-size: 0.9rem;
    padding-left: 10px;
  }

  .info-p {
    margin-bottom: 0;
    font-size: 14px;
    color: gray;
  }
</style>

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
                <span class="fw-semibold
                    @if($order->status_order == 'PENDING')
                        text-warning
                    @elseif($order->status_order == 'SELESAI')
                        text-success
                    @else
                        text-dark
                    @endif
                ">
                    {{ $order->status_order }}
                </span>
            </p>

          </div>
          <div class="col-md-6 text-md-end">
            <p><strong>Total Price:</strong> <span class="text-primary fw-bold">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span></p>
          </div>
        </div>

        <h6 class="mt-4"><strong>Product Details:</strong></h6>
        <div class="order-items">
          @foreach($order->orderItems as $item)
          <div class="cart-item d-flex flex-column flex-md-row align-items-center mb-3 p-3 border rounded shadow-sm">
            <div class="cart-item-image me-3 mb-3 mb-md-0">
              <img src="{{ asset('assets/images/components/image.png') }}" alt="Product Image" class="img-fluid rounded" style="width: 100px; height: 100px; object-fit: cover;" />
            </div>
            <div class="cart-item-details flex-grow-1">
              <h6 class="mb-1">@foreach ($order->orderItems as $orderItem)
                @if ($orderItem->produk)
                    {{ $orderItem->produk->nama_produk }}
                @elseif ($orderItem->sparepart)
                    {{ $orderItem->sparepart->nama_spare_part }}
                @else
                    Produk / Spare Part Tidak Ditemukan
                @endif
            @endforeach

              </h6>
              <div class="d-flex justify-content-between align-items-center">
                <p class="text-muted mb-1">{{ $order->bengkel->name }}</p>
                <span class="product-quantity ms-3">x{{ $item->qty }}</span>
              </div>
              <div class="d-flex flex-column flex-md-row justify-content-between">
                <p class="text-primary fw-bold mb-1">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                <p class="fw-bold mb-1">Total: Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
              </div>
            </div>
          </div>
          @endforeach
        </div>

        <div class="mt-4">
          <h6><strong>Order Notes:</strong></h6>
          <p>{{ $order->invoice->note ?? 'No additional notes for this order.' }}</p>
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
              <p>{{ $order->order_id }}
                <span>
                  <a href="" target="_blank" class="btn btn-custom-2"
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
              <p class="info-p">{{ $order->invoice->nama_rekening ?? 'Bank BRI' }}</p>
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
                <p class="info-p">2024-12-05 10:00</p>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <p class="info-p">Payment Time</p>
              </div>
              <div class="col-6 text-end">
                <p class="info-p">2024-12-05 11:00</p>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <p class="info-p">Shipping Time</p>
              </div>
              <div class="col-6 text-end">
                <p class="info-p">2024-12-06 08:00</p>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <p class="info-p">Completed Order Time</p>
              </div>
              <div class="col-6 text-end">
                <p class="info-p">2024-12-06 12:00</p>
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


  <!-- Modal for Proof of Payment -->
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
            <img src="{{ isset($invoice) && $invoice->bukti_bayar ? url($invoice->bukti_bayar) : asset('assets/images/components/image.png') }}" alt="Bukti Pembayaran" class="img-fluid"
              id="paymentImage" style="max-width: 100%; max-height: 400px; cursor: zoom-in;">
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const paymentImage = document.getElementById('paymentImage');
    paymentImage.addEventListener('click', function() {
      const currentZoom = parseFloat(window.getComputedStyle(paymentImage).getPropertyValue('transform').split(',')[3]) || 1;
      const newZoom = currentZoom === 1 ? 2 : 1;
      paymentImage.style.transform = `scale(${newZoom})`;
      paymentImage.style.transition = 'transform 0.3s ease';
    });
  </script>
@endsection
