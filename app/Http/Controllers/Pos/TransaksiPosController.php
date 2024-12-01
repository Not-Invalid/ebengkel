<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\Product;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class TransaksiPosController extends Controller
{
    public function index($id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);
        $queryProduct = Product::where('delete_produk', 'N')->with('bengkel');

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Bengkel tidak ditemukan.');
        }
        $products = $queryProduct->get();

        return view('pos.master-transaksi.pos.index', compact('bengkel', 'products'), ['id_bengkel' => $id_bengkel]);
    }
    public function checkout(Request $request, $id_bengkel)
    {
        $request->validate([
            'id_customer' => 'required|exists:m_pelanggan,id_customer',
            'tanggal' => 'required|date',
            'total_qty' => 'required|numeric',
            'total_harga' => 'required|numeric',
            'status_order' => 'required|string',
        ]);
        $pesanan = Pesanan::create([
            'id_outlet' => $request->id_outlet,
            'id_customer' => $request->id_customer,
            'id_voucher' => $request->id_voucher,
            'tanggal' => $request->tanggal,
            'nama' => $request->nama,
            'tipe' => $request->tipe,
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'no_kartu' => $request->no_kartu,
            'harga' => $request->harga,
            'diskon' => $request->diskon,
            'ppn' => $request->ppn,
            'total_harga' => $request->total_harga,
            'total_qty' => $request->total_qty,
            'nominal_bayar' => $request->nominal_bayar,
            'kembali' => $request->kembali,
            'shift' => $request->shift,
            'is_delete' => 0
        ]);
        return redirect()->route('pos.tranksaksi_pos.index', ['id_bengkel' => $id_bengkel])
            ->with('status', 'Pesanan berhasil ditambahkan.');
    }
}
