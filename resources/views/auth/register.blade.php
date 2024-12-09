@extends('layouts.app')

@section('title')
    eBengkelku | Register
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endpush

@section('content')

    <div class="auth-container register">
        <div class="wrapper">
            <h2>{{ __('messages.auth.register') }}</h2>
            <form action="{{ route('register-send') }}" method="POST">
                @csrf
                <div class="input-box">
                    <input type="text" name="nama" placeholder="{{ __('messages.auth.username') }}" required>
                </div>
                <div class="input-box">
                    <input type="email" name="email" placeholder="{{ __('messages.auth.email') }}" required>
                </div>
                <div class="input-box">
                    <input type="text" name="telp" placeholder="{{ __('messages.auth.phone') }}" required
                        pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>
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
                    <input type="submit" value="{{ __('messages.auth.register') }}">
                </div>
                <div class="text">
                    <h3>{{ __('messages.auth.already') }} <a href="{{ route('login') }}">{{ __('messages.auth.now') }}</a>
                    </h3>
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
