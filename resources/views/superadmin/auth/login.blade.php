<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>eBengkelku | Super Admin</title>

  <link rel="stylesheet" href="{{ asset('assets/css/superadmin/auth.css') }}">
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
  <section class="container forms">
    <div class="form login">
      <div class="form-content">
        <header>Login</header>
        <form action="{{ route('login-admin-send') }}" method="POST">
          @csrf
          <div class="field input-field">
            <input type="email" name="email" placeholder="Email" class="input">
          </div>

          <div class="field input-field">
            <input type="password" name="password" placeholder="Password" class="password">
            <i class='bx bx-hide eye-icon'></i>
          </div>

          <div class="field button-field">
            <button>Login</button>
          </div>
        </form>
      </div>
    </div>

    <script>
      const forms = document.querySelector(".forms"),
            pwShowHide = document.querySelectorAll(".eye-icon");

      pwShowHide.forEach(eyeIcon => {
          eyeIcon.addEventListener("click", () => {
              let pwFields = eyeIcon.parentElement.parentElement.querySelectorAll(".password");

              pwFields.forEach(password => {
                  if (password.type === "password") {
                      password.type = "text";
                      eyeIcon.classList.replace("bx-hide", "bx-show");
                      return;
                  }
                  password.type = "password";
                  eyeIcon.classList.replace("bx-show", "bx-hide");
              });
          });
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
