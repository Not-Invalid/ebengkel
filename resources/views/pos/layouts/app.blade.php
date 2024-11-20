<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Bengkel Service, Spare Part & Smart Tools.">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/icon.png') }}" type="image/x-icon" />

    {{-- Toastr CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css"
        integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    {{-- Bootstrap --}}
    <link rel="stylesheet" href="{{ asset('template_pos/modules/bootstrap/css/bootstrap.min.css') }}">

    {{-- Aos --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

    {{-- Custom styles --}}
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('template_pos/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('template_pos/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('template_pos/modules/summernote/summernote-bs4.css') }}">



    {{-- Poppins font --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800">
    @stack('css')
    <style>
        .toast-success {
            background-color: #51A351 !important;
            color: #fff !important;
        }

        .toast-error {
            background-color: #bd362f !important;
            color: #fff !important;
        }
    </style>
    <title>@yield('title')</title>

</head>

<body class="@yield('body-class')">
    {{-- Loader --}}
    <div id="loader">
        <div id="center">
            <center>
                <img src="{{ asset('assets/images/components/loader.gif') }}" style="width: 170px;">
                <p id="message" class="text-info" style="display:none;"></p>
            </center>
        </div>
    </div>

    {{-- JavaScript --}}
    @yield('script')

    {{-- Sidebar --}}
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li>
                            <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                                    class="fas fa-bars"></i></a>
                        </li>
                        <li>
                            <a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                                    class="fas fa-search"></i></a>
                        </li>
                    </ul>
                    <div class="search-element">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                            data-width="250" />
                        <button class="btn" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        <div class="search-backdrop"></div>
                        <div class="search-result">
                            <div class="search-header">Histories</div>
                            <div class="search-item">
                                <a href="#">How to hack NASA using CSS</a>
                                <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                            </div>
                            <div class="search-item">
                                <a href="#">Kodinger.com</a>
                                <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                            </div>
                            <div class="search-item">
                                <a href="#">#Stisla</a>
                                <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                            </div>
                            <div class="search-header">Result</div>
                            <div class="search-item">
                                <a href="#">
                                    <img class="mr-3 rounded" width="30" src="assets/img/products/product-3-50.png"
                                        alt="product" />
                                    oPhone S9 Limited Edition
                                </a>
                            </div>
                            <div class="search-item">
                                <a href="#">
                                    <img class="mr-3 rounded" width="30" src="assets/img/products/product-2-50.png"
                                        alt="product" />
                                    Drone X2 New Gen-7
                                </a>
                            </div>
                            <div class="search-item">
                                <a href="#">
                                    <img class="mr-3 rounded" width="30"
                                        src="assets/img/products/product-1-50.png" alt="product" />
                                    Headphone Blitz
                                </a>
                            </div>
                            <div class="search-header">Projects</div>
                            <div class="search-item">
                                <a href="#">
                                    <div class="search-icon bg-danger text-white mr-3">
                                        <i class="fas fa-code"></i>
                                    </div>
                                    Stisla Admin Template
                                </a>
                            </div>
                            <div class="search-item">
                                <a href="#">
                                    <div class="search-icon bg-primary text-white mr-3">
                                        <i class="fas fa-laptop"></i>
                                    </div>
                                    Create a new Homepage Design
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image"
                                src="rc="{{ isset($data_pelanggan) && $data_pelanggan->foto_pelanggan ? url($data_pelanggan->foto_pelanggan) : asset('assets/images/components/avatar.png') }}""
                                class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user() }}</div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-title">Logged in 5 min ago</div>
                            <a href="features-profile.html" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            </a>
                            <a href="features-settings.html" class="dropdown-item has-icon">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <form id="logout-form" action="{{ route('pos.logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                            <a href="#" class="dropdown-item has-icon text-danger"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="index.html">Stisla</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="index.html">St</a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Dashboard</li>
                        <li>
                            <a class="nav-link"
                                href="{{ route('pos.index', ['id_bengkel' => $bengkel->id_bengkel]) }}"><i
                                    class="fas fa-home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="dropdown ">
                            <a href="" class="nav-link has-dropdown"><i class="fas fa-data"></i><span>Master
                                    Data</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="nav-link"
                                        href="{{ route('pos.menu.index', ['id_bengkel' => $bengkel->id_bengkel]) }}">Menu</a>
                                </li>
                                <li>
                                    <a class="nav-link" href="index.html">Ecommerce Dashboard</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </aside>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    @yield('content')
                </section>
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; {{ now()->year }} eBengkelku - Service, Spare Part & Smart Tools
                    Powered By <a href="https://cnplus.id/" target="_blank" class="text-success">CNPLUS</a>
                </div>
            </footer>
        </div>
    </div>

    {{-- Template JS --}}

    <script src="{{ asset('template_pos/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('template_pos/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('template_pos/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('template_pos/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('template_pos/modules/moment.min.js') }}"></script>
    <script src="{{ asset('template_pos/js/stisla.js') }}"></script>
    <script src="{{ asset('template_pos/js/scripts.js') }}"></script>
    <script src="{{ asset('template_pos/js/custom.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>

    {{-- Aos --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

    {{-- Toastr JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        // Toastr configuration
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        // Display success message
        @if (session('status'))
            toastr.success("{{ session('status') }}");
        @endif

        // Display error message
        @if (session('status_error'))
            toastr.error("{{ session('status_error') }}");
        @endif
    </script>
    {{-- Loader script --}}
    <script>
        function show(value) {
            document.getElementById('loader').style.display = value ? 'block' : 'none';
        }

        function loadPage(URL) {
            show(true);
            location = URL;
        }

        function newTab(URL) {
            window.open(URL, '_blank');
        }
        setTimeout(function() {
            show(false);
        }, 2000);
    </script>

    {{-- Currency format --}}
    <script type="text/javascript">
        function formatRupiah(angka) {
            var number_string = angka.toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? ',' : '';
                rupiah += separator + ribuan.join(',');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }
    </script>
</body>

</html>
