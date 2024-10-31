@extends('layouts.partials.sidebar')

@section('title')
    eBengkelku | Profile
@stop

@section('content')
    <div class="w-100">
        <h1>Profil Pelanggan</h1>
        <div class="row">
            <div class="col">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder=" " id="name"
                        value="{{ $data_pelanggan->nama_pelanggan }}" readonly />

                    <label class="did-floating-label">Full Name</label>
                </div>
            </div>
            <div class="col">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="email" placeholder=" " id="name"
                        value="{{ $data_pelanggan->email_pelanggan }}" readonly />

                    <label class="did-floating-label">Email</label>
                </div>
            </div>
        </div>

        <div class="did-floating-label-content">
            <input class="did-floating-input" type="text" placeholder=" " id="name"
                value="{{ $data_pelanggan->telp_pelanggan }}" readonly />

            <label class="did-floating-label">No. Telp</label>
        </div>
        @if ($data_pelanggan->foto_pelanggan)
            <img src="{{ asset('path/to/images/' . $data_pelanggan->foto_pelanggan) }}" alt="Foto Pelanggan">
        @endif
    </div>
@endsection
