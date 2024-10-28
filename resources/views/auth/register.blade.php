<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Ebengkel | Register</title> 
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <h2>Register</h2>
        <form action="" method="POST">
            @csrf
            <div class="input-box">
                <input type="text" name="nama" placeholder="Enter your name" required>
            </div>
            <div class="input-box">
                <input type="text" name="telp" placeholder="Enter your phone number" required>
            </div>
            <div class="input-box">
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Create password" required>
            </div>
            <div class="input-box">
                <input type="password" name="password_confirmation" placeholder="Confirm password" required>
            </div>
            <div class="policy">
                <input type="checkbox" required>
                <h3>I accept all terms & conditions</h3>
            </div>
            <div class="input-box button">
                <input type="submit" value="Register Now">
            </div>
            <div class="text">
                <h3>Already have an account? <a href="{{ route('login') }}">Login now</a></h3>
            </div>
        </form>
    </div>
</body>
</html>
