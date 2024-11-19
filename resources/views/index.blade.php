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
                                <b style="color: #3a6fb0;">Saling Support</b>
                            </h4>
                        </center>
                        <ul class="header-btn">
                            @if (Session::has('id_pelanggan'))
                                <li>
                                    <a class="main-btn btn-one" href="{{ route('profile') }}">
                                        <i class='bx bx-user'></i> PROFILE
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a class="main-btn btn-one" href="{{ route('register') }}">
                                        REGISTER NOW
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a class="main-btn btn-two video-popup" href="https://www.youtube.com/watch?v=r44RKWyfcFw">
                                    OUR VIDEO <i class='bx bx-play-circle bx-sm align-icon'></i>
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
    {{-- Latest Event Section --}}
    <section class="section bg-white" style="padding-top: 50px; padding-bottom: 50px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="text-primary py-2"><i class='bx bx-calendar'></i> Latest Event</h4>
                    <div class="row">
                        {{-- Check if there are events --}}
                        @if ($events->isNotEmpty())
                            @foreach ($events as $event)
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <a href="{{ route('event.detail', $event->id_event) }}" class="card-event p-3">
                                        <img src="{{ asset($event->image_cover) }}" class="card-img-top"
                                            alt="{{ $event->nama_event }}" class="card-img-top"
                                            alt="{{ $event->nama_event }}">
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
                                    <img src="{{ asset('assets/images/components/empty.png') }}" height="200"
                                        width="200" alt="Empty">
                                    <p>No data available for Events.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ route('event.show') }}" class="btn btn-more">
                            More Event <i class="bx bx-chevron-right align-icon"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- Latest Workshop Section --}}
    <section class="section bg-white" style="padding-top: 50px; padding-bottom: 50px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="text-primary py-2"><i class='bx bx-building'></i> Latest Workshop</h4>
                    @if ($bengkels->isEmpty())
                        <div class="d-flex justify-content-center pb-5">
                            <div class="text-center">
                                <img src="{{ asset('assets/images/components/empty.png') }}" height="200" width="200"
                                    alt="No workshops">
                                <p>No data available for workshops.</p>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            @foreach ($bengkels as $bengkel)
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <a href="{{ route('workshop.detail', $bengkel->id_bengkel) }}"
                                        class="card-product p-3">
                                        <img src="{{ isset($bengkel) && $bengkel->foto_bengkel ? url($bengkel->foto_bengkel) : asset('assets/images/components/image.png') }}"
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
                    <div class="text-center mt-4">
                        <a href="{{ route('workshop.show') }}" class="btn btn-more">
                            More Workshop <i class="bx bx-chevron-right align-icon"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- New Product Section --}}
    <section class="section bg-white" style="padding-top: 50px; padding-bottom: 50px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="text-primary py-2"><i class='bx bxl-dropbox'></i> New Product</h4>
                    @if ($products->isEmpty())
                        <div class="d-flex justify-content-center pb-5">
                            <div class="text-center">
                                <img src="{{ asset('assets/images/components/empty.png') }}" height="200"
                                    width="200" alt="No product">
                                <p>No data available for Product.</p>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            @foreach ($products as $item)
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <a href="{{ route('Detail-ProductSparePart', ['type' => 'product', 'id' => $item->id_produk]) }}"
                                        class="card-product p-3">
                                        <img src="{{ isset($item) && $item->foto_produk ? url($item->foto_produk) : asset('assets/images/components/image.png') }}"
                                            class="card-img-top" alt="Workshop Image">
                                        <div class="card-body text-start">
                                            <p class="workshop-name">{{ $item->bengkel->nama_bengkel }}</p>
                                            <h5 class="card-title">
                                                {{ \Illuminate\Support\Str::limit($item->nama_produk, 20) }}</h5>
                                            <div class="footer-card">
                                                <div class="price d-flex justify-content-start">
                                                    <span class="price">
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
                                More Product <i class="bx bx-chevron-right align-icon"></i>
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
                    <h4 class="text-primary py-2"><i class='bx bx-box'></i> Spare Parts</h4>
                    @if ($products->isEmpty())
                        <div class="d-flex justify-content-center pb-5">
                            <div class="text-center">
                                <img src="{{ asset('assets/images/components/empty.png') }}" height="200"
                                    width="200" alt="No product">
                                <p>No data available for Product.</p>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            @foreach ($sparepart as $item)
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <a href="{{ route('Detail-ProductSparePart', ['type' => 'sparepart', 'id' => $item->id_spare_part]) }}"
                                        class="card-product p-3">
                                        <img src="{{ isset($item) && $item->foto_spare_part ? url($item->foto_spare_part) : asset('assets/images/components/image.png') }}"
                                            class="card-img-top" alt="Workshop Image">
                                        <div class="card-body text-start">
                                            <p class="workshop-name">{{ $item->bengkel->nama_bengkel }}</p>
                                            <h5 class="card-title">
                                                {{ \Illuminate\Support\Str::limit($item->nama_spare_part, 20) }}
                                            </h5>
                                            <div class="footer-card">
                                                <div class="price d-flex justify-content-start">
                                                    <span class="price">
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
                                More Spare Part <i class="bx bx-chevron-right align-icon"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- used car --}}
    <!-- Featured Cars Section -->
    <section class="featured-cars">
        <div class="container">
            <!-- Section Header -->
            <div class="section-title text-start">
                <h4 class="text-primary py-2"><i class='bx bx-box'></i> Used Car</h4>
            </div>

            @if ($mobilList->isEmpty())
                <div class="d-flex justify-content-center pb-5">
                    <div class="text-center">
                        <img src="{{ asset('assets/images/components/empty.png') }}" height="200" width="200"
                            alt="No UsedCar">
                        <p>No data available for UsedCar.</p>
                    </div>
                </div>
            @else
                <div id="carCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                    <!-- Carousel Inner -->
                    <div class="carousel-inner">
                        @foreach ($mobilList->chunk(3) as $index => $chunk)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <div class="row justify-content-center">
                                    @foreach ($chunk as $car)
                                        <div class="col-12 col-md-4">
                                            <article class="card h-100 border-0 shadow">
                                                @if ($car->fotos && $car->fotos->file_foto_mobil_1)
                                                    <img src="{{ url($car->fotos->file_foto_mobil_1) }}" alt="Car Image"
                                                        class="car-img">
                                                @else
                                                    <img src="{{ asset('assets/images/components/image.png') }}"
                                                        alt="Car Image" class="car-img">
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
                                                                <div class="nama">{{ $car->jenis_transmisi_mobil }}
                                                                </div>
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
                                                            <button class="btn btn-primary px-4">Detail Car</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Kontrol Carousel -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#carCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Sebelumnya</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Selanjutnya</span>
                    </button>
                </div>
            @endif
        </div>


        <!-- View More Link -->
        <div class="text-center mt-5">
            <a href=" {{ route('used-car') }}" class="btn btn-more">
                More Used Car <i class="bx bx-chevron-right align-icon"></i>
            </a>
        </div>
        </div>
    </section>

@endsection
