 @extends('superadmin.layouts.app')
 <style>
     .tagline {
         font-size: 16px;
     }

     .total {
         border-right: 1px solid #121212;
     }

     /* Card container */
     .card-event {
         border-radius: 8px;
         display: block;
         text-decoration: none;
         transition: transform 0.3s ease, box-shadow 0.3s ease;
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
     }

     .card-event:hover {
         transform: translateY(-2px);
         box-shadow: 0 14px 30px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
     }

     /* Product card styling */
     .product-card {
         background-color: #ffffff;
         overflow: hidden;
         border-radius: 8px;
         display: flex;
         flex-direction: column;
         height: 100%;
         width: 200px;
         padding: 10px;
     }

     /* Image styling */
     .product-image {
         width: 100%;
         height: 100%;
         object-fit: cover;
         border-radius: 8px 8px 0 0;
     }

     /* Product info styling */
     .product-info {
         padding: 12px;
         display: flex;
         flex-direction: column;
         flex-grow: 1;
         justify-content: space-between;
     }

     /* Location styling */
     .location {
         display: flex;
         align-items: center;
         font-size: 14px;
         color: #121212;
         font-weight: 500;
         margin-bottom: 8px;
     }

     .location i {
         margin-right: 4px;
         color: #121212;
     }

     /* Product title styling */
     .product-title {
         font-size: 18px;
         font-weight: 700;
         color: #121212;
         margin-bottom: 4px;
     }

     /* Price styling */
     .price {
         font-size: 16px;
         font-weight: 700;
         color: #121212;
         margin-top: auto;
     }

     @media (min-width: 768px) {
         .total {
             border-right: 1px solid #121212;
         }
     }

     @media (max-width: 575px) {
         .total {
             border-right: none;
         }

         .product-image {
             width: 100%;
             height: 100%;
             object-fit: cover;
             border-radius: 8px 8px 0 0;
         }

         .product-card {
             background-color: #ffffff;
             overflow: hidden;
             border-radius: 8px;
             display: flex;
             flex-direction: column;
             height: 100%;
             width: auto;
             padding: 10px;
         }
     }

     .sold-info {
         font-size: 14px;
         font-weight: 600;
         color: #121212;
     }
 </style>
 @section('title')
     eBengkelku | Detail Workshop
 @stop

 @section('content')
     <div class="container">
         <div class="w-100 shadow bg-white rounded" style="padding: 1rem">

             <div class="d-flex align-items-center">
                 <div class="me-5">
                     <img src="{{ asset('assets/images/bg/car.png') }}" alt=""
                         style="border-radius: 100%; height: 150px; width: 150px; object-fit: cover">
                 </div>
                 <div>
                     <h2 class="">Pinang Team</h2>
                     <h2 class="tagline">Pinang Jaya</h2>
                 </div>
             </div>
             <div class="row">
                 <div class="col-12">
                     <div class="d-flex align-items-center mt-5 ms-3">
                         <i class="fa-regular fa-calendar-days me-2"></i>
                         <span class="fw-bold">Open Workshop : </span>
                         <span class="ms-1">Monday - Sunday | 08.00 - 19.00</span>
                     </div>
                     <div class="d-flex align-items-center mt-3 ms-3">
                         <i class="fa-regular fa-calendar-days me-2"></i>
                         <span class="fw-bold">Location : </span>
                         <span class="ms-1">JL. Gang Samiri</span>
                     </div>
                 </div>
             </div>
             <div class="container-fluid bg-white text-black my-5 py-5">
                 <div class="container">
                     <div class="row g-4 justify-content-center">
                         <div class="col-12 col-md-3 text-center total">
                             <h2 class="text-black mb-2 counter" data-target="1000">10</h2>
                             <div class="d-flex align-items-center justify-content-center">
                                 <i class="fas fa-box-open fa-2x text-black me-2"></i>
                                 <p class="text-black mb-0">Total Product</p>
                             </div>
                         </div>
                         <div class="col-12 col-md-3 text-center total">
                             <h2 class="text-black mb-2 counter" data-target="1000">10</h2>
                             <div class="d-flex align-items-center justify-content-center">
                                 <i class="fas fa-cog fa-2x text-black me-2"></i>
                                 <p class="text-black mb-0">Total Services</p>
                             </div>
                         </div>
                         <div class="col-12 col-md-3 text-center total">
                             <h2 class="text-black mb-2 counter" data-target="1000">10</h2>
                             <div class="d-flex align-items-center justify-content-center">
                                 <i class="fas fa-star fa-2x text-black me-2"></i>
                                 <p class="text-black mb-0">Rating </p>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <div class="container mt-5">
         <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
             <canvas id="line" style="width: auto; height: 400px;"></canvas>
         </div>
     </div>

     <div class="container mt-5">
         <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
             <!-- Filter dropdown -->
             <div class="filter-section mb-3">
                 <select id="filterSelect" class="form-select" aria-label="Filter Products">
                     <option value="all">All</option>
                     <option value="product">Product</option>
                     <option value="service">Service</option>
                 </select>
             </div>
             <div class="row row-cols-1 row-cols-lg-4 row-cols-md-4 gap-5" id="productList">
                 <!-- Product 1 - Product -->
                 <div class=" col" data-type="product">
                     <a href="" class="card-event">
                         <div class="product-card shadow">
                             <!-- Product image -->
                             <img src="{{ asset('assets/images/components/image.png') }}" alt="Mercedes-Benz"
                                 class="product-image">
                             <div class="product-info text-start">
                                 <p class="product-title mt-2">LAMP ERTIGA</p>
                                 <div class="location d-flex align-items-center">
                                     <i class="fas fa-box-open"></i>
                                     <span>Cimone Racing Team</span>
                                 </div>
                                 <div class="d-flex justify-content-start mt-5 align-items-center">
                                     <span class="price">Rp 150.000</span>
                                 </div>
                                 <div class="sold-info mt-2">
                                     <span>5 Terjual</span>
                                 </div>
                             </div>
                         </div>
                     </a>
                 </div>

                 <!-- Product 2 - Service -->
                 <div class="col" data-type="service">
                     <a href="" class="card-event">
                         <div class="product-card shadow">
                             <!-- Product image -->
                             <img src="{{ asset('assets/images/components/image.png') }}" alt="Mercedes-Benz"
                                 class="product-image">
                             <div class="product-info text-start">
                                 <p class="product-title mt-2">LAMP ERTIGA</p>
                                 <div class="location d-flex align-items-center">
                                     <i class="fas fa-box-open"></i>
                                     <span>Cimone Racing Team</span>
                                 </div>
                                 <div class="d-flex justify-content-start mt-5 align-items-center">
                                     <span class="price">Rp 150.000</span>
                                 </div>
                                 <div class="sold-info mt-2">
                                     <span>5 Terjual</span>
                                 </div>
                             </div>
                         </div>
                     </a>
                 </div>

                 <!-- Product 3 - Product -->
                 <div class="col" data-type="product">
                     <a href="" class="card-event">
                         <div class="product-card shadow">
                             <!-- Product image -->
                             <img src="{{ asset('assets/images/components/image.png') }}" alt="Mercedes-Benz"
                                 class="product-image">
                             <div class="product-info text-start">
                                 <p class="product-title mt-2">LAMP ERTIGA</p>
                                 <div class="location d-flex align-items-center">
                                     <i class="fas fa-box-open"></i>
                                     <span>Cimone Racing Team</span>
                                 </div>
                                 <div class="d-flex justify-content-start mt-5 align-items-center">
                                     <span class="price">Rp 150.000</span>
                                 </div>
                                 <div class="sold-info mt-2">
                                     <span>5 Terjual</span>
                                 </div>
                             </div>
                         </div>
                     </a>
                 </div>

                 <!-- Product 4 - Service -->
                 <div class="col" data-type="service">
                     <a href="" class="card-event">
                         <div class="product-card shadow">
                             <!-- Product image -->
                             <img src="{{ asset('assets/images/components/image.png') }}" alt="Mercedes-Benz"
                                 class="product-image">
                             <div class="product-info text-start">
                                 <p class="product-title mt-2">LAMP ERTIGA</p>
                                 <div class="location d-flex align-items-center">
                                     <i class="fas fa-box-open"></i>
                                     <span>Cimone Racing Team</span>
                                 </div>
                                 <div class="d-flex justify-content-start mt-5 align-items-center">
                                     <span class="price">Rp 150.000</span>
                                 </div>
                                 <div class="sold-info mt-2">
                                     <span>5 Terjual</span>
                                 </div>
                             </div>
                         </div>
                     </a>
                 </div>
             </div>
         </div>
     </div>

     <script src="{{ asset('template/assets/extensions/chart.js/chart.umd.js') }}"></script>

     <script>
         // Function to filter products based on selected filter
         document.getElementById("filterSelect").addEventListener("change", function() {
             let filterValue = this.value; // Get the selected filter value
             let products = document.querySelectorAll("#productList .col-12");

             products.forEach(function(product) {
                 // Get the data-type attribute
                 let productType = product.getAttribute("data-type");

                 // Show or hide based on the filter
                 if (filterValue === "all" || productType === filterValue) {
                     product.style.display = "block"; // Show product
                 } else {
                     product.style.display = "none"; // Hide product
                 }
             });
         });
     </script>

     <script>
         var line = document.getElementById("line").getContext("2d")
         var gradient = line.createLinearGradient(0, 0, 0, 400)
         gradient.addColorStop(0, "rgba(50, 69, 209,1)")
         gradient.addColorStop(1, "rgba(265, 177, 249,0)")

         var gradient2 = line.createLinearGradient(0, 0, 0, 400)
         gradient2.addColorStop(0, "rgba(255, 91, 92,1)")
         gradient2.addColorStop(1, "rgba(265, 177, 249,0)")

         var myline = new Chart(line, {
             type: "line",
             data: {
                 labels: [
                     "16-07-2018",
                     "17-07-2018",
                     "18-07-2018",
                     "19-07-2018",
                     "20-07-2018",
                     "21-07-2018",
                     "22-07-2018",
                     "23-07-2018",
                     "24-07-2018",
                     "25-07-2018",
                 ],
                 datasets: [{
                         label: "Balance",
                         data: [50, 25, 61, 50, 72, 52, 60, 41, 30, 45],
                         backgroundColor: "rgba(50, 69, 209,.6)",
                         borderWidth: 3,
                         borderColor: "rgba(63,82,227,1)",
                         pointBorderWidth: 0,
                         pointBorderColor: "transparent",
                         pointRadius: 3,
                         pointBackgroundColor: "transparent",
                         pointHoverBackgroundColor: "rgba(63,82,227,1)",
                     },
                     {
                         label: "Balance",
                         data: [20, 35, 45, 75, 37, 86, 45, 65, 25, 53],
                         backgroundColor: "rgba(253, 183, 90,.6)",
                         borderWidth: 3,
                         borderColor: "rgba(253, 183, 90,.6)",
                         pointBorderWidth: 0,
                         pointBorderColor: "transparent",
                         pointRadius: 3,
                         pointBackgroundColor: "transparent",
                         pointHoverBackgroundColor: "rgba(63,82,227,1)",
                     },
                 ],
             },
             options: {
                 responsive: true,
                 layout: {
                     padding: {
                         top: 10,
                     },
                 },
                 tooltips: {
                     intersect: false,
                     titleFontFamily: "Helvetica",
                     titleMarginBottom: 10,
                     xPadding: 10,
                     yPadding: 10,
                     cornerRadius: 3,
                 },
                 legend: {
                     display: true,
                 },
                 scales: {
                     yAxes: [{
                         gridLines: {
                             display: true,
                             drawBorder: true,
                         },
                         ticks: {
                             display: true,
                         },
                     }, ],
                     xAxes: [{
                         gridLines: {
                             drawBorder: false,
                             display: false,
                         },
                         ticks: {
                             display: false,
                         },
                     }, ],
                 },
             },
         })
     </script>

     <script>
         const counters = document.querySelectorAll('.counter');
         const speed = 200;

         counters.forEach(counter => {
             const animate = () => {
                 const target = +counter.getAttribute('data-target');
                 const count = +counter.innerText;

                 const increment = target / speed;

                 if (count < target) {
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
