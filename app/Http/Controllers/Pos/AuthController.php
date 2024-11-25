<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\Pegawai;
use App\Models\Pelanggan;
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
        $bengkel = Bengkel::where('id_bengkel', $idBengkel)
            ->where('delete_bengkel', 'N')
            ->firstOrFail();

        $pelanggan = Pelanggan::find($bengkel->id_pelanggan);

        return view('pos.auth.register', [
            'idBengkel' => $idBengkel,
            'emailPelanggan' => $pelanggan ? $pelanggan->email_pelanggan : null,
        ]);
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
            'id_bengkel' => 'required|exists:tb_bengkel,id_bengkel',
            'password_pegawai' => 'required|min:6|confirmed',
        ]);

        $bengkel = Bengkel::findOrFail($request->id_bengkel);
        $idPelanggan = $bengkel->id_pelanggan;

        if ($bengkel->POS === 'Y') {
            return back()->withErrors([
                'id_bengkel' => 'POS untuk bengkel ini sudah aktif.',
            ]);
        }

        $pelanggan = Pelanggan::find($bengkel->id_pelanggan);
        if (!$pelanggan) {
            return back()->withErrors([
                'id_bengkel' => 'Pelanggan terkait tidak ditemukan.',
            ]);
        }

        Pegawai::create([
            'id_bengkel' => $request->id_bengkel,
            'id_pelanggan' => $idPelanggan,
            'nama_pegawai' => $request->nama_pegawai,
            'telp_pegawai' => $request->telp_pegawai,
            'email_pegawai' => $pelanggan->email_pelanggan,
            'password_pegawai' => Hash::make($request->password_pegawai),
            'role' => 'Outlet',
        ]);

        $bengkel->POS = 'Y';
        $bengkel->save();

        return redirect()->route('pos.login.show', [
            'id_bengkel' => $request->id_bengkel,
        ])->with('status', 'Registration Successfull. Please login!.');
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

        $bengkel = Bengkel::find($request->id_bengkel);

        Auth::guard('pegawai')->login($pegawai);
        $request->session()->regenerate();

        return redirect()->route('pos.index', [
            'id_bengkel' => $request->id_bengkel,
        ])->with('status', 'Login Succesfull!');
    }

    public function logout(Request $request)
    {
        $idBengkel = $request->input('id_bengkel');
        $bengkel = $idBengkel ? Bengkel::find($idBengkel) : null;

        Auth::guard('pegawai')->logout();

        if ($bengkel) {
            return redirect()->route('pos.login.show', [
                'id_bengkel' => $idBengkel,
            ])->with('status', 'You have been logged out.');
        }

        return redirect()->route('pos.redirect', ['id_bengkel' => $idBengkel])
            ->with('error_status', 'Bengkel tidak ditemukan.');
    }

}
