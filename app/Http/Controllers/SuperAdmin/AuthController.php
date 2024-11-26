<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('superadmin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('superadmin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            $lifetime = config('session.lifetime');
            if (is_numeric($lifetime)) {
                session(['expires_at' => now()->addMinutes((int)$lifetime)]);
            } else {
                session(['expires_at' => now()->addMinutes(120)]);
            }

            return redirect()->route('superadmin')->with('status', 'Login successful!');
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.'])->with('status_error', 'Login failed. Please check your credentials.');
    }



    public function logout()
    {
        Auth::guard('superadmin')->logout();
        return redirect()->route('login-admin')->with('status', 'Logout successful!');
    }
}
