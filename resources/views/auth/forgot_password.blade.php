<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Ebengkel | Login</title> 
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

  </head>
<body>
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
</body>
</html>
