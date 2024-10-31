@extends('layouts.app')
@push('css')
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
@endpush

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
                  <a class="main-btn btn-one" href="home">
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
            {{-- Replace the condition below with your logic to check for actual events --}}
            {{-- @if (false) --}}
            <!-- Change this to your actual data check -->

            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
              <a href="#" class="card-event p-3">
                <img src="https://ebengkelku.com/dashboard/images/event/foto_cover_event_20231107_135644.jpg"
                  class="card-img-top" alt="Event Image">
                <div class="card-body text-start">
                  <p class="card-title mt-4">Mercy Fest 2024</p>
                  <div class="d-flex align-items-center event-date">
                    <i class='bx bx-calendar'></i>
                    <span class="date ms-2">Jan 10, 2024 - Jan 12, 2024</span>
                  </div>
                  <div class="footer-card">
                    <div class="price d-flex justify-content-start">
                      <span class="price">Rp50.000</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
              <a href="#" class="card-event p-3">
                <img src="https://ebengkelku.com/dashboard/images/event/foto_cover_event_20231107_135644.jpg"
                  class="card-img-top" alt="Event Image">
                <div class="card-body text-start">
                  <p class="card-title mt-4">Mercy Fest 2024</p>
                  <div class="d-flex align-items-center event-date">
                    <i class='bx bx-calendar'></i>
                    <span class="date ms-2">Jan 10, 2024 - Jan 12, 2024</span>
                  </div>
                  <div class="footer-card">
                    <div class="price d-flex justify-content-start">
                      <span class="price">Rp50.000</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
              <a href="#" class="card-event p-3">
                <img src="https://ebengkelku.com/dashboard/images/event/foto_cover_event_20231107_135644.jpg"
                  class="card-img-top" alt="Event Image">
                <div class="card-body text-start">
                  <p class="card-title mt-4">Mercy Fest 2024</p>
                  <div class="d-flex align-items-center event-date">
                    <i class='bx bx-calendar'></i>
                    <span class="date ms-2">Jan 10, 2024 - Jan 12, 2024</span>
                  </div>
                  <div class="footer-card">
                    <div class="price d-flex justify-content-start">
                      <span class="price">Rp50.000</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
              <a href="#" class="card-event p-3">
                <img src="https://ebengkelku.com/dashboard/images/event/foto_cover_event_20231107_135644.jpg"
                  class="card-img-top" alt="Event Image">
                <div class="card-body text-start">
                  <p class="card-title mt-4">Mercy Fest 2024</p>
                  <div class="d-flex align-items-center event-date">
                    <i class='bx bx-calendar'></i>
                    <span class="date ms-2">Jan 10, 2024 - Jan 12, 2024</span>
                  </div>
                  <div class="footer-card">
                    <div class="price d-flex justify-content-start">
                      <span class="price">Rp50.000</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <!-- Repeat cards as needed -->
            {{-- @else
              <div class="text-center">
                <img src="{{ asset('assets/images/components/empty.png') }}" width="150" alt="No Data">
                <p>Data saat ini tidak ditemukan.</p>
              </div>
            @endif --}}
          </div>
          <div class="text-center mt-4">
            <a href="#" class="btn btn-more">
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
          <div class="row">
            {{-- Replace the condition below with your logic to check for actual workshops --}}
            {{-- @if (false) --}}
            <!-- Change this to your actual data check -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
              <a href="#" class="card-product p-3">
                <img
                  src="data:image/png;base64,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"
                  class="card-img-top" alt="Workshop Image">
                <div class="card-body text-start">
                  <div class="d-flex align-items-center location-map">
                    <i class='bx bx-map-pin'></i>
                    <p class="location ms-2">Legok, Kab. Tangerang</p>
                  </div>
                  <h5 class="card-title">Akina Speed Star</h5>

                  <div class="mt-3">
                    <div class="tagline d-flex justify-content-start">
                      <span class="tagline">Mechanic Japan Tech</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
              <a href="#" class="card-product p-3">
                <img
                  src="data:image/png;base64,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"
                  class="card-img-top" alt="Workshop Image">
                <div class="card-body text-start">
                  <div class="d-flex align-items-center location-map">
                    <i class='bx bx-map-pin'></i>
                    <p class="location ms-2">Legok, Kab. Tangerang</p>
                  </div>
                  <h5 class="card-title">Akina Speed Star</h5>

                  <div class="mt-3">
                    <div class="tagline d-flex justify-content-start">
                      <span class="tagline">Mechanic Japan Tech</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
              <a href="#" class="card-product p-3">
                <img
                  src="data:image/png;base64,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"
                  class="card-img-top" alt="Workshop Image">
                <div class="card-body text-start">
                  <div class="d-flex align-items-center location-map">
                    <i class='bx bx-map-pin'></i>
                    <p class="location ms-2">Legok, Kab. Tangerang</p>
                  </div>
                  <h5 class="card-title">Akina Speed Star</h5>

                  <div class="mt-3">
                    <div class="tagline d-flex justify-content-start">
                      <span class="tagline">Mechanic Japan Tech</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
              <a href="#" class="card-product p-3">
                <img
                  src="data:image/png;base64,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"
                  class="card-img-top" alt="Workshop Image">
                <div class="card-body text-start">
                  <div class="d-flex align-items-center location-map">
                    <i class='bx bx-map-pin'></i>
                    <p class="location ms-2">Legok, Kab. Tangerang</p>
                  </div>
                  <h5 class="card-title">Akina Speed Star</h5>

                  <div class="mt-3">
                    <div class="tagline d-flex justify-content-start">
                      <span class="tagline">Mechanic Japan Tech</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <!-- Repeat cards as needed -->
            {{-- @else
              <div class="text-center">
                <img src="{{ asset('assets/images/components/empty.png') }}" width="150" alt="No Data">
                <p>Data saat ini tidak ditemukan.</p>
              </div>
            @endif --}}
          </div>
          <div class="text-center mt-4">
            <a href="#" class="btn btn-more">
              More Workshop <i class="bx bx-chevron-right align-icon"></i>
            </a>
          </div>
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
          <div class="row">
            {{-- Replace the condition below with your logic to check for actual spare parts --}}
            {{-- @if (false) --}}
            <!-- Change this to your actual data check -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
              <a href="#" class="card-product p-3">
                <img src="https://img.lazcdn.com/g/p/a5eb9ddcf6bc80ba1af124d92c02c5d2.png_720x720q80.png"
                  class="card-img-top" alt="Sparepart Image">
                <div class="card-body text-start">
                  <p class="workshop-name">Akina Speed Star</p>
                  <h5 class="card-title">Paking Knalpot Mio Smile 2011</h5>
                  <div class="footer-card">
                    <div class="price d-flex justify-content-start">
                      <span class="price">Rp25.550</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
              <a href="#" class="card-product p-3">
                <img src="https://img.lazcdn.com/g/p/a5eb9ddcf6bc80ba1af124d92c02c5d2.png_720x720q80.png"
                  class="card-img-top" alt="Sparepart Image">
                <div class="card-body text-start">
                  <p class="workshop-name">Akina Speed Star</p>
                  <h5 class="card-title">Paking Knalpot Mio Smile 2011</h5>
                  <div class="footer-card">
                    <div class="price d-flex justify-content-start">
                      <span class="price">Rp25.550</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
              <a href="#" class="card-product p-3">
                <img src="https://img.lazcdn.com/g/p/a5eb9ddcf6bc80ba1af124d92c02c5d2.png_720x720q80.png"
                  class="card-img-top" alt="Sparepart Image">
                <div class="card-body text-start">
                  <p class="workshop-name">Akina Speed Star</p>
                  <h5 class="card-title">Paking Knalpot Mio Smile 2011</h5>
                  <div class="footer-card">
                    <div class="price d-flex justify-content-start">
                      <span class="price">Rp25.550</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
              <a href="#" class="card-product p-3">
                <img src="https://img.lazcdn.com/g/p/a5eb9ddcf6bc80ba1af124d92c02c5d2.png_720x720q80.png"
                  class="card-img-top" alt="Sparepart Image">
                <div class="card-body text-start">
                  <p class="workshop-name">Akina Speed Star</p>
                  <h5 class="card-title">Paking Knalpot Mio Smile 2011</h5>
                  <div class="footer-card">
                    <div class="price d-flex justify-content-start">
                      <span class="price">Rp25.550</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <!-- Repeat cards as needed -->
            {{-- @else
              <div class="text-center">
                <img src="{{ asset('assets/images/components/empty.png') }}" width="150" alt="No Data">
                <p>Data saat ini tidak ditemukan.</p>
              </div>
            @endif --}}
          </div>
          <div class="text-center mt-4">
            <a href="#" class="btn btn-more">
              More Spare Part <i class="bx bx-chevron-right align-icon"></i>
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
          <div class="row">
            {{-- Replace the condition below with your logic to check for actual products --}}
            {{-- @if (false) --}}
            <!-- Change this to your actual data check -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
              <a href="#" class="card-product p-3">
                <img src="https://i.ebayimg.com/images/g/OEEAAOSwTnxhSBXT/s-l1200.jpg" class="card-img-top"
                  alt="Product Image">
                <div class="card-body text-start">
                  <p class="workshop-name">Akina Speed Star</p>
                  <h5 class="card-title">LOGIC SPEAKERS SET MERCEDES-BENZ E350 W212 OEM 2010-2018.</h5>
                  <div class="footer-card">
                    <div class="price d-flex justify-content-start">
                      <span class="price">Rp7.787.804</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
              <a href="#" class="card-product p-3">
                <img src="https://i.ebayimg.com/images/g/OEEAAOSwTnxhSBXT/s-l1200.jpg" class="card-img-top"
                  alt="Product Image">
                <div class="card-body text-start">
                  <p class="workshop-name">Akina Speed Star</p>
                  <h5 class="card-title">LOGIC SPEAKERS SET MERCEDES-BENZ E350 W212 OEM 2010-2018.</h5>
                  <div class="footer-card">
                    <div class="price d-flex justify-content-start">
                      <span class="price">Rp7.787.804</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
              <a href="#" class="card-product p-3">
                <img src="https://i.ebayimg.com/images/g/OEEAAOSwTnxhSBXT/s-l1200.jpg" class="card-img-top"
                  alt="Product Image">
                <div class="card-body text-start">
                  <p class="workshop-name">Akina Speed Star</p>
                  <h5 class="card-title">LOGIC SPEAKERS SET MERCEDES-BENZ E350 W212 OEM 2010-2018.</h5>
                  <div class="footer-card">
                    <div class="price d-flex justify-content-start">
                      <span class="price">Rp7.787.804</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
              <a href="#" class="card-product p-3">
                <img src="https://i.ebayimg.com/images/g/OEEAAOSwTnxhSBXT/s-l1200.jpg" class="card-img-top"
                  alt="Product Image">
                <div class="card-body text-start">
                  <p class="workshop-name">Akina Speed Star</p>
                  <h5 class="card-title">LOGIC SPEAKERS SET MERCEDES-BENZ E350 W212 OEM 2010-2018.</h5>
                  <div class="footer-card">
                    <div class="price d-flex justify-content-start">
                      <span class="price">Rp7.787.804</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <!-- Repeat cards as needed -->
            {{-- @else
              <div class="text-center">
                <img src="{{ asset('assets/images/components/empty.png') }}" width="150" alt="No Data">
                <p>Data saat ini tidak ditemukan.</p>
              </div>
            @endif --}}
          </div>
          <div class="text-center mt-4">
            <a href="#" class="btn btn-more">
              More Product <i class="bx bx-chevron-right align-icon"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>



  {{-- used car --}}
@endsection
