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
    <div id="carImageCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <!-- Main Image Carousel Item -->
            <div class="carousel-item active">
                <a class="img-car trigger-modal" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#carImageModal"
                   data-bs-img="{{ $mobilList->fotos->file_foto_mobil_1 ?? 'assets/images/components/image.png' }}">
                    <img src="{{ url($mobilList->fotos->file_foto_mobil_1 ?? 'assets/images/components/image.png') }}"
                         alt="Car Image" class="d-block w-100 main-image object-fit-cover">
                </a>
            </div>
            <!-- Additional Image Carousel Items -->
            <div class="carousel-item">
                <a class="img-car trigger-modal" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#carImageModal"
                   data-bs-img="{{ $mobilList->fotos->file_foto_mobil_2 ?? 'assets/images/components/image.png' }}">
                    <img src="{{ url($mobilList->fotos->file_foto_mobil_2 ?? 'assets/images/components/image.png') }}"
                         alt="Car Image" class="d-block w-100 main-image object-fit-cover">
                </a>
            </div>
            <div class="carousel-item">
                <a class="img-car trigger-modal" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#carImageModal"
                   data-bs-img="{{ $mobilList->fotos->file_foto_mobil_3 ?? 'assets/images/components/image.png' }}">
                    <img src="{{ url($mobilList->fotos->file_foto_mobil_3 ?? 'assets/images/components/image.png') }}"
                         alt="Car Image" class="d-block w-100 main-image object-fit-cover">
                </a>
            </div>
            <div class="carousel-item">
                <a class="img-car trigger-modal" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#carImageModal"
                   data-bs-img="{{ $mobilList->fotos->file_foto_mobil_4 ?? 'assets/images/components/image.png' }}">
                    <img src="{{ url($mobilList->fotos->file_foto_mobil_4 ?? 'assets/images/components/image.png') }}"
                         alt="Car Image" class="d-block w-100 main-image object-fit-cover">
                </a>
            </div>
            <div class="carousel-item">
                <a class="img-car trigger-modal" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#carImageModal"
                   data-bs-img="{{ $mobilList->fotos->file_foto_mobil_5 ?? 'assets/images/components/image.png' }}">
                    <img src="{{ url($mobilList->fotos->file_foto_mobil_5 ?? 'assets/images/components/image.png') }}"
                         alt="Car Image" class="d-block w-100 main-image object-fit-cover">
                </a>
            </div>
        </div>
        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carImageCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carImageCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>



        <div class="modal fade" id="carImageModal" tabindex="-1" aria-labelledby="carImageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="carImageModalLabel">Car Image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <!-- Carousel Start -->
                        <div id="carImageModalCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner" id="carouselImages">
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carImageModalCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carImageModalCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        <!-- Carousel End -->
                    </div>
                </div>
            </div>
        </div>

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
                            <span class="title-desc me-2">{{ $mobilList->km_mobil }} Km | </span>
                            <i class='bx bx-sitemap me-2'></i>
                            <span class="title-desc">{{ $mobilList->jenis_transmisi_mobil }}</span>
                        </div>

                        <!-- Location -->
                        <div class="d-flex align-items-center mb-3">
                            <i class='bx bx-map'></i>
                            <span>
                                <span class="title-desc">
                                    {{ $mobilList->lokasi_mobil }}
                                </span>
                            </span>
                        </div>
                        <hr>
                        <div class="container">
                            <!-- Agenda -->
                            <h5 class="title-desc">Spesifikasi dari Mobil {{ $mobilList->nama_mobil }}</h5>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="text-muted small">Tahun Mobil</div>
                                        <div>{{ $mobilList->tahun_mobil }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="text-muted small">Km Mobil </div>
                                        <div>{{ $mobilList->km_mobil }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="text-muted small">Kapasitas Mesin Mobil </div>
                                        <div>{{ $mobilList->kapasitas_mesin_mobil }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="text-muted small">Bulan Pajak Mobil</div>
                                        <div>{{ $mobilList->bulan_pajak_mobil }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="text-muted small">Tahun Pajak Mobil</div>
                                        <div>{{ $mobilList->tahun_pajak_mobil }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="text-muted small">Terakhir Pajak Mobil</div>
                                        <div>{{ $mobilList->terakhir_pajak_mobil }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="text-muted small">Tahun Pemakain</div>
                                        <div>{{ $mobilList->pemakaian }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- Description -->
                        <p class="mb-4">
                            <span class="title-desc my-2">Deskripsi Mobil</span> <br>
                            {{ $mobilList->keterangan_mobil }}
                        </p>
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
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ticket Section -->
                <div class="card mb-4">
                    <div class="card-header title-desc">
                        Harga Mobil
                    </div>
                    <div class="card-body text-center">
                        <h5 class="fw-bold">
                            {{ 'Rp ' . number_format($mobilList->harga_mobil, 0, ',', '.') }}
                        </h5>
                        <a href="https://wa.me/{{ $mobilList->pelanggan->telp_pelanggan }}"
                            class="btn btn-daftar w-100 mt-2">
                            <i class='bx bxl-whatsapp align-icon'></i> Hubungi Penjual
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Share -->
        <div class="row py-5">
            <div class="col-md-12 text-center">
                <h5 class="fw-bold py-3">Bagikan</h5>

                <!-- Facebook Share Button -->
                <a href="javascript:void(0);" onclick="shareOnFacebook('{{ url()->current() }}')" class="btn btn-outline-primary my-3">
                    <i class='bx bxl-facebook-circle'></i> Facebook
                </a>

                <!-- Instagram Share Button -->
                <a href="https://www.instagram.com" target="_blank" class="btn btn-outline-danger my-3">
                    <i class='bx bxl-instagram'></i> Instagram
                </a>

                <!-- WhatsApp Share Button -->
                <a href="javascript:void(0);" onclick="shareOnWhatsApp('{{ url()->current() }}')" class="btn btn-outline-success my-3">
                    <i class='bx bxl-whatsapp'></i> WhatsApp
                </a>
            </div>
        </div>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var carImageLinks = document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#carImageModal"]');
            if (carImageLinks.length > 0) {
                carImageLinks.forEach(function(link) {
                    link.addEventListener('click', function() {
                        var imageUrl = link.getAttribute('data-bs-img');
                        var images = [
                            "{{ url($mobilList->fotos->file_foto_mobil_1 ?? 'assets/images/components/image.png') }}",
                            "{{ url($mobilList->fotos->file_foto_mobil_2 ?? 'assets/images/components/image.png') }}",
                            "{{ url($mobilList->fotos->file_foto_mobil_3 ?? 'assets/images/components/image.png') }}",
                            "{{ url($mobilList->fotos->file_foto_mobil_4 ?? 'assets/images/components/image.png') }}",
                            "{{ url($mobilList->fotos->file_foto_mobil_5 ?? 'assets/images/components/image.png') }}"
                        ];

                        var carouselInner = document.getElementById('carouselImages');
                        carouselInner.innerHTML = '';

                        images.forEach(function(imageUrl, index) {
                            var activeClass = (index === 0) ? 'active' : '';
                            var carouselItem = `
                                <div class="carousel-item ${activeClass}">
                                    <img src="${imageUrl}" class="d-block w-100" alt="Car Image">
                                </div>
                            `;
                            carouselInner.innerHTML += carouselItem;
                        });

                        var modal = new bootstrap.Modal(document.getElementById('carImageModal'));
                        modal.show();
                    });
                });
            }
        });

        document.addEventListener('hidden.bs.modal', function (event) {
            document.body.classList.remove('modal-open');
            document.body.style.paddingRight = '';
            document.body.style.overflow = '';

            const modalBackdrop = document.querySelector('.modal-backdrop');
            if (modalBackdrop) {
                modalBackdrop.remove();
            }
        });


        function shareOnFacebook(url) {
            const fbUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
            window.open(fbUrl, '_blank', 'width=600,height=400');
        }

        function shareOnWhatsApp(url) {
            const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(url)}`;
            window.open(whatsappUrl, '_blank', 'width=600,height=400');
        }

    </script>
@endsection
