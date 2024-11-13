@extends('layouts.app')

@section('title')
  eBengkelku | Service Detail
@stop

<style>
  .title-header {
    color: var(--main-blue);
    position: relative;
    z-index: 10;
  }

  /* Main Service Image */
  .img-fluid.object-fit-cover {
    object-fit: cover;
    height: 300px;
    border-radius: 10px;
  }

  /* Service Details */
  .fw-bold {
    font-weight: 600;
  }

  /* Price Card */
  .card {
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  .card h5 {
    font-size: 18px;
    font-weight: bold;
    color: #333;
  }

  .text-success {
    font-size: 24px;
    color: #28a745;
  }

  /* Button Styling */
  .btn-primary {
    background-color: #3498db;
    border-color: #3498db;
    color: #fff;
    padding: 12px 20px;
    font-size: 16px;
    text-transform: uppercase;
    border-radius: 5px;
    transition: background-color 0.3s ease;
  }

  .btn-primary:hover {
    background-color: #2980b9;
    border-color: #2980b9;
  }

  /* Contact Info */
  .row.py-5 {
    padding-top: 40px;
    padding-bottom: 40px;
  }

  .row.py-5 p {
    font-size: 16px;
    color: #333;
    margin-bottom: 15px;
  }

  .row.py-5 i {
    font-size: 20px;
    color: #3498db;
  }

  /* Background Overlay */
  .bg-white {
    opacity: 0.7;
    background-color: #fff;
  }

  .section-white {
    padding-top: 100px;
    padding-bottom: 20px;
  }

  /* Phone and Contact Info */
  .contact-icon {
    margin-right: 10px;
    color: #3498db;
  }
</style>

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
          <h4 class="title-header">Service Detail</h4>
        </div>
      </div>
    </div>
  </section>
  </section>

  <div class="container py-5">
    <!-- Main Service Image -->
    <div class="row mb-4">
      <div class="col-md-12">
        <img
          src="{{ isset($service) && $service->foto_services ? url($service->foto_services) : asset('assets/images/components/image.png') }}"
          class="img-fluid object-fit-cover rounded w-100" style="max-height: 300px;" alt="Services Image">
      </div>
    </div>

    <!-- Service Details -->
    <div class="row">
      <div class="col-md-8">
        <h2 class="fw-bold">{{ $service->nama_services }}</h2>
        <p class="mt-3">{{ $service->keterangan_services }}</p>
      </div>
      <div class="col-md-4">
        <div class="card p-4" style="border-radius: 10px; border: none;">
          <h5 class="fw-bold py-2">Harga Service</h5>
          <p class="text-success fw-bold mb-4">Rp {{ number_format($service->harga_services, 0, ',', '.') }}</p>
          <a href="#" class="btn btn-primary w-100">
            <i class="bx bx-cart align-icon"></i> Pesan Sekarang
          </a>
        </div>
      </div>
    </div>

    <!-- Contact Info -->
    <div class="row">
      <div class="col-8">
        &nbsp
      </div>
      <div class="col-md-4 py-4">
        <div class="card p-4" style="border-radius: 10px; border: none;">
          <h5 class="fw-bold py-2">Hubungi Bengkel</h5>
          <p><i class="bx bxl-whatsapp align-icon m-0"></i>
            {{ $service->bengkel ? $service->bengkel->whatsapp : 'N/A' }}
          </p>
          <p><i class="bx bxl-instagram align-icon m-0"></i>
            {{ $service->bengkel ? $service->bengkel->instagram : 'N/A' }}
          </p>
        </div>
      </div>
    </div>

  </div>
@endsection
