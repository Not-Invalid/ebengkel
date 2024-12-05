<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\PesananService;
use Illuminate\Http\Request;

class TransaksiPesananController extends Controller
{
    public function index($id_bengkel, Request $request)
    {
        $bengkel = Bengkel::find($id_bengkel);
        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop Not Found.');
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
    public function store(Request $request, $id_bengkel)
    {
        $request->validate([
            'nama_pemesan'   => 'required|string|max:255',
            'tgl_pesanan'    => 'required|date',
            'telp_pelanggan' => 'required|numeric',
            'nama_service'   => 'required|string|max:255',
            'status'         => 'required|string|max:50',
            'total_pesanan'  => 'required|numeric|min:0',
        ]);

        PesananService::create([
            'id_bengkel'     => $id_bengkel,
            'tgl_pesanan'    => $request->tgl_pesanan,
            'nama_pemesan'   => $request->nama_pemesan,
            'telp_pelanggan' => $request->telp_pelanggan,
            'nama_service'   => $request->nama_service,
            'status'         => $request->status,
            'total_pesanan'  => $request->total_pesanan,
        ]);

        return redirect()->route('pos.tranksaksi_pesanan.index', ['id_bengkel' => $id_bengkel])
            ->with('status', 'Order Successfully Added!');
    }

    public function edit($id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }

        $pesanan = PesananService::where('id_bengkel', $id_bengkel)->first();

        if (!$pesanan) {
            return redirect()->route('pos.tranksaksi_pesanan.index', ['id_bengkel' => $id_bengkel])
                ->with('status_error', 'No orders found for this workshop.');
        }

        return view('pos.master-transaksi.pesanan.edit', compact('bengkel', 'pesanan'));
    }

    public function update(Request $request, $id_bengkel)
    {
        $pesanan = PesananService::where('id_bengkel', $id_bengkel)->first();

        if (!$pesanan) {
            return redirect()->route('pos.tranksaksi_pesanan.index', ['id_bengkel' => $id_bengkel])
                ->with('status_error', 'Pesanan tidak ditemukan.');
        }

        $request->validate([
            'tgl_pesanan'    => 'required|date',
            'nama_pemesan'   => 'required|string|max:255',
            'telp_pelanggan' => 'required|numeric',
            'nama_service'   => 'required|string|max:255',
            'status'         => 'required|string|max:50',
            'total_pesanan'  => 'required|numeric|min:0',
        ]);

        $pesanan->update([
            'tgl_pesanan'    => $request->tgl_pesanan,
            'nama_pemesan'   => $request->nama_pemesan,
            'telp_pelanggan' => $request->telp_pelanggan,
            'nama_service'   => $request->nama_service,
            'status'         => $request->status,
            'total_pesanan'  => $request->total_pesanan,
        ]);

        return redirect()->route('pos.tranksaksi_pesanan.index', ['id_bengkel' => $id_bengkel])
            ->with('status_success', 'Order Updated Successfully.');
    }

    public function delete($id_bengkel)
    {
        $pesanan = PesananService::where('id_bengkel', $id_bengkel)->first();

        if (!$pesanan) {
            return redirect()->route('pos.tranksaksi_pesanan.index', ['id_bengkel' => $id_bengkel])
                ->with('status_error', 'No orders found for this workshop.');
        }

        $pesanan->delete();

        return redirect()->route('pos.tranksaksi_pesanan.index', ['id_bengkel' => $id_bengkel])
            ->with('status_success', 'Order deleted successfully.');
    }
}
