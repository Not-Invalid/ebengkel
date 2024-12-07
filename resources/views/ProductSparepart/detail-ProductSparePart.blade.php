@extends('layouts.app')

@push('css')
  <link rel="stylesheet" href="{{ asset('assets/css/detail-ProductSparePart.css') }}">
@endpush

@section('title')
  eBengkelku | Detail Product & SparePart
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
          <h4 class="title-header">Product & SparePart</h4>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
      <div class="row gx-4 gx-lg-5">
        <!-- Product Images Section -->
        <div class="col-md-5">
          <div class="row">
            <div class="col-md-12">
              <!-- Foto Besar -->
              <div class="mb-3 text-center">
                <img id="mainPhoto" src="{{ $mainPhoto }}" alt="Main Photo"
                  style="width: 100%; height: 400px; object-fit: cover; border-radius: 8px;" class="shadow">
              </div>
              <!-- Foto Kecil -->
              <div class="d-flex justify-content-start gap-2 mb-3">
                @foreach ($thumbnailPhotos as $thumbnail)
                  <img class="thumbnail-photo shadow" src="{{ $thumbnail }}" alt="Thumbnail"
                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; cursor: pointer;"
                    onclick="changeMainPhoto(this)">
                @endforeach
              </div>
            </div>
          </div>


          <div class="store-info p-3 rounded shadow">
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
                class="btn btn-outline-primary btn-sm">{{ __('messages.ProductSparepart.visit_store') }}</a>
            </div>
          </div>
        </div>


        <!-- Product Details Section -->
        <div class="col-md-7">
          <h3 class="fw-semibold mb-2">{{ $data->nama_produk ?? $data->nama_spare_part }}</h3>
          <div class="d-flex align-items-center mb-3">
            <div class="reviews-count text-muted me-3">
              {{ __('messages.ProductSparepart.stock', ['count' => $data->stok_produk ?? $data->stok_spare_part]) }}
            </div>
            <div class="sales-count text-muted">
              {{ __('messages.ProductSparepart.sold', ['count' => 1919]) }}
            </div>
          </div>

          <!-- Price -->
          <div class="fs-4 mb-4">
            <span class="fw-medium">Rp.
              {{ number_format($data->harga_produk ?? $data->harga_spare_part, 0, ',', '.') }}</span>
          </div>

          <!-- Description -->
          <span class="text-muted mb-1">{{ __('messages.ProductSparepart.description') }}</span>
          <p class="m-0 mb-3">{{ $data->keterangan_produk ?? $data->keterangan_spare_part }}</p>

          <!-- Quantity Section -->
          <div class="d-flex align-items-center mb-4">
            <label class="fw-semibold me-3">{{ __('messages.ProductSparepart.quantity') }}:</label>
            <div class="cart-item-quantity d-flex align-items-center me-3">
              <button class="btn btn-outline-dark btn-sm btn-decrement">−</button>
              <input type="text" class="form-control form-control-sm text-center mx-1 quantity-input" value="1"
                style="width: 50px;">
              <button class="btn btn-outline-dark btn-sm btn-increment">+</button>
            </div>
          </div>

          <!-- Action Buttons -->
          <form action="{{ route('cart.add') }}" method="POST" class="d-flex gap-3 mb-4">
            @csrf
            <input type="hidden" name="id_produk" value="{{ $data->id_produk ?? '' }}">
            <input type="hidden" name="id_spare_part" value="{{ $data->id_spare_part ?? '' }}">
            <input type="hidden" name="quantity" value="1" id="quantity-input">
            <button class="btn btn-outline-dark flex-grow-1 py-2" type="submit" id="add-to-cart-btn">
              <i class="bx bx-cart me-1"></i> {{ __('messages.ProductSparepart.add_to_cart') }}
            </button>
            <button class="btn btn-primary flex-grow-1 py-2">
              {{ __('messages.ProductSparepart.buy_now') }}
            </button>
          </form>

        </div>
      </div>
    </div>
  </section>


  <script>
    document.querySelector('.btn-increment').addEventListener('click', function() {
      var quantityInput = document.querySelector('.quantity-input');
      quantityInput.value = parseInt(quantityInput.value) + 1;
      document.querySelector('#quantity-input').value = quantityInput.value; // Update hidden input
    });

    document.querySelector('.btn-decrement').addEventListener('click', function() {
      var quantityInput = document.querySelector('.quantity-input');
      if (parseInt(quantityInput.value) > 1) {
        quantityInput.value = parseInt(quantityInput.value) - 1;
        document.querySelector('#quantity-input').value = quantityInput.value; // Update hidden input
      }
    });
  </script>
  <script>
    function changeMainPhoto(thumbnail) {
      // Simpan elemen foto utama
      let mainPhoto = document.getElementById('mainPhoto');

      // Simpan URL foto besar saat ini
      let currentMainPhotoSrc = mainPhoto.src;

      // Ganti foto utama dengan foto kecil yang diklik
      mainPhoto.src = thumbnail.src;

      // Ganti foto kecil yang diklik dengan foto besar sebelumnya
      thumbnail.src = currentMainPhotoSrc;
    }
  </script>

@endsection
