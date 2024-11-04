@extends('layouts.app')

@section('title')
    eBengkelku | Terms & Condition
@stop

@section('content')
<section class="mt-5 py-3">
  <div class="bg-light py-5">
    <div class="container">
      <div class="d-flex justify-content-between">
        <h2 class="fw-bold">Terms & Conditions</h2>
        <nav class="pt-3" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Terms & Conditions</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>

<div class="container">
    <div class="row align-items-center">
        <div class="col-lg-6">
            <p class="welcome-text">Selamat datang di eBengkelku, platform digital terdepan yang menyederhanakan pengelolaan bengkel otomotif. Syarat dan ketentuan ini mengatur penggunaan Anda terhadap situs web kami dan layanan yang kami tawarkan. Dengan mengakses atau menggunakan situs web kami, Anda setuju untuk mematuhi dan terikat oleh syarat dan ketentuan berikut. Mohon baca syarat dan ketentuan ini dengan seksama sebelum melanjutkan penggunaan layanan kami.</p>
        </div>

        <div class="col-lg-6 text-center">
            <img src="{{ asset('assets/images/logo/logo.png') }}" class="img-fluid rounded w-50" alt="eBengkelku">
        </div>
    </div>

    <div class="row my-4">
        <div class="col-lg-6">
            <h5 class="fw-bold mt-4">Persetujuan Penggunaan</h5>
            <p class="terms-detail">Dengan mengakses atau menggunakan situs eBengkelku, Anda menyetujui untuk mematuhi semua syarat dan ketentuan yang berlaku.</p>
        </div>

        <div class="col-lg-6">
            <h5 class="fw-bold mt-4">Layanan eBengkelku</h5>
            <p class="terms-detail">eBengkelku menyediakan layanan untuk mencari dan membeli suku cadang, produk otomotif, dan layanan terkait. Kami tidak bertanggung jawab atas kualitas layanan pihak ketiga.</p>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-lg-6">
            <h5 class="fw-bold mt-4">Keamanan Akun</h5>
            <p class="terms-detail">Pengguna bertanggung jawab menjaga kerahasiaan akun dan bertanggung jawab atas aktivitas yang terjadi melalui akun tersebut.</p>
        </div>

        <div class="col-lg-6">
            <h5 class="fw-bold mt-4">Perubahan Syarat & Ketentuan</h5>
            <p class="terms-detail">eBengkelku berhak mengubah syarat dan ketentuan tanpa pemberitahuan terlebih dahulu.</p>
        </div>
    </div>

</div>

@endsection
