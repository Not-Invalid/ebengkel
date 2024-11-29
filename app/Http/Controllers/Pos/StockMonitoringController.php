<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bengkel;
use App\Models\Product;
use App\Models\SpareParts;

class StockMonitoringController extends Controller
{
    public function index(Request $request, $id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }

        $type = $request->input('type', '10');
        $perPage = $request->input('per_page', 10);

        if ($type == '10') {

            $items = Product::where('id_bengkel', $id_bengkel)
                            ->where('delete_produk', 'N')
                            ->paginate($perPage);

            $items->getCollection()->transform(function ($item) {
                $item->status = $item->stok_produk <= 20 ? 'Not Available' : 'Available';
                return $item;
            });

        } else {
            $items = SpareParts::where('id_bengkel', $id_bengkel)
                            ->where('delete_spare_part', 'N')
                            ->paginate($perPage);

            $items->getCollection()->transform(function ($item) {
                $item->status = $item->stok_spare_part <= 20 ? 'Not Available' : 'Available';
                return $item;
            });
        }

        $totalEntries = $items->total();
        $start = ($items->currentPage() - 1) * $perPage + 1;
        $end = min($items->currentPage() * $perPage, $totalEntries);

        return view('pos.reports.stockmonitoring', compact('bengkel', 'items', 'type', 'totalEntries', 'start', 'end'));
    }
}
