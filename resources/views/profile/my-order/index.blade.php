@extends('layouts.partials.sidebar')

@section('title')
  eBengkelku | My Order
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/myorder.css') }}">
@endpush

@section('content')
  <section class="mt-5">
    <div class="custom-tabs-container">
      <ul class="custom-tabs shadow text-center">
        @foreach ($statusNames as $key => $name)
          <li class="custom-tab-item">
            <a class="custom-tab-link {{ $status == $key ? 'active' : '' }}"
               href="{{ route('my-order.index', ['status' => $key]) }}" data-tab="{{ $key }}">
              <i class="fas
                {{ $key == 'PENDING' ? 'fa-credit-card' :
                   ($key == 'Waiting_Confirmation' ? 'fa-hourglass' :
                   ($key == 'DIKEMAS' ? 'fa-box-open' :
                   ($key == 'DIKIRIM' ? 'fa-truck-fast' : 'fa-check-circle'))) }}">
              </i>
              {{ $name }}
            </a>
          </li>
        @endforeach
      </ul>

      <!-- Dropdown untuk Mobile -->
      <select class="custom-dropdown shadow my-5" id="mobileOrderDropdown">
        @foreach ($statusNames as $key => $name)
          <option value="{{ route('my-order.index', ['status' => $key]) }}" {{ $status == $key ? 'selected' : '' }}>
            {{ $name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="w-100 shadow bg-white rounded my-5" style="padding: 1rem;">
      <div class="container my-4">
        <!-- Konten Tab -->
        <div class="tab-content">
          @foreach ($statusNames as $key => $name)
            <div class="tab-pane {{ $status == $key ? 'active show' : '' }}" id="{{ $key }}">
              <div class="row">
                @php
                  // Filter orders berdasarkan status yang dipilih
                  $filteredOrders = $orders->where('status_order', $key);
                @endphp

                @if ($filteredOrders->isEmpty())
                  <div class="col-12 text-center">
                    <p>Belum ada pesanan dengan status "{{ $name }}".</p>
                  </div>
                @else
                  @foreach ($filteredOrders as $order)
                    <a href="{{ route('my-order.detail', ['order_id' => $order->order_id]) }}" class="cart-item text-decoration-none d-flex flex-column flex-sm-row align-items-center mb-3 p-3 border rounded shadow-sm"
                         data-id="{{ $order->order_id }}" data-stock="{{ $order->orderItems->sum('qty') }}"
                         data-price="{{ $order->grand_total }}" data-href="{{ route('my-order.detail', ['order_id' => $order->order_id]) }}">

                      <div class="cart-item-image me-3 mb-3 mb-sm-0">
                        @foreach ($order->orderItems as $orderItem)
                          <img src="{{ $orderItem->imageUrl }}" class="card-img-top"
                               alt="{{ $orderItem->produk->nama_produk ?? ($orderItem->sparepart->nama_spare_part ?? 'Default Image') }}">
                        @endforeach
                      </div>

                      <div class="cart-item-details flex-grow-1">
                        <h6>
                          @foreach ($order->orderItems as $orderItem)
                            {{ $orderItem->produk->nama_produk ?? ($orderItem->sparepart->nama_spare_part ?? 'Produk / Spare Part Tidak Ditemukan') }}
                          @endforeach
                        </h6>
                        <p class="text-muted mb-1">{{ $order->bengkel->nama_bengkel ?? 'Workshop' }}</p>
                        <p class="text-primary fw-bold mb-1">Rp {{ number_format($order->total_harga) }}</p>
                      </div>

                      <!-- Order Quantity -->
                      <div class="cart-item-quantity d-flex align-items-center me-3 mb-3 mb-sm-0">
                        <p class="product-quantity fw-semibold mb-0">Total {{ $order->orderItems->sum('qty') }} Produk</p>
                      </div>

                      <!-- Action Buttons -->
                      <div class="d-flex flex-column mt-2">
                        @if ($order->status_order == 'PENDING')
                          <a href="{{ route('payment', ['order_id' => $order->order_id, 'id' => $order->invoice->id]) }}"
                             class="btn btn-custom-2 mb-2">Bayar Sekarang</a>
                        @elseif($order->status_order == 'SELESAI')
                          <a href="{{ route('order.buy-again', $order->order_id) }}" class="btn btn-success mb-2">Beli Lagi</a>
                        @endif
                      </div>

                    </a>
                  @endforeach
                @endif
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>
@endsection
