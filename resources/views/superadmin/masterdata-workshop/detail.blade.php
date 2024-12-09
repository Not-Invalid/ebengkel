 @extends('superadmin.layouts.app')

 @section('title')
     eBengkelku | Detail Workshop
 @stop


    <link rel="stylesheet" href="{{ asset('assets/css/superadmin/detail-workshop.css') }}">
 @section('content')
     <div class="container">
         <div class="w-100 shadow bg-white rounded" style="padding: 1rem">

             <div class="d-flex align-items-center">
                 <div class="me-5">
                     <img src="{{ isset($bengkel) && $bengkel->foto_bengkel ? url($bengkel->foto_bengkel) : asset('assets/images/components/image.png') }}" alt=""
                         class="border" style="border-radius: 100%; height: 150px; width: 150px; object-fit: cover">
                 </div>
                 <div>
                     <h2 class="">{{ $bengkel->nama_bengkel  }}</h2>
                     <h2 class="tagline">{{ $bengkel->tagline_bengkel }}</h2>
                 </div>
             </div>
             <div class="row">
                 <div class="col-12">
                     <div class="d-flex align-items-center mt-5 ms-3">
                         <i class="fa-regular fa-calendar-days me-2"></i>
                         <span class="fw-bold">Open Workshop : </span>
                         <span class="ms-1">
                            {{ $bengkel->open_day }} - {{ $bengkel->close_day }},
                            {{ \Carbon\Carbon::parse($bengkel->open_time)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($bengkel->close_time)->format('H:i') }} WIB
                         </span>
                     </div>
                     <div class="d-flex align-items-center mt-3 ms-3">
                         <i class="fa-regular fa-calendar-days me-2"></i>
                         <span class="fw-bold">Location : </span>
                         <span class="ms-1 fs-6">{{ \Illuminate\Support\Str::limit($bengkel->alamat_bengkel, 100) }}</span>
                     </div>
                 </div>
             </div>
             <div class="container-fluid bg-white text-black my-5 py-5">
                <div class="container">
                    <div class="row g-4 justify-content-center align-items-center">
                        <div class="col-12 col-md-3 text-center total">
                            <h2 class="text-black mb-2 counter" data-target="{{ $totalProducts }}">{{ $totalProducts }}</h2>
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-box-open fa-2x fs-5 text-black me-2"></i>
                                <p class="text-black mb-0">Total Products</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 text-center total">
                            <h2 class="text-black mb-2 counter" data-target="{{ $totalSpareParts }}">{{ $totalSpareParts }}</h2>
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-cogs fa-2x fs-5 text-black me-2"></i>
                                <p class="text-black mb-0">Total Spareparts</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 text-center total">
                            <h2 class="text-black mb-2 counter" data-target="{{ $totalServices }}">{{ $totalServices }}</h2>
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-cog fa-2x fs-5 text-black me-2"></i>
                                <p class="text-black mb-0">Total Services</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 text-center total">
                            <h2 class="text-black mb-2 counter" data-target="{{ number_format($averageRating, 1) }}">
                                {{ number_format($averageRating, 1) }}
                            </h2>
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-star fa-2x fs-5 text-black me-2"></i>
                                <p class="text-black mb-0">Rating</p>
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
                    <option value="sparepart">Sparepart</option>
                    <option value="service">Service</option>
                </select>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 mx-2" id="productList">
                <!-- Loop untuk menampilkan produk -->
                @foreach($products as $product)
                    <div class="col my-3" data-type="product">
                        <a href="" class="card-event">
                            <div class="product-card shadow">
                                <img src="{{ isset($product->fotoProduk) && $product->fotoProduk->file_foto_produk_1
                                ? url($product->fotoProduk->file_foto_produk_1)
                                : asset('assets/images/components/image.png') }}" class="product-image">
                                <div class="product-info text-start">
                                    <p class="product-title mt-2">{{ $product->nama_produk }}</p>
                                    <div class="location d-flex align-items-center">
                                        <span class="text-primary">{{ $product->merk_produk }}</span>
                                    </div>
                                    <div class="d-flex justify-content-start mt-5 align-items-center">
                                        <span class="price">Rp {{ number_format($product->harga_produk, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach

                <!-- Loop untuk menampilkan sparepart -->
                @foreach($spareParts as $sparePart)
                    <div class="col my-3" data-type="sparepart">
                        <a href="" class="card-event">
                            <div class="product-card shadow">
                                <img src="{{ isset($sparePart->fotoSparepart) && $sparePart->fotoSparepart->file_foto_spare_part_1
                                ? url($sparePart->fotoSparepart->file_foto_spare_part_1)
                                : asset('assets/images/components/image.png') }}" class="product-image">
                                <div class="product-info text-start">
                                    <p class="product-title mt-2">{{ $sparePart->nama_spare_part }}</p>
                                    <div class="location d-flex align-items-center">
                                        <span class="text-primary">{{ $sparePart->merk_spare_part }}</span>
                                    </div>
                                    <div class="d-flex justify-content-start mt-5 align-items-center">
                                        <span class="price">Rp {{ number_format($sparePart->harga_spare_part, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach

                <!-- Loop untuk menampilkan layanan -->
                @foreach($services as $service)
                    <div class="col my-3" data-type="service">
                        <a href="" class="card-event">
                            <div class="product-card shadow">
                                <img src="{{ isset($service) && $service->foto_services ? url($service->foto_services) : asset('assets/images/components/image.png') }}" class="product-image">
                                <div class="product-info text-start">
                                    <p class="product-title mt-2">{{ $service->nama_services }}</p>
                                    <div class="location d-flex align-items-center">
                                        <span>{{ $service->jumlah_services }} Layanan per Hari</span>
                                    </div>
                                    <div class="d-flex justify-content-start mt-5 align-items-center">
                                        <span class="price">Rp {{ number_format($service->harga_services, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

     </div>

     <script src="{{ asset('template/assets/extensions/chart.js/chart.umd.js') }}"></script>

     <script>
         document.getElementById("filterSelect").addEventListener("change", function() {
            let filterValue = this.value; // Get the selected filter value
            let products = document.querySelectorAll("#productList .col");

            products.forEach(function(product) {
                let productType = product.getAttribute("data-type");

                if (filterValue === "all" || productType === filterValue) {
                    product.style.display = "block"; // Show product
                } else {
                    product.style.display = "none"; // Hide product
                }
            });
        });

     </script>

<script>
    var line = document.getElementById("line").getContext("2d");
    var gradient = line.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, "rgba(50, 69, 209,1)");
    gradient.addColorStop(1, "rgba(265, 177, 249,0)");

    var gradient2 = line.createLinearGradient(0, 0, 0, 400);
    gradient2.addColorStop(0, "rgba(255, 91, 92,1)");
    gradient2.addColorStop(1, "rgba(265, 177, 249,0)");

    var myline = new Chart(line, {
        type: "line",
        data: {
            labels: [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ],
            datasets: [{
                    label: "Products Sold",
                    data: [120, 150, 170, 130, 200, 180, 210, 190, 230, 250, 220, 240], // Replace with actual product data
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
                    label: "Services Sold",
                    data: [100, 130, 150, 120, 170, 160, 200, 180, 210, 220, 190, 230], // Replace with actual service data
                    backgroundColor: "rgba(253, 183, 90,.6)",
                    borderWidth: 3,
                    borderColor: "rgba(253, 183, 90,.6)",
                    pointBorderWidth: 0,
                    pointBorderColor: "transparent",
                    pointRadius: 3,
                    pointBackgroundColor: "transparent",
                    pointHoverBackgroundColor: "rgba(253, 183, 90,1)",
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
                }],
                xAxes: [{
                    gridLines: {
                        drawBorder: false,
                        display: false,
                    },
                    ticks: {
                        display: true, // Show month labels
                    },
                }],
            },
        },
    });
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
