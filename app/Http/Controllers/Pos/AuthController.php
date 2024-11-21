<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function redirectToPos($idBengkel)
    {
        $bengkel = Bengkel::where('id_bengkel', $idBengkel)
            ->where('delete_bengkel', 'N')
            ->first();

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Bengkel tidak ditemukan.');
        }
        if ($bengkel->POS === 'Y') {
            return redirect()->route('pos.login.show', ['id_bengkel' => $idBengkel]);
        } else {
            return redirect()->route('pos.register.show', ['id_bengkel' => $idBengkel]);
        }
    }

    public function showregister($idBengkel)
    {
        return view('pos.auth.register', compact('idBengkel'));
    }

    public function showlogin($idBengkel)
    {
        return view('pos.auth.login', compact('idBengkel'));
    }
    public function register(Request $request)
    {
        $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'telp_pegawai' => 'required|string|max:15',
            'email_pegawai' => 'required|email|unique:tb_pegawai,email_pegawai',
            'password_pegawai' => 'required|min:6|confirmed',
            'id_bengkel' => 'required|exists:tb_bengkel,id_bengkel',
        ]);

        Pegawai::create([
            'nama_pegawai' => $request->nama_pegawai,
            'telp_pegawai' => $request->telp_pegawai,
            'email_pegawai' => $request->email_pegawai,
            'password_pegawai' => Hash::make($request->password_pegawai),
            'role' => 'Outlet',
        ]);

        $bengkel = Bengkel::find($request->id_bengkel);
        if ($bengkel) {
            $bengkel->POS = 'Y';
            $bengkel->save();
        }

        return redirect()->route('pos.login.show', ['id_bengkel' => $request->id_bengkel])
            ->with('status', 'Registration successful. Please login.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email_pegawai' => 'required|email',
            'password_pegawai' => 'required',
            'id_bengkel' => 'required|exists:tb_bengkel,id_bengkel',
        ]);

        if (Auth::guard('pegawai')->attempt([
            'email_pegawai' => $request->email_pegawai,
            'password' => $request->password_pegawai,
        ])) {
            $request->session()->regenerate();
            return redirect()->route('pos.index', ['id_bengkel' => $request->id_bengkel])
                ->with('status', 'Login successful!');
        }

        return back()->withErrors([
            'email_pegawai' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        Auth::guard('pegawai')->logout();
        return redirect()->route('pos.login.show')->with('status', 'You have been logged out.');
    }
}
