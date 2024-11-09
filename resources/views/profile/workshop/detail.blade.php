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
</style>

@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <div class="d-flex justify-content-center h-50 w-50">
                <img src="{{ isset($bengkel) && $bengkel->foto_cover_bengkel ? url($bengkel->foto_cover_bengkel) : asset('assets/images/components/image.png') }}"
                    alt="main image" class="img-fluid main-image object-fit-cover h-50 w-75 rounded" />
            </div>
            <h2>{{ $bengkel->nama_bengkel }}</h2>
            <p>{{ $bengkel->tagline_bengkel }}</p>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card info-event mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <i class='bx bx-calendar text-primary me-2'></i>
                            <span><span class="title-desc fw-semibold">Open Workshop :</span> {{ $bengkel->open_day }} -
                                {{ $bengkel->close_day }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class='bx bx-time text-primary me-2'></i>
                            <span><span class="title-desc fw-semibold">Open time :</span> {{ $bengkel->open_time }} -
                                {{ $bengkel->close_time }}</span>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <i class='bx bx-map text-primary me-2'></i>
                            <span><span class="title-desc fw-semibold">Alamat :</span>{{ $bengkel->alamat_bengkel }}</span>
                        </div>
                        <hr>
                        <p class="mb-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span class="title-desc fw-semibold my-2">Service Available</span>
                                @foreach ($serviceAvailable as $service)
                                    <p class="m-0">{{ $service }}</p>
                                @endforeach
                            </div>

                            <div>
                                <span class="title-desc fw-semibold my-2">Payment Methods</span>
                                @foreach ($paymentMethods as $method)
                                    <p class="m-0">{{ $method }}</p>
                                @endforeach
                            </div>

                        </div>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card info-event mb-4">
                    <div class="card-header title-desc fw-semibold">
                        Hubungi Kami
                    </div>
                    <div class="card-body">
                        <p><i class='bx bxl-whatsapp align-icon me-2'></i>{{ $bengkel->whatsapp }}</p>
                        <p><i class='bx bxl-instagram align-icon me-2'></i>{{ $bengkel->instagram }}</p>
                        <p><i class='bx bxl-tiktok align-icon me-2'></i>{{ $bengkel->tiktok }}</p>
                    </div>
                </div>
            </div>
        </div>

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
                </ul>
                <select class="custom-dropdown shadow">
                    <option value="all" selected>All</option>
                    <option value="service">Service</option>
                    <option value="product">Product</option>
                    <option value="spareparts">Spareparts</option>
                </select>
            </div>

            <div class="tab-content">
                <div class="tab-pane active" id="all">
                    {{-- isi card --}}
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 py-4">
                            <div class="card-product p-3">
                                <img src="{{ asset('assets/images/components/image.png') }}" class="card-img-top"
                                    alt="Workshop Image">
                                <div class="card-body text-start">
                                    <h5 class="card-title">Busi</h5>
                                    <div class="d-flex align-items-center">
                                        <i class='bx bx-box me-1 workshop' style="font-size: 14px"></i>
                                        <span class="workshop" style="font-size: 14px">Cimone Racing</span>
                                    </div>
                                    <div class="mt-3">
                                        <div class="tagline d-flex justify-content-start">
                                            <p>Rp 300.000</p>
                                        </div>
                                    </div>
                                    <div class="footer-card d-flex justify-content-start gap-3">
                                        <a href="" class="btn btn-link" title="Edit">
                                            <i class='bx bx-edit-alt' style="font-size: 1.3rem;"></i>
                                        </a>
                                        <form {{-- action="{{ route('profile.workshop.destroy', ['id_bengkel' => $bengkel->id_bengkel]) }}" --}} method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this workshop?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link" title="Delete">
                                                <i class='bx bx-trash' style="font-size: 1.3rem;"></i>
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="service">
                    {{-- isi card --}}
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 py-4">
                            <div class="card-product p-3">
                                <img src="{{ asset('assets/images/components/image.png') }}" class="card-img-top"
                                    alt="Workshop Image">
                                <div class="card-body text-start">
                                    <h5 class="card-title">Shockbreaker</h5>
                                    <div class="d-flex align-items-center">
                                        <i class='bx bx-box me-1 workshop' style="font-size: 14px"></i>
                                        <span class="workshop" style="font-size: 14px">Cimone Racing</span>
                                    </div>
                                    <div class="mt-3">
                                        <div class="tagline d-flex justify-content-start">
                                            <p>Rp 300.000</p>
                                        </div>
                                    </div>
                                    <div class="footer-card d-flex justify-content-start gap-3">
                                        <a href="" class="btn btn-link" title="Edit">
                                            <i class='bx bx-edit-alt' style="font-size: 1.3rem;"></i>
                                        </a>
                                        <form {{-- action="{{ route('profile.workshop.destroy', ['id_bengkel' => $bengkel->id_bengkel]) }}" --}} method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this workshop?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link" title="Delete">
                                                <i class='bx bx-trash' style="font-size: 1.3rem;"></i>
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="product">
                    {{-- isi card --}}
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 py-4">
                            <div class="card-product p-3">
                                <img src="{{ asset('assets/images/components/image.png') }}" class="card-img-top"
                                    alt="Workshop Image">
                                <div class="card-body text-start">
                                    <h5 class="card-title">Oli</h5>
                                    <div class="d-flex align-items-center">
                                        <i class='bx bx-box me-1 workshop' style="font-size: 14px"></i>
                                        <span class="workshop" style="font-size: 14px">Cimone Racing</span>
                                    </div>
                                    <div class="mt-3">
                                        <div class="tagline d-flex justify-content-start">
                                            <p>Rp 300.000</p>
                                        </div>
                                    </div>
                                    <div class="footer-card d-flex justify-content-start gap-3">
                                        <a href="" class="btn btn-link" title="Edit">
                                            <i class='bx bx-edit-alt' style="font-size: 1.3rem;"></i>
                                        </a>
                                        <form {{-- action="{{ route('profile.workshop.destroy', ['id_bengkel' => $bengkel->id_bengkel]) }}" --}} method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this workshop?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link" title="Delete">
                                                <i class='bx bx-trash' style="font-size: 1.3rem;"></i>
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="spareparts">
                    {{-- isi card --}}
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 py-4">
                            <div class="card-product p-3">
                                <img src="{{ asset('assets/images/components/image.png') }}" class="card-img-top"
                                    alt="Workshop Image">
                                <div class="card-body text-start">
                                    <h5 class="card-title">Velg</h5>
                                    <div class="d-flex align-items-center">
                                        <i class='bx bx-box me-1 workshop' style="font-size: 14px"></i>
                                        <span class="workshop" style="font-size: 14px">Cimone Racing</span>
                                    </div>
                                    <div class="mt-3">
                                        <div class="tagline d-flex justify-content-start">
                                            <p>Rp 300.000</p>
                                        </div>
                                    </div>
                                    <div class="footer-card d-flex justify-content-start gap-3">
                                        <a href="" class="btn btn-link" title="Edit">
                                            <i class='bx bx-edit-alt' style="font-size: 1.3rem;"></i>
                                        </a>
                                        <form {{-- action="{{ route('profile.workshop.destroy', ['id_bengkel' => $bengkel->id_bengkel]) }}" --}} method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this workshop?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link" title="Delete">
                                                <i class='bx bx-trash' style="font-size: 1.3rem;"></i>
                                            </button>
                                        </form>
                                    </div>

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
    </div>

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
