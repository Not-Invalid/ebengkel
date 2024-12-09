@extends('layouts.app')

@section('title')
    eBengkelku | Reset Password
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endpush

@section('content')

    <div class="auth-container reset-pw">
        <div class="wrapper">
            <h2>{{ __('messages.auth.reset_password') }}</h2>
            <form action="{{ route('reset-password-send') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token ?? '' }}">
                <div class="input-box">
                    <input type="password" id="password" name="password" placeholder="{{ __('messages.auth.password') }}"
                        required>
                    <span class="toggle-password" onclick="togglePasswordVisibility('password', 'toggle-icon1')">
                        <i class="bx bx-hide" id="toggle-icon1"></i>
                    </span>
                </div>
                <div class="input-box">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="{{ __('messages.auth.confirm') }}" required>
                    <span class="toggle-password"
                        onclick="togglePasswordVisibility('password_confirmation', 'toggle-icon2')">
                        <i class="bx bx-hide" id="toggle-icon2"></i>
                    </span>
                </div>
                <div class="input-box button">
                    <input type="submit" value="{{ __('messages.auth.reset_password') }}">
                </div>
            </form>
        </div>
    </div>
    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.replace("bx-hide", "bx-show");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.replace("bx-show", "bx-hide");
            }
        }
    </script>
@endsection
