<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>eBengkelku | Super Admin</title>
  <link rel="stylesheet" href="{{ asset('assets/css/superadmin/auth.css') }}" />
  <link rel="shortcut icon" href="{{ asset('assets/images/logo/icon.png') }}" type="image/x-icon" />
</head>
<body>
  <div class="login_form">
    <form action="{{ route('login-admin-send') }}" method="POST">
        @csrf
        <h3>Log in</h3>
        <div class="input_box">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Enter email address" required />
        </div>

        <div class="input_box">
            <div class="password_title">
                <label for="password">Password</label>
                <a href="#">Forgot Password?</a>
            </div>
            <input type="password" name="password" id="password" placeholder="Enter your password" required />
        </div>

        <button type="submit">Log In</button>
    </form>

  </div>
</body>
</html>
