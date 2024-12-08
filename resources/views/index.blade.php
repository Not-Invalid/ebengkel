@extends('layouts.app')
@push('css')
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
@endpush

@section('title')
  eBengkelku | Service, Spare Part & Smart Tools
@stop
@section('content')
  <div id="home" class="header-hero bg_cover"
    style="background-image: url('{{ asset('assets/images/bg/wallpaper.png') }}')">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
          <div class="header-content text-center" style="padding-top: 10em;">
            <div class="row">
              <div class="col-md-3">&nbsp;</div>
              <div class="col-md-6">
                <img src="{{ asset('assets/images/logo/logo.png') }}" style="max-width: 100%;">
              </div>
            </div>
            <center>
              <h4>
                <p>&nbsp;</p>
                <b style="color: #3a6fb0;">{{ __('messages.home.saling_support') }}</b>
              </h4>
            </center>
            <ul class="header-btn">
              @if (Session::has('id_pelanggan'))
                <li>
                  <a class="main-btn btn-one" href="{{ route('profile') }}">
                    <i class='bx bx-user'></i>PROFILE
                  </a>
                </li>
              @else
                <li>
                  <a class="main-btn btn-one" href="{{ route('register') }}">
                    {{ __('messages.home.register_now') }}
                  </a>
                </li>
              @endif
              <li>
                <a class="main-btn btn-two video-popup" href="https://www.youtube.com/watch?v=r44RKWyfcFw">
                  {{ __('messages.home.our_video') }} <i class='bx bx-play-circle bx-sm align-icon'></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="header-shape">
      <img src="{{ asset('assets/images/bg/header-shape.svg') }}" alt="shape" style="margin-bottom: -5px;">
    </div>
  </div>

  {{-- GET START  --}}
  <section class="section get-start bg-white" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="container">
      <h2 class="h2 section-title">{{ __('messages.home.what_is_ebengkelku') }}</h2>

      <ul class="get-start-list">
        <!-- Card 1: Bergabung dengan Ebengkelku -->
        <li>
          <div class="get-start-card shadow">
            <div class="card-icon icon-1">
              <i class='bx bx-user-plus'></i>
            </div>
            <h3 class="card-title">{{ __('messages.home.join_ebengkelku') }}</h3>
            <p class="card-text mb-3">{{ __('messages.home.join_description') }}</p>
            @if (auth('pelanggan')->guest())
              <a href="{{ route('register') }}"
                class="card-link text-decoration-none">{{ __('messages.home.register_now') }}</a>
            @endif
          </div>
        </li>

        <!-- Card 2: Temukan Layanan -->
        <li>
          <div class="get-start-card shadow">
            <div class="card-icon icon-2">
              <i class="bx bx-car"></i>
            </div>
            <h3 class="card-title">{{ __('messages.home.choose_service') }}</h3>
            <p class="card-text">{{ __('messages.home.service_description') }}</p>
          </div>
        </li>

        <!-- Card 3: Temukan Bengkel Terdekat -->
        <li>
          <div class="get-start-card shadow">
            <div class="card-icon icon-3">
              <i class="bx bx-map-pin"></i>
            </div>
            <h3 class="card-title">{{ __('messages.home.find_nearby_workshop') }}</h3>
            <p class="card-text">{{ __('messages.home.workshop_description') }}</p>
          </div>
        </li>

        <!-- Card 4: Jadwalkan Servis -->
        <li>
          <div class="get-start-card shadow">
            <div class="card-icon icon-4">
              <i class="bx bx-calendar-check"></i>
            </div>
            <h3 class="card-title">{{ __('messages.home.schedule_service') }}</h3>
            <p class="card-text">{{ __('messages.home.schedule_description') }}</p>
          </div>
        </li>
      </ul>
    </div>
  </section>
  {{-- Latest Event Section --}}
  <section class="section bg-white" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h4 class="text-primary py-2"><i class='bx bx-calendar me-2'></i>{{ __('messages.home.latest_event') }}</h4>
          <div class="row">
            {{-- Check if there are events --}}
            @if ($events->isNotEmpty())
              @foreach ($events as $event)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                  <a href="{{ route('event.detail', $event->id_event) }}" class="card-event p-3">
                    <img src="{{ asset($event->image_cover) }}" class="card-img-top" alt="{{ $event->nama_event }}">
                    <div class="card-body text-start">
                      <p class="card-title mt-4">{{ $event->nama_event }}</p>
                      <div class="d-flex align-items-center event-date">
                        <i class='bx bx-calendar'></i>
                        <span class="date ms-2">
                          {{ \Carbon\Carbon::parse($event->event_start_date)->format('M d, Y') }}
                          -
                          {{ \Carbon\Carbon::parse($event->event_end_date)->format('M d, Y') }}
                        </span>
                      </div>
                      <div class="d-flex align-items-center mt-1 event-date">
                        <i class='bx bx-map-pin'></i>
                        <span class="date ms-2">
                          {{ $event->lokasi }}
                        </span>
                      </div>
                      <div class="footer-card">
                        <div class="price d-flex justify-content-start">
                          <span
                            class="price">{{ $event->tipe_harga === 'Gratis' ? 'Free' : 'Rp' . number_format($event->harga, 0, ',', '.') }}</span>
                        </div>
                      </div>
                    </div>
                  </a>
                </div>
              @endforeach
            @else
              <div class="d-flex justify-content-center pb-5">
                <div class="text-center">
                  <img src="{{ asset('assets/images/components/empty.png') }}" height="200" width="200"
                    alt="Empty">
                  <p>{{ __('messages.home.no_data_event') }}.</p>
                </div>
              </div>
            @endif
          </div>
          {{-- Only show the "More Event" button if there are events available --}}
          @if ($events->isNotEmpty())
            <div class="text-center mt-4">
              <a href="{{ route('event.show') }}" class="btn btn-more">
                {{ __('messages.home.more_event') }} <i class="bx bx-chevron-right align-icon"></i>
              </a>
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>


  {{-- Latest Workshop Section --}}
  <section class="section bg-white" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h4 class="text-primary py-2"><i class='bx bx-building me-2'></i>{{ __('messages.home.latest_workshop') }}</h4>
          @if ($bengkels->isEmpty())
            <div class="d-flex justify-content-center pb-5">
              <div class="text-center">
                <img src="{{ asset('assets/images/components/empty.png') }}" height="200" width="200"
                  alt="No workshops">
                <p>{{ __('messages.home.no_data_workshop') }}.</p>
              </div>
            </div>
          @else
            <div class="row">
              @foreach ($bengkels as $bengkel)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                  <a href="{{ route('workshop.detail', $bengkel->id_bengkel) }}" class="card-product p-3">
                    <img
                      src="{{ isset($bengkel) && $bengkel->foto_bengkel ? url($bengkel->foto_bengkel) : asset('assets/images/components/image.png') }}"
                      class="card-img-top" alt="Workshop Image">
                    <div class="card-body text-start">
                      <div class="d-flex align-items-center location-map">
                        <i class='bx bx-map-pin'></i>
                        <p class="location ms-2 py-2">
                          {{ \Illuminate\Support\Str::limit($bengkel->alamat_bengkel, 22) }}
                        </p>
                      </div>
                      <h5 class="card-title">
                        {{ \Illuminate\Support\Str::limit($bengkel->nama_bengkel, 20) }}</h5>
                      <div class="mt-3">
                        <div class="tagline d-flex justify-content-start">
                          <span
                            class="tagline">{{ \Illuminate\Support\Str::limit($bengkel->tagline_bengkel, 20) }}</span>
                        </div>
                      </div>
                    </div>
                  </a>
                </div>
              @endforeach
            </div>
          @endif

          @if (!$bengkels->isEmpty())
            <!-- Only show the "More Workshop" button if there are workshops -->
            <div class="text-center mt-4">
              <a href="{{ route('workshop.show') }}" class="btn btn-more">
                {{ __('messages.home.more_workshop') }} <i class="bx bx-chevron-right align-icon"></i>
              </a>
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>


  {{-- New Product Section --}}
  <section class="section bg-white" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h4 class="text-primary py-2"><i class='bx bxl-dropbox me-2'></i>{{ __('messages.home.new_product') }}</h4>
          @if ($products->isEmpty())
            <div class="d-flex justify-content-center pb-5">
              <div class="text-center">
                <img src="{{ asset('assets/images/components/empty.png') }}" height="200" width="200"
                  alt="No product">
                <p>{{ __('messages.home.no_data_product') }}.</p>
              </div>
            </div>
          @else
            <div class="row">
              @foreach ($products as $item)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                  <a href="{{ route('Detail-ProductSparePart', ['type' => 'product', 'id' => $item->id_produk]) }}"
                    class="card-product p-3">
                    <img
                      src="{{ isset($item) && $item->foto_produk ? url($item->foto_produk) : asset('assets/images/components/image.png') }}"
                      class="card-img-top" alt="Workshop Image">
                    <div class="card-body text-start">
                      <p class="workshop-name">{{ $item->bengkel->nama_bengkel }}</p>
                      <h5 class="card-title">
                        {{ \Illuminate\Support\Str::limit($item->nama_produk, 20) }}</h5>
                      <div class="footer-card">
                        <div class="price d-flex justify-content-start">
                          <span class="price">Rp.
                            {{ number_format($item->harga_produk, 0, ',', '.') }}</span>
                        </div>
                      </div>
                    </div>
                  </a>
                </div>
              @endforeach
            </div>
            <div class="text-center mt-4">
              <a href="{{ route('ProductSparePart') }}" class="btn btn-more">
                {{ __('messages.home.more_product') }} <i class="bx bx-chevron-right align-icon"></i>
              </a>
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>

  {{-- Spare Parts Section --}}
  <section class="section bg-white" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h4 class="text-primary py-2"><i class='bx bxs-cog me-2'></i>{{ __('messages.home.spare_parts') }}</h4>
          @if ($products->isEmpty())
            <div class="d-flex justify-content-center pb-5">
              <div class="text-center">
                <img src="{{ asset('assets/images/components/empty.png') }}" height="200" width="200"
                  alt="No product">
                <p>{{ __('messages.home.no_data_spare_part') }}.</p>
              </div>
            </div>
          @else
            <div class="row">
              @foreach ($sparepart as $item)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                  <a href="{{ route('Detail-ProductSparePart', ['type' => 'sparepart', 'id' => $item->id_spare_part]) }}"
                    class="card-product p-3">
                    <img
                      src="{{ isset($item) && $item->foto_spare_part ? url($item->foto_spare_part) : asset('assets/images/components/image.png') }}"
                      class="card-img-top" alt="Workshop Image">
                    <div class="card-body text-start">
                      <p class="workshop-name">{{ $item->bengkel->nama_bengkel }}</p>
                      <h5 class="card-title">
                        {{ \Illuminate\Support\Str::limit($item->nama_spare_part, 20) }}
                      </h5>
                      <div class="footer-card">
                        <div class="price d-flex justify-content-start">
                          <span class="price">Rp.
                            {{ number_format($item->harga_spare_part, 0, ',', '.') }}</span>
                        </div>
                      </div>
                    </div>
                  </a>
                </div>
              @endforeach
            </div>
            <div class="text-center mt-4">
              <a href="{{ route('ProductSparePart') }}" class="btn btn-more">
                {{ __('messages.home.more_spare_part') }} <i class="bx bx-chevron-right align-icon"></i>
              </a>
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>

  {{-- used car --}}
  <section class="featured-cars section bg-white">
    <div class="container">
      <h4 class="text-primary py-2"><i class='bx bx-car me-2'></i>{{ __('messages.home.usedcar') }}</h4>
      @if ($mobilList->isEmpty())
        <div class="d-flex justify-content-center pb-5">
          <div class="text-center">
            <img src="{{ asset('assets/images/components/empty.png') }}" height="200" width="200"
              alt="No UsedCar">
            <p>{{ __('messages.home.no_data_usedcar') }}.</p>
          </div>
        </div>
      @else
        <div class="horizontal">
          <div id="carousel-custom">
            @foreach ($mobilList as $car)
              <div class="carousel-content">
                <div class="card h-100 border-0 shadow">
                  @if ($car->fotos && $car->fotos->file_foto_mobil_1)
                    <img src="{{ url($car->fotos->file_foto_mobil_1) }}" alt="Car Image" class="car-img">
                  @else
                    <img src="{{ asset('assets/images/components/image.png') }}" alt="Car Image" class="car-img">
                  @endif
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <h3 class="h5 mb-0">
                        {{ \Illuminate\Support\Str::limit($car->nama_mobil, 15) }}</h3>
                      <span class="badge">{{ $car->tahun_mobil }}</span>
                    </div>

                    <div class="row g-3 mb-3 mt-2">
                      <div class="col-6">
                        <div class="d-flex align-items-center text-muted">
                          <i class="fas fa-tag specs-icon me-2"></i>
                          <div class="nama">{{ $car->merkMobil->nama_merk }}</div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="d-flex align-items-center text-muted">
                          <i class="fas fa-gauge specs-icon me-2"></i>
                          <div class="nama">{{ $car->km_mobil }} KM</div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="d-flex align-items-center text-muted">
                          <i class="fas fa-gas-pump specs-icon me-2"></i>
                          <div class="nama">{{ $car->bahan_bakar_mobil }}</div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="d-flex align-items-center text-muted">
                          <i class="fas fa-sitemap specs-icon me-2"></i>
                          <div class="nama">{{ $car->jenis_transmisi_mobil }}</div>
                        </div>
                      </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <span class="h5 mb-0">Rp
                          {{ number_format($car->harga_mobil, 0, ',', '.') }}</span>
                      </div>
                      <div class="d-flex gap-2">
                        <button class="btn btn-primary px-4">
                          Detail <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
        <div class="text-center mt-5">
          <a href="{{ route('used-car') }}" class="btn btn-more">
            {{ __('more.usedcar') }} <i class="bx bx-chevron-right align-icon"></i>
          </a>
        </div>
      @endif
    </div>
  </section>

  {{-- Blog --}}
  <section class="featured-blogs section bg-white py-5">
    <div class="container">
      <div class=" d-flex justify-content-between align-items-center">
        <h4 class="text-primary py-2"><i class='bx bx-news me-2'></i>{{ __('messages.home.latest_blog') }}</h4>
        <a href="{{ route('blog') }}" class="btn btn-custom mb-2">{{ __('messages.home.more_product') }}</a>
      </div>

      @if ($latestBlogs->isEmpty())
        <div class="d-flex justify-content-center pb-5">
          <div class="text-center">
            <img src="{{ asset('assets/images/components/empty.png') }}" height="200" width="200"
              alt="No Blog Available">
            <p>{{ __('messages.home.no_data_blog') }}.</p>
          </div>
        </div>
      @else
        <div class="horizontal">
          <div id="carousel-custom">
            @foreach ($latestBlogs as $blog)
              <div class="carousel-content">
                <div class="card-blog h-100 border-0 shadow">
                  <a href="{{ route('blog.show', $blog->slug) }}" class="text-decoration-none">
                    <figure class="m-0">
                      <img
                        src="{{ $blog->foto_cover ? asset($blog->foto_cover) : asset('assets/images/components/image.png') }}"
                        alt="Blog Image" class="articles-img">
                    </figure>
                    <div class="card-blog-body">
                      <span class="category-blog">{{ $blog->kategori->nama_kategori }}</span>
                      <h5 class="article-title py-2">{{ $blog->judul }}</h5>
                      <div class="meta">
                        <span>{{ $blog->penulis ?: 'Anonymous' }}</span>
                        <span>{{ \Carbon\Carbon::parse($blog->tanggal_post)->format('M d, Y') }}</span>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    </div>
  </section>


  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const carCarousel = document.querySelector('.featured-cars .horizontal');
      const carScrollDistance = 250;
      let carScrollInterval;

      function startCarAutoScroll() {
        carScrollInterval = setInterval(function() {
          if (carCarousel.scrollLeft + carCarousel.clientWidth >= carCarousel.scrollWidth) {
            carCarousel.scrollLeft = 0;
          } else {
            carCarousel.scrollLeft += carScrollDistance;
          }
        }, 3000);
      }

      startCarAutoScroll();

      carCarousel.addEventListener('mouseenter', function() {
        clearInterval(carScrollInterval);
      });

      carCarousel.addEventListener('mouseleave', function() {
        startCarAutoScroll();
      });

      const blogCarousel = document.querySelector('.featured-blogs .horizontal');
      const blogScrollDistance = 250;
      let blogScrollInterval;

      function startBlogAutoScroll() {
        blogScrollInterval = setInterval(function() {
          if (blogCarousel.scrollLeft + blogCarousel.clientWidth >= blogCarousel.scrollWidth) {
            blogCarousel.scrollLeft = 0;
          } else {
            blogCarousel.scrollLeft += blogScrollDistance;
          }
        }, 3000);
      }

      startBlogAutoScroll();

      blogCarousel.addEventListener('mouseenter', function() {
        clearInterval(blogScrollInterval);
      });

      blogCarousel.addEventListener('mouseleave', function() {
        startBlogAutoScroll();
      });
    });
  </script>


@endsection
