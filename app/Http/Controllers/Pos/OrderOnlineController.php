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

        $perPage = $request->get('per_page', 10);

        $orderonline = OrderOnline::where('id_bengkel', $id_bengkel)
            ->where('is_delete', 'N')
            ->with('produk', 'sparepart', 'pelanggan')
            ->paginate($perPage);

        $totalEntries = $orderonline->total();
        $start = ($orderonline->currentPage() - 1) * $perPage + 1;
        $end = min($orderonline->currentPage() * $perPage, $totalEntries);

        return view('pos.order-online.index', compact('bengkel', 'orderonline', 'start', 'end', 'totalEntries'));
    }
    public function edit($id_bengkel, $id_order)
    {
        $bengkel = Bengkel::findOrFail($id_bengkel);
        $order = OrderOnline::where('id', $id_order)
            ->where('id_bengkel', $id_bengkel)
            ->with(['invoice', 'produk', 'sparepart', 'pelanggan'])
            ->firstOrFail();

        return view('pos.order-online.edit', compact('bengkel', 'order'));
    }

    public function update(Request $request, $id_bengkel, $id_order)
    {
        $request->validate([
            'status_order' => 'required|string',
            'status_invoice' => 'required|string',
        ]);

        $order = OrderOnline::where('id', $id_order)
            ->where('id_bengkel', $id_bengkel)
            ->firstOrFail();

        $invoice = Invoice::where('id_order', $order->order_id)->firstOrFail();

        $order->update([
            'status_order' => $request->status_order,
        ]);

        // Update Invoice
        $invoice->update([
            'status_invoice' => $request->status_invoice,
        ]);

        return redirect()->route('pos.order-online', $id_bengkel)
            ->with('status', 'Order and Invoice updated successfully.');
    }

}
