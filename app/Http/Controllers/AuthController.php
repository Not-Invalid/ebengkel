<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $pelanggan = Pelanggan::where('email_pelanggan', $request->email)
            ->where('delete_pelanggan', 'N')
            ->first();

        if ($pelanggan && Hash::check($request->password, $pelanggan->password_pelanggan)) {
            Session::put('id_pelanggan', $pelanggan->id_pelanggan);

            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telp' => 'required|numeric',
            'email' => 'required|email|unique:tb_pelanggan,email_pelanggan',
            'password' => 'required|min:8|confirmed',
        ]);

        $pelanggan = Pelanggan::create([
            'nama_pelanggan' => $request->nama,
            'telp_pelanggan' => $request->telp,
            'email_pelanggan' => $request->email,
            'password_pelanggan' => Hash::make($request->password),
            'foto_pelanggan' => 'logos/avatar.png',
        ]);

        return redirect()->route('index')->with('status', 'Registration successful!');
    }

    public function logout()
    {
        Session::forget('id_pelanggan');
        return redirect()->route('login');
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
            return back()->withErrors(['email' => 'Email not found']);
        }

        $token = Str::random(60);
        $pelanggan->update(['password_reset_token' => $token]);

        Mail::to($pelanggan->email_pelanggan)->send(new PasswordResetMail($token));

        return back()->with('status', 'Reset link sent! Please check your email.');
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
            return back()->withErrors(['token' => 'Invalid token']);
        }

        $pelanggan->update([
            'password_pelanggan' => Hash::make($request->password),
            'password_reset_token' => null,
        ]);

        return redirect()->route('login')->with('status', 'Password successfully reset!');
    }
}
