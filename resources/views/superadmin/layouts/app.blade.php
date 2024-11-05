<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Bengkel Service, Spare Part & Smart Tools.">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/icon.png') }}" type="image/x-icon" />
    <title>@yield('title')</title>

    {{-- Boxicons --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    {{-- Custom styles --}}
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/compiled/css/app-dark.css') }}">


    {{-- Poppins font --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800">
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

    {{-- sidebar --}}
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="index.html"><img src="{{ asset('assets/images/logo/logo_side.png') }}"
                                    alt="Logo" srcset="" style="height: 50px"></a>
                        </div>
                        <div class="sidebar-toggler  x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class='bx bx-x'></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>
                        <li class="sidebar-item  {{ request()->routeIs('superadmin') ? 'active' : '' }}">
                            <a href="{{ route('superadmin') }}" class='sidebar-link'>
                                <i class='bx bxs-dashboard'></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class='bx bxs-data'></i>
                                <span>Master Data</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item  has-sub">
                                    <a href="#" class="submenu-link">Category</a>
                                    <ul class="submenu submenu-level-2 ">
                                        <li class="submenu-item ">
                                            <a href="ui-multi-level-menu.html" class="submenu-link">Support Center</a>
                                        </li>
                                        <li class="submenu-item ">
                                            <a href="#" class="submenu-link">Mobil</a>
                                        </li>
                                        <li class="submenu-item ">
                                            <a href="#" class="submenu-link">Product & Spare Parts</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="main" class='layout-navbar navbar-fixed'>
            <header>
                <nav class="navbar navbar-expand navbar-light navbar-top">
                    <div class="container-fluid">
                        <a href="#" class="burger-btn d-block">
                            <i class='bx bx-menu-alt-left fs-3'></i>
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <div class="dropdown ms-auto">
                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="user-menu d-flex">
                                        <div class="user-name text-end me-3">
                                            <h6 class="mb-0 text-gray-600">John Ducky</h6>
                                            <p class="mb-0 text-sm text-gray-600">Administrator</p>
                                        </div>
                                        <div class="user-img d-flex align-items-center">
                                            <div class="avatar avatar-md">
                                                <img
                                                    src="{{ isset($data_pelanggan) && $data_pelanggan->foto_pelanggan ? url($data_pelanggan->foto_pelanggan) : asset('assets/images/components/avatar.png') }}">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                                    style="min-width: 11rem;">
                                    <li>
                                        <h6 class="dropdown-header">Hello, John!</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#"><i
                                                class="icon-mid bi bi-box-arrow-left me-2"></i> Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
            <div id="main-content">
                <div class="page-heading">
                    <section class="section">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">About Vertical Navbar</h4>
                            </div>
                            <div class="card-body">
                                @yield('content')
                            </div>
                        </div>
                    </section>
                </div>

            </div>
            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="d-flex justify-content-center">
                        Copyright &copy; {{ now()->year }} eBengkelku - Service, Spare Part & Smart Tools
                        Powered By <a href="https://cnplus.id/" target="_blank" class="text-success">CNPLUS</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="{{ asset('template/assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('template/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('template/assets/compiled/js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>

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
