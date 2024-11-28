@extends('pos.layouts.app')

@section('title')
    Ebengkelku | Management Staff - Add
@stop

@php
    $header = 'Management Staff - Add';
@endphp

@section('content')

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                confirmButtonColor: "#3085d6",
                text: '{{ session('success') }}'
            });
        });
    </script>
@endif

<div class="section-body">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header">
                    <h4>Bengkel: {{ $bengkel->nama_bengkel }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('pos.management-user.store', ['id_bengkel' => $bengkel->id_bengkel]) }}" method="POST">
                        @csrf
                        <!-- Nama Pegawai -->
                        <div class="form-group">
                            <label for="nama_pegawai">Nama Pegawai</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai" required value="{{ old('nama_pegawai') }}">
                            </div>
                        </div>

                        <!-- Email Pegawai -->
                        <div class="form-group">
                            <label for="email_pegawai">Email Pegawai</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                </div>
                                <input type="email" class="form-control" id="email_pegawai" name="email_pegawai" required value="{{ old('email_pegawai') }}">
                            </div>
                        </div>

                        <!-- No Telp Pegawai -->
                        <div class="form-group">
                            <label for="telp_pegawai">No Telp Pegawai</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control" id="telp_pegawai" name="telp_pegawai" required value="{{ old('telp_pegawai') }}">
                            </div>
                        </div>

                        <!-- Role Pegawai -->
                        <div class="form-group">
                            <label for="role">Role Pegawai</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-user-tag"></i>
                                    </div>
                                </div>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="" disabled selected hidden>Pilih Role</option>
                                    <option value="Administrator">Administrator</option>
                                    <option value="Kasir">Kasir</option>
                                </select>
                            </div>
                        </div>

                        <!-- Auto-Generated Password (Displayed to user for convenience) -->
                        <div class="form-group">
                            <label for="password_pegawai">Password Pegawai (Generated Automatically)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                </div>
                                <!-- Display the random password here -->
                                <input type="text" class="form-control" id="password_pegawai" name="password_pegawai"
                                    value="{{ $randomPassword }}" readonly>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('pos.management-user', ['id_bengkel' => $bengkel->id_bengkel]) }}" class="btn btn-cancel">Cancel</a>
                            <button type="submit" class="btn btn-custom-icon">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Wait for the DOM to load before adding event listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        function togglePassword() {
            var passwordField = document.getElementById("password_pegawai");
            var toggleButton = document.getElementById("togglePassword");
            var icon = toggleButton.querySelector("i");  // Get the icon element within the button

            // Toggle visibility of the password field
            if (passwordField.type === "text") {
                passwordField.type = "password";  // Change to password to hide it
                icon.classList.remove("fa-eye-slash");  // Remove the eye-slash icon
                icon.classList.add("fa-eye");  // Add the eye icon to show
            } else {
                passwordField.type = "text";  // Change to text to show the password
                icon.classList.remove("fa-eye");  // Remove the eye icon
                icon.classList.add("fa-eye-slash");  // Add the eye-slash icon to hide
            }
        }

        // Attach the togglePassword function to the button click event
        document.getElementById("togglePassword").addEventListener('click', togglePassword);
    });
</script>

@endsection
