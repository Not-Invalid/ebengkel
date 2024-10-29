@extends('layouts.app')

@section('content')
<section class="mt-5 py-3">
  <div class="bg-light py-5">
    <div class="container">
      <div class="d-flex justify-content-between">
        <h2 class="fw-bold">About us</h2>
        <nav class="pt-3" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">About</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>

<div class="container-fluid fact bg-dark my-5 py-5">
    <div class="container">
        <div class="row g-4 d-flex justify-content-center">
            <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.1s">
                <i class="bx bx-wrench fa-2x text-white mb-3"></i>
                <h2 class="text-white mb-2" data-toggle="counter-up">1234</h2>
                <p class="text-white mb-0">Registered Workshops</p>
            </div>
            <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.3s">
                <i class="bx bx-box fa-2x text-white mb-3"></i>
                <h2 class="text-white mb-2" data-toggle="counter-up">5678</h2>
                <p class="text-white mb-0">Available Products</p>
            </div>
            <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.5s">
                <i class="bx bx-cog fa-2x text-white mb-3"></i>
                <h2 class="text-white mb-2" data-toggle="counter-up">910</h2>
                <p class="text-white mb-0">Available Services</p>
            </div>
            <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.7s">
                <i class="bx bx-user fa-2x text-white mb-3"></i>
                <h2 class="text-white mb-2" data-toggle="counter-up">2345</h2>
                <p class="text-white mb-0">Registered Users</p>
            </div>
            
        </div>
    </div>
</div>
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 d-flex justify-content-center">
            <div class="col-lg-6 pt-4" style="min-height: 400px;">
                <div class="position-relative h-100 wow fadeIn" data-wow-delay="0.1s">
                    <img class="position-absolute img-fluid rounded shadow-sm" src="{{ asset('assets/images/logo/logo.png') }}" style="object-fit: cover; width:auto;" alt="">
                </div>
            </div>
            <div class="col-lg-6">
                <h6 class="text-title">About Us</h6>
                <h2 class="mb-4"><span class="text-p">Ebengkelku</span> Is The Best Place For Your Auto Care</h2>
                <p class="mb-4">
                    Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et eos. Clita erat ipsum et lorem et sit, sed stet lorem sit clita duo justo magna dolore erat amet
                </p>
            </div>
        </div>
    </div>
</div>


@endsection
