<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetMail;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = Pelanggan::where('email_pelanggan', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password_pelanggan)) {
            Auth::guard('pelanggan')->login($user);
            $request->session()->regenerate();

            Session::put('id_pelanggan', $user->id_pelanggan);

            $logData = [
                'id_pelanggan' => $user->id_pelanggan,
                'tgl_log_pelanggan' => now(),
            ];
            DB::table('tb_log_pelanggan')->insert($logData);

            return redirect()->route('home')->with('status', __('messages.toast.login_success'));
        }

        return back()->withErrors([
            'email' => __('messages.toast.credential'),
        ])->with('status_error', __('messages.toast.login_failed'));
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telp' => 'required|numeric',
            'email' => 'required|email|unique:tb_pelanggan,email_pelanggan',
            'password' => 'required|min:8|confirmed',
        ]);

        Pelanggan::create([
            'nama_pelanggan' => $request->nama,
            'telp_pelanggan' => $request->telp,
            'email_pelanggan' => $request->email,
            'password_pelanggan' => Hash::make($request->password),
            'foto_pelanggan' => asset('assets/images/components/avatar.png'),
        ]);

        return redirect()->route('login')->with('status', __('messages.toast.regis_success'));
    }

    public function logout()
    {
        Auth::guard('pelanggan')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('home')->with('status', __('messages.toast.logout_success'));
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot_password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $pelanggan = Pelanggan::where('email_pelanggan', $request->email)->first();
        if (!$pelanggan) {
            return back()->with('status_error', __('messages.toast.notfound_email'));
        }

        $token = Str::random(60);
        $pelanggan->update(['password_reset_token' => $token]);

        Mail::to($pelanggan->email_pelanggan)->send(new PasswordResetMail($token));

        return redirect()->route('login')->with('status', __('messages.toast.reset_link'));
    }

    public function showResetPasswordForm($token)
    {
        return view('auth.reset_password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $pelanggan = Pelanggan::where('password_reset_token', $request->token)->first();
        if (!$pelanggan) {
            return back()->withErrors(['token' => 'Invalid token'])->with('status_error', __('messages.toast.invalid'));
        }

        $pelanggan->update([
            'password_pelanggan' => Hash::make($request->password),
            'password_reset_token' => null,
        ]);

        return redirect()->route('login')->with('status', __('messages.toast.reset_success'));
    }
}
