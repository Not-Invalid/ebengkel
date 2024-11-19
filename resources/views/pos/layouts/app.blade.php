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

    {{-- Boxicons --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    {{-- Aos --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

    {{-- Custom styles --}}
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('template_pos/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('template_pos/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('template_pos/css/app.css') }}">

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
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <img src="{{ asset('assets/images/logo/logo_side.png') }}" alt="" srcset="" />
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Main Menu</li>
                        <li class="sidebar-item">
                            <a href="index.html" class="sidebar-link">
                                <i data-feather="home" width="20"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main">
            <nav class="navbar navbar-header navbar-expand navbar-light">
                <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
                <button class="btn navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav d-flex align-items-center navbar-light ms-auto">
                        <li class="dropdown">
                            <a href="#" data-bs-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <div class="avatar me-1">
                                    <img src="{{ isset($data_pelanggan) && $data_pelanggan->foto_pelanggan ? url($data_pelanggan->foto_pelanggan) : asset('assets/images/components/avatar.png') }}"
                                        alt="Profile Picture" srcset="" />
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#"><i data-feather="user"></i> Account</a>
                                <div class="dropdown-divider"></div>
                                <form id="logout-form" action="{{ route('pos.logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i data-feather="log-out"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            @yield('content')

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

    {{-- Template JS --}}
    <script src="{{ asset('template_pos/js/feather-icons/feather.js') }}"></script>
    <script src="{{ asset('template_pos/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('template_pos/js/app.js') }}"></script>
    <script src="{{ asset('template_pos/js/main.js') }}"></script>
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
