@extends('layouts.app')

@section('content')
<section class="mt-5 py-3">
  <div class="bg-light py-5">
    <div class="container">
      <div class="d-flex justify-content-between">
        <h2 class="fw-bold">Contact us</h2>
        <nav class="pt-3" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Contact</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>

<main>
  <div class="container py-5">
    <div class="row g-5">
      <div class="col-xl-6">
          <div class="aos-item" data-aos="fade-up" data-aos-delay="200">
            <div class="aos-item__inner">
              <div class="bg-light hvr-shutter-out-horizontal d-block p-3">
                <div class="d-flex justify-content-start">
                  <i class="bx bx-envelope h3 pe-2"></i>
                  <span class="h5">Email</span>
                </div>
                <span>ebengkelku@gmail.com</span>
              </div>
            </div>
          </div>
          <div class="aos-item" data-aos="fade-up" data-aos-delay="400">
            <div class="aos-item__inner">
              <div class="bg-light hvr-shutter-out-horizontal d-block p-3">
                <div class="d-flex justify-content-start">
                  <i class="bx bx-phone h3 pe-2"></i>
                  <span class="h5">Phone</span>
                </div>
                <span>+62 1234567898</span>
              </div>
            </div>
          </div>
        <div class="aos-item" data-aos="fade-up" data-aos-delay="800">
          <div class="mt-4 w-100 aos-item__inner">
            <iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=300&amp;hl=en&amp;q=CNPLUS%20%7C%20DOKTORTJ%20@-6.2819825,106.5749969&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
          </div>
        </div>
      </div>

      <div class="col-xl-6">
        <h2 class="pb-4">Leave a message</h2>
        <form action="{{ route('message-send') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Tulis Nama Lengkap Anda" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="email@contoh.com" required>
            </div>
            <div class="mb-3">
                <label for="telepon" class="form-label">Nomor Telepon</label>
                <input type="tel" class="form-control" id="telepon" name="telepon" placeholder="+62XXXXXXXX" required>
            </div>
            <div class="mb-3">
                <label for="pesan" class="form-label">Pesan</label>
                <textarea class="form-control" style="resize: none;" id="pesan" name="pesan" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-custom">Kirim Pesan</button>
        </form>
      </div>
    </div>
  </div>
</main>

@endsection
