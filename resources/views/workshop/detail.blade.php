@extends('layouts.app')
@push('css')
  <link rel="stylesheet" href="{{ asset('assets/css/workshop.css') }}">
@endpush
@section('title')
  eBengkelku | Workshop Detail
@stop
<script>
  function copyLink() {
    const link = 'https://yourworkshopwebsite.com/akinaworkshop'; // Replace with the actual workshop link
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
              src="data:image/png;base64,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"
              alt="Cover Bengkel" class="img-cover w-100" style="object-fit: cover; height: 225px;">

            <div class="d-flex align-items-center p-3 position-absolute top-50 start-0 translate-middle-y"
              style="background: rgba(0, 0, 0, 0.5); border-radius: 0 0.5rem 0.5rem 0;">
              <img
                src="data:image/png;base64,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"
                alt="Profile Image" class="rounded-circle me-3" style="width: 80px; height: 80px; object-fit: cover;">
              <div class="text-light">
                <h4 class="mb-1" style="font-weight: bold; color:white;">Akina Speed Stars</h4>
                <p class="mb-0" style="font-size: 0.9rem; color:white;">Mechanic Japan Tech</p>
              </div>
            </div>

            <!-- Social Media and Share Icons with Individual Backgrounds and Opacity -->
            <div class="position-absolute bottom-0 end-0 p-3 d-flex align-items-center">
              <!-- WhatsApp Button -->
              <a href="https://wa.me/81295429920" target="_blank" class="btn btn-dark rounded-circle me-2">
                <i class='bx bxl-whatsapp fs-4' style="color: white;"></i>
              </a>

              <!-- Instagram Button -->
              <a href="https://instagram.com/fwsabdm" target="_blank" class="btn btn-dark rounded-circle me-2">
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
                  <small>Mon - Fri, 08:00 - 17:00 WIB</small>
                </div>
              </div>
              <div class="col-12 col-md-6 d-flex align-items-center text-start py-2">
                <i class='bx bx-wrench fs-4 text-primary'></i>
                <div class="ms-3">
                  <span class="d-block fw-bold">Service Availability</span>
                  <small>Available for On-Call and In-Shop Service</small>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 d-flex align-items-center text-start py-2">
                <i class='bx bx-credit-card fs-4 text-primary'></i>
                <div class="ms-3">
                  <span class="d-block fw-bold">Accepted Payment Methods</span>
                  <small>Cash, Credit Card, Mobile Payment</small>
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
                    <small>Komplek STPI, Jl. Raya STPI Pos 3 No.Blok H, RT.02/RW.02, Rancagong, Kec. Legok, Kabupaten
                      Tangerang, Banten 15820</small>
                  </div>
                </div>
                <a href="https://www.google.com/maps/search/?api=1&query=Komplek+STPI+Jl+Raya+STPI+Pos+3+No+Blok+H+RT+02+RW+02+Rancagong+Kec+Legok+Kabupaten+Tangerang+Banten+15820"
                  target="_blank" class="btn btn-map ms-3 ">
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
                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQQIRnM3n_kvflDS6rZMfI0riK_yW9rWH_F4g&s"
                    class="card-img-top" alt="Service Image">
                  <div class="card-body text-start">
                    <p class="workshop-name">Akina Speed Star</p>
                    <h5 class="card-title">Service Radiator</h5>
                    <div class="footer-card">
                      <div class="price d-flex justify-content-start">
                        <span class="price">Rp550.550</span>
                      </div>
                    </div>
                  </div>
                </a>
              </div>

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
            {{-- isi card --}}
            <div class="row py-5">
              <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <a href="#" class="card-product p-3">
                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQQIRnM3n_kvflDS6rZMfI0riK_yW9rWH_F4g&s"
                    class="card-img-top" alt="Service Image">
                  <div class="card-body text-start">
                    <p class="workshop-name">Akina Speed Star</p>
                    <h5 class="card-title">Service Radiator</h5>
                    <div class="footer-card">
                      <div class="price d-flex justify-content-start">
                        <span class="price">Rp550.550</span>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <a href="#" class="card-product p-3">
                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQQIRnM3n_kvflDS6rZMfI0riK_yW9rWH_F4g&s"
                    class="card-img-top" alt="Service Image">
                  <div class="card-body text-start">
                    <p class="workshop-name">Akina Speed Star</p>
                    <h5 class="card-title">Service Radiator</h5>
                    <div class="footer-card">
                      <div class="price d-flex justify-content-start">
                        <span class="price">Rp550.550</span>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <a href="#" class="card-product p-3">
                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQQIRnM3n_kvflDS6rZMfI0riK_yW9rWH_F4g&s"
                    class="card-img-top" alt="Service Image">
                  <div class="card-body text-start">
                    <p class="workshop-name">Akina Speed Star</p>
                    <h5 class="card-title">Service Radiator</h5>
                    <div class="footer-card">
                      <div class="price d-flex justify-content-start">
                        <span class="price">Rp550.550</span>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <a href="#" class="card-product p-3">
                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQQIRnM3n_kvflDS6rZMfI0riK_yW9rWH_F4g&s"
                    class="card-img-top" alt="Service Image">
                  <div class="card-body text-start">
                    <p class="workshop-name">Akina Speed Star</p>
                    <h5 class="card-title">Service Radiator</h5>
                    <div class="footer-card">
                      <div class="price d-flex justify-content-start">
                        <span class="price">Rp550.550</span>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
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
            {{-- isi card --}}
            <div class="reviews">
              <div class="reviews-header d-flex justify-content-between align-items-center">
                <h3 class="reviews-title">Reviews</h3>
                <button type="button" class="btn btn-review" data-bs-toggle="modal"
                  data-bs-target="#reviewModal">Berikan Ulasan</button>
              </div>
              <div class="overall-rating">
                <div class="rating-value">4.5</div>
                <span>
                  <div class="rating-category">Very good</div>


                  <div class="rating-text">200 verified reviews</div>
                </span>
              </div>
              <hr>
              <div class="review-list py-2">
                <div class="review-item">
                  <img src="{{ asset('assets/images/components/avatar.png') }}" alt="User Avatar">
                  <div class="review-content">
                    <div class="rating">
                      <span class="angka-rate">5.0/5</span> | Rusdy Buitenzorg
                    </div>
                    <p>Mekaniknya asik 🔥</p>
                  </div>
                </div>
                <hr>
                <div class="review-item">
                  <img src="{{ asset('assets/images/components/avatar.png') }}" alt="User Avatar">
                  <div class="review-content">
                    <div class="rating">
                      <span class="angka-rate">5.0/5</span> | Rusdy Paku Banten
                    </div>
                    <p>Bakal pesen sparepart disini lagi nih 😁😁😁</p>
                  </div>
                </div>
                <hr>
                <div class="review-item">
                  <img src="{{ asset('assets/images/components/avatar.png') }}" alt="User Avatar">
                  <div class="review-content">
                    <div class="rating">
                      <span class="angka-rate">5.0/5</span> | Rusdy Mangunkubuwono IX
                    </div>
                    <p>Service disini emang paling best sih 😙😙</p>
                  </div>
                </div>
                <hr>
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
  <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-body">
          <form id="reviewForm">
            <div class="container py-3">
              <h3 class="title-rating">Berikan Ulasan Untuk Workshop Ini</h3>
              <div class="rating-form">
                {{-- 1 --}}
                <input type="radio" name="rating" id="star1" value="1" />
                <label for="star1" class="star py-2">
                  <i class='bx bxs-star' style="font-size: 25px;"></i>
                </label>
                {{-- 2 --}}
                <input type="radio" name="rating" id="star2" value="2" />
                <label for="star2" class="star py-2">
                  <i class='bx bxs-star' style="font-size: 25px;"></i>
                </label>
                {{-- 3 --}}
                <input type="radio" name="rating" id="star3" value="3" />
                <label for="star3" class="star py-2">
                  <i class='bx bxs-star' style="font-size: 25px;"></i>
                </label>
                {{-- 4 --}}
                <input type="radio" name="rating" id="star4" value="4" />
                <label for="star4" class="star py-2">
                  <i class='bx bxs-star' style="font-size: 25px;"></i>
                </label>
                {{-- 5 --}}
                <input type="radio" name="rating" id="star5" value="5" />
                <label for="star5" class="star py-2">
                  <i class='bx bxs-star' style="font-size: 25px;"></i>
                </label>
              </div>
            </div>


            <div class="mb-3">
              <textarea class="form-control" id="comments" rows="3" placeholder="Tulis Ulasan Anda Disini..."></textarea>
            </div>
            <button type="submit" class="btn btn-send-rate"> <span class="iconify" data-icon="mynaui:send-solid"
                data-width="16" data-height="16"></span>Kirim
              Ulasan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
