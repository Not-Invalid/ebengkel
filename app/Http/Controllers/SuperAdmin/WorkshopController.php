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

        $products = Product::where('id_bengkel', $id)->get();

        $spareParts = SpareParts::where('id_bengkel', $id)->get();

        $services = Service::where('id_bengkel', $id)->get();

        $totalProducts = $products->count();
        $totalSpareParts = $spareParts->count();
        $totalServices = $services->count();

        $averageRating = ReviewWorkshop::where('id_bengkel', $id)->avg('rating');

        return view('superadmin.masterdata-workshop.detail', compact('bengkel', 'products', 'spareParts', 'services', 'totalProducts', 'totalSpareParts', 'totalServices', 'averageRating'));
    }
}
