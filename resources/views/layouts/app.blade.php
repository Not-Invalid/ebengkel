<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Bengkel Service, Spare Part & Smart Tools.">
  <link rel="shortcut icon" href="{{ asset('assets/images/logo/icon.png') }}" type="image/x-icon" />

    {{-- Bootstrap CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">

    {{-- Toastr CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    {{-- Boxicons --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    {{-- Custom styles --}}
    <link rel="stylesheet" href="{{ asset('assets/css/partials.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    {{-- Poppins font --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800">
    @stack('css')
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

    {{-- Header --}}
    <header>
        @include('layouts.partials.navbar')
    </header>

    {{-- Main content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.partials.footer')

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>

    {{-- Toastr JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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

    {{-- UsedCar --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const offcanvas = document.getElementById('offcanvasExample');
            const toggleText = document.getElementById('toggle-other-brands');
            const otherBrands = document.getElementById('other-brands');

            // Event listener for opening the offcanvas
            offcanvas.addEventListener('show.bs.offcanvas', function() {
                // Reset "Lihat Semuanya" text and hide other brands every time sidebar opens
                otherBrands.style.display = 'none';
                toggleText.innerText = 'Lihat Semuanya';

                // Show main sections by setting visibility and height
                const sections = document.querySelectorAll('.filter-section');
                sections.forEach(section => {
                    section.style.opacity = '1';
                    section.style.maxHeight = '500px';
                });
            });

            // Function to toggle visibility of other brands
            window.toggleOtherBrands = function() {
                const isVisible = otherBrands.style.display === 'block';

                // Toggle other brands visibility and update toggle text
                otherBrands.style.display = isVisible ? 'none' : 'block';
                toggleText.innerText = isVisible ? 'Lihat Semuanya' : 'Sembunyikan';
            };

            // Function to toggle individual sections
            window.toggleSection = function(sectionId) {
                const section = document.getElementById(sectionId);
                const chevron = document.getElementById(`chevron-icon-${sectionId}`);
                const isVisible = section.style.opacity === '1';

                // Toggle the clicked section
                if (isVisible) {
                    section.style.opacity = '0';
                    section.style.maxHeight = '0';
                    chevron.style.transform = 'rotate(0deg)'; // Chevron points up
                } else {
                    section.style.opacity = '1';
                    section.style.maxHeight = '500px'; // Adjust to your desired max height
                    chevron.style.transform = 'rotate(180deg)'; // Chevron points down
                }
            };
        });
    </script>

    {{-- Product SparePart --}}
    <script>
        function filterCategory(category) {
            // Dapatkan semua elemen produk
            const items = document.querySelectorAll('.col-12');

            // Loop melalui setiap item dan atur tampilannya
            items.forEach(item => {
                // Jika kategori adalah 'all' atau sesuai dengan kategori item, tampilkan item
                if (category === 'all' || item.getAttribute('data-category') === category) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    </script>
</body>

</html>
