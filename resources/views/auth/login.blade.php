@extends('layouts.app')

@section('title')
    eBengkelku | Login
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endpush

@section('content')
    <div class="auth-container login">
        <div class="wrapper">
            <h2>{{ __('messages.auth.login') }}</h2>
            <form action="{{ route('login-send') }}" method="POST">
                @csrf
                <div class="input-box">
                    <input type="text" name="email" placeholder="{{ __('messages.auth.email') }}" required>
                </div>
                <div class="input-box">
                    <input type="password" id="password" name="password" placeholder="{{ __('messages.auth.password') }}"
                        required>
                    <span class="toggle-password" onclick="togglePasswordVisibility()">
                        <i class="bx bx-hide" id="toggle-icon"></i>
                    </span>
                </div>
                <div class="forgot">
                    <h3><a href="{{ route('forgot-password') }}">{{ __('messages.auth.forgot') }}</a></h3>
                </div>
                <div class="input-box button">
                    <input type="submit" value="Login">
                </div>
                <div class="text">
                    <h3>{{ __('messages.auth.have account') }} <a
                            href="{{ route('register') }}">{{ __('messages.auth.regis') }}</a></h3>
                </div>
            </form>
        </div>

        <script>
            function togglePasswordVisibility() {
                const passwordInput = document.getElementById("password");
                const toggleIcon = document.getElementById("toggle-icon");

                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    toggleIcon.classList.replace("bx-hide", "bx-show");
                } else {
                    passwordInput.type = "password";
                    toggleIcon.classList.replace("bx-show", "bx-hide");
                }
            }

            // Check if redirected from cart
            window.addEventListener('DOMContentLoaded', (event) => {
                if (sessionStorage.getItem('redirectedFromCart') === 'true') {
                    toastr.warning('Please login to add products to your cart!');
                    sessionStorage.removeItem('redirectedFromCart');
                }
            });
        </script>
    </div>
@endsection
