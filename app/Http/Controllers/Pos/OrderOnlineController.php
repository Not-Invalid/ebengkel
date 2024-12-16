<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\SpareParts;
use App\Models\OrderOnline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        $statusOrder = $request->get('status_order', '');

        $query = OrderOnline::where('id_bengkel', $id_bengkel)
                            ->where('is_delete', 'N')
                            ->with('pelanggan', 'orderItems', 'invoice');

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

        $bengkel = Bengkel::findOrFail($id_bengkel);

        if (!Auth::guard('pegawai')->check()) {
            return redirect()->route('pos.login');
        }

        $order = OrderOnline::where('order_id', $order_id)
            ->where('id_bengkel', $id_bengkel)
            ->with([
                'invoice',
                'orderItems',
                'pelanggan'
            ])
            ->firstOrFail();

        return view('pos.order.order-online.edit', compact('bengkel', 'order'));
    }

    public function update(Request $request, $id_bengkel, $order_id)
    {

        $request->validate([
            'status_order' => 'required|string',
            'status_invoice' => 'required|string',
        ]);

        $order = OrderOnline::where('order_id', $order_id)
            ->where('id_bengkel', $id_bengkel)
            ->with('orderItems')
            ->firstOrFail();

        $invoice = Invoice::where('id_order', $order->order_id)->firstOrFail();

        $isStatusChangedToDikemas = $request->status_order === 'DIKEMAS' && $order->status_order !== 'DIKEMAS';

        try {

            $order->status_order = $request->status_order;
            $order->save();

            $invoice->status_invoice = $request->status_invoice;
            $invoice->save();

            if ($isStatusChangedToDikemas) {
                foreach ($order->orderItems as $item) {
                    if ($item->id_produk) {

                        $product = Product::findOrFail($item->id_produk);

                        if ($product->stok_produk < $item->qty) {
                            throw new \Exception("Insufficient stock for product: {$product->nama_produk}");
                        }

                        $product->stok_produk -= $item->qty;
                        $product->save();
                    } elseif ($item->id_spare_part) {

                        $sparePart = SpareParts::findOrFail($item->id_spare_part);

                        if ($sparePart->stok_spare_part < $item->qty) {
                            throw new \Exception("Insufficient stock for spare part: {$sparePart->nama_spare_part}");
                        }

                        $sparePart->stok_spare_part -= $item->qty;
                        $sparePart->save();
                    }
                }
            }

            return redirect()->route('pos.order-online', $id_bengkel)
                ->with('status', 'Order and Invoice updated successfully.');

        } catch (\Exception $e) {

            Log::error('Order update failed: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

}
