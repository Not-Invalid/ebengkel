<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\Service;
use App\Models\SpareParts;
use App\Models\Product;
use App\Models\OrderOnline; // Model untuk t_order_online
use App\Models\OrderItemOnline; // Model untuk t_order_item_online
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index($id_bengkel)
    {
        // Mengambil bengkel berdasarkan ID
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Bengkel tidak ditemukan.');
        }

        if (!Auth::guard('pegawai')->check()) {
            return redirect()->route('pos.login');
        }

        // Mengambil data total
        $totalServices = Service::count();
        $totalSpareParts = SpareParts::count();
        $totalProducts = Product::count();
        $totalOrderOnline = OrderOnline::whereMonth('tanggal', now()->month)
                                        ->whereYear('tanggal', now()->year)
                                        ->count();

        // Mengambil data pesanan dengan relasi OrderItemOnline
        $orders = OrderOnline::with('orderItems.produk', 'orderItems.sparepart', 'pelanggan', 'bengkel') // Memuat relasi produk dan sparepart
            ->where('id_bengkel', $id_bengkel)
            ->get();

        return view('pos.index', compact('bengkel', 'totalServices', 'totalSpareParts', 'totalProducts', 'totalOrderOnline', 'orders'));
    }
}
