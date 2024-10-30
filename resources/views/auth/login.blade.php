@extends('layouts.app')

@section('title', 'Ebengkel | Login')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endpush

@section('content')
<div class="auth-container login">
    <div class="wrapper">
        <h2>Login</h2>
        @if (session('status'))
           <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('login-send') }}" method="POST">
            @csrf
            <div class="input-box">
                <input type="text" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-box">
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                <span class="toggle-password" onclick="togglePasswordVisibility()">
                    <i class="bx bx-show" id="toggle-icon"></i>
                </span>
            </div>
            <div class="forgot">
                <h3><a href="{{ route('forgot-password') }}">Forgot Password</a></h3>
            </div>
            @if ($errors->any())
                <div class="fs-6 text-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <div class="input-box button">
                <input type="submit" value="Login">
            </div>
            <div class="text">
                <h3>Don't have an account? <a href="{{ route('register') }}">Register now</a></h3>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById("password");
        const toggleIcon = document.getElementById("toggle-icon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.classList.replace("bx-show", "bx-hide");
        } else {
            passwordInput.type = "password";
            toggleIcon.classList.replace("bx-hide", "bx-show");
        }
    }
</script>
@endsection
