<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bengkel;

class TransactionHistoryController extends Controller
{
    public function index(Request $request, $id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }

        return view('pos.reports.transaction-history.index', compact('bengkel'));
    }
}
