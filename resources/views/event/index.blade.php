@extends('layouts.app')
@push('css')
  <link rel="stylesheet" href="{{ asset('assets/css/event.css') }}">
@endpush

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
          <h4 class="title-header">See Our Event</h4>
        </div>
      </div>
    </div>
  </section>

  <section class="section bg-white py-5">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="d-flex justify-content-center align-items-center" style="min-height: 50px;">
            <form method="GET" action="" style="width: 60%;">
              <div class="input-group">
                <input type="text" name="search" required maxlength="255" placeholder="Ketik kata kunci..."
                  class="form-control" style="border-radius: 20px 0 0 20px;">
                <div class="input-group-append">
                  <button type="submit" class="btn btn-search" style="border-radius: 0 20px 20px 0;">
                    <i class='bx bx-search-alt align-icon'></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  {{-- Latest Event Section --}}
  <section class="section bg-white" style="padding-bottom: 50px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
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
          <!-- Static Pagination -->
          <nav aria-label="Page navigation" class="d-flex justify-content-center mt-4">
            <ul class="pagination">
              <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
              </li>
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item">
                <a class="page-link" href="#">Next</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </section>
@endsection