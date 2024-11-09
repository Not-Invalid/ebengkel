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
            {{-- Replace the condition below with your logic to check for actual events --}}
            {{-- @if (false) --}}
            <!-- Change this to your actual data check -->

            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
              <a href="{{ route('event.detail') }}" class="card-event p-3">
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
                  <a href="{{ route('workshop.detail', $bengkel->id_bengkel) }}" class="card-product p-3">
                    <img
                      src="{{ isset($bengkel) && $bengkel->foto_bengkel ? url($bengkel->foto_bengkel) : asset('assets/images/components/image.png') }}"
                      class="card-img-top" alt="Workshop Image">
                    <div class="card-body text-start">
                      <div class="d-flex align-items-center location-map">
                        <i class='bx bx-map-pin'></i>
                        <p class="location ms-2 py-2">{{ \Illuminate\Support\Str::limit($bengkel->alamat_bengkel, 22) }}
                        </p>
                      </div>
                      <h5 class="card-title">{{ \Illuminate\Support\Str::limit($bengkel->nama_bengkel, 20) }}</h5>
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
            <a href="#" class="btn btn-more">
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
          <div class="row">
            {{-- Replace the condition below with your logic to check for actual products --}}
            {{-- @if (false) --}}
            <!-- Change this to your actual data check -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
              <a href="#" class="card-product p-3">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRmgDTyalHBoNMXH-vCdIJTlNK7U7FvU0Ilog&s"
                  class="card-img-top" alt="Product Image">
                <div class="card-body text-start">
                  <p class="workshop-name">Akina Speed Star</p>
                  <h5 class="card-title">Disc Brake Mercy</h5>
                  <div class="footer-card">
                    <div class="price d-flex justify-content-start">
                      <span class="price">Rp2500.550</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
              <a href="#" class="card-product p-3">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRmgDTyalHBoNMXH-vCdIJTlNK7U7FvU0Ilog&s"
                  class="card-img-top" alt="Product Image">
                <div class="card-body text-start">
                  <p class="workshop-name">Akina Speed Star</p>
                  <h5 class="card-title">Disc Brake Mercy</h5>
                  <div class="footer-card">
                    <div class="price d-flex justify-content-start">
                      <span class="price">Rp2500.550</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
              <a href="#" class="card-product p-3">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRmgDTyalHBoNMXH-vCdIJTlNK7U7FvU0Ilog&s"
                  class="card-img-top" alt="Product Image">
                <div class="card-body text-start">
                  <p class="workshop-name">Akina Speed Star</p>
                  <h5 class="card-title">Disc Brake Mercy</h5>
                  <div class="footer-card">
                    <div class="price d-flex justify-content-start">
                      <span class="price">Rp2500.550</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
              <a href="#" class="card-product p-3">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRmgDTyalHBoNMXH-vCdIJTlNK7U7FvU0Ilog&s"
                  class="card-img-top" alt="Product Image">
                <div class="card-body text-start">
                  <p class="workshop-name">Akina Speed Star</p>
                  <h5 class="card-title">Disc Brake Mercy</h5>
                  <div class="footer-card">
                    <div class="price d-flex justify-content-start">
                      <span class="price">Rp2500.550</span>
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
                <img src="https://i.ebayimg.com/images/g/OEEAAOSwTnxhSBXT/s-l1200.jpg" class="card-img-top"
                  alt="Sparepart Image">
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
                  alt="Sparepart Image">
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
                  alt="Sparepart Image">
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
                  alt="Sparepart Image">
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
              More Spare Part <i class="bx bx-chevron-right align-icon"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- used car --}}
@endsection
