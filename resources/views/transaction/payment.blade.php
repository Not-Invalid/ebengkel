@extends('layouts.app')

@section('title')
    eBengkelku | Payment
@stop

@section('content')
<h1>Silakan Lakukan Pembayaran</h1>

    @if ($snapToken)
        <p>Scan QR Code untuk melakukan pembayaran</p>

        <div id="payment-qr"></div> <!-- Tempat untuk menampilkan QR Code -->

        <!-- Menambahkan Midtrans JS library untuk menampilkan QR Code -->
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}"></script>

        <script type="text/javascript">
            // Menginisialisasi Snap dengan Snap Token yang diberikan
            snap.pay("{{ $snapToken }}", {
                onSuccess: function(result) {
                    alert("Pembayaran berhasil!");
                    // Setelah pembayaran berhasil, arahkan pengguna ke halaman Cart
                    window.location.href = "{{ route('cart.index') }}";
                },
                onPending: function(result) {
                    alert("Pembayaran Anda masih pending.");
                    // Jika pembayaran masih pending, arahkan pengguna ke halaman Cart
                    window.location.href = "{{ route('cart.index') }}";
                },
                onError: function(result) {
                    alert("Pembayaran gagal.");
                    // Jika pembayaran gagal, arahkan pengguna ke halaman Cart
                    window.location.href = "{{ route('cart.index') }}";
                }
            });
        </script>

    @else
        <p>QR Code tidak tersedia.</p>
    @endif

@endsection
