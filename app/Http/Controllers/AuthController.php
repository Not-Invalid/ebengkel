<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetMail;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
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

        $pelanggan = Pelanggan::where('email_pelanggan', $request->email)
            ->where('delete_pelanggan', 'N')
            ->first();

        if ($pelanggan && Hash::check($request->password, $pelanggan->password_pelanggan)) {
            Session::put('id_pelanggan', $pelanggan->id_pelanggan);

            // Log the login time
            $logData = [
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'tgl_log_pelanggan' => now(),
            ];
            DB::table('tb_log_pelanggan')->insert($logData);

            return redirect()->route('home')->with('status', 'Login successful!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->with('status_error', 'Login failed. Please check your credentials.');
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

        return redirect()->route('login')->with('status', 'Registration successful!');
    }

    public function logout()
    {
        Session::forget('id_pelanggan');
        return redirect()->route('home')->with('status', 'Logout successful!');
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
            return back()->with('status_error', 'Email not found');
        }

        $token = Str::random(60);
        $pelanggan->update(['password_reset_token' => $token]);

        Mail::to($pelanggan->email_pelanggan)->send(new PasswordResetMail($token));

        return redirect()->route('login')->with('status', 'Reset link sent! Please check your email.');
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
            return back()->withErrors(['token' => 'Invalid token'])->with('status_error', 'Invalid token');
        }

        $pelanggan->update([
            'password_pelanggan' => Hash::make($request->password),
            'password_reset_token' => null,
        ]);

        return redirect()->route('login')->with('status', 'Password successfully reset!');
    }
}
