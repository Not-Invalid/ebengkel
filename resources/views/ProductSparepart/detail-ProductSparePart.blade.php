@extends('layouts.app')

@push('css')
  <link rel="stylesheet" href="{{ asset('assets/css/detail-ProductSparePart.css') }}">
@endpush

@section('title')
  eBengkelku - Detail Product & SparePart
@stop
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const decrementButton = document.querySelector('.btn-decrement');
    const incrementButton = document.querySelector('.btn-increment');
    const quantityInput = document.querySelector('.form-control');
    const addToCartButton = document.getElementById('add-to-cart-btn');
    const maxStock = {{ $data->stok_produk ?? $data->stok_spare_part }}; // Maksimal stok

    // Decrement button functionality
    decrementButton?.addEventListener('click', () => {
      const currentValue = parseInt(quantityInput.value) || 1;
      if (currentValue > 1) quantityInput.value = currentValue - 1;
    });

    // Increment button functionality
    incrementButton?.addEventListener('click', () => {
      const currentValue = parseInt(quantityInput.value) || 1;
      if (currentValue < maxStock) quantityInput.value = currentValue + 1;
    });

    // Quantity input validation
    quantityInput.addEventListener('input', () => {
      const currentValue = parseInt(quantityInput.value) || 1;
      if (currentValue > maxStock) quantityInput.value = maxStock;
      else if (currentValue < 1) quantityInput.value = 1;
    });

    // Add to Cart
    addToCartButton.addEventListener('click', () => {
      const productId = addToCartButton.getAttribute('data-product-id');
      const quantity = quantityInput.value;

      if (!productId) return alert('Product ID is missing!');

      fetch('/add-to-cart', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({
            id_produk: productId,
            quantity: quantity
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            toastr.success(data.message); // Show success toast
          } else {
            toastr.error(data.message); // Show error toast
          }
        })
        .catch(() => {
          toastr.error('An error occurred. Please try again.'); // Show error toast on failure
        });
    });
  });
</script>
{{-- <script>
  document.addEventListener("DOMContentLoaded", function() {
    const decrementButton = document.querySelector('.btn-decrement');
    const incrementButton = document.querySelector('.btn-increment');
    const quantityInput = document.querySelector('.form-control');
    const addToCartButton = document.getElementById('add-to-cart-btn');
    const maxStock = {{ $data->stok_produk ?? $data->stok_spare_part }}; // Maksimal stok

    // Decrement button functionality
    if (decrementButton) {
      decrementButton.addEventListener('click', () => {
        let currentValue = parseInt(quantityInput.value) || 1;
        if (currentValue > 1) {
          quantityInput.value = currentValue - 1;
        }
      });
    }

    // Increment button functionality
    if (incrementButton) {
      incrementButton.addEventListener('click', () => {
        let currentValue = parseInt(quantityInput.value) || 1;
        if (currentValue < maxStock) {
          quantityInput.value = currentValue + 1;
        }
      });
    }

    // Quantity input validation (ensure value is within range)
    quantityInput.addEventListener('input', () => {
      let currentValue = parseInt(quantityInput.value) || 1;
      if (currentValue > maxStock) {
        quantityInput.value = maxStock;
      } else if (currentValue < 1) {
        quantityInput.value = 1;
      }
    });

    addToCartButton.addEventListener('click', function() {
      const productId = addToCartButton.getAttribute('data-product-id');

      const quantity = quantityInput.value;

      console.log('Product ID:', productId); // Pastikan ID produk muncul di sini

      if (!productId) {
        alert('Product ID is missing!');
        return;
      }

      fetch('/add-to-cart', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({
            id_produk: productId,
            quantity: quantity
          })
        })

        .then(response => response.json())
        .then(data => {
          console.log('Response:', data); // Log the response
          if (data.success) {
            alert(data.message); // Show success message
          } else {
            alert(data.message); // Show error message
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred. Please try again.');
        });
    });

  });
</script> --}}

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
          <h4 class="title-header">Product & SparePart</h4>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
      <div class="row gx-4 gx-lg-5 ">
        <!-- Product Images Section -->
        <div class="col-md-5">
          <div class="main-image-container mb-3">
            <img
              src="{{ isset($data->foto_produk) ? url($data->foto_produk) : (isset($data->foto_spare_part) ? url($data->foto_spare_part) : asset('assets/images/components/image.png')) }}"
              class="img-fluid rounded shadow" alt="Main product image">
          </div>

          <div class="store-info p-3 rounded  shadow">
            <div class="d-flex align-items-center mb-2">
              <div class="store-badge me-2">
                <img
                  src="{{ isset($data->bengkel->foto_bengkel) ? url($data->bengkel->foto_bengkel) : asset('assets/images/default_bengkel.png') }}"
                  alt="" style="height: 40px; width: 40px; object-fit: cover" class="rounded-circle shadow">
              </div>
              <div class="store-rating">
                {{ $data->bengkel->nama_bengkel }}
              </div>
            </div>
            <hr>
            <div class="d-flex justify-content-between align-items-center">
              <span><i
                  class="bx bx-map me-2"></i>{{ \Illuminate\Support\Str::limit($data->bengkel->alamat_bengkel, 25) }}</span>
              <a href="{{ route('workshop.detail', $data->bengkel->id_bengkel) }}"
                class="btn btn-outline-primary btn-sm">VISIT STORE</a>
            </div>
          </div>
        </div>

        <!-- Product Details Section -->
        <div class="col-md-7">
          <h3 class="fw-semibold mb-2">{{ $data->nama_produk ?? $data->nama_spare_part }}</h3>
          <div class="d-flex align-items-center mb-3">
            <div class="reviews-count text-muted me-3">
              {{ $data->stok_produk ?? $data->stok_spare_part }} Stock
            </div>
            <div class="sales-count text-muted">
              1,919 Sold
            </div>
          </div>

          <!-- Price -->
          <div class="fs-4 mb-4">
            <span class="fw-medium">Rp.
              {{ number_format($data->harga_produk ?? $data->harga_spare_part, 0, ',', '.') }}</span>
          </div>

          <!--desc-->
          <span class="text-muted mb-1">Description</span>
          <p class="m-0 mb-3">{{ $data->keterangan_produk ?? $data->keterangan_spare_part }}</p>

          <!-- Quantity -->
          {{-- <div class="d-flex align-items-center mb-4">
            <label class="fw-semibold me-3">Jumlah:</label>
            <div class="input-group" style="width: 150px;">
              <button class="btn btn-outline-secondary btn-decrement" type="button">-</button>
              <input type="text" class="form-control text-center" value="1">
              <button class="btn btn-outline-secondary btn-increment" type="button">+</button>
            </div>
          </div> --}}
          <!-- Quantity Section -->
          <div class="d-flex align-items-center mb-4">
            <label class="fw-semibold me-3">Jumlah:</label>
            <div class="cart-item-quantity d-flex align-items-center me-3">
              <button class="btn btn-outline-dark btn-sm btn-decrement">−</button>
              <input type="text" class="form-control form-control-sm text-center mx-1 quantity-input" value="1"
                style="width: 50px;">
              <button class="btn btn-outline-dark btn-sm btn-increment">+</button>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="d-flex gap-3 mb-4">
            <button class="btn btn-outline-dark flex-grow-1 py-2" id="add-to-cart-btn"
              data-product-id="{{ $data->id_produk }}">
              <i class="bx bx-cart me-1"></i> Add to Cart
            </button>
            <button class="btn btn-primary flex-grow-1 py-2">
              Buy Now
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
