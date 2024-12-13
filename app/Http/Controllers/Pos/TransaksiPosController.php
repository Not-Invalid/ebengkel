<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SpareParts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $items = $products->map(function ($item) {
            $item->type = 'produk';
            $item->id = $item->id_produk;
            return $item;
        })->concat($spareparts->map(function ($item) {
            $item->type = 'sparepart';
            $item->id = $item->id_spare_part;
            return $item;
        }));

        return view('pos.master-transaksi.pos.index', compact('bengkel', 'items'), ['id_bengkel' => $id_bengkel]);
    }

    public function checkout(Request $request, $id_bengkel)
    {
        $orderData = $request->input('cart');

        if (empty($orderData)) {
            return response()->json(['error' => 'Keranjang belanja kosong.'], 400);
        }

        $totalHarga = 0;
        $totalQty = 0;

        foreach ($orderData as $item) {
            $totalHarga += $item['quantity'] * $item['harga'];
            $totalQty += $item['quantity'];
        }

        DB::beginTransaction();
        try {
            // Save order to t_order
            $order = Order::create([
                'kode_order' => strtoupper(uniqid('ORD')),
                'id_bengkel' => $id_bengkel,
                'total_harga' => $totalHarga,
                'total_qty' => $totalQty,
                'status' => 'Menunggu Pembayaran',
                'jenis_pembayaran' => 'Cash',
                'input_by' => Auth::guard('pegawai')->user()->nama_pegawai,
                'is_delete' => 'N',
            ]);

            foreach ($orderData as $item) {
                $orderItemData = [
                    'id_order' => $order->id_order,
                    'id_bengkel' => $id_bengkel,
                    'qty' => $item['quantity'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['quantity'] * $item['harga'],
                    'tanggal' => now(),
                ];

                // Determine whether the item is a product or spare part
                if ($item['tipe'] === 'produk') {
                    $orderItemData['id_produk'] = $item['id'];
                } else {
                    $orderItemData['id_spare_part'] = $item['id'];
                }

                OrderItem::create($orderItemData);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'redirect' => route('pos.tranksaksi_pos.createPayment', ['id_bengkel' => $id_bengkel, 'id_order' => $order->id_order]),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createPayment($id_bengkel, $id_order)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found!.');
        }
        $order = Order::with('orderItems')->find($id_order);
        if (!$order) {
            return redirect()->back()->with('error_status', 'Order tidak ditemukan.');
        }

        return view('pos.master-transaksi.pos.create', compact('order', 'bengkel'));
    }

}
