<header class="header-area">
    <div class="navgition navgition-transparent">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand" href="{{ route('home') }}">
                            <img src="{{ asset('assets/images/logo/logo_side.png') }}" alt="eBengkelku - Logo"
                                style="width: 150px;">
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarOne" aria-controls="navbarOne" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse sub-menu-bar" id="navbarOne">
                            <ul class="navbar-nav m-auto">
                                <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                                    <a href="{{ route('home') }}">
                                        <i class='bx bx-home'></i> Home
                                    </a>
                                </li>
                                <li class="nav-item {{ request()->is('event*') ? 'active' : '' }}">
                                    <a href="{{ route('event.show') }}">
                                        <i class='bx bx-calendar'></i> Event
                                    </a>
                                </li>
                                <li class="nav-item {{ request()->is('workshop*') ? 'active' : '' }}">
                                    <a href="{{ route('workshop.show') }}">
                                        <i class='bx bx-buildings'></i> Workshop
                                    </a>
                                </li>
                                <li class="nav-item {{ request()->is('ProductsSparePart*') ? 'active' : '' }}">
                                    <a href="{{ route('ProductSparePart') }}">
                                        <i class='bx bx-box'></i> Product & Spare Parts
                                    </a>
                                </li>
                                <li class="nav-item {{ request()->is('used-car*') ? 'active' : '' }}">
                                    <a href="{{ route('used-car') }}">
                                        <i class='bx bx-car'></i> Used Car
                                    </a>
                                </li>
                                @if (auth('pelanggan')->check())
                                    <li class="nav-item">
                                        <a href="{{ route('profile') }}">
                                            <i class='bx bx-user'></i> Profile
                                        </a>
                                    </li>
                                @else
                                    <li class="nav-item {{ request()->routeIs('login') ? 'active' : '' }}">
                                        <a href="{{ route('login') }}">
                                            <i class='bx bx-log-in'></i> Login
                                        </a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a href="{{ route('cart.index') }}">
                                        <i class='bx bx-cart'></i>
                                        <span class="badge badge-cart badge-pill" id="countCart">
                                            0
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" id="languageDropdown" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bx bx-world"></i>
                                        <span
                                            id="activeLanguage">{{ app()->getLocale() === 'id' ? 'ID' : 'EN' }}</span>
                                        <!-- Menampilkan bahasa aktif -->
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown"
                                        style="padding: 12px !important">
                                        <li>
                                            <a href="{{ route('change-language', 'en') }}"
                                                class="{{ session('locale') === 'en' ? 'active' : '' }}"
                                                style="padding: 8px !important">EN</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('change-language', 'id') }}"
                                                class="{{ session('locale') === 'id' ? 'active' : '' }}"
                                                style="padding: 8px !important">ID</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>


<script>
    window.onscroll = function() {
        var header = document.querySelector('.navgition');
        var sticky = header.offsetTop;

        if (window.pageYOffset > sticky) {
            header.classList.add('sticky');
        } else {
            header.classList.remove('sticky');
        }
    };

    window.onload = function() {
    // Fetch the cart count when the page loads
    fetch('{{ route("cart.getCartCount") }}')
        .then(response => response.json())
        .then(data => {
            // Update the cart count in the navbar
            document.getElementById('countCart').textContent = data.count;
        })
        .catch(error => {
            console.error('Error fetching cart count:', error);
        });
};

</script>

