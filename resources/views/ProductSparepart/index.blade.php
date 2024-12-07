@extends('layouts.app')
@push('css')
  <link rel="stylesheet" href="{{ asset('assets/css/productSparepart.css') }}">
@endpush
@section('title')
  eBengkelku | Product & Sparepart
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
          <h4 class="title-header">{{ __('messages.ProductSparepart.title') }}</h4>
        </div>
      </div>
    </div>
  </section>

  <div class="container mt-5">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="d-flex justify-content-center align-items-center" style="min-height: 50px;">
            <form method="GET" action="" style="width: 60%;">
              <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}" required maxlength="255"
                  placeholder="{{ __('messages.ProductSparepart.search') }}..." class="form-control"
                  style="border-radius: 20px 0 0 20px;">
                <div class="input-group-append">
                  <button type="submit" class="btn btn-search" style="border-radius: 0 20px 20px 0;">
                    <i class='bx bx-search-alt align-icon'></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <!-- Filter Buttons -->
      <div class="filter-buttons">
        <button onclick="filterCategory('all')" class="filter-btn">{{ __('messages.ProductSparepart.all') }}</button>
        <button onclick="filterCategory('product')"
          class="filter-btn">{{ __('messages.ProductSparepart.product') }}</button>
        <button onclick="filterCategory('sparepart')"
          class="filter-btn">{{ __('messages.ProductSparepart.spareparts') }}</button>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="row">
            @foreach ($product as $prod)
              <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-3" data-category="product">
                <a href="{{ route('Detail-ProductSparePart', ['type' => 'product', 'id' => $prod->id_produk]) }}"
                  class="card-event p-3">
                  <img
                    src="{{ isset($prod->fotoProduk) && $prod->fotoProduk->file_foto_produk_1
                        ? url($prod->fotoProduk->file_foto_produk_1)
                        : asset('assets/images/components/image.png') }}"
                    class="card-img-top" alt="Product Image">
                  <div class="card-body text-start">
                    <p class="workshop-name">{{ $prod->bengkel->nama_bengkel }}</p>
                    <p class="card-title">{{ $prod->nama_produk }}</p>
                    <div class="footer-card">
                      <div class="price d-flex justify-content-start">
                        <span class="price">Rp. {{ number_format($prod->harga_produk, 0, ',', '.') }}</span>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            @endforeach

            @foreach ($sparepart as $spare)
              <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-3" data-category="sparepart">
                <a href="{{ route('Detail-ProductSparePart', ['type' => 'sparepart', 'id' => $spare->id_spare_part]) }}"
                  class="card-event p-3">
                  <img
                    src="{{ isset($spare->fotoSparepart) && $spare->fotoSparepart->file_foto_spare_part_1
                        ? url($spare->fotoSparepart->file_foto_spare_part_1)
                        : asset('assets/images/components/image.png') }}"
                    class="card-img-top" alt="Sparepart Image">
                  <div class="card-body text-start">
                    <p class="workshop-name">{{ $spare->bengkel->nama_bengkel }}</p>
                    <p class="card-title">{{ $spare->nama_spare_part }}</p>
                    <div class="footer-card">
                      <div class="price d-flex justify-content-start">
                        <span class="price">Rp. {{ number_format($spare->harga_spare_part, 0, ',', '.') }}</span>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            @endforeach
          </div>

        </div>
      </div>
    </div>

  </div>
@endsection
