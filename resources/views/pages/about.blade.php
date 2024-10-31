@extends('layouts.app')


@section('title')
    eBengkelku | About us
@stop

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
    <div class="row g-4 justify-content-center">
      <div class="col-6 col-md-3 text-center">
        <i class="bx bx-wrench fa-2x text-white mb-3"></i>
        <h2 class="text-white mb-2 counter" data-target="1000">10</h2>
        <p class="text-white mb-0">Registered Workshops</p>
      </div>
      <div class="col-6 col-md-3 text-center">
        <i class="bx bx-box fa-2x text-white mb-3"></i>
        <h2 class="text-white mb-2 counter" data-target="750">10</h2>
        <p class="text-white mb-0">Available Products</p>
      </div>
      <div class="col-6 col-md-3 text-center">
        <i class="bx bx-cog fa-2x text-white mb-3"></i>
        <h2 class="text-white mb-2 counter" data-target="500">10</h2>
        <p class="text-white mb-0">Available Services</p>
      </div>
      <div class="col-6 col-md-3 text-center">
        <i class="bx bx-user fa-2x text-white mb-3"></i>
        <h2 class="text-white mb-2 counter" data-target="250">10</h2>
        <p class="text-white mb-0">Registered Users</p>
      </div>
    </div>
  </div>
</div>

<div class="container-xxl py-5">
  <div class="container">
    <div class="row g-5 justify-content-center">
      <div class="col-lg-6 d-flex justify-content-center align-items-center">
        <img class="img-fluid rounded shadow-sm" src="{{ asset('assets/images/logo/logo.png') }}" style="width:100%; max-width:300px;" alt="Logo eBengkelku">
      </div>
      <div class="col-lg-6">
        <h6 class="text-title">Tentang Kami</h6>
        <h2 class="mb-2"><span class="text-p">eBengkelku</span> Solusi Terbaik untuk Manajemen Bengkel Anda</h2>
        <p class="mb-2">
            eBengkelku adalah platform digital yang menyederhanakan pengelolaan bengkel otomotif, membantu pemilik bengkel dalam mencatat data kendaraan, melacak riwayat dan jadwal servis, serta mengoptimalkan operasional bisnis. Dengan berbagai fitur canggih, eBengkelku mendukung pengusaha bengkel dalam mengelola usaha mereka dengan lebih efisien.
        </p>
        <p class="mb-2">
            Platform ini menawarkan direktori Workshop untuk menemukan bengkel dengan berbagai keahlian, marketplace Mobil Bekas & Suku Cadang, serta fitur Event untuk promosi acara otomotif. Dilengkapi dengan sistem POS, eBengkelku memudahkan transaksi dan penjualan pelanggan. Tersedia di web dan mobile, platform ini dikembangkan oleh CNPLUS untuk memberikan pengalaman terbaik bagi pelanggan dan pemilik bengkel.
        </p>
      </div>
    </div>
  </div>
</div>

<script>
  const counters = document.querySelectorAll('.counter');
  const speed = 200;

  counters.forEach(counter => {
    const animate = () => {
      const target = +counter.getAttribute('data-target');
      const count = +counter.innerText;

      const increment = target / speed;

      if(count < target) {
        counter.innerText = Math.ceil(count + increment);
        setTimeout(animate, 10);
      } else {
        counter.innerText = target;
      }
    };

    animate();
  });
</script>
@endsection
