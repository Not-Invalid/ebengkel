<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\ReviewWorkshop;
use App\Models\Service;
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

        $totalProducts = Product::count();
        $totalServices = Service::count();
        $averageRating = ReviewWorkshop::avg('rating');
        if (!$bengkel) {
            return redirect()->back()->with('error', 'Bengkel not found.');
        }

        return view('superadmin.masterdata-workshop.detail', compact('bengkel', 'totalProducts', 'totalServices', 'averageRating'));
    }
}
