<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/icon.png') }}" type="image/x-icon" />

    <title>eBengkelku | POS</title>

    <link rel="stylesheet" href="{{ asset('assets/css/POS/auth.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>


<body>
    <div class="container">
        <div class="left-side">
            <div class="welcome-text">
                <h2>Create Your Account</h2>
                <p>Sign up to join us and start your journey today.</p>
            </div>
            <div class="copyright">
                &COPY; {{ now()->year }} Ebengkelku. All rights reserved.
            </div>
        </div>

        <div class="right-side">
            <form method="POST" action="{{ route('pos.register') }}" class="login-form" id="loginForm">
                @csrf
                <input type="hidden" name="id_bengkel" value="{{ request('id_bengkel') }}">
                <h3>Sign Up</h3>
                <div class="input-group">
                    <i class="bx bx-user icon"></i>
                    <input type="text" id="text" name="nama_pegawai" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <i class="bx bx-phone icon"></i>
                    <input type="text" id="text" name="telp_pegawai" placeholder="No. Telp" required
                        pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>
                <div class="input-group">
                    <i class="bx bx-envelope icon"></i>
                    <input type="email" id="email" name="email_pegawai" placeholder="Email address" required>
                </div>
                <div class="input-group">
                    <i class="bx bx-lock icon"></i>
                    <input type="password" id="password" name="password_pegawai" class="password-field"
                        placeholder="Password" required>
                    <i class='bx bx-hide eye-icon'></i>
                </div>
                <div class="input-group">
                    <i class="bx bx-lock icon"></i>
                    <input type="password" id="password" name="password_pegawai_confirmation" class="password-field"
                        placeholder="Confirm Password" required>
                    <i class='bx bx-hide eye-icon'></i>
                </div>
                <button type="submit" class="submit-btn">Sign Up</button>
            </form>

        </div>
    </div>

    <script>
        const pwShowHide = document.querySelector(".eye-icon");
        const passwordField = document.querySelector("#password");

        pwShowHide.addEventListener("click", () => {
            if (passwordField.type === "password") {
                passwordField.type = "text";
                pwShowHide.classList.replace("bx-hide", "bx-show");
            } else {
                passwordField.type = "password";
                pwShowHide.classList.replace("bx-show", "bx-hide");
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Toastr configuration
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        @if (session('status'))
            toastr.success("{{ session('status') }}");
        @endif

        @if (session('status_error'))
            toastr.error("{{ session('status_error') }}");
        @endif
    </script>
</body>

</html>
