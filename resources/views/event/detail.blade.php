@extends('layouts.app')

@push('css')
  <link rel="stylesheet" href="{{ asset('assets/css/event.css') }}">
@endpush

@section('title')
  eBengkelku | Event Detail
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
          <h4 class="title-header">Event Detail</h4>
        </div>
      </div>
    </div>
  </section>

  <!-- Event Gallery Section (only main image) -->
  <div class="container gallery">
    <section class="pt-5 image">
      <div class="row">
        <div class="col-md-12 gallery-item">
          <img src="{{ asset($event->image_cover) }}" alt="{{ $event->nama_event }}"
            class="img-fluid main-image object-fit-cover" />
        </div>
      </div>
    </section>

    <!-- Event Title and Image -->
    <div class="row py-4">
      <div class="col-md-12 text-center">
        <h2 class="title-event">{{ $event->nama_event }}</h2>
      </div>
    </div>

    <!-- Event Details -->
    <div class="row">
      <!-- Left Column - Main Details -->
      <div class="col-md-8">
        <div class="card info-event mb-4" style="border: 0;">
          <div class="card-body">
            <!-- Date and Time -->
            <div class="d-flex align-items-center mb-3">
              <i class='bx bx-calendar text-primary me-2'></i>
              <span><span class="title-desc">Tanggal:</span> {{ \Carbon\Carbon::parse($event->event_start_date)->format('d F Y') }}</span>
            </div>
            <div class="d-flex align-items-center mb-3">
              <i class='bx bx-time text-primary me-2'></i>
              <span><span class="title-desc">Waktu:</span> {{ \Carbon\Carbon::parse($event->event_start_date)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->event_end_date)->format('H:i') }}</span>
            </div>

            <!-- Location -->
            <div class="d-flex align-items-center mb-3">
              <i class='bx bx-map text-primary me-2'></i>
              <span><span class="title-desc">Lokasi:</span> {{ $event->alamat_event }}</span>
            </div>
            <hr>
            <!-- Description -->
            <p class="mb-4">
              <span class="title-desc my-2">Deskripsi Acara:</span> <br>
              {{ $event->deskripsi }}
            </p>
            <hr>
            <!-- Agenda -->
            <h5 class="title-desc">Agenda Acara</h5>
            <ul class="agenda-event">
                @foreach ($event->agenda_acara as $agenda)
                    <li class="list-text my-2">
                        <i class='bx bx-check-circle text-success align-icon me-2'></i>
                        <strong>{{ $agenda['judul'] }}</strong> - {{ $agenda['waktu'] }}
                    </li>
                @endforeach
            </ul>
          </div>
        </div>
      </div>

      <!-- Right Column - Additional Info -->
      <div class="col-md-4">
        <!-- Speakers Section -->
        <div class="card info-event mb-4" style="border: 0;">
          <div class="card-header title-desc"
            style="outline:none; border-start-end-radius: 10px; border-start-start-radius: 10px;">
            Pembicara Acara
          </div>
          <div class="card-body">
            @foreach ($event->bintang_tamu as $speaker)
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('assets/images/components/avatar.png') }}" class="rounded-circle me-3" alt="Speaker" width="50">
                    <div>
                        <span class="title-desc">{{ $speaker }}</span><br>
                    </div>
                </div>
            @endforeach
        </div>
        </div>

        <!-- Ticket Section -->
        <div class="card info-event mb-4" style="border: 0;">
          <div class="card-header title-desc"
            style="outline:none; border-start-end-radius: 10px; border-start-start-radius: 10px;">
            Tiket Acara
          </div>
          <div class="card-body text-center">
            <h5 class="fw-bold">Rp {{ number_format($event->harga, 0, ',', '.') }}</h5>
            <a href="{{ route('event.daftar', ['id_event' => $event->id_event]) }}" class="btn btn-daftar w-100 mt-2">
              <i class='bx bx-cart align-icon'></i> Daftar Sekarang
            </a>
          </div>
        </div>

        <!-- Contact Info -->
        <div class="card info-event mb-4" style="border: 0;">
          <div class="card-header title-desc"
            style="outline:none; border-start-end-radius: 10px; border-start-start-radius: 10px;">
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
          <i class='bx bxl-facebook-circle align-icon'></i> Facebook
        </a>
        <a href="#" class="btn btn-outline-info my-3">
          <i class='bx bxl-twitter align-icon'></i> Twitter
        </a>
        <a href="#" class="btn btn-outline-danger my-3">
          <i class='bx bxl-instagram align-icon'></i> Instagram
        </a>
      </div>
    </div>
  </div>
@endsection
