<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Bengkel Service, Spare Part & Smart Tools.">
  <link rel="shortcut icon" href="{{ asset('assets/images/logo/icon.png') }}" type="image/x-icon" />
  <title>@yield('title')</title>

  {{-- Bootstrap --}}
  <link rel="stylesheet" href="{{ asset('template_pos/modules/bootstrap/css/bootstrap.min.css') }}" />

  {{-- Toastr CSS --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
    integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  {{-- Font awesome --}}
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

  {{-- Aos --}}
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

  {{-- select2 --}}
  <link href="{{ asset('template_pos/modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" />

  {{-- Css libraries --}}
  <link rel="stylesheet" href="{{ asset('template_pos/modules/jqvmap/dist/jqvmap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('template_pos/modules/weather-icon/css/weather-icons.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('template_pos/modules/weather-icon/css/weather-icons-wind.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('template_pos/modules/summernote/summernote-bs4.css') }}" />

  {{-- Template and Custom css --}}
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
  <link rel="stylesheet" href="{{ asset('template_pos/css/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('template_pos/css/components.css') }}" />

  <!-- Start GA -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag("js", new Date());

    gtag("config", "UA-94034622-3");
  </script>
  <!-- /END GA -->

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

    #toast-container>.toast:before {
      font-family: FontAwesome;
      content: "\f00c";
      margin-right: 10px;
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
              <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a>
            </li>
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <img alt="image"
                src="{{ Auth::guard('pegawai')->user()->foto_pegawai ?? asset('assets/images/components/avatar.png') }}"
                class="rounded-circle mr-1">
              <div class="d-sm-none d-lg-inline-block">
                Hi, {{ Auth::guard('pegawai')->user()->nama_pegawai ?? 'Guest' }}
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="{{ route('profile-pegawai', ['id_bengkel' => $bengkel->id_bengkel, 'id_pegawai' => auth('pegawai')->user()->id_pegawai]) }}"
                class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
              <div class="dropdown-divider"></div>
              <form id="logout-form" action="{{ route('pos.logout') }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="id_bengkel" value="{{ $bengkel->id_bengkel }}">
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
            <a href="{{ route('pos.index', ['id_bengkel' => $bengkel->id_bengkel]) }}">
              <img src="  {{ asset('assets/images/logo/logo_side.png') }}" alt="" style="width: 85%"
                height="45px">
            </a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('pos.index', ['id_bengkel' => $bengkel->id_bengkel]) }}">
              <img src="{{ asset('assets/images/logo/icon.png') }}" alt="" style="height: 50px" width="50px">
            </a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Menu</li>
            <li class="{{ request()->routeIs('pos.index') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('pos.index', ['id_bengkel' => $bengkel->id_bengkel]) }}"><i
                  class="fas fa-home"></i>
                <span>Dashboard</span>
              </a>
            </li>
            <li class="dropdown ">
              <a href="#" class="nav-link has-dropdown"><i class="fas fa-shopping-cart"></i>
                <span>Transaksi</span></a>
              <ul class="dropdown-menu">
                <li class="{{ request()->routeIs('pos.tranksaksi_pos.index') ? 'active' : '' }}">
                  <a class="nav-link"
                    href="{{ route('pos.tranksaksi_pos.index', ['id_bengkel' => $bengkel->id_bengkel]) }}">POS</a>
                </li>
                <li class="{{ request()->routeIs('pos.tranksaksi_pesanan.index') ? 'active' : '' }}">
                  <a class="nav-link"
                    href="{{ route('pos.tranksaksi_pesanan.index', ['id_bengkel' => $bengkel->id_bengkel]) }}">Pesanan</a>
                </li>
              </ul>
            </li>
            <li class="dropdown ">
              <a href="#" class="nav-link has-dropdown"><i class="fas fa-boxes-stacked"></i>
                <span>Management Stock</span></a>
              <ul class="dropdown-menu">
                <li class="{{ request()->routeIs('pos.management-stock.inbound') ? 'active' : '' }}">
                  <a class="nav-link"
                    href="{{ route('pos.management-stock.inbound', ['id_bengkel' => $bengkel->id_bengkel]) }}">Stock
                    Inbound</a>
                </li>
                <li class="{{ request()->routeIs('pos.management-stock.opname') ? 'active' : '' }}">
                  <a class="nav-link"
                    href="{{ route('pos.management-stock.opname', ['id_bengkel' => $bengkel->id_bengkel]) }}">Stock
                    Opname</a>
                </li>
              </ul>
            </li>
            <li class="dropdown ">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-chart-pie"></i>
                  <span>Reports</span></a>
                <ul class="dropdown-menu">
                  <li class="{{ request()->routeIs('pos.achievement-summary') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pos.achievement-summary', ['id_bengkel' => $bengkel->id_bengkel]) }}">Achievement Summary</a>
                  </li>
                  <li class="{{ request()->routeIs('pos.monitoring-stock') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pos.monitoring-stock', ['id_bengkel' => $bengkel->id_bengkel]) }}">Stock Monitoring</a>
                  </li>
                  <li class="{{ request()->routeIs('pos.transaction-history') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pos.transaction-history', ['id_bengkel' => $bengkel->id_bengkel]) }}">Transaction History</a>
                  </li>
                </ul>
            </li>
            <li class="dropdown ">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-calculator"></i>
                  <span>Accounting</span></a>
                <ul class="dropdown-menu">
                  <li class="{{ request()->routeIs('pos.expense-record') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pos.expense-record', ['id_bengkel' => $bengkel->id_bengkel]) }}">Expense Record</a>
                  </li>
                </ul>
            </li>
            <li class="{{ request()->routeIs('profile-pegawai') ? 'active' : '' }}">
              <a href="{{ route('profile-pegawai', ['id_bengkel' => $bengkel->id_bengkel, 'id_pegawai' => auth('pegawai')->user()->id_pegawai]) }}"
                class="nav-link">
                <i class="fas fa-user"></i>
                <span>Profile</span>
              </a>
            </li>
          </ul>
          <ul class="sidebar-menu">
            <li class="menu-header">Master Data</li>
            <li class="{{ request()->routeIs('pos.product.*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('pos.product.index', ['id_bengkel' => $bengkel->id_bengkel]) }}">
                <i class="fas fa-box"></i>
                <span>Product</span>
              </a>
            </li>
            <li class="{{ request()->routeIs('pos.sparepart.*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('pos.sparepart.index', ['id_bengkel' => $bengkel->id_bengkel]) }}">
                <i class="fas fa-cogs"></i>
                <span>Sparepart</span>
              </a>
            </li>
            <li class="{{ request()->routeIs('pos.service.*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('pos.service.index', ['id_bengkel' => $bengkel->id_bengkel]) }}">
                <i class="fas fa-wrench"></i>
                <span>Service</span>
              </a>
            </li>
            <li class="{{ request()->routeIs('pos.expense-type.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pos.expense-type', ['id_bengkel' => $bengkel->id_bengkel]) }}">
                  <i class="fas fa-clipboard-list"></i>
                  <span>Expense Type</span>
                </a>
            </li>
          </ul>

          <ul class="sidebar-menu">
            <li class="menu-header">General</li>
            <li class="{{ request()->routeIs('pos.management-user') ? 'active' : '' }}">
              <a class="nav-link"
                href="{{ route('pos.management-user', ['id_bengkel' => $bengkel->id_bengkel]) }}"><i
                  class="fas fa-users"></i>
                <span>Management Users</span>
              </a>
            </li>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown"><i class="fas fa-gear"></i>
                <span>Settings</span></a>
              <ul class="dropdown-menu">
                <li>
                  <a class="nav-link" href="{{ route('pos.change-password', ['id_bengkel' => $bengkel->id_bengkel]) }}">Change Password</a>
                </li>
                {{-- <li>
                    <a class="nav-link" href="{{ route('pos.language', ['id_bengkel' => $bengkel->id_bengkel]) }}">Language</a>
                </li> --}}
              </ul>
            </li>
          </ul>
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{ $header }}</h1>
          </div>
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

  {{-- General JS --}}
  <script src="{{ asset('template_pos/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('template_pos/modules/popper.js') }}"></script>
  <script src="{{ asset('template_pos/modules/tooltip.js') }}"></script>
  <script src="{{ asset('template_pos/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('template_pos/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('template_pos//modules/moment.min.js') }}"></script>
  <script src="{{ asset('template_pos/js/stisla.js') }}"></script>

  {{-- JS libraries --}}
  <script src="{{ asset('template_pos/modules/simple-weather/jquery.simpleWeather.min.js') }}"></script>
  <script src="{{ asset('template_pos/modules/chart.min.js') }}"></script>
  <script src="{{ asset('template_pos/modules/jqvmap/dist/jquery.vmap.min.js') }}"></script>
  <script src="{{ asset('template_pos/modules/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
  <script src="{{ asset('template_pos/modules/summernote/summernote-bs4.js') }}"></script>
  <script src="{{ asset('template_pos/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

  {{-- Template JS file --}}
  <script src="{{ asset('template_pos/js/scripts.js') }}"></script>
  <script src="{{ asset('template_pos/js/custom.js') }}"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
  <script>
    $(document).ready(function() {
        $('.select2').select2();
    });
  </script>

</body>

</html>
