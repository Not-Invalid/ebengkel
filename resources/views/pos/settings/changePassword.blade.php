@extends('pos.layouts.app')
@section('title')
    eBengkelku | POS
@stop
@php
    $header = 'Change Password';
@endphp
@section('content')
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('settings.updatePassword', ['id_bengkel' => $bengkel->id_bengkel]) }}" method="POST">
                        @csrf
                        <div class="form-group my-2">
                            <label for="currentPassword" class="form-label">Current Password</label>
                            <input type="password" name="currentPassword" id="currentPassword" class="form-control" placeholder="Enter your current password">
                            @error('currentPassword')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group my-2">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" name="newPassword" id="newPassword" class="form-control" placeholder="Enter new password">
                        </div>
                        <div class="form-group my-2">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" name="newPassword_confirmation" id="confirmPassword" class="form-control" placeholder="Confirm new password">
                            @error('newPassword')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group my-2 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
