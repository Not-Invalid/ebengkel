@extends('layouts.partials.sidebar')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/workshop.css') }}">
@endpush

@section('title')
    eBengkelku | Workshop Detail
@stop

<style>
    .custom-tab-link {
        color: #000;
        font-weight: 600;
        text-align: center;
        /* Center the text */
        text-decoration: none;
        padding: 1.2rem 2rem;
        /* Adjust padding for better alignment */
        position: relative;
        cursor: pointer;
        display: block;
        transition: color 0.3s ease;
    }

    .custom-tabs {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
        margin: 0;
        border-radius: 10px;
        background-color: white;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .custom-tab-item {
        margin-bottom: -1px;
        position: relative;
    }

    .custom-tab-item::after {
        content: "";
        position: absolute;
        right: 0;
        top: 15%;
        height: 70%;
        width: 0.1px;
        background-color: #d7e2ee;
    }

    .custom-tab-item:last-child::after {
        display: none;
    }

    .custom-tab-link::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%) scaleX(0);
        /* Center underline */
        width: 50%;
        height: 2px;
        background-color: var(--main-blue);
        transition: transform 0.3s ease;
    }

    .custom-tab-link.active {
        color: #000;
    }

    .custom-tab-link.active::after {
        transform: translateX(-50%) scaleX(1);
        /* Show underline when active */
    }

    .custom-tabs-container {
        position: relative;
    }

    .custom-dropdown {
        display: none;
        width: 100%;
        padding: 1rem;
        font-size: 1rem;
        border-radius: 10px;
        border: none;
        background-color: white;
        outline: none;
    }

    .custom-dropdown:focus,
    .custom-dropdown:active {
        border: none;
    }

    .align-icon {
        font-size: 1.2em;
        margin-left: 5px;
        vertical-align: middle;
    }
</style>

@section('content')
    <section class="mt-5">
        <div class="py-3">
            <div class="container">
                <div class="d-flex justify-content-between">
                    <nav class="pt-3"
                        style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                        aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="nav-link d-inline-flex align-items-center"
                                    href="{{ route('profile.workshop') }}">{{ __('messages.sidebar.workshop') }}</a></li>
                            <li class="breadcrumb-item active d-inline-flex align-items-center" aria-current="page">
                                {{ $bengkel->nama_bengkel }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <div class="w-100 shadow-lg bg-light rounded " style="padding: 1rem">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <div class="position-relative" style="max-width: 600px; margin: auto;">
                <!-- Main Cover Image -->
                <div class="cover-container">
                    <img src="{{ isset($bengkel) && $bengkel->foto_cover_bengkel ? url($bengkel->foto_cover_bengkel) : asset('assets/images/components/image.png') }}"
                        alt="Main Cover Image" class="img-fluid object-fit-cover rounded w-100"
                        style="max-height: 300px;" />
                </div>

                <!-- Profile Image Overlay -->
                <div class="position-absolute" style="bottom: -50px; left: 50%; transform: translateX(-50%);">
                    <img src="{{ isset($bengkel) && $bengkel->foto_bengkel ? url($bengkel->foto_bengkel) : asset('assets/images/components/image.png') }}"
                        alt="Profile Image" class="rounded-circle border border-white"
                        style="width: 120px; height: 120px; object-fit: cover;" />
                </div>
            </div>


            <h2 class="mt-5 pt-3">{{ $bengkel->nama_bengkel }}</h2>
            <p>{{ $bengkel->tagline_bengkel }}</p>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card info-event mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <i class='bx bx-calendar text-primary me-2'></i>
                            <span><span class="title-desc fw-semibold">{{ __('messages.profile.workshop.fields.open_day') }}
                                    : <span>{{ __('messages.profile.workshop.fields.day.' . $bengkel->open_day) }} -
                                        {{ __('messages.profile.workshop.fields.day.' . $bengkel->close_day) }}</span></span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class='bx bx-time text-primary me-2'></i>
                            <span><span class="title-desc fw-semibold">{{ __('messages.profile.workshop.detail.time') }}
                                    :</span> {{ $bengkel->open_time }} -
                                {{ $bengkel->close_time }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class='bx bx-map text-primary me-2'></i>
                            <span><span class="title-desc fw-semibold">{{ __('messages.profile.workshop.detail.address') }}
                                    :</span>
                                {{ $bengkel->alamat_bengkel }}</span>
                        </div>
                        <hr>
                        <p class="mb-4">
                        <div class="row d-flex justify-content-between">
                            <div class="col-lg-6 mb-3">
                                <div>
                                    <span
                                        class="title-desc fw-semibold">{{ __('messages.profile.workshop.detail.services') }}:</span>
                                    @foreach ($serviceAvailable as $service)
                                        <p><i class='bx bx-check-circle align-icon fs-5 m-0'
                                                style="color: var(--main-green)"></i>
                                            {{ $service }}</p>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div>
                                    <span
                                        class="title-desc fw-semibold">{{ __('messages.profile.workshop.detail.payment_methods') }}:</span>
                                    @foreach ($paymentMethods as $method)
                                        <p><i class='bx bx-check-circle align-icon fs-5 m-0'
                                                style="color: var(--main-green)"></i>
                                            {{ $method }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card info-event mb-4">
                    <div class="card-header title-desc fw-semibold">
                        {{ __('messages.profile.workshop.detail.contact') }}
                    </div>
                    <div class="card-body">
                        <p><i class='bx bxl-whatsapp align-icon me-2' style="color: var(--main-green)"></i>
                            {{ $bengkel->whatsapp }}
                        </p>
                        <p><i class='bx bxl-instagram align-icon me-2' style="color: #833ab4"></i>
                            {{ $bengkel->instagram }}
                        </p>
                    </div>
                </div>
                <a href="{{ route('pos.redirect', ['id_bengkel' => $bengkel->id_bengkel]) }}" target="_blank"
                    class="btn btn-custom-2 w-100">
                    {{ __('messages.profile.workshop.detail.connect') }}
                </a>
            </div>
        </div>
    </div>

    <section class="mt-5">
        <div class="custom-tabs-container">
            <ul class="custom-tabs shadow text-center">
                <li class="custom-tab-item">
                    <a class="custom-tab-link active" data-tab="service">
                        {{ __('messages.profile.workshop.detail.service') }}
                    </a>
                </li>
                <li class="custom-tab-item">
                    <a class="custom-tab-link" data-tab="product">
                        {{ __('messages.profile.workshop.detail.product') }}
                    </a>
                </li>
                <li class="custom-tab-item">
                    <a class="custom-tab-link" data-tab="spareparts">
                        {{ __('messages.profile.workshop.detail.sparepart') }}
                    </a>
                </li>
            </ul>
            <select class="custom-dropdown shadow">
                <option value="service" selected>{{ __('messages.profile.workshop.detail.service') }}</option>
                <option value="product">{{ __('messages.profile.workshop.detail.product') }}</option>
                <option value="spareparts">{{ __('messages.profile.workshop.detail.sparepart') }}</option>
            </select>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="service">
                <div class="d-flex justify-content-between align-items-center mt-5">
                    <h4 class="fs-5">{{ __('messages.profile.workshop.detail.your_service') }}</h4>

                </div>
                {{-- isi card --}}
                <div class="row">
                    @forelse ($services as $service)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 py-4">
                            <div class="card-product p-3">
                                <img src="{{ isset($service) && $service->foto_services ? url($service->foto_services) : asset('assets/images/components/image.png') }}"
                                    class="card-img-top" alt="Service Image">
                                <div class="card-body text-start my-4">
                                    <h5 class="card-title">{{ $service->nama_services }}</h5>
                                    <div class="mt-3">
                                        <div class="price d-flex justify-content-start">
                                            <span
                                                class="price">{{ 'Rp' . number_format($service->harga_services ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card-body d-flex justify-content-center pb-5">
                            <div class="text-center">
                                <img src="{{ asset('assets/images/components/empty.png') }}" height="200"
                                    width="200" alt="No services">
                                <p>{{ __('messages.profile.workshop.detail.no_data') }}.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="tab-pane" id="product">
                <div class="d-flex justify-content-between align-items-center mt-5">
                    <h4 class="fs-5">{{ __('messages.profile.workshop.detail.your_product') }}</h4>

                </div>
                {{-- isi card --}}
                <div class="row">
                    @forelse ($produk as $item)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 py-4">
                            <div class="card-product p-3">
                                <img src="{{ isset($item) && $item->foto_produk ? url($item->foto_produk) : asset('assets/images/components/image.png') }}"
                                    class="card-img-top" alt="Product Image">
                                <div class="card-body text-start my-4">
                                    <h5 class="card-title">{{ $item->nama_produk }}</h5>
                                    <div class="mt-3">
                                        <div class="price d-flex justify-content-start">
                                            <span
                                                class="price">{{ 'Rp' . number_format($item->harga_produk ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card-body d-flex justify-content-center pb-5">
                            <div class="text-center">
                                <img src="{{ asset('assets/images/components/empty.png') }}" height="200"
                                    width="200" alt="No services">
                                <p>{{ __('messages.profile.workshop.detail.no_data') }}.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="tab-pane" id="spareparts">
                {{-- isi card --}}
                <div class="d-flex justify-content-between align-items-center mt-5">
                    <h4 class="fs-5">{{ __('messages.profile.workshop.detail.your_sparepart') }}</h4>
                </div>
                {{-- isi card --}}
                <div class="row">
                    @forelse ($sparepart as $item)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 py-4">
                            <div class="card-product p-3">
                                <img src="{{ isset($item) && $item->foto_spare_part ? url($item->foto_spare_part) : asset('assets/images/components/image.png') }}"
                                    class="card-img-top" alt="Product Image">
                                <div class="card-body text-start my-4">
                                    <h5 class="card-title">{{ $item->nama_spare_part }}</h5>
                                    <div class="mt-3">
                                        <div class="price d-flex justify-content-start">
                                            <span
                                                class="price">{{ 'Rp' . number_format($item->harga_spare_part ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card-body d-flex justify-content-center pb-5">
                            <div class="text-center">
                                <img src="{{ asset('assets/images/components/empty.png') }}" height="200"
                                    width="200" alt="No spareparts">
                                <p>{{ __('messages.profile.workshop.detail.no_data') }}.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

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
@endsection
