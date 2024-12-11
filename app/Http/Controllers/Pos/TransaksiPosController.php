<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\Product;
use App\Models\SpareParts;
use Illuminate\Http\Request;

class TransaksiPosController extends Controller
{
    public function index(Request $request, $id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);
        $queryProduct = Product::where('delete_produk', 'N')->with('bengkel');
        $querySparepart = SpareParts::where('delete_spare_part', 'N')->with('bengkel');

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop Not Found.');
        }

        $products = $queryProduct->get();
        $spareparts = $querySparepart->get();

        // Gabungkan produk dan sparepart
        $items = $products->map(function ($item) {
            $item->type = 'produk';
            return $item;
        })->concat($spareparts->map(function ($item) {
            $item->type = 'sparepart';
            return $item;
        }));

        if ($request->isMethod('post') && $request->has('checkout')) {
            $orderData = $request->input('orderData');
            $items = $orderData['items'];

            foreach ($items as $item) {
                if ($item['type'] === 'produk') {
                    $product = Product::find($item['id']);
                    if ($product) {
                        if ($product->stok_produk < $item['quantity']) {
                            return redirect()->back()->with('error_status', 'Stok tidak mencukupi untuk produk ' . $product->nama_produk);
                        }
                        $product->stok_produk -= $item['quantity'];
                        $product->save();
                    }
                } elseif ($item['type'] === 'sparepart') {
                    $sparepart = SpareParts::find($item['id']);
                    if ($sparepart) {
                        if ($sparepart->stok_sparepart < $item['quantity']) {
                            return redirect()->back()->with('error_status', 'Stok tidak mencukupi untuk sparepart ' . $sparepart->nama_sparepart);
                        }
                        $sparepart->stok_sparepart -= $item['quantity'];
                        $sparepart->save();
                    }
                }
            }

            return redirect()->route('pos.tranksaksi_pos.showcheckoutpos', ['id_bengkel' => $id_bengkel])
                ->with('success_status', 'Pesanan berhasil dibuat!');
        }

        return view('pos.master-transaksi.pos.index', compact('bengkel', 'items'), ['id_bengkel' => $id_bengkel]);
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
}
