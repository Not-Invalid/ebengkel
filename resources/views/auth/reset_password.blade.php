<h2>Reset Your Password</h2>
<form action="{{ route('reset-password-send') }}" method="POST">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="password" name="password" placeholder="New Password" required>
    <input type="password" name="password_confirmation" placeholder="Confirm New Password" required>
    <button type="submit">Reset Password</button>
</form>
