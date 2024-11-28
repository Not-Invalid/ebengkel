<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\Bengkel;
use App\Models\Pegawai;

class SettingController extends Controller
{
    public function showChangePassword($id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Bengkel tidak ditemukan.');
        }

        if (Auth::guard('pegawai')->user()->bengkel_id != $bengkel->id) {
            return redirect()->route('pos.dashboard')->with('status_error', 'Akses ke bengkel ini tidak diperbolehkan.');
        }

        return view('pos.settings.changePassword', compact('bengkel'));
    }

    public function updatePassword(Request $request, $id_bengkel)
    {

        $request->validate([
            'currentPassword' => 'required|string|min:6',
            'newPassword' => 'required|string|min:6|confirmed',
        ]);


        $bengkel = Bengkel::find($id_bengkel);
        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Bengkel tidak ditemukan.');
        }


        $pegawai = Auth::guard('pegawai')->user();


        if (!password_verify($request->input('currentPassword'), $pegawai->password_pegawai)) {
            return back()->with('status_error', 'Current password is incorrect.');
        }


        $pegawai->password_pegawai = Hash::make($request->input('newPassword'));
        $pegawai->save();


        Auth::guard('pegawai')->logout();


        session()->invalidate();
        session()->regenerateToken();


        return redirect()->route('pos.login.show', ['id_bengkel' => $bengkel->id_bengkel])->with('status', 'Password successfully updated. Please log in again.');
    }

    public function showLanguageSetting($id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Bengkel tidak ditemukan.');
        }

        if (Auth::guard('pegawai')->user()->bengkel_id != $bengkel->id) {
            return redirect()->route('pos.dashboard')->with('status_error', 'Akses ke bengkel ini tidak diperbolehkan.');
        }

        return view('pos.settings.language', compact('bengkel'));
    }

    public function changeLanguage(Request $request, $id_bengkel)
{
    $request->validate([
        'language' => 'required|in:id,en',
    ]);

    session(['locale' => $request->input('language')]);

    return response()->json([
        'message' => __('message.language_change_success'),
    ]);
}

}
