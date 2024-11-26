<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
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
}
