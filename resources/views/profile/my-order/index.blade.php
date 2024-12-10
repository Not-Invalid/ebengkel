@extends('layouts.partials.sidebar')

@section('title')
  eBengkelku | My Order
@stop

<style>
  .custom-tab-link {
    color: #000;
    font-weight: 600;
    text-align: center;
    font-size: 13px;
    text-decoration: none;
    padding: 1.2rem 2rem;
    position: relative;
    cursor: pointer;
    display: block;
    transition: color 0.3s ease;
  }

  .custom-tabs .custom-tab-link i {
    margin-right: 5px;
  }

  .custom-dropdown option {
    padding-left: 10px;
    /* Menambahkan jarak kiri di dalam option */
  }

  .custom-tabs {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
    margin: 0;
    border-radius: 10px;
    background-color: white;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
  }

  .custom-tab-item {
    margin-bottom: -1px;
    position: relative;
  }

  .custom-tab-item::after {
    content: "";
    position: absolute;
    right: 0;
    top: 15%;
    height: 70%;
    width: 0.1px;
    background-color: #d7e2ee;
  }

  .custom-tab-item:last-child::after {
    display: none;
  }

  .custom-tab-link::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%) scaleX(0);
    width: 50%;
    height: 2px;
    background-color: var(--main-blue);
    transition: transform 0.3s ease;
  }

  .custom-tab-link.active {
    color: #000;
  }

  .custom-tab-link.active::after {
    transform: translateX(-50%) scaleX(1);
  }

  .custom-tabs-container {
    position: relative;
  }

  .custom-dropdown {
    display: none;
    width: 100%;
    padding: 1rem;
    font-size: 1rem;
    border-radius: 10px;
    border: none;
    background-color: white;
    outline: none;
  }

  .custom-dropdown:focus,
  .custom-dropdown:active {
    border: none;
  }

  .tab-pane {
    display: none;
    /* Menyembunyikan semua tab secara default */
  }

  .tab-pane.active {
    display: block;
    /* Menampilkan tab yang aktif */
  }

  .tab-pane.show {
    display: block;
    /* Menampilkan tab yang sedang aktif dengan kelas show */
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
    cursor: pointer;
  }

  .cart-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
  }

  .cart-item img {
    border-radius: 8px;
    height: 100px;
    width: 100px;
  }


  /* Menyembunyikan tab pada perangkat mobile dan tablet */
  @media (max-width: 768px) {
    .custom-tabs {
      display: none;
      /* Sembunyikan tab pada layar kecil */
    }

    .custom-dropdown {
      display: block;
      /* Tampilkan dropdown pada perangkat mobile/tablet */
    }
  }

  /* Menampilkan tab pada layar besar */
  @media (min-width: 769px) {
    .custom-dropdown {
      display: none;
      /* Sembunyikan dropdown pada perangkat desktop */
    }

    .custom-tabs {
      display: flex;
      /* Menampilkan tab pada layar besar */
    }
  }
</style>

@section('content')
  <section class="mt-5">
    <div class="custom-tabs-container">
      <ul class="custom-tabs shadow text-center">
        @foreach ($statusNames as $key => $name)
          <li class="custom-tab-item">
            <a class="custom-tab-link {{ $status == $key ? 'active' : '' }}"
              href="{{ route('my-order.index', ['status' => $key]) }}" data-tab="{{ $key }}">
              <!-- Menambahkan ikon sesuai status -->
              <i
                class="fas {{ $key == 'PENDING'
                    ? 'fa-credit-card'
                    : ($key == 'Waiting_Confirmation'
                        ? 'fa-hourglass'
                        : ($key == 'DIKEMAS'
                            ? 'fa-box-open'
                            : ($key == 'DIKIRIM'
                                ? 'fa-truck-fast'
                                : 'fa-check-circle'))) }}"></i>
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
                  // Filter order berdasarkan status tab
                  $filteredOrders = $orders->where('status_order', $key);
                @endphp
                @foreach ($filteredOrders as $order)
                  <div
                    class="cart-item d-flex flex-column flex-sm-row align-items-center mb-3 p-3 border rounded shadow-sm"
                    data-id="{{ $order->order_id }}" data-stock="{{ $order->orderItems->sum('qty') }}"
                    data-price="{{ $order->grand_total }}"
                    data-href="{{ route('my-order.detail', ['order_id' => $order->order_id]) }}"
                    onclick="window.location.href=this.dataset.href;">

                    <!-- Product Image -->
                    <div class="cart-item-image me-3 mb-3 mb-sm-0">
                      <img src="{{ asset('assets/images/components/image.png') }}" alt="Product Image" class="img-fluid"
                        style="width: 100px; height: 100px; object-fit: cover;" />
                    </div>

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
                          class="btn btn-custom-2 mb-2">Bayar Sekarang</a>
                      @elseif($order->status_order == 'SELESAI')
                        <a href="{{ route('order.buy-again', $order->order_id) }}" class="btn btn-success mb-2">Beli
                          Lagi</a>
                      @endif
                    </div>

                  </div>
                @endforeach




              </div>
            </div>
          @endforeach
        </div>



      </div>

    </div>
    </div>
  </section>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const tabLinks = document.querySelectorAll(".custom-tab-link");
      const dropdown = document.querySelector("#mobileOrderDropdown");
      const tabs = document.querySelectorAll(".tab-pane");

      // Handle Tab Switch
      tabLinks.forEach((link) => {
        link.addEventListener("click", function(e) {
          e.preventDefault();

          tabLinks.forEach((tab) => tab.classList.remove("active"));
          tabs.forEach((pane) => {
            pane.classList.remove("active", "show");
            // Hapus pesan empty jika ada
            const emptyMessage = pane.querySelector('.empty-message');
            if (emptyMessage) {
              emptyMessage.remove();
            }
          });

          // Menambahkan kelas active dan show ke tab yang dipilih
          this.classList.add("active");
          const targetTab = document.getElementById(this.getAttribute("data-tab"));

          // Pastikan tab dengan status kosong tetap tampil
          if (targetTab) {
            targetTab.classList.add("active", "show");

            // Cek apakah tab kosong dan pastikan pesan hanya ditambahkan sekali
            if (!targetTab.querySelector('.cart-item') && !targetTab.querySelector('.empty-message')) {
              const emptyMessage = document.createElement('div');
              emptyMessage.classList.add('empty-message', 'col-12');
              emptyMessage.innerHTML = `
            <div class="card border-1 rounded-2">
              <div class="card-body d-flex justify-content-center">
                <div class="text-center">
                  <img src="{{ asset('assets/images/components/empty.png') }}" height="130" width="130" alt="No Address">
                  <p>Belum ada pesanan di status ${this.innerText}.</p>
                </div>
              </div>
            </div>`;
              targetTab.appendChild(emptyMessage);
            }
          }
        });
      });

      // Handle Dropdown Selection
      dropdown.addEventListener("change", function() {
        window.location.href = this.value;
      });
    });
  </script>
@endsection
