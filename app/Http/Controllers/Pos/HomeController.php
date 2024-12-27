<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\Service;
use App\Models\SpareParts;
use App\Models\Product;
use App\Models\OrderOnline;
use App\Models\OrderItemOnline;
use App\Models\OrderItem;
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

        $periodeProduk = $request->input('periodeProduk', 'month');
        $periodeSpareParts = $request->input('periodeSpareParts', 'month');

        $startDateProduk = Carbon::now()->startOf($periodeProduk);
        $endDateProduk = Carbon::now()->endOf($periodeProduk);

        $startDateSpareParts = Carbon::now()->startOf($periodeSpareParts);
        $endDateSpareParts = Carbon::now()->endOf($periodeSpareParts);

        $totalServices = Service::count();
        $totalSpareParts = SpareParts::count();
        $totalProducts = Product::count();
        $totalOrderOnline = OrderOnline::where('id_bengkel', $id_bengkel)
                                        ->whereBetween('tanggal', [$startDateProduk, $endDateProduk])
                                        ->count();

        $orders = OrderOnline::with('orderItems.produk', 'orderItems.sparepart', 'pelanggan', 'bengkel')
                             ->where('id_bengkel', $id_bengkel)
                             ->orderBy('tanggal', 'desc')
                             ->take(6)
                             ->get();

                             $salesDataOnline = OrderItemOnline::with(['produk', 'sparepart'])
                             ->whereHas('orderOnline', function ($query) use ($id_bengkel, $startDateProduk, $endDateProduk) {
                                 $query->where('id_bengkel', $id_bengkel)
                                       ->where('status_order', 'SELESAI')
                                       ->whereBetween('tanggal', [$startDateProduk, $endDateProduk]);
                             })
                             ->get();

    $salesDataOffline = OrderItem::with(['produk', 'sparepart'])
                        ->whereHas('order', function ($query) use ($id_bengkel, $startDateProduk, $endDateProduk) {
                            $query->where('id_bengkel', $id_bengkel)
                                  ->where('status', 'SUCCESS')
                                  ->whereBetween('tanggal', [$startDateProduk, $endDateProduk]);
                        })
                        ->get();

        $salesDataOnlineProducts = $salesDataOnline->whereNotNull('id_produk');
        $salesDataOfflineProducts = $salesDataOffline->whereNotNull('id_produk');


        $salesDataOnlineSpareParts = $salesDataOnline->whereNotNull('id_spare_part');
        $salesDataOfflineSpareParts = $salesDataOffline->whereNotNull('id_spare_part');


        $topProductsOnline = $salesDataOnlineProducts->groupBy('id_produk')
                                                     ->map(function ($item) {
                                                         return $item->sum('qty');
                                                     })
                                                     ->sortDesc()
                                                     ->take(5);

        $topProductsOffline = $salesDataOfflineProducts->groupBy('id_produk')
                                                      ->map(function ($item) {
                                                          return $item->sum('qty');
                                                      })
                                                      ->sortDesc()
                                                      ->take(5);

        $topSparePartsOnline = $salesDataOnlineSpareParts->groupBy('id_spare_part')
                                                        ->map(function ($item) {
                                                            return $item->sum('qty');
                                                        })
                                                        ->sortDesc()
                                                        ->take(5);

        $topSparePartsOffline = $salesDataOfflineSpareParts->groupBy('id_spare_part')
                                                          ->map(function ($item) {
                                                              return $item->sum('qty');
                                                          })
                                                          ->sortDesc()
                                                          ->take(5);

        $totalQtyProducts = [];
        $totalQtySpareParts = [];

        foreach ($topProductsOnline as $id_produk => $onlineQtyProduct) {
            $offlineQtyProducts = $topProductsOffline[$id_produk] ?? 0;
            $totalQtyProducts[$id_produk] = $onlineQtyProduct + $offlineQtyProducts;
        }

        foreach ($topSparePartsOnline as $sparePartId => $onlineQtySparePart) {
            $offlineQtySpareParts = $topSparePartsOffline[$sparePartId] ?? 0;
            $totalQtySpareParts[$sparePartId] = $onlineQtySparePart + $offlineQtySpareParts;
        }

        return view('pos.index', compact(
            'bengkel',
            'totalServices',
            'totalSpareParts',
            'totalProducts',
            'totalOrderOnline',
            'orders',
            'topProductsOnline',
            'topProductsOffline',
            'topSparePartsOnline',
            'topSparePartsOffline',
            'periodeProduk',
            'periodeSpareParts',
            'totalQtyProducts',
            'totalQtySpareParts'
        ));
    }
}
