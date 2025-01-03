@extends('layouts.app')
@push('css')
  <link rel="stylesheet" href="{{ asset('assets/css/workshop.css') }}">
@endpush
@section('title')
  eBengkelku | Workshop Detail
@stop
<!-- Tambahkan CSS -->
<style>
  .rating-form i {
    font-size: 30px;
    color: #ccc;
    cursor: pointer;
    direction: rtl;
  }

  .rating-form i.selected {
    color: #f39c12;
    /* Warna bintang terpilih */
  }

  #komentar {
    border: none;
    background-color: #f6f6f6;
    box-shadow: 0px 5px 5px 0px rgba(0, 0, 0, 0.2);
    height: 100px;
    resize: none;
  }
</style>
<script>
  function copyLink() {
    const link =
      'https://ebengkelku.com/workshop/{{ $bengkel->id_bengkel }}'; // Replace with the actual workshop link
    navigator.clipboard.writeText(link).then(() => {
      // Display Toastr notification
      toastr.success("Link copied!");
    }).catch(err => {
      toastr.error("Failed to copy link.");
    });
  }
</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const tabLinks = document.querySelectorAll(".custom-tab-link");
    const dropdown = document.querySelector(".custom-dropdown");

    tabLinks.forEach((link) => {
      link.addEventListener("click", function(e) {
        e.preventDefault();
        tabLinks.forEach((tab) => tab.classList.remove("active"));
        document
          .querySelectorAll(".tab-pane")
          .forEach((pane) => pane.classList.remove("active"));
        this.classList.add("active");
        document
          .getElementById(this.getAttribute("data-tab"))
          .classList.add("active");
      });
    });

    dropdown.addEventListener("change", function() {
      const selectedTab = this.value;
      tabLinks.forEach((tab) => tab.classList.remove("active"));
      document
        .querySelectorAll(".tab-pane")
        .forEach((pane) => pane.classList.remove("active"));
      document
        .querySelector(`[data-tab="${selectedTab}"]`)
        .classList.add("active");
      document.getElementById(selectedTab).classList.add("active");
    });
  });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.rating-form i');
    const ratingInput = document.getElementById('ratingInput');

    stars.forEach((star, index) => {
      star.addEventListener('click', function() {
        const selectedValue = index + 1;
        ratingInput.value = selectedValue;

        stars.forEach(s => s.classList.remove('selected'));

        for (let i = 0; i < selectedValue; i++) {
          stars[i].classList.add('selected');
        }
      });
    });
  });
</script>

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
          <h4 class="title-header">{{ __('messages.workshop.workshop_detail') }}</h4>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container my-5">
      <section>
        <div class="card workshop-header">
          <div class="position-relative">
            <img
              src="{{ isset($bengkel) && $bengkel->foto_cover_bengkel ? url($bengkel->foto_cover_bengkel) : asset('assets/images/components/image.png') }}"
              alt="Cover Bengkel" class="img-cover w-100" style="object-fit: cover; height: 225px;">

            <div class="d-flex align-items-center p-3 position-absolute top-50 start-0 translate-middle-y"
              style="background: rgba(0, 0, 0, 0.5); border-radius: 0 0.5rem 0.5rem 0;">
              <img
                src="{{ isset($bengkel) && $bengkel->foto_bengkel ? url($bengkel->foto_bengkel) : asset('assets/images/components/image.png') }}"
                alt="Profile Image" class="rounded-circle me-3" style="width: 80px; height: 80px; object-fit: cover;">
              <div class="text-light">
                <h4 class="mb-1" style="font-weight: bold; color:white;">
                  {{ \Illuminate\Support\Str::limit($bengkel->nama_bengkel, 20) }}</h4>
                <p class="mb-0" style="font-size: 0.9rem; color:white;">
                  {{ \Illuminate\Support\Str::limit($bengkel->tagline_bengkel, 20) }}h</p>
              </div>
            </div>

            <!-- Social Media and Share Icons with Individual Backgrounds and Opacity -->
            <div class="position-absolute bottom-0 end-0 p-3 d-flex align-items-center">
              <!-- WhatsApp Button -->
              <a href="https://wa.me/{{ $bengkel->whatsapp }}" target="_blank" class="btn btn-dark rounded-circle me-2">
                <i class='bx bxl-whatsapp fs-4' style="color: white;"></i>
              </a>

              <!-- Instagram Button -->
              <a href="https://instagram.com/{{ $bengkel->instagram }}" target="_blank"
                class="btn btn-dark rounded-circle me-2">
                <i class='bx bxl-instagram fs-4' style="color: white;"></i>
              </a>

              <!-- Share Button -->
              <button onclick="copyLink()" class="btn btn-dark rounded-circle">
                <i class='bx bx-share fs-4' style="color: white;"></i>
              </button>
            </div>
          </div>


          <div class="card-body info-workshop">
            <div class="row">
              <div class="col-12 col-md-6 d-flex align-items-center text-start py-2">
                <i class='bx bx-time fs-4 text-primary'></i>
                <div class="ms-3">
                  <span class="d-block fw-bold">{{ __('messages.workshop.operational_hours') }}</span>
                  <small>
                    {{ $bengkel->open_day }} - {{ $bengkel->close_day }},
                    {{ \Carbon\Carbon::parse($bengkel->open_time)->format('H:i') }} -
                    {{ \Carbon\Carbon::parse($bengkel->close_time)->format('H:i') }} WIB
                  </small>
                </div>
              </div>
              <div class="col-12 col-md-6 d-flex align-items-center text-start py-2">
                <i class='bx bx-wrench fs-4 text-primary'></i>
                <div class="ms-3">
                  <span class="d-block fw-bold">{{ __('messages.workshop.service_availability') }}</span>
                  <small>
                    @if ($serviceAvailable && is_array($serviceAvailable))
                      @foreach ($serviceAvailable as $service)
                        <p><i class='bx bx-check-circle align-icon fs-5 m-0'
                            style="color: var(--main-green)"></i>{{ $service }}</p>
                      @endforeach
                    @else
                      <p>{{ __('messages.workshop.no_services_available') }}</p>
                    @endif
                  </small>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 d-flex align-items-center text-start py-2">
                <i class='bx bx-credit-card fs-4 text-primary'></i>
                <div class="ms-3">
                  <span class="d-block fw-bold">{{ __('messages.workshop.accepted_payment_methods') }}</span>
                  <small>
                    @if ($paymentMethods && is_array($paymentMethods))
                      @foreach ($paymentMethods as $method)
                        <p><i class='bx bx-check-circle align-icon fs-5 m-0'
                            style="color: var(--main-green)"></i>{{ $method }}</p>
                      @endforeach
                    @else
                      <p>{{ __('messages.workshop.no_payment_methods') }}</p>
                    @endif
                  </small>
                </div>
              </div>
              <div class="col-12 col-md-6 d-flex align-items-center text-start py-2">
                <i class='bx bx-star fs-4 text-primary'></i>
                <div class="ms-3">
                  <span class="d-block fw-bold">{{ number_format($averageRating, 1) }}
                    {{ __('messages.workshop.rating') }}</span>
                  <small>{{ $totalReviews }} {{ __('messages.workshop.verified_reviews') }}</small>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-12 d-flex align-items-center justify-content-between text-start py-2">
                <div class="d-flex align-items-center">
                  <i class='bx bx-map-pin fs-4 text-primary'></i>
                  <div class="ms-3">
                    <span class="d-block fw-bold">{{ __('messages.workshop.location') }}</span>
                    <small>{{ \Illuminate\Support\Str::limit($bengkel->alamat_bengkel, 100) }} </small>
                  </div>
                </div>
                <a href="{{ $bengkel->gmaps }}" target="_blank" class="btn btn-map ms-3">
                  <i class='bx bx-map'></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="mt-5">
        <div class="custom-tabs-container">
          <ul class="custom-tabs shadow text-center">
            <li class="custom-tab-item">
              <a class="custom-tab-link active" data-tab="all">
                {{ __('messages.workshop.all') }}
              </a>
            </li>
            <li class="custom-tab-item">
              <a class="custom-tab-link" data-tab="service">
                {{ __('messages.workshop.service') }}
              </a>
            </li>
            <li class="custom-tab-item">
              <a class="custom-tab-link" data-tab="product">
                {{ __('messages.workshop.product') }}
              </a>
            </li>
            <li class="custom-tab-item">
              <a class="custom-tab-link" data-tab="spareparts">
                {{ __('messages.workshop.spareparts') }}
              </a>
            </li>
            <li class="custom-tab-item">
              <a class="custom-tab-link" data-tab="ulasan">
                {{ __('messages.workshop.reviews') }}
              </a>
            </li>
          </ul>
          <select class="custom-dropdown shadow">
            <option value="all" selected>{{ __('messages.workshop.all') }}</option>
            <option value="service">{{ __('messages.workshop.service') }}</option>
            <option value="product">{{ __('messages.workshop.product') }}</option>
            <option value="spareparts">{{ __('messages.workshop.spareparts') }}</option>
            <option value="ulasan">{{ __('messages.workshop.reviews') }}</option>
          </select>
        </div>
        <div class="tab-content">
          <div class="tab-pane active" id="all">
            {{-- isi card --}}
            <div class="row py-5">
              {{-- Cek apakah ada data untuk services --}}
              @forelse ($services as $service)
                @if ($service->id_bengkel === $bengkel->id_bengkel)
                  <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="{{ route('service.detail', ['id_bengkel' => $bengkel->id_bengkel, 'id_services' => $service->id_services]) }}"
                      class="card-product p-3">
                      <img
                        src="{{ $service->foto_services ? url($service->foto_services) : asset('assets/images/components/image.png') }}"
                        class="card-img-top" alt="Service Image">
                      <div class="card-body text-start mt-4">
                        <h5 class="card-title">{{ $service->nama_services }}</h5>
                        <div class="footer-card">
                          <div class="price d-flex justify-content-start">
                            <span
                              class="price">{{ 'Rp' . number_format($service->harga_services ?? 0, 0, ',', '.') }}</span>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                @endif
              @empty
              @endforelse

              {{-- Cek apakah ada data untuk products --}}
              @forelse ($products as $product)
                @if ($product->id_bengkel === $bengkel->id_bengkel)
                  <div class="col-12 col-sm-6 col-md-4 col-lg-3 position-relative">
                    <a href="{{ route('Detail-ProductSparePart', ['type' => 'product', 'id' => $product->id_produk]) }}"
                      class="card-product p-3">
                      <img
                        src="{{ $product->fotoProduk && file_exists(public_path($product->fotoProduk->file_foto_produk_1))
                            ? asset($product->fotoProduk->file_foto_produk_1)
                            : asset('assets/images/components/image.png') }}"
                        class="card-img-top" alt="{{ $product->nama_produk ?? 'Default Image' }}">
                      {{-- Badge stok di kanan atas --}}
                      <div class="card-body text-start mt-4">
                        <h5 class="card-title">{{ $product->nama_produk }}</h5>
                        <div class="footer-card">
                          <div class="price d-flex justify-content-start">
                            <span
                              class="price">{{ 'Rp' . number_format($product->harga_produk ?? 0, 0, ',', '.') }}</span>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                @endif
                {{-- isi pagination product disini --}}
              @empty
              @endforelse

              {{-- Cek apakah ada data untuk spareparts --}}
              @forelse ($spareparts as $sparepart)
                @if ($sparepart->id_bengkel === $bengkel->id_bengkel)
                  <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="{{ route('Detail-ProductSparePart', ['type' => 'sparepart', 'id' => $sparepart->id_spare_part]) }}"
                      class="card-product p-3">
                      <img
                        src="{{ $sparepart->fotoSparepart && file_exists(public_path($sparepart->fotoSparepart->file_foto_spare_part_1))
                            ? asset($sparepart->fotoSparepart->file_foto_spare_part_1)
                            : asset('assets/images/components/image.png') }}"
                        class="card-img-top" alt="{{ $sparepart->nama_produk ?? 'Default Image' }}">
                      <div class="card-body text-start mt-4">
                        <h5 class="card-title">{{ $sparepart->nama_spare_part }}</h5>
                        <div class="footer-card">
                          <div class="price d-flex justify-content-start">
                            <span
                              class="price">{{ 'Rp' . number_format($sparepart->harga_spare_part ?? 0, 0, ',', '.') }}</span>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                @endif
                {{-- isi pagination sparepart disini --}}
              @empty
              @endforelse

              {{-- Jika semua kategori kosong --}}
              @if ($services->isEmpty() && $products->isEmpty() && $spareparts->isEmpty())
                <div class="text-center w-100">
                  <img src="{{ asset('assets/images/components/empty.png') }}" width="200" alt="No Data">
                  <p>{{ __('messages.workshop.no_data_items') }}.</p>
                </div>
              @endif

            </div>
          </div>
          <!-- Service Tab -->
          <div class="tab-pane" id="service">
            <div class="row py-5">
              @forelse ($services as $service)
                @if ($service->id_bengkel === $bengkel->id_bengkel)
                  <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="{{ route('service.detail', ['id_bengkel' => $bengkel->id_bengkel, 'id_services' => $service->id_services]) }}"
                      class="card-product p-3">
                      <img
                        src="{{ $service->foto_services ? url($service->foto_services) : asset('assets/images/components/image.png') }}"
                        class="card-img-top" alt="Service Image">
                      <div class="card-body text-start mt-4">
                        <h5 class="card-title">{{ $service->nama_services }}</h5>
                        <div class="footer-card">
                          <div class="price d-flex justify-content-start">
                            <span
                              class="price">{{ 'Rp' . number_format($service->harga_services ?? 0, 0, ',', '.') }}</span>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                @endif
              @empty
                <div class="text-center">
                  <img src="{{ asset('assets/images/components/empty.png') }}" width="200" alt="No Data">
                  <p>{{ __('messages.workshop.no_data_items') }}.</p>
                </div>
              @endforelse
              <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation">
                  <ul class="pagination">
                    @if ($services->onFirstPage())
                      <li class="page-item disabled">
                        <a class="page-link">{{ __('messages.workshop.previous') }}</a>
                      </li>
                    @else
                      <li class="page-item">
                        <a href="{{ $services->previousPageUrl() . '&tab=service' }}"
                          class="page-link">{{ __('messages.workshop.previous') }}</a>
                      </li>
                    @endif
                    @foreach ($services->getUrlRange(1, $services->lastPage()) as $page => $url)
                      <li class="page-item {{ $page == $services->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url . '&tab=service' }}">{{ $page }}</a>
                      </li>
                    @endforeach
                    @if ($services->hasMorePages())
                      <li class="page-item">
                        <a href="{{ $services->nextPageUrl() . '&tab=service' }}"
                          class="page-link">{{ __('messages.workshop.next') }}</a>
                      </li>
                    @else
                      <li class="page-item disabled">
                        <a class="page-link">{{ __('messages.workshop.next') }}</a>
                      </li>
                    @endif
                  </ul>
                </nav>
              </div>
            </div>
          </div>

          <!-- Product Tab -->
          <div class="tab-pane" id="product">
            <div class="row py-5">
              @forelse ($products as $product)
                @if ($product->id_bengkel === $bengkel->id_bengkel)
                  <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="{{ route('Detail-ProductSparePart', ['type' => 'product', 'id' => $product->id_produk]) }}"
                      class="card-product p-3">
                      <img
                        src="{{ $product->fotoProduk && file_exists(public_path($product->fotoProduk->file_foto_produk_1))
                            ? asset($product->fotoProduk->file_foto_produk_1)
                            : asset('assets/images/components/image.png') }}"
                        class="card-img-top" alt="{{ $product->nama_produk ?? 'Default Image' }}">
                      <div class="card-body text-start mt-4">
                        <h5 class="card-title">{{ $product->nama_produk }}</h5>
                        <div class="footer-card">
                          <div class="price d-flex justify-content-start">
                            <span
                              class="price">{{ 'Rp' . number_format($product->harga_produk ?? 0, 0, ',', '.') }}</span>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                @endif
              @empty
                <div class="text-center">
                  <img src="{{ asset('assets/images/components/empty.png') }}" width="200" alt="No Data">
                  <p>{{ __('messages.workshop.no_data_items') }}.</p>
                </div>
              @endforelse
              <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation">
                  <ul class="pagination">
                    @if ($products->onFirstPage())
                      <li class="page-item disabled">
                        <a class="page-link">{{ __('messages.workshop.previous') }}</a>
                      </li>
                    @else
                      <li class="page-item">
                        <a href="{{ $products->previousPageUrl() . '&tab=product' }}"
                          class="page-link">{{ __('messages.workshop.previous') }}</a>
                      </li>
                    @endif
                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                      <li class="page-item {{ $page == $products->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url . '&tab=product' }}">{{ $page }}</a>
                      </li>
                    @endforeach
                    @if ($products->hasMorePages())
                      <li class="page-item">
                        <a href="{{ $products->nextPageUrl() . '&tab=product' }}"
                          class="page-link">{{ __('messages.workshop.next') }}</a>
                      </li>
                    @else
                      <li class="page-item disabled">
                        <a class="page-link">{{ __('messages.workshop.next') }}</a>
                      </li>
                    @endif
                  </ul>
                </nav>
              </div>
            </div>
          </div>

          <!-- Spare Parts Tab -->
          <div class="tab-pane" id="spareparts">
            <div class="row py-5">
              @forelse ($spareparts as $sparepart)
                @if ($sparepart->id_bengkel === $bengkel->id_bengkel)
                  <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="{{ route('Detail-ProductSparePart', ['type' => 'sparepart', 'id' => $sparepart->id_spare_part]) }}"
                      class="card-product p-3">
                      <img
                        src="{{ $sparepart->fotoSparepart && file_exists(public_path($sparepart->fotoSparepart->file_foto_spare_part_1))
                            ? asset($sparepart->fotoSparepart->file_foto_spare_part_1)
                            : asset('assets/images/components/image.png') }}"
                        class="card-img-top" alt="{{ $sparepart->nama_produk ?? 'Default Image' }}">
                      <div class="card-body text-start mt-4">
                        <h5 class="card-title">{{ $sparepart->nama_spare_part }}</h5>
                        <div class="footer-card">
                          <div class="price d-flex justify-content-start">
                            <span
                              class="price">{{ 'Rp' . number_format($sparepart->harga_spare_part ?? 0, 0, ',', '.') }}</span>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                @endif
              @empty
                <div class="text-center">
                  <img src="{{ asset('assets/images/components/empty.png') }}" width="200" alt="No Data">
                  <p>{{ __('messages.workshop.no_data_items') }}.</p>
                </div>
              @endforelse
              <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation">
                  <ul class="pagination">
                    @if ($spareparts->onFirstPage())
                      <li class="page-item disabled">
                        <a class="page-link">{{ __('messages.workshop.previous') }}</a>
                      </li>
                    @else
                      <li class="page-item">
                        <a href="{{ $spareparts->previousPageUrl() . '&tab=spareparts' }}"
                          class="page-link">{{ __('messages.workshop.previous') }}</a>
                      </li>
                    @endif
                    @foreach ($spareparts->getUrlRange(1, $spareparts->lastPage()) as $page => $url)
                      <li class="page-item {{ $page == $spareparts->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url . '&tab=spareparts' }}">{{ $page }}</a>
                      </li>
                    @endforeach
                    @if ($spareparts->hasMorePages())
                      <li class="page-item">
                        <a href="{{ $spareparts->nextPageUrl() . '&tab=spareparts' }}"
                          class="page-link">{{ __('messages.workshop.next') }}</a>
                      </li>
                    @else
                      <li class="page-item disabled">
                        <a class="page-link">{{ __('messages.workshop.next') }}</a>
                      </li>
                    @endif
                  </ul>
                </nav>
              </div>
            </div>
          </div>

          <div class="tab-pane" id="ulasan">
            <div class="reviews-header d-flex justify-content-between align-items-center py-5">
              <h3 class="review-title">{{ __('messages.workshop.header') }}</h3>
              @if (session()->has('id_pelanggan'))
                <button type="button" class="btn btn-review" data-bs-toggle="modal" data-bs-target="#reviewModal">
                  {{ __('messages.workshop.button_review') }}
                </button>
              @endif
            </div>
            <div class="overall-rating">
              <div class="rating-value">{{ number_format($averageRating, 1) }}</div>
              <span>
                <div class="rating-category">
                  {{ $ratingCategory ?? __('messages.workshop.rating_category_none') }}
                </div>
                <div class="rating-text">
                  {{ __('messages.workshop.total_reviews', ['count' => $totalReviews]) }}
                </div>
              </span>
            </div>
            <hr>
            @foreach ($ulasan as $review)
              <div class="review-card d-flex align-items-start mb-4">
                <div class="review-photo me-3">
                  <img
                    src="{{ isset($review->pelanggan) && $review->pelanggan->foto_pelanggan ? url($review->pelanggan->foto_pelanggan) : asset('assets/images/components/avatar.png') }}"
                    alt="Profile Picture" class="rounded-circle" width="50" height="50">
                </div>
                <div class="review-content w-100">
                  <div class="row mb-2">
                    <div class="col text-start">
                      <h6 class="fw-bold">
                        {{ $review->pelanggan->nama_pelanggan }}
                        <span class="text-muted" style="font-size:14px;">
                          ({{ __('messages.workshop.rating_format', ['rating' => $review->rating]) }})
                        </span>
                      </h6>
                    </div>
                    <div class="col text-end">
                      <small class="text-muted">
                        {{ __('messages.workshop.review_date', ['date' => \Carbon\Carbon::parse($review->created_at)->format('d M Y')]) }}
                      </small>
                    </div>
                  </div>
                  <p>{{ $review->komentar }}</p>
                </div>
              </div>
            @endforeach

            <!-- Modal -->
            <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-body">
                    <form method="POST" action="{{ route('ulasan.store') }}">
                      @csrf
                      <!-- Hidden field for customer ID -->
                      <input type="hidden" name="id_pelanggan" value="{{ session('id_pelanggan') }}">
                      <!-- Hidden field for workshop ID -->
                      <input type="hidden" name="id_bengkel" value="{{ $bengkel->id_bengkel }}">
                      <h3 class="title-rating">{{ __('messages.workshop.review_modal_title') }}
                      </h3>
                      <div class="form-group py-3">
                        <div class="rating-form">
                          <i class="bx bx-star" data-value="1"></i>
                          <i class="bx bx-star" data-value="2"></i>
                          <i class="bx bx-star" data-value="3"></i>
                          <i class="bx bx-star" data-value="4"></i>
                          <i class="bx bx-star" data-value="5"></i>
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" required>
                      </div>
                      <div class="mb-3">
                        <textarea name="komentar" class="form-control" id="komentar" rows="3"
                          placeholder="{{ __('messages.workshop.comment_placeholder') }}"></textarea>
                      </div>
                      <button type="submit" class="btn btn-review">
                        {{ __('messages.workshop.submit_button') }}
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>
@endsection
