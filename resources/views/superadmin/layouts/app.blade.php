<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Bengkel Service, Spare Part & Smart Tools.">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/icon.png') }}" type="image/x-icon" />
    <title>@yield('title')</title>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- Custom styles --}}
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/extensions/flatpickr/flatpickr.min.css') }}">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

     {{-- Toastr CSS --}}
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

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
                        <div class="sidebar-toggler x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="fas fa-times"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>
                        <li class="sidebar-item {{ request()->routeIs('superadmin') ? 'active' : '' }}">
                            <a href="{{ route('superadmin') }}" class="sidebar-link">
                                <i class="fas fa-grip-horizontal"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item has-sub">
                            <a href="#" class="sidebar-link">
                                <i class="fas fa-database"></i>
                                <span>Master Data</span>
                            </a>
                            <ul class="submenu">
                                <li class="submenu-item has-sub">
                                    <a href="#" class="submenu-link">
                                        <i class="fas fa-list"></i>
                                        Category
                                    </a>
                                    <ul class="submenu submenu-level-2">
                                        <li class="submenu-item">
                                            <a href="{{ route('support-center-category') }}"
                                                class="submenu-link">Support Center</a>
                                        </li>
                                        <li class="submenu-item">
                                            <a href="{{ route('product-sparepart-category') }}" class="submenu-link">Product & Spare Parts</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="submenu-item has-sub">
                                    <a href="#" class="submenu-link">
                                        <i class="fas fa-tags"></i>
                                        Merk
                                    </a>
                                    <ul class="submenu submenu-level-2">
                                        <li class="submenu-item">
                                            <a href="{{ route('merk-mobil') }}" class="submenu-link">Mobil</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="submenu-item has-sub">
                                    <a href="{{ route('workshop-data') }}" class="sidebar-link">
                                        <i class="fas fa-wrench" style="color: #25396f !important;"></i>
                                        Workshop
                                    </a>
                                </li>
                                <li class="submenu-item has-sub">
                                    <a href="{{ route('inbox') }}" class="sidebar-link">
                                        <i class="fas fa-inbox" style="color: #25396f !important;"></i>
                                        Inbox
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('support-center-info') ? 'active' : '' }}">
                            <a href="{{ route('support-center-info') }}" class="sidebar-link">
                                <i class="fas fa-circle-question"></i>
                                <span>Support Center</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('event-data') ? 'active' : '' }}">
                            <a href="{{ route('event-data') }}" class="sidebar-link">
                                <i class="fas fa-bullhorn"></i>
                                <span>Event</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('profile-admin') ? 'active' : '' }}">
                            <a href="{{ route('profile-admin') }}" class="sidebar-link">
                                <i class="fas fa-user"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        @if (Auth::user()->role === 'Administrator')
                        <li class="sidebar-item has-sub">
                            <a href="#" class="sidebar-link">
                                <i class="fas fa-user-gear"></i>
                                <span>Management Users</span>
                            </a>
                            <ul class="submenu">
                                <li class="submenu-item has-sub">
                                    <a href="" class="sidebar-link">
                                        <i class="fas fa-users" style="color: #25396f !important;"></i>
                                        Data Pelanggan
                                    </a>
                                </li>
                                <li class="submenu-item has-sub">
                                    <a href="{{ route('data-staff-admin') }}" class="sidebar-link">
                                        <i class="fas fa-user-tie" style="color: #25396f !important;"></i>
                                        Data Staff Admin
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div id="main" class="layout-navbar navbar-fixed">
            <header>
                <nav class="navbar navbar-expand navbar-light navbar-top">
                    <div class="container-fluid">
                        <a href="#" class="burger-btn d-block">
                            <i class="fas fa-bars fs-3"></i>
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
                                            <h6 class="mb-0 text-gray-600">{{ Auth::user()->name }}</h6>
                                            <p class="mb-0 text-sm text-gray-600">{{ Auth::user()->role ?? 'User' }}</p>
                                        </div>
                                        <div class="user-img d-flex align-items-center">
                                            <div class="avatar avatar-md">
                                                <img src="{{ Auth::user()->foto_profile ?? asset('assets/images/components/avatar-admin.png') }}" alt="User Avatar">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                                    style="min-width: 11rem;">
                                    <li>
                                        <h6 class="dropdown-header">Hello, {{ Auth::user()->name }}!</h6>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile-admin') }}">
                                            <i class="fas fa-user me-2"></i> Profile
                                        </a>
                                    </li>
                                    <li>
                                        <form id="logout-form" action="{{ route('logout-admin') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                        <a class="dropdown-item" href="#"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
            <div id="main-content">
                <div class="page-heading">
                    <section class="section">
                        <div class="">
                            <div class="">
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
                        Powered By <a href="https://cnplus.id/" target="_blank" class="text-success mx-1">CNPLUS</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="{{ asset('template/assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('template/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('template/assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('template/assets/extensions/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('template/assets/static/js/pages/date-picker.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>

    {{-- Toastr JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

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

    <script>
        function updateIconPreview() {
            const iconInput = document.getElementById('icon');
            const iconPreview = document.getElementById('icon-preview');
            const iconClass = iconInput.value.trim();

            iconPreview.className = 'fas fa-' + iconClass;

            if (window.getComputedStyle(iconPreview, ':before').content !== 'none') {
                iconPreview.style.backgroundColor = '#f0f0f0';
            } else {
                iconPreview.style.backgroundColor = '#ffcccc';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const iconInput = document.getElementById('icon');
            iconInput.addEventListener('input', updateIconPreview);

            updateIconPreview();
        });
    </script>
</body>

</html>
