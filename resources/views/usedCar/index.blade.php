@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/car.css') }}">
@endpush

@section('title')
    eBengkelku - Profile
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
                    <h4 class="title-header">Used Car</h4>
                </div>
            </div>
        </div>
    </section>
    <div class="container mt-5">
        <!-- Search Bar -->
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

        <!-- Tab Navigation -->
        <button class="tab-button mt-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
            aria-controls="offcanvasExample">
            Filter
        </button>

        <div class="container">
            <div class="row">
                @foreach ($cars as $car)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-3">
                        <a href="{{ route('usedcar.detail', $car->id) }}" class="card-event p-3">
                            <img src="{{ asset('storage/' . $car->image) }}" class="card-img-top" alt="{{ $car->name }}">
                            <div class="card-body text-start">
                                <div class="d-flex align-items-center location-map mt-3">
                                    <i class='bx bx-map-pin'></i>
                                    <p class="location ms-2">{{ $car->location }}</p>
                                </div>
                                <p class="card-title">{{ $car->brand }}</p>
                                <div class="d-flex align-items-center event-date">
                                    <span class="jenis">{{ $car->model }}</span>
                                </div>
                                <div class="footer-card">
                                    <div class="price d-flex justify-content-start">
                                        <span class="price">Rp{{ number_format($car->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $cars->links() }}
        </div>


        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-body">
                <div class="offcanvas-header">
                    <h5 class="brand-title" onclick="toggleSection('brand')">
                        <div class="">
                            <i class='bx bx-car icon-size'></i>
                            Brand
                        </div>
                        <i id="chevron-icon-brand" class='bx bx-chevron-up chevron'></i>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <!-- Brand Section -->
                <div id="brand" class="filter-section">
                    <div class="mt-2"><input type="checkbox" id="toyota" name="brand" value="Toyota"><label
                            for="toyota" class="mx-2">Toyota</label></div>
                    <div class="mt-2"><input type="checkbox" id="daihatsu" name="brand" value="Daihatsu"><label
                            for="daihatsu" class="mx-2">Daihatsu</label></div>
                    <div class="mt-2"><input type="checkbox" id="honda" name="brand" value="honda"><label
                            for="honda" class="mx-2">Honda</label></div>
                    <div class="mt-2"><input type="checkbox" id="suzuki" name="brand" value="Suzuki"><label
                            for="suzuki" class="mx-2">Suzuki</label></div>
                    <div class="mt-2"><input type="checkbox" id="mercy" name="brand" value="Mercy"><label
                            for="mercy" class="mx-2">Mercy</label></div>
                    <div class="mt-2"><input type="checkbox" id="bmw" name="brand" value="BMW"><label
                            for="bmw" class="mx-2">BMW</label></div>
                    <div class="mt-2"><input type="checkbox" id="audi" name="brand" value="Audi"><label
                            for="audi" class="mx-2">Audi</label></div>
                    <div id="other-brands" style="display: none;">
                        <div class="mt-2"><input type="checkbox" id="mitsubishi" name="brand"
                                value="Mitsubishi"><label for="mitsubishi" class="mx-2">Mitsubishi</label></div>
                        <div class="mt-2"><input type="checkbox" id="wuling" name="brand" value="Wuling"><label
                                for="wuling" class="mx-2">Wuling</label></div>
                        <div class="mt-2"><input type="checkbox" id="nissan" name="brand" value="Nissan"><label
                                for="nissan" class="mx-2">Nissan</label></div>
                        <div class="mt-2"><input type="checkbox" id="mazda" name="brand" value="Mazda"><label
                                for="mazda" class="mx-2">Mazda</label></div>
                        <div class="mt-2"><input type="checkbox" id="kia" name="brand" value="Kia"><label
                                for="kia" class="mx-2">Kia</label></div>
                        <div class="mt-2"><input type="checkbox" id="hyundai" name="brand" value="Hyundai"><label
                                for="hyundai" class="mx-2">Hyundai</label></div>
                    </div>
                    <div class="mt-2"><span id="toggle-other-brands" onclick="toggleOtherBrands()"
                            style="color: #007bff; cursor: pointer;">Lihat Semuanya</span></div>
                </div>

                <div class="offcanvas-header">
                    <h5 class="brand-title" onclick="toggleSection('harga')">
                        <div class="">
                            <i class='bx bx-money icon-size'></i>
                            Harga
                        </div>
                        <i id="chevron-icon-harga" class='bx bx-chevron-up chevron'></i>
                    </h5>
                </div>

                <!-- Harga Section -->
                <div id="harga" class="filter-section">
                    <div class="mt-2"><input type="checkbox" name="harga" value="< 100 Juta"><label class="mx-2">
                            < 100 Juta</label>
                    </div>
                    <div class="mt-2"><input type="checkbox" name="harga" value="100 - 250 Juta"><label
                            class="mx-2">100 - 250
                            Juta</label></div>
                    <div class="mt-2"><input type="checkbox" name="harga" value="250 - 400 Juta"><label
                            class="mx-2">250 - 400
                            Juta</label></div>
                    <div class="mt-2"><input type="checkbox" name="harga" value="400 - 550 Juta"><label
                            class="mx-2">400 - 550
                            Juta</label></div>
                    <div class="mt-2"><input type="checkbox" name="harga" value="400 - 550 Juta"><label
                            class="mx-2">550 - 700
                            Juta</label></div>
                    <div class="mt-2"><input type="checkbox" name="harga" value="400 - 550 Juta"><label
                            class="mx-2">700 - 850
                            Juta</label></div>
                    <div class="mt-2"><input type="checkbox" name="harga" value="400 - 550 Juta"><label
                            class="mx-2">850 - 1 Miliar
                            Juta</label></div>
                    <div class="mt-2"><input type="checkbox" name="harga" value="> 1 Miliar"><label
                            class="mx-2">> 1
                            Miliar</label></div>
                </div>

                <div class="offcanvas-header">
                    <h5 class="brand-title" onclick="toggleSection('pemakaian')">
                        <div class="">
                            <i class='bx bx-time-five icon-size'></i>
                            Pemakaian
                        </div>
                        <i id="chevron-icon-pemakaian" class='bx bx-chevron-up chevron'></i>
                    </h5>
                </div>

                <!-- Pemakaian Section -->
                <div id="pemakaian" class="filter-section">
                    <div class="mt-2"><input type="checkbox" name="pemakaian" value="Dibawah 1 Tahun"><label
                            class="mx-2">Dibawah 1
                            Tahun</label></div>
                    <div class="mt-2"><input type="checkbox" name="pemakaian" value="Dibawah 3 Tahun"><label
                            class="mx-2">Dibawah 3
                            Tahun</label></div>
                    <div class="mt-2"><input type="checkbox" name="pemakaian" value="Dibawah 5 Tahun"><label
                            class="mx-2">Dibawah 5
                            Tahun</label></div>
                    <div class="mt-2"><input type="checkbox" name="pemakaian" value="Dibawah 7 Tahun"><label
                            class="mx-2">Dibawah 7
                            Tahun</label></div>
                    <div class="mt-2"><input type="checkbox" name="pemakaian" value="Dibawah 10 Tahun"><label
                            class="mx-2">Dibawah
                            10 Tahun</label></div>
                </div>
            </div>
        </div>

    </div>

@endsection
