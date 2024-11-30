<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\PesananService;
use App\Models\OrderOnline;
use Illuminate\Http\Request;

class TransaksiPesananController extends Controller
{
    public function index($id_bengkel, Request $request)
    {
        $bengkel = Bengkel::find($id_bengkel);
        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Bengkel tidak ditemukan.');
        }
        $perPage = $request->get('per_page', 10);

        $orders = PesananService::with('pelanggan')
            ->where('id_bengkel', $id_bengkel)
            ->orderBy('tgl_pesanan', 'desc')
            ->paginate($perPage);

        $totalEntries = $orders->total();
        $start = ($orders->currentPage() - 1) * $perPage + 1;
        $end = min($orders->currentPage() * $perPage, $totalEntries);
        return view('pos.master-transaksi.pesanan.index', compact('bengkel', 'orders', 'totalEntries', 'start', 'end', 'id_bengkel'));
    }

    public function create($id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }

        return view('pos.master-transaksi.pesanan.create', compact('bengkel'));
    }
}
