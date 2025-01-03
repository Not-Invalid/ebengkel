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
              <i
                class="fas
                  {{ $key == 'PENDING'
                      ? 'fa-credit-card'
                      : ($key == 'Waiting_Confirmation'
                          ? 'fa-hourglass'
                          : ($key == 'DIKEMAS'
                              ? 'fa-box-open'
                              : ($key == 'DIKIRIM'
                                  ? 'fa-truck-fast'
                                  : 'fa-check-circle'))) }} ">
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
                    <a href="{{ route('my-order.detail', ['order_id' => $order->order_id]) }}"
                      class="text-decoration-none">
                      <div
                        class="cart-item d-flex flex-column flex-sm-row align-items-center justify-content-between mb-3 p-3 border rounded shadow-sm"
                        data-id="{{ $order->order_id }}" data-stock="{{ $order->orderItems->sum('qty') }}"
                        data-price="{{ $order->grand_total }}">

                        <div class="cart-item-image flex-shrink-0 me-3">
                          @foreach ($order->orderItems as $orderItem)
                            <img src="{{ $orderItem->imageUrl }}" class="rounded"
                              alt="{{ $orderItem->produk->nama_produk ?? ($orderItem->sparepart->nama_spare_part ?? 'Default Image') }}"
                              style="width: 100px; height: 100px; object-fit: cover;">
                          @endforeach
                        </div>

                        <div class="cart-item-details d-flex flex-column flex-grow-1">
                          <h6 class="mb-2">
                            @foreach ($order->orderItems as $orderItem)
                              {{ $orderItem->produk->nama_produk ?? ($orderItem->sparepart->nama_spare_part ?? 'Produk / Spare Part Tidak Ditemukan') }}
                            @endforeach
                          </h6>
                          <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1">
                              {{ $order->bengkel->nama_bengkel ?? 'Workshop' }}</p>
                            <p class="product-quantity fw-semibold mb-0">Total
                              {{ $order->orderItems->sum('qty') }}
                              Produk</p>
                          </div>
                          <div class="d-flex justify-content-between align-items-center mt-2">
                            <p class="text-primary fw-bold mb-1">Rp
                              {{ number_format($order->total_harga) }}</p>
                            @if ($order->status_order == 'PENDING')
                              <a href="{{ route('payment', ['order_id' => $order->order_id, 'id' => $order->invoice->id]) }}"
                                class="btn btn-custom-2">Bayar Sekarang</a>
                            @elseif ($order->status_order == 'SELESAI')
                              <form action="{{ route('cart.add') }}" method="POST" class="d-flex">
                                @csrf
                                <input type="hidden" name="id_produk"
                                  value="{{ $order->orderItems[0]->id_produk ?? '' }}">
                                <input type="hidden" name="id_spare_part"
                                  value="{{ $order->orderItems[0]->id_spare_part ?? '' }}">
                                <input type="hidden" name="quantity" value="1" class="quantity-input">
                                <button class="btn btn-custom-2 buy-again-btn" type="button">
                                  Beli Lagi
                                </button>
                              </form>
                            @endif
                          </div>
                        </div>
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

  <script>
    document.getElementById('mobileOrderDropdown').addEventListener('change', function() {
      window.location.href = this.value;
    });
  </script>
  <script>
    document.querySelectorAll('.buy-again-btn').forEach(button => {
      button.addEventListener('click', function(event) {
        event.preventDefault();
        var form = this.closest('form');
        var buyAgainInput = document.createElement('input');
        buyAgainInput.type = 'hidden';
        buyAgainInput.name = 'buy_again';
        buyAgainInput.value = 'true';
        form.appendChild(buyAgainInput);

        var quantityInput = form.querySelector('.quantity-input');
        quantityInput.value = quantityInput.value || 1;

        form.submit();
      });
    });
  </script>

@endsection
