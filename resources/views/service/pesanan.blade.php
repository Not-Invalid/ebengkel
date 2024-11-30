@extends('layouts.app')

@section('title')
    eBengkelku | Pesanan Service
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/daftar-event.css') }}">
@endpush

<style>
    .title-header {
        color: var(--main-blue);
        position: relative;
        z-index: 10;
    }

    /* Main Service Image */
    .img-fluid.object-fit-cover {
        object-fit: cover;
        height: 300px;
        border-radius: 10px;
    }

    /* Service Details */
    .fw-bold {
        font-weight: 600;
    }

    /* Price Card */
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .card h5 {
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }

    .text-success {
        font-size: 24px;
        color: #28a745;
    }

    /* Button Styling */
    .btn-primary {
        background-color: #3498db;
        border-color: #3498db;
        color: #fff;
        padding: 12px 20px;
        font-size: 16px;
        text-transform: uppercase;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #2980b9;
        border-color: #2980b9;
    }

    /* Contact Info */
    .row.py-5 {
        padding-top: 40px;
        padding-bottom: 40px;
    }

    .row.py-5 p {
        font-size: 16px;
        color: #333;
        margin-bottom: 15px;
    }

    .row.py-5 i {
        font-size: 20px;
        color: #3498db;
    }

    /* Background Overlay */
    .bg-white {
        opacity: 0.7;
        background-color: #fff;
    }

    .section-white {
        padding-top: 100px;
        padding-bottom: 20px;
    }

    /* Phone and Contact Info */
    .contact-icon {
        margin-right: 10px;
        color: #3498db;
    }
</style>

@section('content')
    <section class="section section-white"
        style="position: relative; overflow: hidden; padding-top: 100px; padding-bottom: 20px;">
        <div
            style="background-image: url('{{ asset('assets/images/bg/wallpaper.png') }}'); background-size: cover; background-position: center; background-attachment: fixed; background-repeat: no-repeat; position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0;">
        </div>
        <div class="bg-white" style="position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0; opacity: 0.7;">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h4 class="title-header">Service Detail</h4>
                </div>
            </div>
        </div>
    </section>

    <div class="container daftar">
        <div class="wrapper">
            {{-- <h2 class="text-center">Registrasi Dirimu untuk memesan Service {{ $service->nama_service }}</h2> --}}
            <form
                action="{{ route('store.pesanan-services', ['id_bengkel' => $id_bengkel, 'id_services' => $id_services]) }}"
                method="POST">
                @csrf
                <div class="input-box">
                    <input type="text" id="nama_pemesan" name="nama_pemesan" placeholder="Enter your name" required>
                </div>

                <div class="input-box">
                    <input type="date" id="tgl_pesanan" name="tgl_pesanan" value="{{ now()->format('Y-m-d') }}" required>
                </div>

                <div class="input-box">
                    <input type="text" id="nama_service" name="nama_service" value="{{ $service->nama_service }}"
                        readonly>
                </div>

                <div class="input-box">
                    <input type="text" id="harga"
                        value="Rp {{ number_format($service->harga_service, 0, ',', '.') }}" readonly>
                </div>

                <div class="input-box button">
                    <input type="submit" value="Pesan Sekarang">
                </div>
            </form>

        </div>
    </div>
@endsection
