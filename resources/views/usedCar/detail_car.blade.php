@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/car_detail.css') }}">
@endpush

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
                    <h4 class="title-header">Car Detail</h4>
                </div>
            </div>
        </div>
    </section>
    <div class="container gallery">
        <section class="pt-5 image">
            <div class="row">
                <div class="col-md-6 gallery-item">
                    @if ($mobilList->fotos && $mobilList->fotos->file_foto_mobil_1)
                        <img src="{{ url($mobilList->fotos->file_foto_mobil_1) }}" alt="Car Image"
                            class="img-fluid main-image object-fit-cover">
                    @else
                        <img src="{{ asset('assets/images/components/image.png') }}"
                            alt="Car Image"class="img-fluid main-image object-fit-cover">
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6 col-6 picture">
                            @if ($mobilList->fotos && $mobilList->fotos->file_foto_mobil_2)
                                <img src="{{ url($mobilList->fotos->file_foto_mobil_2) }}" alt="Car Image"
                                    class="img-fluid small-image-1 object-fit-cover">
                            @else
                                <img src="{{ asset('assets/images/components/image.png') }}"
                                    alt="Car Image"class="img-fluid small-image-1 object-fit-cover">
                            @endif
                        </div>
                        <div class="col-md-6 col-6 picture">
                            @if ($mobilList->fotos && $mobilList->fotos->file_foto_mobil_3)
                                <img src="{{ url($mobilList->fotos->file_foto_mobil_3) }}" alt="Car Image"
                                    class="img-fluid img-fluid small-image-2 object-fit-cover">
                            @else
                                <img src="{{ asset('assets/images/components/image.png') }}"
                                    alt="Car Image"class="img-fluid img-fluid small-image-2 object-fit-cover">
                            @endif
                        </div>
                        <div class="col-md-6 col-6 picture">
                            @if ($mobilList->fotos && $mobilList->fotos->file_foto_mobil_4)
                                <img src="{{ url($mobilList->fotos->file_foto_mobil_4) }}" alt="Car Image"
                                    class="img-fluid img-fluid small-image-3 object-fit-cover">
                            @else
                                <img src="{{ asset('assets/images/components/image.png') }}"
                                    alt="Car Image"class="img-fluid img-fluid small-image-3 object-fit-cover">
                            @endif
                        </div>
                        <div class="col-md-6 col-6 picture position-relative">
                            @if ($mobilList->fotos && $mobilList->fotos->file_foto_mobil_5)
                                <img src="{{ url($mobilList->fotos->file_foto_mobil_5) }}" alt="Car Image"
                                    class="img-fluid img-fluid small-image-4 object-fit-cover">
                            @else
                                <img src="{{ asset('assets/images/components/image.png') }}"
                                    alt="Car Image"class="img-fluid img-fluid small-image-4 object-fit-cover">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Event Title and Image -->
        <div class="row py-5">
            <div class="col-md-12 text-center">
                <h2 class="title-event"> {{ $mobilList->merkMobil->nama_merk }}
                </h2>
            </div>
        </div>

        <!-- Event Details -->
        <div class="row">
            <!-- Left Column - Main Details -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Date and Time -->
                        <div class="d-flex align-items-center mb-3">
                            <div>
                                <h3 class="title-car">{{ $mobilList->nama_mobil }}</h3>

                            </div>
                            {{-- <i class='bx bx-calendar text-primary me-2'></i>
                            <span><span class="title-desc">Tanggal:</span> 1 November 2024</span> --}}
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class='bx bx-gas-pump me-2'></i>
                            <span class="title-desc me-2">{{ $mobilList->bahan_bakar_mobil }} | </span>
                            <i class='bx bx-tachometer me-2'></i>
                            <span class="title-desc me-2">{{ $mobilList->km_mobil }} Km| </span>
                            <i class='bx bx-sitemap me-2'></i>
                            <span class="title-desc">Authomatic </span>
                        </div>

                        <!-- Location -->
                        <div class="d-flex align-items-center mb-3">
                            <i class='bx bx-map'></i>
                            <span><span class="title-desc"></span> CNPLUS Computer Center, BSD City, South Tangerang
                                City, Banten, Indonesia</span>
                        </div>
                        <hr>
                        <!-- Description -->
                        <p class="mb-4">
                            <span class="title-desc my-2">Deskripsi Mobil:</span> <br>
                            {{ $mobilList->keterangan_mobil }}
                        </p>
                        <hr>
                        {{-- <!-- Agenda -->
                        <h5 class="title-desc">Agenda Acara</h5>
                        <ul class="agenda-event">
                            <li class="list-text my-2">
                                <i class='bx bx-check-circle text-success align-icon me-2'></i>
                                Sesi Pembukaan - 10:00
                            </li>
                            <li class="list-text my-2">
                                <i class='bx bx-check-circle text-success align-icon me-2'></i>
                                Workshop Teknologi - 12:00
                            </li>
                            <li class="list-text my-2">
                                <i class='bx bx-check-circle text-success align-icon me-2'></i>
                                Penutupan - 17:00
                            </li>
                        </ul> --}}
                    </div>
                </div>
            </div>

            <!-- Right Column - Additional Info -->
            <div class="col-md-4">
                <!-- Speakers Section -->
                <div class="card mb-4">
                    <div class="card-header title-desc">
                        Penjual
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('assets/images/components/avatar.png') }}" class="rounded-circle me-3"
                                alt="Speaker" width="50">
                            <div>
                                <span class="title-desc">{{ $mobilList->pelanggan->nama_pelanggan }}</span><br>
                                {{-- Ahli Teknologi --}}
                            </div>
                        </div>
                        {{-- <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/images/components/avatar.png') }}" class="rounded-circle me-3"
                                alt="Speaker" width="50">
                            <div>
                                <span class="title-desc">Revan Smith</span><br>
                                Pengembang Perangkat Agak Lunak
                            </div>
                        </div> --}}
                    </div>
                </div>

                <!-- Ticket Section -->
                <div class="card mb-4">
                    <div class="card-header title-desc">
                        Harga Mobil
                    </div>
                    <div class="card-body text-center">
                        <h5 class="fw-bold">Rp 160,000,000</h5>
                        <a href="https://wa.me/{{ $mobilList->pelanggan->telp_pelanggan }}"
                            class="btn btn-daftar w-100 mt-2">
                            <i class='bx bxl-whatsapp align-icon'></i> Hubungi Penjual
                        </a>
                    </div>
                </div>

                {{-- <!-- Contact Info -->
                <div class="card">
                    <div class="card-header title-desc">
                        Hubungi Penjual
                    </div>
                    <div class="card-body">
                        <p><i class='bx bx-phone align-icon me-2'></i>+62 878-6697-4026</p>
                        <p><i class='bx bxl-whatsapp align-icon me-2'></i>+62 878-6697-4026</p>
                        <p><i class='bx bx-envelope align-icon me-2'></i>fathanrevandhikasuherman.com</p>
                    </div>
                </div> --}}
            </div>
        </div>

        <!-- Social Share -->
        <div class="row py-5">
            <div class="col-md-12 text-center">
                <h5 class="fw-bold py-3">Bagikan</h5>
                <a href="#" class="btn btn-outline-primary my-3">
                    <i class='bx bxl-facebook-circle'></i> Facebook
                </a>
                <a href="#" class="btn btn-outline-info my-3">
                    <i class='bx bxl-twitter'></i> Twitter
                </a>
                <a href="#" class="btn btn-outline-danger my-3">
                    <i class='bx bxl-instagram'></i> Instagram
                </a>
            </div>
        </div>
    </div>
@endsection
