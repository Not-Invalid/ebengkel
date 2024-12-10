@extends('layouts.app')

@section('title')
    eBengkelku | Forgot Password
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endpush

@section('content')
    <div class="auth-container forgot-pw">
        <div class="wrapper">
            <h2>{{ __('messages.auth.forgot_password') }}</h2>
            <form action="{{ route('forgot-password-send') }}" method="POST">
                @csrf
                <div class="input-box">
                    <input type="text" name="email" placeholder="{{ __('messages.auth.email') }}" required>
                </div>
                <div class="input-box button">
                    <input type="Submit" value="{{ __('messages.auth.reset_link') }}">
                </div>
            </form>
        </div>
    </div>
@endsection
