@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/productSparepart.css') }}">
@endpush
@section('title')
    eBengkelku - Produk & Sparepart
@stop

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
                    <h4 class="title-header">Product & SparePart</h4>
                </div>
            </div>
        </div>
    </section>

    <div class="container mt-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-center align-items-center" style="min-height: 50px;">
                        <form method="GET" action="" style="width: 60%;">
                            <div class="input-group">
                                <input type="text" name="search" required maxlength="255"
                                    placeholder="Ketik kata kunci..." class="form-control"
                                    style="border-radius: 20px 0 0 20px;">
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

        <div class="container">
            <!-- Filter Buttons -->
            <div class="filter-buttons">
                <button onclick="filterCategory('all')" class="filter-btn">All</button>
                <button onclick="filterCategory('product')" class="filter-btn">Product</button>
                <button onclick="filterCategory('sparepart')" class="filter-btn">Sparepart</button>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="row ">
                        <!-- Item 1 - Product -->
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-3" data-category="product">
                            <a href="{{ route('usedcar.detail') }}" class="card-event p-3">
                                <img src="https://images.tokopedia.net/img/cache/700/VqbcmM/2023/5/18/5c98527e-2296-4cbb-9595-065cf85f3d98.jpg"
                                    class="card-img-top" alt="Event Image">
                                <div class="card-body text-start">
                                    <p class="card-title">LAMP LED ERTIGA</p>
                                    <div class="d-flex align-items-center">
                                        <i class='bx bx-box me-1 workshop'></i>
                                        <span class="workshop">Cimone Racing</span>
                                    </div>
                                    <div class="footer-card">
                                        <div class="price d-flex justify-content-start">
                                            <span class="price">Rp. 160,000,000</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-3" data-category="product">
                            <a href="{{ route('usedcar.detail') }}" class="card-event p-3">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQM7_mrU1UgeKqkdz_if2Zz4doIBEgY8kRmcA&s"
                                    class="card-img-top" alt="Event Image">
                                <div class="card-body text-start">
                                    <p class="card-title">OLI GARDAN</p>
                                    <div class="d-flex align-items-center">
                                        <i class='bx bx-box me-1 workshop'></i>
                                        <span class="workshop">Cimone Bengkel</span>
                                    </div>
                                    <div class="footer-card">
                                        <div class="price d-flex justify-content-start">
                                            <span class="price">Rp. 160,000,000</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Item 2 - Sparepart -->
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-3" data-category="sparepart">
                            <a href="{{ route('usedcar.detail') }}" class="card-event p-3">
                                <img src="https://thumbs.dreamstime.com/b/windshield-wiper-blade-spare-part-windshield-wiper-blade-spare-part-isolated-white-background-car-detail-repair-engine-gear-163373523.jpg?w=1600"
                                    class="card-img-top" alt="Event Image">
                                <div class="card-body text-start">
                                    <p class="card-title">WIPER BOSCH BLADE</p>
                                    <div class="d-flex align-items-center">
                                        <i class='bx bx-box me-1 workshop'></i>
                                        <span class="workshop">Auto Car</span>
                                    </div>
                                    <div class="footer-card">
                                        <div class="price d-flex justify-content-start">
                                            <span class="price">Rp. 160,000,000</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-3" data-category="sparepart">
                            <a href="{{ route('usedcar.detail') }}" class="card-event p-3">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTg8MuQLbZ6gme1vFtLnc-7LgPGOYSRgLT71w&s"
                                    class="card-img-top" alt="Event Image">
                                <div class="card-body text-start">
                                    <p class="card-title">VELG</p>
                                    <div class="d-flex align-items-center">
                                        <i class='bx bx-box me-1 workshop'></i>
                                        <span class="workshop">Arya Mobile</span>
                                    </div>
                                    <div class="footer-card">
                                        <div class="price d-flex justify-content-start">
                                            <span class="price">Rp. 160,000,000</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
