<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
</head>
<body>
    <h1>Password Reset Request</h1>
    <p>Click the link below to reset your password:</p>
    <p><a href="{{ route('reset-password', $token) }}">Reset Password</a></p>

</body>
</html>
