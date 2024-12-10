@extends('layouts.partials.sidebar')

@section('title')
  eBengkelku | My Order
@stop
<style>
  /* Gaya default untuk ikon dan teks */
  .nav-pills .nav-link {
    color: var(--main-grey);
    display: flex;
    flex-direction: column;
    align-items: center;
    border: none;
    background: transparent;
  }

  .nav-pills .nav-link:hover {
    color: var(--main-grey) !important;
    background: transparent !important;
    box-shadow: none;
    border: none;
  }

  .nav-pills .nav-link.active {
    color: var(--main-blue-dark) !important;
    background: transparent !important;
    box-shadow: none;
    border: none;
  }

  .nav-pills .nav-link i {
    font-size: 20px;
    margin-bottom: 5px;
  }

  .horizontal-line {
    width: 30px;
    height: 1px;
    background-color: red;
    margin: 0 auto;
    position: relative;
    top: 50%;
    transform: translateY(-50%);
  }

  #orderTabs {
    gap: 30px;
  }

  .cart-item {
    border-radius: 10px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
    position: relative;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    width: 100%;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .cart-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
  }

  .cart-item img {
    border-radius: 8px;
  }

  .shipping:hover {
    background-color: var(--main-light-grey);
    color: var(--main-dark-blue);
  }
</style>
@section('content')
  <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
    <div class="container my-4">
      <!-- Tambahkan Dropdown untuk Mobile -->
      <div class="d-md-none mb-3">
        <select class="form-select" id="mobileOrderDropdown" onchange="window.location.href=this.value">
          @foreach ($statusNames as $key => $name)
            <option value="{{ route('my-order.index', ['status' => $key]) }}" {{ $status == $key ? 'selected' : '' }}>
              {{ $name }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Tabs untuk perangkat desktop -->
      <ul class="nav nav-pills justify-content-center mb-3 d-none d-md-flex mb-5" id="orderTabs" role="tablist">
        @foreach ($statusNames as $key => $name)
          <li class="nav-item" role="presentation">
            <button class="nav-link text-center {{ $status == $key ? 'active' : '' }}" id="{{ $key }}-tab"
              data-bs-toggle="pill" data-bs-target="#{{ $key }}" type="button" role="tab"
              aria-controls="{{ $key }}" aria-selected="{{ $status == $key ? 'true' : 'false' }}">
              <i
                class="fas fa-{{ $key == 'PENDING'
                    ? 'credit-card'
                    : ($key == 'Waiting_Confirmation'
                        ? 'hourglass'
                        : ($key == 'DIKEMAS'
                            ? 'box-open'
                            : ($key == 'DIKIRIM'
                                ? 'truck-fast'
                                : 'circle-check'))) }} fas-md"></i><br>
              {{ $name }}
            </button>
          </li>

          @if (!$loop->last)
            <!-- Jangan tampilkan horizontal line di tab terakhir -->
            <li class="nav-item" role="presentation">
              <hr class="horizontal-line">
            </li>
          @endif
        @endforeach
      </ul>

      <!-- Konten Tab -->
      <div class="tab-content" id="orderTabsContent">
        @foreach ($statusNames as $key => $name)
          <div class="tab-pane fade {{ $status == $key ? 'show active' : '' }}" id="{{ $key }}" role="tabpanel"
            aria-labelledby="{{ $key }}-tab">
            @php
              // Filter orders sesuai status
              $filteredOrders = $orders->where('status_order', $key);
            @endphp

            @if ($filteredOrders->isEmpty())
              <div class="card border-1 rounded-2 mt-4">
                <div class="card-body d-flex justify-content-center">
                  <div class="text-center">
                    <img src="{{ asset('assets/images/components/empty.png') }}" height="130" width="130"
                      alt="No Address">
                    <p>Nothing is {{ $name }}.</p>
                  </div>
                </div>
              </div>
            @else
              @foreach ($filteredOrders as $order)
                <div class="cart-item d-flex flex-column flex-sm-row align-items-center mb-3 p-3 border rounded shadow-sm"
                  data-id="{{ $order->order_id }}" data-stock="{{ $order->orderItems->sum('qty') }}"
                  data-price="{{ $order->grand_total }}">

                  <!-- Product Image -->
                  <div class="cart-item-image me-3 mb-3 mb-sm-0">
                    <img src="{{ asset('assets/images/components/image.png') }}" alt="Product Image" class="img-fluid"
                      style="width: 100px; height: 100px; object-fit: cover;" />
                  </div>

                  <!-- Order Details -->
                  <div class="cart-item-details flex-grow-1">
                    <h6>
                      @foreach ($order->orderItems as $orderItem)
                        @if ($orderItem->produk)
                          {{ $orderItem->produk->nama_produk }}
                        @elseif ($orderItem->sparepart)
                          {{ $orderItem->sparepart->nama_spare_part }}
                        @else
                          Produk / Spare Part Tidak Ditemukan
                        @endif
                      @endforeach
                    </h6>
                    <p class="text-muted mb-1">{{ $order->bengkel->nama_bengkel ?? 'Workshop' }}</p>
                    <p class="text-primary fw-bold mb-1">Rp {{ number_format($order->total_harga) }}</p>
                  </div>

                  <!-- Order Quantity -->
                  <div class="cart-item-quantity d-flex align-items-center me-3 mb-3 mb-sm-0">
                    <p class="product-quantity fw-semibold mb-0">Total {{ $order->orderItems->sum('qty') }} Produk</p>
                  </div>

                  <!-- Action Buttons (Moved Below Quantity) -->
                  <div class="d-flex flex-column mt-2">
                    @if ($order->status_order == 'PENDING')
                      <a href="{{ route('payment', ['order_id' => $order->order_id, 'id' => $order->invoice->id]) }}"
                        class="btn btn-custom-2 mb-2">
                        Bayar Sekarang
                      </a>
                    @elseif($order->status_order == 'SELESAI')
                      <a href="{{ route('order.buy-again', $order->order_id) }}" class="btn btn-success mb-2">
                        Beli Lagi
                      </a>
                    @endif
                  </div>

                </div>
              @endforeach
            @endif
          </div>
        @endforeach
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const mobileDropdown = document.getElementById('mobileOrderDropdown');
      const tabs = document.querySelectorAll('.tab-pane');

      mobileDropdown.addEventListener('change', function() {
        const selectedTab = mobileDropdown.value;

        // Hide all tab panes
        tabs.forEach((tab) => {
          tab.classList.remove('show', 'active');
        });

        // Show the selected tab pane
        const activeTab = document.getElementById(selectedTab);
        if (activeTab) {
          activeTab.classList.add('show', 'active');
        }
      });
    });
  </script>

@endsection
