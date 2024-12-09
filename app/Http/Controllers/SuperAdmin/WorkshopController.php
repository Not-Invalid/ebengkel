<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\ReviewWorkshop;
use App\Models\Service;
use App\Models\SpareParts;
use App\Models\Product;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{
    public function index()
    {
        $workshop = Bengkel::orderBy('id_bengkel', 'ASC')->paginate(10);
        return view('superadmin.masterdata-workshop.index', compact('workshop'));
    }
    public function detail($id)
    {
        $bengkel = Bengkel::find($id);

        if (!$bengkel) {
            return redirect()->back()->with('error', 'Bengkel not found.');
        }

        // Ambil produk yang terkait dengan bengkel
        $products = Product::where('id_bengkel', $id)->get();

        // Ambil sparepart yang terkait dengan bengkel
        $spareParts = SpareParts::where('id_bengkel', $id)->get();

        // Ambil layanan yang terkait dengan bengkel
        $services = Service::where('id_bengkel', $id)->get();

        // Total produk, sparepart, dan layanan
        $totalProducts = $products->count();
        $totalSpareParts = $spareParts->count();
        $totalServices = $services->count();

        // Rating rata-rata (menggunakan relasi)
        $averageRating = ReviewWorkshop::where('id_bengkel', $id)->avg('rating');

        return view('superadmin.masterdata-workshop.detail', compact('bengkel', 'products', 'spareParts', 'services', 'totalProducts', 'totalSpareParts', 'totalServices', 'averageRating'));
    }

}
