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
                  <a class="main-btn btn-one" href="profile/profile?visit=&page=profile">
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
            <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
              <div class="card h-100 shadow-sm">
                <img src="{{ asset('assets/images/components/image.png') }}" class="card-img-top" alt="Event Name">
                <div class="card-body">
                  <h5 class="card-title">Event Name</h5>
                  <p><i class="bx bx-calendar"></i> 1 January 2024 - 5 January 2024</p>
                  <p><i class="bx bx-map"></i> Event Address</p>
                  <p><strong>Free</strong></p>
                </div>
              </div>
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
            <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
              <div class="card h-100 shadow-sm">
                <img src="{{ asset('assets/images/components/image.png') }}" class="card-img-top" alt="Workshop Name">
                <div class="card-body">
                  <h5 class="card-title">Workshop Name</h5>
                  <p><i>Workshop Tagline</i></p>
                </div>
              </div>
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
            <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
              <div class="card h-100 shadow-sm">
                <img src="{{ asset('assets/images/components/image.png') }}" class="card-img-top" alt="Spare Part Name">
                <div class="card-body">
                  <h5 class="card-title">Spare Part Name</h5>
                  <p>Stock: 20</p>
                  <p><strong>Rp. 150,000</strong></p>
                </div>
              </div>
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
            <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
              <div class="card h-100 shadow-sm">
                <img src="{{ asset('assets/images/components/image.png') }}" class="card-img-top" alt="Product Name">
                <div class="card-body">
                  <h5 class="card-title">Product Name</h5>
                  <p><strong>Rp. 200,000</strong></p>
                </div>
              </div>
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
