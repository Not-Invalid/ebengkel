<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Bengkel Service, Spare Part & Smart Tools.">
  <link rel="shortcut icon" href="{{ asset('assets/images/logo/icon.png') }}" type="image/x-icon"  />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="{{ asset('assets/css/partials.css') }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800">
  @stack('css')
</head>

<body class="@yield('body-class')">


  {{-- loader --}}
  <div id="loader">
    <div id="center">
      <center>
        <img src="{{ asset('assets/images/components/loader.gif') }}" style="width: 170px;">
        <p id="message" class="text-info" style="display:none;"></p>
      </center>
    </div>
  </div>
  @yield('script')
  <header>
    @include('layouts.partials.navbar')
  </header>
  <main>
    @yield('content')
  </main>
  @include('layouts.partials.footer')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
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
