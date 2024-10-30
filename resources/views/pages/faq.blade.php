@extends('layouts.app')

@section('title', 'Ebengkel | FAQs')

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
        <h2 class="pb-2 fw-bold">Frequently Asked Questions</h2>
        <p>eBengkelku adalah platform digital terpercaya untuk manajemen bengkel otomotif, menghadirkan solusi inovatif bagi pemilik bengkel dalam mengelola data kendaraan, riwayat servis, dan jadwal servis. Dengan fitur direktori bengkel, marketplace mobil bekas & suku cadang, serta sistem POS, eBengkelku mendukung operasional bisnis secara efisien, kapan saja dan di mana saja, melalui web dan mobile.</p>
        <a class="btn btn-custom mt-3" href="#">Contact us</a>
      </div>
      <div class="col-md-7">
        <div class="accordion" id="Questions-accordion">
          <div class="accordion-item">
            <h2 class="accordion-header" id="Questions-headingOne">
              <button class="accordion-button collapsed bg-light" data-bs-target="#Questions-collapseOne" data-bs-toggle="collapse" type="button">
                Lorem ipsum dolor sit amet adipisicing?
              </button>
            </h2>
            <div id="Questions-collapseOne" class="accordion-collapse collapse" data-bs-parent="#Questions-accordion" aria-labelledby="Questions-headingOne">
              <div class="accordion-body">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maxime quos voluptatum at, quibusdam blanditiis saepe soluta laborum, repellendus nemo id porro dolor eveniet perspiciatis veritatis doloremque aliquam nam! Libero, nostrum!
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="Questions-headingTwo">
              <button class="accordion-button collapsed bg-light" data-bs-target="#Questions-collapseTwo" data-bs-toggle="collapse" type="button">
                Lorem ipsum dolor sit amet adipisicing?
              </button>
            </h2>
            <div id="Questions-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#Questions-accordion" aria-labelledby="Questions-headingTwo">
              <div class="accordion-body">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maxime quos voluptatum at, quibusdam blanditiis saepe soluta laborum, repellendus nemo id porro dolor eveniet perspiciatis veritatis doloremque aliquam nam! Libero, nostrum!
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="Questions-headingThree">
              <button class="accordion-button collapsed bg-light" data-bs-target="#Questions-collapseThree" data-bs-toggle="collapse" type="button">
                Lorem ipsum dolor sit amet adipisicing?
              </button>
            </h2>
            <div id="Questions-collapseThree" class="accordion-collapse collapse" data-bs-parent="#Questions-accordion" aria-labelledby="Questions-headingThree">
              <div class="accordion-body">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maxime quos voluptatum at, quibusdam blanditiis saepe soluta laborum, repellendus nemo id porro dolor eveniet perspiciatis veritatis doloremque aliquam nam! Libero, nostrum!
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="Questions-headingFour">
              <button class="accordion-button collapsed bg-light" data-bs-target="#Questions-collapseFour" data-bs-toggle="collapse" type="button">
                Lorem ipsum dolor sit amet adipisicing?
              </button>
            </h2>
            <div id="Questions-collapseFour" class="accordion-collapse collapse" data-bs-parent="#Questions-accordion" aria-labelledby="Questions-headingFour">
              <div class="accordion-body">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maxime quos voluptatum at, quibusdam blanditiis saepe soluta laborum, repellendus nemo id porro dolor eveniet perspiciatis veritatis doloremque aliquam nam! Libero, nostrum!
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
