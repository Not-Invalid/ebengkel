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
    <h2>Login</h2>
    <form action="#" method="POST">
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
      <div class="input-box button">
        <input type="Submit" value="Register Now">
      </div>
      <div class="text">
        <h3>Don't have an account? <a href="#"> Register</a></h3>
      </div>
    </form>
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
</body>
</html>
