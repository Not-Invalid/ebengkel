@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Staff User
@stop

@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <h4>Add New Staff</h4>
        <form class="py-4" action="{{ route('data-staff-send') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="name" name="name" />
                        <label class="did-floating-label">Nama Staff</label>
                    </div>
                </div>
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="email" placeholder=" " id="email" name="email" />
                        <label class="did-floating-label">Email</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="phone_number" name="phone_number" />
                        <label class="did-floating-label">No Telepon</label>
                    </div>
                </div>
                <div class="col">
                    <div class="did-floating-label-content">
                        <select class="did-floating-input" id="role" name="role">
                            <option value="" disabled selected>Tentukan Role</option>
                            <option value="Administrator">Administrator</option>
                            <option value="User">User</option>
                        </select>
                        <label class="did-floating-label">Role</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="password" placeholder=" " id="password" name="password" readonly />
                        <label class="did-floating-label">Password</label>
                        <span toggle="#password" class="fa fa-eye field-icon toggle-password position-absolute top-50 end-0 translate-middle-y me-2" style="cursor: pointer;"></span>
                    </div>
                </div>
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="password" placeholder=" " id="password_confirmation" name="password_confirmation" readonly />
                        <label class="did-floating-label">Confirm Password</label>
                    </div>
                </div>
            </div>


            <div class="mt-3 d-flex gap-2">
                <a href="{{ route('data-staff-admin') }}" class="btn btn-cancel ms-2">
                    Cancel
                </a>
                <button type="submit" class="btn btn-custom-icon">
                    <i class='fas fa-floppy-disk fs-6'></i> Save
                </button>
            </div>
        </form>
    </div>

    <script>
        function generatePassword() {
            const prefix = "eBengkel";
            const randomPart = Math.floor(1000 + Math.random() * 9000);
            const password = prefix + randomPart;

            document.getElementById("password").value = password;
            document.getElementById("password_confirmation").value = password;
        }

        window.onload = generatePassword;

        document.querySelector('.toggle-password').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    </script>
@endsection