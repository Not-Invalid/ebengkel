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

        $bengkel = Bengkel::find($request->id_bengkel);

        if ($bengkel->POS === 'Y') {
            return back()->withErrors([
                'id_bengkel' => 'POS untuk bengkel ini sudah aktif.',
            ]);
        }

        Pegawai::create([
            'id_bengkel' => $request->id_bengkel,
            'nama_pegawai' => $request->nama_pegawai,
            'telp_pegawai' => $request->telp_pegawai,
            'email_pegawai' => $request->email_pegawai,
            'password_pegawai' => Hash::make($request->password_pegawai),
            'role' => 'Outlet',
        ]);

        $bengkel->POS = 'Y';
        $bengkel->save();

        return redirect()->route('pos.login.show', ['id_bengkel' => $request->id_bengkel])
            ->with('status', 'Registrasi berhasil. Silakan login.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email_pegawai' => 'required|email',
            'password_pegawai' => 'required',
            'id_bengkel' => 'required|exists:tb_bengkel,id_bengkel',
        ]);
        $pegawai = Pegawai::where('email_pegawai', $request->email_pegawai)
            ->where('id_bengkel', $request->id_bengkel)
            ->first();

        if (!$pegawai) {
            return back()->withErrors([
                'email_pegawai' => 'Pegawai atau bengkel tidak sesuai.',
            ]);
        }
        if (!Hash::check($request->password_pegawai, $pegawai->password_pegawai)) {
            return back()->withErrors([
                'password_pegawai' => 'Password salah.',
            ]);
        }
        Auth::guard('pegawai')->login($pegawai);
        $request->session()->regenerate();

        return redirect()->route('pos.index', ['id_bengkel' => $request->id_bengkel])
            ->with('status', 'Login berhasil!');
    }

    public function logout(Request $request)
    {
        $idBengkel = $request->input('id_bengkel');

        Auth::guard('pegawai')->logout();

        if ($idBengkel) {
            return redirect()->route('pos.login.show', ['id_bengkel' => $idBengkel])
                ->with('status', 'You have been logged out.');
        }

        return redirect()->route('pos.redirect', ['id_bengkel' => $idBengkel])
            ->with('error_status', 'Bengkel tidak ditemukan.');
    }
}
