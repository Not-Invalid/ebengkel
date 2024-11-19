<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index($id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Bengkel tidak ditemukan.');
        }

        if (!Auth::guard('pegawai')->check()) {
            return redirect()->route('pos.login');
        }

        return view('pos.index', compact('bengkel'));
    }
}
