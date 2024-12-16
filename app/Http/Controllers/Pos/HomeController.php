<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\Service;
use App\Models\SpareParts;
use App\Models\Product;
use App\Models\OrderOnline;
use App\Models\OrderItemOnline;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index($id_bengkel, Request $request)
    {

        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Bengkel tidak ditemukan.');
        }

        if (!Auth::guard('pegawai')->check()) {
            return redirect()->route('pos.login');
        }

        $periode = $request->input('periode', 'month');
        $startDate = Carbon::now()->startOf($periode);
        $endDate = Carbon::now()->endOf($periode);

        $totalServices = Service::count();
        $totalSpareParts = SpareParts::count();
        $totalProducts = Product::count();
        $totalOrderOnline = OrderOnline::where('id_bengkel', $id_bengkel)
                                        ->whereBetween('tanggal', [$startDate, $endDate])
                                        ->count();

        $orders = OrderOnline::with('orderItems.produk', 'orderItems.sparepart', 'pelanggan', 'bengkel')
                                ->where('id_bengkel', $id_bengkel)
                                ->orderBy('tanggal', 'desc')
                                ->take(6)
                                ->get();

        $salesData = OrderItemOnline::with(['produk', 'sparepart'])
                                    ->whereHas('orderOnline', function ($query) use ($id_bengkel, $startDate, $endDate) {
                                        $query->where('id_bengkel', $id_bengkel)
                                            ->whereBetween('tanggal', [$startDate, $endDate]);
                                    })
                                    ->get();

        $topProducts = $salesData->whereNotNull('id_produk')
            ->groupBy('id_produk')
            ->map(function ($item) {
                return $item->sum('qty');
            })
            ->sortDesc()
            ->take(5);

        $topSpareParts = $salesData->whereNotNull('id_spare_part')
            ->groupBy('id_spare_part')
            ->map(function ($item) {
                return $item->sum('qty');
            })
            ->sortDesc()
            ->take(5);
        return view('pos.index', compact('bengkel', 'totalServices', 'totalSpareParts', 'totalProducts', 'totalOrderOnline',  'orders', 'topProducts', 'topSpareParts', 'periode'));
    }
}
