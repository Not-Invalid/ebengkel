@extends('layouts.app')

@section('title')
    eBengkelku | Daftar Event
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/daftar-event.css') }}">
@endpush

@section('content')
    <div class="container daftar">
        <div class="wrapper">
            <h2 class="text-center">{{ __('messages.event.join') }} {{ $event->nama_event }}</h2>
            <form action="{{ route('event.store', ['id' => $event->id_event]) }}" method="POST">
                @csrf
                <div class="input-box">
                    <input type="text" name="nama_peserta" placeholder="{{ __('messages.event.name') }}" required>
                </div>
                <div class="input-box">
                    <input type="email" name="email" placeholder="{{ __('messages.event.email') }}" required>
                </div>
                <div class="input-box">
                    <input type="text" name="no_telepon" placeholder="{{ __('messages.event.phone') }}" required>
                </div>
                <div class="input-box">
                    <input type="text" value="Rp {{ number_format($event->harga, 0, ',', '.') }}" readonly>
                </div>
                <div class="input-box button">
                    <input type="submit" value="{{ __('messages.event.regis') }}">
                </div>
            </form>
        </div>
    </div>
@endsection
