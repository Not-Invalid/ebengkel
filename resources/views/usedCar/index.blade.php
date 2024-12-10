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
                    <h4 class="title-header">{{ __('messages.usedcar.title') }}</h4>
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
                                    placeholder="{{ __('messages.usedcar.search') }}..." class="form-control"
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

        <section class="section bg-white" style="padding-bottom: 50px;">
            <div class="container">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            @if ($mobilList->isEmpty())
                                {{-- Tampilkan pesan dari server jika tidak ada data sama sekali --}}
                                <div class="d-flex justify-content-center pb-5">
                                    <div class="text-center">
                                        <img src="{{ asset('assets/images/components/empty.png') }}" height="200"
                                            width="200" alt="No cars">
                                        <p>{{ __('messages.usedcar.no_data') }}.</p>
                                    </div>
                                </div>
                            @else
                                {{-- Data tersedia, tampilkan kartu mobil --}}
                                <div class="row" id="car-list">
                                    @foreach ($mobilList as $car)
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-3 car-card">
                                            <a href="{{ route('usedcar.detail', $car->id_mobil) }}" class="card-event p-3">
                                                @if ($car->fotos && $car->fotos->file_foto_mobil_1)
                                                    <img src="{{ url($car->fotos->file_foto_mobil_1) }}" alt="Car Image"
                                                        class="card-img-top">
                                                @else
                                                    <img src="{{ asset('assets/images/components/image.png') }}"
                                                        alt="Car Image" class="card-img-top">
                                                @endif
                                                <div class="card-body text-start">
                                                    <div class="d-flex align-items-center location-map mt-3">
                                                        <i class='bx bx-map-pin'></i>
                                                        <p class="location ms-2">
                                                            {{ \Illuminate\Support\Str::limit($car->lokasi_mobil, 15) }}</p>
                                                    </div>
                                                    <p class="card-title">
                                                        {{ \Illuminate\Support\Str::limit($car->nama_mobil, 15) }}</p>
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
                                {{-- Pesan filter kosong (hanya dikendalikan JavaScript) --}}
                                <div id="no-result-message" style="display: none; text-align: center; margin-top: 30px;">
                                    <img src="{{ asset('assets/images/components/empty.png') }}" height="200"
                                        width="200" alt="No Result">
                                    <p>{{ __('messages.usedcar.no_filter') }}.</p>
                                </div>
                            @endif

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-4">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        {{-- Previous Page Link --}}
                                        @if ($mobilList->onFirstPage())
                                            <li class="page-item disabled">
                                                <a class="page-link">{{ __('messages.usedcar.previous') }}</a>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a href="{{ $mobilList->previousPageUrl() }}"
                                                    class="page-link">{{ __('messages.usedcar.previous') }}</a>
                                            </li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @foreach ($mobilList->getUrlRange(1, $mobilList->lastPage()) as $page => $url)
                                            @if ($page == $mobilList->currentPage())
                                                <li class="page-item active" aria-current="page">
                                                    <a class="page-link" href="{{ $url }}">{{ $page }}
                                                        <span class="visually-hidden">(current)</span></a>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link"
                                                        href="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endforeach

                                        {{-- Next Page Link --}}
                                        @if ($mobilList->hasMorePages())
                                            <li class="page-item">
                                                <a href="{{ $mobilList->nextPageUrl() }}"
                                                    class="page-link">{{ __('messages.usedcar.next') }}</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <a class="page-link">{{ __('messages.usedcar.next') }}</a>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-body">
                <!-- Brand Section -->
                <div class="offcanvas-header">
                    <h5 class="brand-title">
                        <div class="">
                            <i class='bx bx-car icon-size'></i>
                            {{ __('messages.usedcar.filter.brand') }}
                        </div>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
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
                            {{ __('messages.usedcar.filter.see_all') }}
                        </span>
                    </div>
                </div>

                <!-- Price Section -->
                <div class="offcanvas-header">
                    <h5 class="brand-title">
                        <div class="">
                            <i class='bx bx-money icon-size'></i>
                            {{ __('messages.usedcar.filter.price') }}
                        </div>
                    </h5>
                </div>
                <div id="harga" class="filter-section show">
                    @foreach (__('messages.usedcar.filter.price_range') as $key => $range)
                        <div class="mt-2">
                            <input type="checkbox" name="harga" value="{{ $range }}">
                            <label class="mx-2">{{ $range }}</label>
                        </div>
                    @endforeach
                </div>

                <!-- Usage Section -->
                <div class="offcanvas-header">
                    <h5 class="brand-title">
                        <div class="">
                            <i class='bx bx-time-five icon-size'></i>
                            {{ __('messages.usedcar.filter.usage') }}
                        </div>
                    </h5>
                </div>
                <div id="pemakaian" class="filter-section show">
                    @foreach (__('messages.usedcar.filter.usage_range') as $key => $range)
                        <div class="mt-2">
                            <input type="checkbox" name="pemakaian" value="{{ $range }}">
                            <label class="mx-2">{{ $range }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            const carCards = document.querySelectorAll('.car-card'); // Select all car cards
            const noResultMessage = document.getElementById('no-result-message'); // No result message element

            function filterCars() {
                let anyCardVisible = false; // Flag to check if any card is visible

                carCards.forEach(function(card) {
                    const carBrandElem = card.querySelector('.jenis');
                    const carPriceElem = card.querySelector('.price');
                    const carUsageElem = card.querySelector('.location');

                    // Ensure required elements exist
                    if (!carBrandElem || !carPriceElem || !carUsageElem) {
                        card.style.display = 'none';
                        return;
                    }

                    const carBrand = carBrandElem.textContent.trim();
                    const carPriceText = carPriceElem.textContent.trim();
                    const carUsage = carUsageElem.textContent.trim();

                    const carPrice = parseInt(carPriceText.replace(/[^0-9]/g, ''));

                    let showCard = true;

                    // Filter by brand
                    const selectedBrands = Array.from(document.querySelectorAll(
                        'input[name="nama_merk"]:checked')).map(
                        (input) => input.value
                    );
                    if (selectedBrands.length > 0 && !selectedBrands.includes(carBrand)) {
                        showCard = false;
                    }

                    // Filter by price
                    const selectedPrices = Array.from(document.querySelectorAll(
                        'input[name="harga"]:checked')).map(
                        (input) => input.value
                    );
                    if (selectedPrices.length > 0) {
                        const priceInRange = selectedPrices.some((priceFilter) => {
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
                        'input[name="pemakaian"]:checked')).map(
                        (input) => input.value
                    );
                    if (selectedUsages.length > 0) {
                        const usageInRange = selectedUsages.some((usageFilter) => {
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
                    if (showCard) {
                        card.style.display = 'block';
                        anyCardVisible = true; // Found at least one card
                    } else {
                        card.style.display = 'none';
                    }
                });

                // If no card is visible, show the "no result" message
                noResultMessage.style.display = anyCardVisible ? 'none' : 'block';
            }

            checkboxes.forEach((checkbox) => checkbox.addEventListener('change', filterCars));
            filterCars(); // Initial call to apply any pre-selected filters
        });
    </script>

@endsection
