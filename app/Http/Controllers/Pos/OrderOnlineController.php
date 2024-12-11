<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\Invoice;
use App\Models\OrderOnline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderOnlineController extends Controller
{
    public function index(Request $request, $id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found!');
        }

        if (!Auth::guard('pegawai')->check()) {
            return redirect()->route('pos.login');
        }

        // Ambil nilai per page dan status filter dari request
        $perPage = $request->get('per_page', 10);
        $statusOrder = $request->get('status_order', ''); // Ambil status order dari parameter

        $query = OrderOnline::where('id_bengkel', $id_bengkel)
                            ->where('is_delete', 'N')
                            ->with('pelanggan', 'orderItems', 'invoice');

        // Tambahkan filter berdasarkan status_order jika ada
        if ($statusOrder) {
            $query->where('status_order', $statusOrder);
        }

        $orderonline = $query->paginate($perPage);

        $totalEntries = $orderonline->total();
        $start = ($orderonline->currentPage() - 1) * $perPage + 1;
        $end = min($orderonline->currentPage() * $perPage, $totalEntries);

        return view('pos.order.order-online.index', compact('bengkel', 'orderonline', 'start', 'end', 'totalEntries'));
    }


    public function edit($id_bengkel, $order_id)
    {
        // Menemukan bengkel berdasarkan ID
        $bengkel = Bengkel::findOrFail($id_bengkel);

        // Memastikan user sudah login
        if (!Auth::guard('pegawai')->check()) {
            return redirect()->route('pos.login');
        }

        // Menemukan order berdasarkan ID order dan ID bengkel, serta memuat relasi yang dibutuhkan
        $order = OrderOnline::where('order_id', $order_id)
            ->where('id_bengkel', $id_bengkel)
            ->with([
                'invoice',         // Menarik data invoice terkait order
                'orderItems',      // Menarik data order items (produk/sparepart)
                'pelanggan'        // Menarik data pelanggan yang terkait
            ])
            ->firstOrFail();

        // Mengembalikan tampilan 'edit' dengan data yang dibutuhkan
        return view('pos.order.order-online.edit', compact('bengkel', 'order'));
    }

    public function update(Request $request, $id_bengkel, $order_id)
    {
        // Validasi inputan dari form
        $request->validate([
            'status_order' => 'required|string',
            'status_invoice' => 'required|string',
        ]);

        // Menemukan order berdasarkan ID order dan ID bengkel
        $order = OrderOnline::where('order_id', $order_id)
            ->where('id_bengkel', $id_bengkel)
            ->firstOrFail();

        // Menemukan invoice yang terkait dengan order
        $invoice = Invoice::where('id_order', $order->order_id)->firstOrFail();

        // Memperbarui status order pada tabel t_order_online
        $order->update([
            'status_order' => $request->status_order,
        ]);

        // Memperbarui status invoice pada tabel t_invoice
        $invoice->update([
            'status_invoice' => $request->status_invoice,
        ]);

        // Redirect kembali dengan pesan status berhasil
        return redirect()->route('pos.order-online', $id_bengkel)
            ->with('status', 'Order and Invoice updated successfully.');
    }

}
