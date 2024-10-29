<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Bengkel Service, Spare Part & Smart Tools.">
  {{-- favicon --}}
  <link rel="apple-touch-icon" sizes="76x76" href="<?= url('logos/icon.png') ?>">
  {{-- bootstrap css --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
  {{-- boxicon --}}
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  {{-- style css --}}
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  {{-- poppins --}}
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800">
</head>

<body>
  {{-- loader --}}
  <div id="loader">
    <div id="center">
      <center>
        <img src="{{ asset('assets/images/components/loader.gif') }}" style="width: 170px;">
        <p id="message" class="text-info" style="display:none;"></p>
      </center>
    </div>
  </div>
  {{-- JavaScript Section --}}
  @yield('script')
  {{-- end JavaScript Section --}}
  {{-- header --}}
  <header>
    @include('layouts.partials.navbar') <!-- Ensure the navbar is included here -->
  </header>
  {{-- end header --}}
  {{-- content --}}
  <main>
    @yield('content')
  </main>
  {{-- end content --}}
  {{-- footer --}}
  @include('layouts.partials.footer')
  {{-- end footer --}}
  {{-- bootstrap js --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  {{-- main js --}}
  {{-- <script src="{{ asset('js/main.js') }}"></script> --}}
  {{-- loader --}}
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
  {{-- end loader --}}
  {{-- cart --}}
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

    $(document).ready(function() {
      $('select').selectize({
        sortField: 'text'
      });

      @if (Session::has('id_pelanggan'))
        $("#countCart").text("{{ $getItem }}");
      @endif
    });

    $('#input-number').maskNumber({
      integer: true
    });
  </script>
  {{-- end cart --}}
</body>

</html>
