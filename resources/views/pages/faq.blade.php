@extends('layouts.app')

@section('title')
    eBengkelku | FAQs
@stop

@section('content')
<section class="mt-5 py-3">
  <div class="bg-light py-5">
    <div class="container">
      <div class="d-flex justify-content-between">
        <h2 class="fw-bold">FAQs</h2>
        <nav class="pt-3" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">FAQs</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>

<section class="py-4">
  <div class="container py-2">
    <div class="row justify-content-center">
      <div class="col-md-5 py-2">
        <h2 class="pb-2 fw-bold">Have Any Question?</h2>
        <a class="btn btn-custom mt-3" href="{{ route('contact') }}">Contact us</a>
      </div>
      <div class="col-md-7">
        <div class="accordion" id="Questions-accordion">
          <div class="accordion-item mb-1">
            <h2 class="accordion-header" id="Questions-headingOne">
              <button class="accordion-button collapsed" data-bs-target="#Questions-collapseOne" data-bs-toggle="collapse" type="button">
                <i class="bx bx-chevron-down me-2 fs-4"></i>
                Apa itu eBengkelku?
              </button>
            </h2>
            <div id="Questions-collapseOne" class="accordion-collapse collapse" data-bs-parent="#Questions-accordion" aria-labelledby="Questions-headingOne">
              <div class="accordion-body">
                eBengkelku adalah platform digital yang dirancang untuk membantu pemilik bengkel otomotif dalam mengelola operasional bisnis mereka. Dengan fitur-fitur canggih seperti manajemen data kendaraan pelanggan, marketplace untuk mobil bekas dan suku cadang, serta sistem POS, eBengkelku memudahkan pengelolaan bengkel dari mana saja.
              </div>
            </div>
          </div>
          <div class="accordion-item mb-1">
            <h2 class="accordion-header" id="Questions-headingTwo">
              <button class="accordion-button collapsed" data-bs-target="#Questions-collapseTwo" data-bs-toggle="collapse" type="button">
                <i class="bx bx-chevron-down me-2 fs-4"></i>
                Fitur apa saja yang ditawarkan oleh eBengkelku?
              </button>
            </h2>
            <div id="Questions-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#Questions-accordion" aria-labelledby="Questions-headingTwo">
              <div class="accordion-body">
                eBengkelku menawarkan berbagai fitur unggulan, termasuk manajemen data kendaraan dan riwayat servis, marketplace untuk mobil bekas dan suku cadang, direktori workshop untuk menemukan bengkel dengan berbagai keahlian, sistem Point of Sale (POS) untuk memudahkan transaksi, serta fitur Event untuk mempromosikan acara otomotif.
              </div>
            </div>
          </div>
          <div class="accordion-item mb-1">
            <h2 class="accordion-header" id="Questions-headingThree">
              <button class="accordion-button collapsed" data-bs-target="#Questions-collapseThree" data-bs-toggle="collapse" type="button">
                <i class="bx bx-chevron-down me-2 fs-4"></i>
                Bagaimana cara eBengkelku membantu pengelolaan bengkel?
              </button>
            </h2>
            <div id="Questions-collapseThree" class="accordion-collapse collapse" data-bs-parent="#Questions-accordion" aria-labelledby="Questions-headingThree">
              <div class="accordion-body">
                eBengkelku membantu pengelolaan bengkel dengan menyediakan alat untuk menyederhanakan administrasi, seperti mengelola data pelanggan dan jadwal servis kendaraan. Platform ini juga memperlancar proses penjualan dengan POS dan memudahkan pencarian suku cadang atau mobil bekas yang dibutuhkan oleh pelanggan.
              </div>
            </div>
          </div>
          <div class="accordion-item mb-1">
            <h2 class="accordion-header" id="Questions-headingFour">
              <button class="accordion-button collapsed" data-bs-target="#Questions-collapseFour" data-bs-toggle="collapse" type="button">
                <i class="bx bx-chevron-down me-2 fs-4"></i>
                Apakah eBengkelku dapat diakses melalui perangkat mobile?
              </button>
            </h2>
            <div id="Questions-collapseFour" class="accordion-collapse collapse" data-bs-parent="#Questions-accordion" aria-labelledby="Questions-headingFour">
              <div class="accordion-body">
                Ya, eBengkelku tersedia di web dan perangkat mobile. Hal ini memungkinkan pemilik bengkel dan pengguna untuk mengakses platform dengan mudah dari mana saja, sehingga manajemen bengkel bisa dilakukan secara fleksibel.
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection
