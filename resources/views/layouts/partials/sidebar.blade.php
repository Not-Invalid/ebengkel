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

    {{-- Boxicons --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />

    {{-- Custom styles --}}
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar_profile.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">


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

    {{-- JavaScript --}}
    @yield('script')

    {{-- sidebar --}}
    <div class="custom">
        <div class="overlay"></div>
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <span class="menu-text">Profile</span>
                </div>
                <button class="toggle-btn">
                    <i class="bx bx-menu"></i>
                </button>
            </div>
            <a href="{{ route('profile.show') }}"
                class="menu-item {{ request()->routeIs('profile.show') ? 'active' : '' }}">
                <i class="bx bx-user"></i>
                <span class="menu-text">Account</span>
            </a>
            <a href="{{ route('profile.address') }}"
                class="menu-item {{ request()->routeIs('profile.address') ? 'active' : '' }}">
                <i class='bx bxs-map'></i>
                <span class="menu-text">Address</span>
            </a>
            <a href="messages.html" class="menu-item">
                <i class='bx bx-building-house'></i>
                <span class="menu-text">Workshop</span>
            </a>
            <a href="settings.html" class="menu-item">
                <i class="bx bx-cog"></i>
                <span class="menu-text">Settings</span>
            </a>
            <a href="{{ route('home') }}" class="menu-item">
                <i class="bx bx-chevron-left"></i>
                <span class="menu-text">Back To Home</span>
            </a>
        </div>


        <main class="content">
            <nav class="navbar shadow">
                <button class="mobile-toggle">
                    <i class="bx bx-menu"></i>
                </button>
                <div class="profile-dropdown">
                    <img src="{{ isset($data_pelanggan) && $data_pelanggan->foto_pelanggan ? url($data_pelanggan->foto_pelanggan) : asset('assets/images/components/avatar.png') }}"alt="Profile Picture"
                        class="profile-pic" onclick="toggleDropdown()" />
                    <div class="dropdown-menu" id="dropdownMenu">
                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
                            <div class="d-flex align-items-center">
                                <i class='bx bx-log-out mx-2'></i> Logout
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

        // Desktop toggle
        toggleBtn.addEventListener("click", () => {
            container.classList.toggle("collapsed");
        });

        // Mobile toggle
        mobileToggle.addEventListener("click", () => {
            sidebar.classList.add("active");
            overlay.style.display = "block";
        });

        // Close sidebar when clicking overlay
        overlay.addEventListener("click", () => {
            sidebar.classList.remove("active");
            overlay.style.display = "none";
        });

        // Add click event to menu items
        const menuItems = document.querySelectorAll(".menu-item");
        menuItems.forEach((item) => {
            item.addEventListener("click", () => {
                menuItems.forEach((i) => i.classList.remove("active"));
                item.classList.add("active");

                // Close sidebar on mobile when menu item is clicked
                if (window.innerWidth < 1024) {
                    sidebar.classList.remove("active");
                    overlay.style.display = "none";
                }
            });
        });

        // Handle resize events
        window.addEventListener("resize", () => {
            if (window.innerWidth >= 1024) {
                overlay.style.display = "none";
                sidebar.classList.remove("active");
            }
        });

        function toggleDropdown() {
            const dropdownMenu = document.getElementById("dropdownMenu");
            dropdownMenu.style.display =
                dropdownMenu.style.display === "block" ? "none" : "block";
        }

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.matches(".profile-pic")) {
                const dropdowns =
                    document.getElementsByClassName("dropdown-menu");
                for (let i = 0; i < dropdowns.length; i++) {
                    const openDropdown = dropdowns[i];
                    if (openDropdown.style.display === "block") {
                        openDropdown.style.display = "none";
                    }
                }
            }
        };
    </script>
</body>

</html>
