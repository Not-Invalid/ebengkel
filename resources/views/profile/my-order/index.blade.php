@extends('layouts.partials.sidebar')

@section('title')
  eBengkelku | My Order
@stop

@section('content')
  <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
    <div class="container my-4">
      <!-- Tambahkan Dropdown untuk Mobile -->
      <div class="d-md-none mb-3">
        <select class="form-select" id="mobileOrderDropdown">
          <option value="dikemas">Dikemas</option>
          <option value="dikirim">Dikirim</option>
          <option value="selesai">Selesai</option>
        </select>
      </div>

      <!-- Tabs untuk perangkat desktop -->
      <ul class="nav nav-pills justify-content-center mb-3 d-none d-md-flex mb-5" id="orderTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active text-center" id="dikemas-tab" data-bs-toggle="pill" data-bs-target="#dikemas"
            type="button" role="tab" aria-controls="dikemas" aria-selected="true">
            <i class="bx bx-package bx-md"></i><br>Dikemas
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <hr class="horizontal-line">
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link text-center" id="dikirim-tab" data-bs-toggle="pill" data-bs-target="#dikirim"
            type="button" role="tab" aria-controls="dikirim" aria-selected="false">
            <i class="bx bxs-truck bx-md"></i><br>Dikirim
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <hr class="horizontal-line">
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link text-center" id="selesai-tab" data-bs-toggle="pill" data-bs-target="#selesai"
            type="button" role="tab" aria-controls="selesai" aria-selected="false">
            <i class="bx bx-check-circle bx-md  "></i><br>Selesai
          </button>
        </li>
      </ul>

      <!-- Konten Tab -->
      <div class="tab-content" id="orderTabsContent">
        <div class="tab-pane fade show active" id="dikemas" role="tabpanel" aria-labelledby="dikemas-tab">
          <div class="cart-item d-flex align-items-center mb-3 p-3" data-id="12345" data-stock="10" data-price="50000"
            style="position: relative;">
            <div class="cart-item-image me-3">
              <img src="{{ asset('assets/images/components/image.png') }}" alt="Product Image"
                style="width: 100px; height: 100px; object-fit: cover;" />
            </div>
            <div class="cart-item-details flex-grow-1">
              <h6>Product Name</h6>
              <p class="text-muted mb-1">Workshop Name</p>
              <p class="text-primary fw-bold mb-1"><span class="text-muted fw-light">Total 2 Pesanan: </span>Rp 50,000</p>
            </div>

            <!-- Button Detail Order at the center-right -->
            <a href="{{ route('my-order.detail') }}" class="btn btn-primary btn-sm"
              style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%);">Detail Order</a>
          </div>


          {{-- <div class="card border-1 rounded-2 mt-4">
            <div class="card-body d-flex justify-content-center">
              <div class="text-center">
                <img src="{{ asset('assets/images/components/empty.png') }}" height="130" width="130"
                  alt="No Address">
                <p>Nothing is being packaged.</p>
              </div>
            </div>
          </div> --}}
        </div>
        <div class="tab-pane fade" id="dikirim" role="tabpanel" aria-labelledby="dikirim-tab">
          <div class="card border-1 rounded-2 mt-4">
            <div class="card-body d-flex justify-content-center">
              <div class="text-center">
                <img src="{{ asset('assets/images/components/empty.png') }}" height="130" width="130"
                  alt="No Address">
                <p>Nothing is being sent.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
          <div class="card border-1 rounded-2 mt-4">
            <div class="card-body d-flex justify-content-center">
              <div class="text-center">
                <img src="{{ asset('assets/images/components/empty.png') }}" height="130" width="130"
                  alt="No Address">
                <p>Nothing was ever purchased.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

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

  .cart-summary h5 {
    margin-bottom: 15px;
  }

  .cart-item-quantity input {
    max-width: 50px;
  }

  .list-unstyled li {
    font-size: 13px;
    margin-left: 2px;
    margin-top: 5px;
    color: var(--main-grey) !important;
  }

  .shipping:hover {
    background-color: var(--main-light-grey);
    color: var(--main-dark-blue);
  }
</style>

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
