@extends('layouts.app')
@push('css')
  <link rel="stylesheet" href="{{ asset('assets/css/workshop.css') }}">
@endpush
@section('title')
  eBengkelku | Workshop Detail
@stop
<script>
  function copyLink() {
    const link = 'https://ebengkelku.com/workshop/{{ $bengkel->id_bengkel }}'; // Replace with the actual workshop link
    navigator.clipboard.writeText(link).then(() => {
      // Display Toastr notification
      toastr.success("Link copied!");
    }).catch(err => {
      toastr.error("Failed to copy link.");
    });
  }
</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const tabLinks = document.querySelectorAll(".custom-tab-link");
    const dropdown = document.querySelector(".custom-dropdown");

    tabLinks.forEach((link) => {
      link.addEventListener("click", function(e) {
        e.preventDefault();
        tabLinks.forEach((tab) => tab.classList.remove("active"));
        document
          .querySelectorAll(".tab-pane")
          .forEach((pane) => pane.classList.remove("active"));
        this.classList.add("active");
        document
          .getElementById(this.getAttribute("data-tab"))
          .classList.add("active");
      });
    });

    dropdown.addEventListener("change", function() {
      const selectedTab = this.value;
      tabLinks.forEach((tab) => tab.classList.remove("active"));
      document
        .querySelectorAll(".tab-pane")
        .forEach((pane) => pane.classList.remove("active"));
      document
        .querySelector(`[data-tab="${selectedTab}"]`)
        .classList.add("active");
      document.getElementById(selectedTab).classList.add("active");
    });
  });
</script>
<script>
  const ratingInputs = document.querySelectorAll('.rating-form input');

  ratingInputs.forEach(input => {
    input.addEventListener('change', () => {
      const ratingValue = input.value;

      ratingInputs.forEach((item, index) => {
        const starIcon = item.nextElementSibling.querySelector('i');
        // Change star icon based on rating
        if (index < ratingValue) {
          starIcon.classList.remove('bx-star');
          starIcon.classList.add('bxs-star');
          starIcon.style.color = 'gold'; // Active stars
        } else {
          starIcon.classList.remove('bxs-star');
          starIcon.classList.add('bx-star');
          starIcon.style.color = 'gray'; // Inactive stars
        }
      });
    });
  });
</script>

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
          <h4 class="title-header">Workshop Detail</h4>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container my-5">
      <section>
        <div class="card workshop-header mb-5">
          <div class="position-relative">
            <img
              src="{{ isset($bengkel) && $bengkel->foto_cover_bengkel ? url($bengkel->foto_cover_bengkel) : asset('assets/images/components/image.png') }}"
              alt="Cover Bengkel" class="img-cover w-100" style="object-fit: cover; height: 225px;">

            <div class="d-flex align-items-center p-3 position-absolute top-50 start-0 translate-middle-y"
              style="background: rgba(0, 0, 0, 0.5); border-radius: 0 0.5rem 0.5rem 0;">
              <img
                src="{{ isset($bengkel) && $bengkel->foto_bengkel ? url($bengkel->foto_bengkel) : asset('assets/images/components/image.png') }}"
                alt="Profile Image" class="rounded-circle me-3" style="width: 80px; height: 80px; object-fit: cover;">
              <div class="text-light">
                <h4 class="mb-1" style="font-weight: bold; color:white;">
                  {{ \Illuminate\Support\Str::limit($bengkel->nama_bengkel, 20) }}</h4>
                <p class="mb-0" style="font-size: 0.9rem; color:white;">
                  {{ \Illuminate\Support\Str::limit($bengkel->tagline_bengkel, 20) }}h</p>
              </div>
            </div>

            <!-- Social Media and Share Icons with Individual Backgrounds and Opacity -->
            <div class="position-absolute bottom-0 end-0 p-3 d-flex align-items-center">
              <!-- WhatsApp Button -->
              <a href="https://wa.me/{{ $bengkel->whatsapp }}" target="_blank" class="btn btn-dark rounded-circle me-2">
                <i class='bx bxl-whatsapp fs-4' style="color: white;"></i>
              </a>

              <!-- Instagram Button -->
              <a href="https://instagram.com/{{ $bengkel->instagram }}" target="_blank"
                class="btn btn-dark rounded-circle me-2">
                <i class='bx bxl-instagram fs-4' style="color: white;"></i>
              </a>

              <!-- Share Button -->
              <button onclick="copyLink()" class="btn btn-dark rounded-circle">
                <i class='bx bx-share fs-4' style="color: white;"></i>
              </button>
            </div>
          </div>


          <div class="card-body info-workshop">
            <div class="row">
              <div class="col-12 col-md-6 d-flex align-items-center text-start py-2">
                <i class='bx bx-time fs-4 text-primary'></i>
                <div class="ms-3">
                  <span class="d-block fw-bold">Operational Hours</span>
                  <small>
                    {{ $bengkel->open_day }} - {{ $bengkel->close_day }},
                    {{ \Carbon\Carbon::parse($bengkel->open_time)->format('H:i') }} -
                    {{ \Carbon\Carbon::parse($bengkel->close_time)->format('H:i') }} WIB
                  </small>
                </div>

              </div>
              <div class="col-12 col-md-6 d-flex align-items-center text-start py-2">
                <i class='bx bx-wrench fs-4 text-primary'></i>
                <div class="ms-3">
                  <span class="d-block fw-bold">Service Availability</span>
                  <small>
                    @foreach ($serviceAvailable as $service)
                      {{ $service }} @if (!$loop->last)
                        ,
                      @endif
                    @endforeach
                  </small>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 d-flex align-items-center text-start py-2">
                <i class='bx bx-credit-card fs-4 text-primary'></i>
                <div class="ms-3">
                  <span class="d-block fw-bold">Accepted Payment Methods</span>
                  <small>
                    @foreach ($paymentMethods as $payment)
                      {{ $payment }} @if (!$loop->last)
                        ,
                      @endif
                    @endforeach
                  </small>
                </div>
              </div>
              <div class="col-12 col-md-6 d-flex align-items-center text-start py-2">
                <i class='bx bx-star fs-4 text-primary'></i>
                <div class="ms-3">
                  <span class="d-block fw-bold">4.5 Rating</span>
                  <small>200 verified reviews</small>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12 col-md-12 d-flex align-items-center justify-content-between text-start py-2">
                <div class="d-flex align-items-center">
                  <i class='bx bx-map-pin fs-4 text-primary'></i>
                  <div class="ms-3">
                    <span class="d-block fw-bold">Location</span>
                    <small>{{ \Illuminate\Support\Str::limit($bengkel->alamat_bengkel, 100) }} </small>
                  </div>
                </div>
                <a href="{{ $bengkel->gmaps }}" target="_blank" class="btn btn-map ms-3 ">
                  <i class='bx bx-map'></i>
                </a>
              </div>
            </div>
          </div>

        </div>
      </section>
      <section>

        <div class="custom-tabs-container">
          <ul class="custom-tabs shadow text-center">
            <li class="custom-tab-item">
              <a class="custom-tab-link active" data-tab="all">

                All
              </a>
            </li>
            <li class="custom-tab-item">
              <a class="custom-tab-link" data-tab="service">
                Service

              </a>
            </li>
            <li class="custom-tab-item">
              <a class="custom-tab-link" data-tab="product">

                Product
              </a>
            </li>
            <li class="custom-tab-item">
              <a class="custom-tab-link" data-tab="spareparts">

                Spareparts
              </a>
            </li>
            <li class="custom-tab-item">
              <a class="custom-tab-link" data-tab="ulasan">

                Ulasan
              </a>
            </li>
          </ul>
          <select class="custom-dropdown shadow">
            <option value="all" selected>All</option>
            <option value="service">Service</option>
            <option value="product">Product</option>
            <option value="spareparts">Spareparts</option>
            <option value="ulasan">Ulasan</option>
          </select>
        </div>

        <div class="tab-content">
          <div class="tab-pane active" id="all">
            {{-- isi card --}}
            <div class="row py-5">
              <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <a href="#" class="card-product p-3">
                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRmgDTyalHBoNMXH-vCdIJTlNK7U7FvU0Ilog&s"
                    class="card-img-top" alt="Sparepart Image">
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
            </div>
          </div>
          <div class="tab-pane" id="service">
            {{-- Display service cards --}}
            <div class="row py-5">
              @forelse ($services as $service)
                @if ($service->id_bengkel === $bengkel->id_bengkel)
                  <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="{{ route('service.detail', ['id_bengkel' => $bengkel->id_bengkel, 'id_services' => $service->id_services]) }}"
                      class="card-product p-3">
                      <img
                        src="{{ $service->foto_services ? url($service->foto_services) : asset('assets/images/components/image.png') }}"
                        class="card-img-top" alt="Service Image">
                      <div class="card-body text-start mt-4">

                        <h5 class="card-title">{{ $service->nama_services }}</h5>
                        <div class="footer-card">
                          <div class="price d-flex justify-content-start">
                            <span
                              class="price">{{ 'Rp' . number_format($service->harga_services ?? 0, 0, ',', '.') }}</span>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                @endif
              @empty
                <div class="text-center">
                  <img src="{{ asset('assets/images/components/empty.png') }}" width="200" alt="No Data">
                  <p>Data saat ini tidak ditemukan.</p>
                </div>
              @endforelse
            </div>
          </div>
          <div class="tab-pane" id="product">
            {{-- isi card --}}
            <div class="row py-5">
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
            </div>

          </div>
          <div class="tab-pane" id="spareparts">
            {{-- isi card --}}
            <div class="row py-5">
              <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <a href="#" class="card-product p-3">
                  <img src="https://i.ebayimg.com/images/g/OEEAAOSwTnxhSBXT/s-l1200.jpg" class="card-img-top"
                    alt="Spareparts Image">
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
                    alt="Spareparts Image">
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
                    alt="Spareparts Image">
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
                    alt="Spareparts Image">
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
            </div>

          </div>
          <div class="tab-pane" id="ulasan">
            @if (session()->has('id_pelanggan'))
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">Berikan
                Ulasan</button>
            @endif
            @foreach ($ulasan as $review)
              <div class="review-card">
                <h6>{{ $review->pelanggan->nama_pelanggan }} ({{ $review->rating }}/5)</h6>
                <p>{{ $review->komentar }}</p>
                <small>{{ \Carbon\Carbon::parse($review->created_at)->format('d M Y') }}</small>
              </div>
            @endforeach


            <!-- Modal -->
            <!-- Modal -->
            <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Berikan Ulasan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form method="POST" action="{{ route('ulasan.store') }}">
                      @csrf
                      <!-- Hidden field for customer ID -->
                      <input type="hidden" name="id_pelanggan" value="{{ session('id_pelanggan') }}">
                      <!-- Hidden field for workshop ID -->
                      <input type="hidden" name="id_bengkel" value="{{ $bengkel->id_bengkel }}">

                      <div class="form-group">
                        <label for="rating">Rating</label>
                        <select name="rating" class="form-control" id="rating" required>
                          <option value="" disabled selected>Pilih rating</option>
                          <!-- Option tambahan untuk placeholder -->
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="komentar">Komentar</label>
                        <textarea name="komentar" class="form-control" id="komentar" rows="3"></textarea>
                      </div>

                      <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                  </div>
                </div>
              </div>
            </div>

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
      </section>
    </div>

  </section>
@endsection
