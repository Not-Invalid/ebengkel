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
    <h2>Forgot Your Password</h2>
    <form action="{{ route('forgot-password-send') }}" method="POST">
    @csrf
      <div class="input-box">
        <input type="text" name="email" placeholder="Enter your email" required>
      </div>
      <div class="input-box button">
        <input type="Submit" value="Send Reset Link">
      </div>
    </form>
  </div>
</div>
@endsection
