<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Bengkel Service, Spare Part & Smart Tools.">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/icon.png') }}" type="image/x-icon" />
    <title>@yield('title')</title>

    {{-- Bootstrap CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">

    {{-- Icons --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    {{-- Toastr CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    {{-- Custom styles --}}
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar_profile.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

    {{-- Poppins font --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800">
    @stack('css')
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

    {{-- sidebar --}}
    <div class="custom">
        <div class="overlay"></div>
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <span class="menu-text">{{ __('messages.sidebar.profile') }}</span>
                </div>
                <button class="toggle-btn">
                    <i class="bx bx-menu"></i>
                </button>
            </div>
            <a href="{{ route('profile') }}" class="menu-item {{ request()->is('profile') ? 'active' : '' }}">
                <i class="bx bx-user"></i>
                <span class="menu-text">{{ __('messages.sidebar.account') }}</span>
            </a>
            <a href="{{ route('profile.address') }}"
                class="menu-item {{ request()->is('profile/address*') ? 'active' : '' }}">
                <i class='bx bxs-map'></i>
                <span class="menu-text">{{ __('messages.sidebar.address') }}</span>
            </a>
            <a href="{{ route('profile.workshop') }}"
                class="menu-item {{ request()->is('profile/workshop*') ? 'active' : '' }}">
                <i class='bx bx-building-house'></i>
                <span class="menu-text">{{ __('messages.sidebar.workshop') }}</span>
            </a>
            <a href="{{ route('profile-used-car') }}"
                class="menu-item {{ request()->is('profile/used-car*') ? 'active' : '' }}">
                <i class='bx bx-car'></i>
                <span class="menu-text">{{ __('messages.sidebar.usedcar') }}</span>
            </a>
            <a href="{{ route('my-order.index') }}"
                class="menu-item {{ request()->is('my-order*') ? 'active' : '' }}">
                <i class='bx bx-package'></i>
                <span class="menu-text">{{ __('messages.sidebar.order') }}</span>
            </a>

            <a href="{{ route('profile.setting') }}"
                class="menu-item {{ request()->is('profile/settings*') ? 'active' : '' }}">
                <i class="bx bx-cog"></i>
                <span class="menu-text">{{ __('messages.sidebar.setting') }}</span>
            </a>
            <a href="{{ route('home') }}" class="menu-item">
                <i class="bx bx-chevron-left"></i>
                <span class="menu-text">{{ __('messages.sidebar.back') }}</span>
            </a>
        </div>

        <main class="content">
            <nav class="navbar shadow">
                <button class="mobile-toggle">
                    <i class="bx bx-menu"></i>
                </button>
                <div class="profile-dropdown">
                    <img src="{{ isset($data_pelanggan) && $data_pelanggan->foto_pelanggan ? url($data_pelanggan->foto_pelanggan) : asset('assets/images/components/avatar.png') }}"
                        alt="Profile Picture" class="profile-pic" onclick="toggleDropdown()" />
                    <div class="dropdown-menu" id="dropdownMenu">
                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
                            <div class="d-flex align-items-center">
                                <i class='bx bx-log-out mx-2'></i> {{ __('messages.sidebar.logout') }}
                            </div>
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;"
                                id="logout-form">
                                @csrf
                            </form>
                        </a>
                    </div>
                </div>
            </nav>

            <div class="main">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <script>
        // Toastr configuration
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000"
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

    {{-- sidebar script --}}
    <script>
        const toggleBtn = document.querySelector(".toggle-btn");
        const mobileToggle = document.querySelector(".mobile-toggle");
        const sidebar = document.querySelector(".sidebar");
        const container = document.querySelector(".custom");
        const overlay = document.querySelector(".overlay");

        toggleBtn.addEventListener("click", () => {
            container.classList.toggle("collapsed");
        });

        mobileToggle.addEventListener("click", () => {
            sidebar.classList.add("active");
            overlay.style.display = "block";
        });

        overlay.addEventListener("click", () => {
            sidebar.classList.remove("active");
            overlay.style.display = "none";
        });

        const menuItems = document.querySelectorAll(".menu-item");
        menuItems.forEach((item) => {
            item.addEventListener("click", () => {
                menuItems.forEach((i) => i.classList.remove("active"));
                item.classList.add("active");

                if (window.innerWidth < 1024) {
                    sidebar.classList.remove("active");
                    overlay.style.display = "none";
                }
            });
        });

        window.addEventListener("resize", () => {
            if (window.innerWidth >= 1024) {
                overlay.style.display = "none";
                sidebar.classList.remove("active");
            }
        });

        function toggleDropdown() {
            const dropdownMenu = document.getElementById("dropdownMenu");
            dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
        }

        window.onclick = function(event) {
            if (!event.target.matches(".profile-pic")) {
                const dropdowns = document.getElementsByClassName("dropdown-menu");
                for (let i = 0; i < dropdowns.length; i++) {
                    const openDropdown = dropdowns[i];
                    if (openDropdown.style.display === "block") {
                        openDropdown.style.display = "none";
                    }
                }
            }
        };
    </script>

    @stack('scripts')
</body>

</html>
