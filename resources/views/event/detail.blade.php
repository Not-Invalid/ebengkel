@extends('layouts.app')
@push('css')
  <link rel="stylesheet" href="{{ asset('assets/css/event.css') }}">
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
          <h4 class="title-header">Event Detail</h4>
        </div>
      </div>
    </div>
  </section>
  <div class="container gallery">
    <section class="pt-5 image">
      <div class="row">
        <div class="col-md-6 gallery-item">
          <img src="https://ebengkelku.com/dashboard/images/event/foto_cover_event_20231107_135644.jpg" alt="main image"
            class="img-fluid main-image object-fit-cover" />
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-6 col-6 picture">
              <img src="https://ebengkelku.com/dashboard/images/event/foto_cover_event_20231107_135644.jpg" alt="small 1"
                class="img-fluid small-image-1 object-fit-cover" />
            </div>
            <div class="col-md-6 col-6 picture">
              <img src="https://ebengkelku.com/dashboard/images/event/foto_cover_event_20231107_135644.jpg" alt="small 2"
                class="img-fluid small-image-2 object-fit-cover" />
            </div>
            <div class="col-md-6 col-6 picture">
              <img src="https://ebengkelku.com/dashboard/images/event/foto_cover_event_20231107_135644.jpg" alt="small 3"
                class="img-fluid small-image-3 object-fit-cover" />
            </div>
            <div class="col-md-6 col-6 picture position-relative">
              <img src="https://ebengkelku.com/dashboard/images/event/foto_cover_event_20231107_135644.jpg" alt="small 4"
                class="img-fluid small-image-4 object-fit-cover" />
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Event Title and Image -->
    <div class="row py-5">
      <div class="col-md-12 text-center">
        <h2 class="title-event">Mercy Fest 2024</h2>
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
              <i class='bx bx-calendar text-primary me-2'></i>
              <span><span class="title-desc">Tanggal:</span> 1 November 2024</span>
            </div>
            <div class="d-flex align-items-center mb-3">
              <i class='bx bx-time text-primary me-2'></i>
              <span><span class="title-desc">Waktu:</span> 10:00 - 17:00</span>
            </div>

            <!-- Location -->
            <div class="d-flex align-items-center mb-3">
              <i class='bx bx-map text-primary me-2'></i>
              <span><span class="title-desc">Lokasi:</span> Jalanin Aja Dulu No.1, Kab. Tangerang</span>
            </div>
            <hr>
            <!-- Description -->
            <p class="mb-4">
              <span class="title-desc my-2">Deskripsi Acara:</span> <br>
              Mercy Fest 2024 adalah acara tahunan yang menyatukan
              para pecinta otomotif dari seluruh negeri. Acara ini akan menampilkan produk-produk terbaru, layanan bengkel
              modern, serta kesempatan untuk belajar dari para ahli di bidang otomotif. Jangan lewatkan kesempatan untuk
              melihat berbagai kendaraan dan teknologi terkini, serta berinteraksi dengan para profesional industri.
            </p>
            <hr>
            <!-- Agenda -->
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
            </ul>
          </div>
        </div>
      </div>

      <!-- Right Column - Additional Info -->
      <div class="col-md-4">
        <!-- Speakers Section -->
        <div class="card mb-4">
          <div class="card-header title-desc">
            Pembicara Acara
          </div>
          <div class="card-body">
            <div class="d-flex align-items-center mb-3">
              <img src="{{ asset('assets/images/components/avatar.png') }}" class="rounded-circle me-3" alt="Speaker"
                width="50">
              <div>
                <span class="title-desc">Fawas Alexandre Steven</span><br>
                Ahli Teknologi
              </div>
            </div>
            <div class="d-flex align-items-center">
              <img src="{{ asset('assets/images/components/avatar.png') }}" class="rounded-circle me-3" alt="Speaker"
                width="50">
              <div>
                <span class="title-desc">Revan Smith</span><br>
                Pengembang Perangkat Agak Lunak
              </div>
            </div>
          </div>
        </div>

        <!-- Ticket Section -->
        <div class="card mb-4">
          <div class="card-header title-desc">
            Tiket Acara
          </div>
          <div class="card-body text-center">
            <h5 class="fw-bold">Rp 100,000</h5>
            <a href="#" class="btn btn-daftar w-100 mt-2">
              <i class='bx bx-cart align-icon'></i> Daftar Sekarang
            </a>
          </div>
        </div>

        <!-- Contact Info -->
        <div class="card">
          <div class="card-header title-desc">
            Hubungi Kami
          </div>
          <div class="card-body">
            <p><i class='bx bx-phone align-icon me-2'></i>+62 812-9542-9920</p>
            <p><i class='bx bxl-whatsapp align-icon me-2'></i>+62 812-9542-9920</p>
            <p><i class='bx bx-envelope align-icon me-2'></i>fawasabid15.com</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Social Share -->
    <div class="row py-5">
      <div class="col-md-12 text-center">
        <h5 class="fw-bold py-3">Bagikan Acara</h5>
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
