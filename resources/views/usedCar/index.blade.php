@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/car.css') }}">
@endpush

@section('title')
    eBengkelku - Used Car
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
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        @if ($mobilList->isEmpty())
                            <div class="d-flex justify-content-center pb-5">
                                <div class="text-center">
                                    <img src="{{ asset('assets/images/components/empty.png') }}" height="200"
                                        width="200" alt="No workshops">
                                    <p>No data available for usedCar.</p>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                @foreach ($mobilList as $car)
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-3">
                                        <a href="{{ route('usedcar.detail', $car->id_mobil) }}" class="card-event p-3">
                                            @if ($car->fotos && $car->fotos->file_foto_mobil_1)
                                                <img src="{{ url($car->fotos->file_foto_mobil_1) }}" alt="Car Image"
                                                    class="card-img-top">
                                            @else
                                                <img src="{{ asset('assets/images/components/image.png') }}"
                                                    alt="Car Image"class="card-img-top">
                                            @endif
                                            <div class="card-body text-start">
                                                <div class="d-flex align-items-center location-map mt-3">
                                                    <i class='bx bx-map-pin'></i>
                                                    <p class="location ms-2">
                                                        {{ \Illuminate\Support\Str::limit($car->lokasi_mobil, 15) }}
                                                    </p>
                                                </div>
                                                <p class="card-title">
                                                    {{ \Illuminate\Support\Str::limit($car->nama_mobil, 15) }}
                                                </p>
                                                <div class="d-flex align-items-center event-date">
                                                    <span class="jenis">{{ $car->merkMobil->nama_merk }}</span>
                                                </div>
                                                <div class="footer-card">
                                                    <div class="price d-flex justify-content-start">
                                                        <span
                                                            class="price">Rp{{ number_format($car->harga_mobil, 0, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
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
        </div>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-body">
                <div class="offcanvas-header">
                    <h5 class="brand-title">
                        <div class="">
                            <i class='bx bx-car icon-size'></i>
                            Brand
                        </div>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <!-- Brand Section -->
                <div id="brand" class="filter-section show">
                    @foreach ($merks as $merk)
                        <div class="mt-2">
                            <input type="checkbox" id="{{ strtolower($merk->nama_merk) }}" name="nama_merk"
                                value="{{ $merk->nama_merk }}">
                            <label for="{{ strtolower($merk->nama_merk) }}"
                                class="mx-2">{{ $merk->nama_merk }}</label>
                        </div>
                    @endforeach
                    <div class="mt-2">
                        <span id="toggle-other-brands" onclick="toggleOtherBrands()"
                            style="color: #007bff; cursor: pointer;">
                            Lihat Semuanya
                        </span>
                    </div>
                </div>

                <div class="offcanvas-header">
                    <h5 class="brand-title">
                        <div class="">
                            <i class='bx bx-money icon-size'></i>
                            Harga
                        </div>
                    </h5>
                </div>

                <!-- Harga Section -->
                <div id="harga" class="filter-section show">
                    <div class="mt-2"><input type="checkbox" name="harga" value="< 100 Juta"><label class="mx-2">
                            < 100 Juta</label>
                    </div>
                    <div class="mt-2"><input type="checkbox" name="harga" value="100 - 250 Juta"><label
                            class="mx-2">100 - 250 Juta</label></div>
                    <div class="mt-2"><input type="checkbox" name="harga" value="250 - 400 Juta"><label
                            class="mx-2">250 - 400 Juta</label></div>
                    <div class="mt-2"><input type="checkbox" name="harga" value="400 - 550 Juta"><label
                            class="mx-2">400 - 550 Juta</label></div>
                    <div class="mt-2"><input type="checkbox" name="harga" value="550 - 700 Juta"><label
                            class="mx-2">550 - 700 Juta</label></div>
                    <div class="mt-2"><input type="checkbox" name="harga" value="700 - 850 Juta"><label
                            class="mx-2">700 - 850 Juta</label></div>
                    <div class="mt-2"><input type="checkbox" name="harga" value="850 - 1 Miliar"><label
                            class="mx-2">850 - 1 Miliar</label></div>
                    <div class="mt-2"><input type="checkbox" name="harga" value="> 1 Miliar"><label
                            class="mx-2">> 1 Miliar</label></div>
                </div>

                <div class="offcanvas-header">
                    <h5 class="brand-title">
                        <div class="">
                            <i class='bx bx-time-five icon-size'></i>
                            Pemakaian
                        </div>
                    </h5>
                </div>

                <!-- Pemakaian Section -->
                <div id="pemakaian" class="filter-section show">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            const carCards = document.querySelectorAll('.col-12'); // Select all car cards

            function filterCars() {
                carCards.forEach(function(card) {
                    const carBrand = card.querySelector('.jenis').textContent.trim();
                    const carPriceText = card.querySelector('.price').textContent.trim();
                    const carUsage = card.querySelector('.location').textContent.trim();

                    const carPrice = parseInt(carPriceText.replace(/[^0-9]/g, ''));

                    let showCard = true;

                    // Filter by brand
                    const selectedBrands = Array.from(document.querySelectorAll(
                        'input[name="nama_merk"]:checked')).map(input => input.value);
                    if (selectedBrands.length > 0 && !selectedBrands.includes(carBrand)) {
                        showCard = false;
                    }

                    // Filter by price
                    const selectedPrices = Array.from(document.querySelectorAll(
                        'input[name="harga"]:checked')).map(input => input.value);
                    if (selectedPrices.length > 0) {
                        const priceInRange = selectedPrices.some(priceFilter => {
                            switch (priceFilter) {
                                case '< 100 Juta':
                                    return carPrice < 100000000;
                                case '100 - 250 Juta':
                                    return carPrice >= 100000000 && carPrice <= 250000000;
                                case '250 - 400 Juta':
                                    return carPrice >= 250000000 && carPrice <= 400000000;
                                case '400 - 550 Juta':
                                    return carPrice >= 400000000 && carPrice <= 550000000;
                                case '550 - 700 Juta':
                                    return carPrice >= 550000000 && carPrice <= 700000000;
                                case '700 - 850 Juta':
                                    return carPrice >= 700000000 && carPrice <= 850000000;
                                case '850 - 1 Miliar':
                                    return carPrice >= 850000000 && carPrice <= 1000000000;
                                case '> 1 Miliar':
                                    return carPrice > 1000000000;
                                default:
                                    return true;
                            }
                        });
                        if (!priceInRange) {
                            showCard = false;
                        }
                    }

                    // Filter by usage
                    const selectedUsages = Array.from(document.querySelectorAll(
                        'input[name="pemakaian"]:checked')).map(input => input.value);
                    if (selectedUsages.length > 0) {
                        const usageInRange = selectedUsages.some(usageFilter => {
                            switch (usageFilter) {
                                case 'Dibawah 1 Tahun':
                                    return parseInt(carUsage) < 1;
                                case 'Dibawah 3 Tahun':
                                    return parseInt(carUsage) < 3;
                                case 'Dibawah 5 Tahun':
                                    return parseInt(carUsage) < 5;
                                case 'Dibawah 7 Tahun':
                                    return parseInt(carUsage) < 7;
                                case 'Dibawah 10 Tahun':
                                    return parseInt(carUsage) < 10;
                                default:
                                    return true;
                            }
                        });
                        if (!usageInRange) {
                            showCard = false;
                        }
                    }

                    // Show or hide the card
                    card.style.display = showCard ? 'block' : 'none';
                });
            }

            checkboxes.forEach(checkbox => checkbox.addEventListener('change', filterCars));
            filterCars(); // Initial call to apply any pre-selected filters
        });
    </script>

@endsection
