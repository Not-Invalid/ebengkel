<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
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

        $orders = OrderOnline::with('pelanggan')
            ->where('id_outlet', $id_bengkel)
            ->where('is_delete', 'N')
            ->orderBy('tanggal', 'desc')
            ->paginate(10); // 10 data per halaman

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
