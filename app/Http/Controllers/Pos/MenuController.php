<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;

class MenuController extends Controller
{
    public function index($id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Bengkel tidak ditemukan.');
        }
        return view('pos.masterdata-menu.index', compact('bengkel'));
    }
}
