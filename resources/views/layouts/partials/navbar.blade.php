<header class="header-area">
  <div class="navgition navgition-transparent">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="{{ route('home') }}">
              <img src="{{ asset('assets/images/logo/logo_side.png') }}" alt="eBengkelku - Logo" style="width: 150px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarOne"
              aria-controls="navbarOne" aria-expanded="false" aria-label="Toggle navigation">
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
                <li class="nav-item {{ request()->routeIs('event.show') ? 'active' : '' }}">
                  <a href="{{ route('event.show') }}">
                    <i class='bx bx-calendar'></i> Event
                  </a>
                </li>
                <li class="nav-item {{ request()->routeIs('workshop.show') ? 'active' : '' }}">
                  <a href="{{ route('workshop.show') }}">
                    <i class='bx bx-buildings'></i> Workshop
                  </a>
                </li>
                <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                  <a href="{{ route('home') }}">
                    <i class='bx bx-box'></i> Product & Spare Parts
                  </a>
                </li>
                <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                  <a href="{{ route('home') }}">
                    <i class='bx bx-car'></i> Used Car
                  </a>
                </li>
                @if (Session::has('id_pelanggan'))
                  <li class="nav-item">
                    <a href="{{ route('profile.show') }}">
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
                <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                  <a href="{{ route('home') }}">
                    <i class='bx bx-cart'></i>
                    <span class="badge badge-pill badge-danger" id="countCart">
                      0
                    </span>
                  </a>
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
</script>
