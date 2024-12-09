<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\Product;
use App\Models\Pesanan;
use App\Models\Order;
use Illuminate\Http\Request;

class TransaksiPosController extends Controller
{
    public function index(Request $request, $id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);
        $queryProduct = Product::where('delete_produk', 'N')->with('bengkel');

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop Not Found.');
        }
        $products = $queryProduct->get();

        if ($request->isMethod('post') && $request->has('checkout')) {
            $orderData = $request->input('orderData');
            $items = $orderData['items'];

            foreach ($items as $item) {
                $product = Product::find($item['id']);
                if ($product) {
                    if ($product->stok_produk < $item['quantity']) {
                        return redirect()->back()->with('error_status', 'Stok tidak mencukupi untuk produk ' . $product->nama_produk);
                    }

                    // Kurangi stok produk
                    $product->stok_produk -= $item['quantity'];
                    $product->save();
                }
            }

            return redirect()->route('pos.tranksaksi_pos.showcheckoutpos', ['id_bengkel' => $id_bengkel])
                ->with('success_status', 'Pesanan berhasil dibuat!');
        }

        return view('pos.master-transaksi.pos.index', compact('bengkel', 'products'), ['id_bengkel' => $id_bengkel]);
    }

    public function showCheckout($id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop Not Found.');
        }

        // Ambil produk tertentu
        $product = Product::where('delete_produk', 'N')->where('id_bengkel', $id_bengkel)->first();

        if (!$product) {
            return redirect()->route('profile.workshop')->with('status_error', 'No product found.');
        }

        return view('pos.master-transaksi.pos.create', compact('bengkel', 'product'));
    }

    public function storeCheckout(Request $request, $id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }

        // Validasi input dari form
        $validated = $request->validate([
            'nama_customer' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'tipe' => 'required|string|in:produk,spare_part',
            'jenis_pembayaran' => 'required|string|in:tunai,kredit',
            'harga' => 'required|numeric',
            'diskon' => 'nullable|numeric',
            'ppn' => 'nullable|numeric',
            'total_harga' => 'required|numeric',
            'total_qty' => 'required|integer',
            'nominal_bayar' => 'required|numeric',
        ]);

        // Menghitung nilai kembali
        $kembali = $request->nominal_bayar - $request->total_harga;

        // Membuat order baru
        $order = new Order();
        $order->id_bengkel = $bengkel->id_bengkel;
        $order->nama_customer = $request->nama_customer;
        $order->tanggal = $request->tanggal;
        $order->tipe = $request->tipe;
        $order->jenis_pembayaran = $request->jenis_pembayaran;
        $order->harga = $request->harga;
        $order->diskon = $request->diskon ?? 0;
        $order->ppn = $request->ppn ?? 0;
        $order->total_harga = $request->total_harga;
        $order->total_qty = $request->total_qty;
        $order->nominal_bayar = $request->nominal_bayar;
        $order->kembali = $kembali;
        $order->save(); // Simpan order ke database

        // Redirect ke halaman transaksi POS dengan status sukses
        return redirect()->route('pos.tranksaksi_pos.index', ['id_bengkel' => $id_bengkel])
            ->with('success_status', 'Pesanan berhasil dibuat!');
    }
}
