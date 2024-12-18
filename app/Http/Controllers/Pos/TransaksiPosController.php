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

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop Not Found.');
        }

        $search = $request->input('search'); // Ambil kata kunci dari input pencarian

        $queryProduct = Product::where('delete_produk', 'N')->with('bengkel');
        $querySparepart = SpareParts::where('delete_spare_part', 'N')->with('bengkel');

        if ($search) {
            // Filter produk berdasarkan nama atau merk
            $queryProduct->where(function ($query) use ($search) {
                $query->where('nama_produk', 'LIKE', "%{$search}%")
                    ->orWhere('merk_produk', 'LIKE', "%{$search}%");
            });

            // Filter sparepart berdasarkan nama atau merk
            $querySparepart->where(function ($query) use ($search) {
                $query->where('nama_spare_part', 'LIKE', "%{$search}%")
                    ->orWhere('merk_spare_part', 'LIKE', "%{$search}%");
            });
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
                'tipe' => 'POS',
                'status' => 'Pending',
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

                if ($item['tipe'] === 'produk') {
                    $orderItemData['id_produk'] = $item['id'];

                    $product = Product::find($item['id']);
                    if ($product) {
                        if ($product->stok_produk < $item['quantity']) {
                            throw new \Exception("Stok produk '{$product->nama_produk}' tidak mencukupi.");
                        }
                        $product->stok_produk -= $item['quantity'];
                        $product->save();
                    }
                } else {
                    $orderItemData['id_spare_part'] = $item['id'];

                    $sparepart = SpareParts::find($item['id']);
                    if ($sparepart) {
                        if ($sparepart->stok_spare_part < $item['quantity']) {
                            throw new \Exception("Stok spare part '{$sparepart->nama_spare_part}' tidak mencukupi.");
                        }
                        $sparepart->stok_spare_part -= $item['quantity'];
                        $sparepart->save();
                    }
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

    public function update(Request $request, $id_bengkel, $id_order)
    {
        $bengkel = Bengkel::find($id_bengkel);
        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found.');
        }

        $order = Order::with('orderItems')->find($id_order);
        if (!$order) {
            return redirect()->back()->with('error_status', 'Order tidak ditemukan.');
        }

        DB::beginTransaction();

        try {
            // Update data
            $order->update([
                'nama_customer' => $request->input('nama_customer', $order->nama_customer),
                'tanggal' => $request->input('tanggal', $order->tanggal),
                'harga' => $request->input('harga', $order->harga),
                'status' => 'Success',
                'diskon' => (float) $request->input('diskon', $order->diskon ?? 0),
                'ppn' => (float) $request->input('ppn', $order->ppn ?? 0),
                'total_harga' => (float) $request->input('total_harga', $order->total_harga),
                'nominal_bayar' => (float) $request->input('nominal_bayar', $order->nominal_bayar ?? 0),
                'kembali' => (float) $request->input('kembali', $order->kembali ?? 0),
                'input_by' => Auth::guard('pegawai')->user()->nama_pegawai,
            ]);

            DB::commit();

            // Redirect with preview URL
            $previewUrl = route('preview.struk', ['id_order' => $id_order]);
            return redirect()->route('pos.tranksaksi_pos.index', ['id_bengkel' => $id_bengkel])
                ->with('status', 'Order berhasil dibuat.')
                ->with('preview_url', $previewUrl);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error_status', 'Terjadi kesalahan saat memperbarui order.');
        }
    }

    public function preview($id_order)
    {
        $order = Order::with('orderItems')->find($id_order);
        if (!$order) {
            abort(404, 'Order tidak ditemukan.');
        }

        return view('pos.master-transaksi.pos.struk', compact('order'));
    }

}
