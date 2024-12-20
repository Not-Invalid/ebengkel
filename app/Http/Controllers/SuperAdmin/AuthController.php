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

            return redirect()->route('superadmin')->with('status', __('messages-superadmin.toast_superadmin.toast_auth.login2'));
        }

        return back()->withErrors(['email' =>  __('messages-superadmin.toast_superadmin.toast_auth.credentials')])->with('status_error',  __('messages-superadmin.toast_superadmin.toast_auth.erro_login'));
    }

    public function logout()
    {
        Auth::guard('superadmin')->logout();
        return redirect()->route('login-admin')->with('status',  __('messages-superadmin.toast_superadmin.toast_auth.logout'));
    }
}
