<?php

namespace App\Http\Controllers;

use App\Models\Bengkel;
use App\Models\Event;
use App\Models\Product;
use App\Models\UsedCar;
use App\Models\MerkMobil;
use App\Models\SpareParts;
use App\Models\SupportCategory;
use Illuminate\Routing\Controller;

class PageController extends Controller
{
    public function index()
    {
        $bengkels = Bengkel::where('delete_bengkel', 'N')->get();
        $events = Event::all();
        $products = Product::where('delete_produk', 'N')->get();
        $sparepart = SpareParts::where('delete_spare_part', 'N')->get();
        $mobilList = UsedCar::where('delete_mobil', 'N')->with('merkMobil')->get();
        $merks = MerkMobil::all();
        return view('index', compact('bengkels', 'events', 'products', 'sparepart', 'mobilList', 'merks'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function faqs()
    {
        return view('pages.faq');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function supportCenter()
    {
        $categories = SupportCategory::all();
        return view('pages.support_center', compact('categories'));
    }

    public function detail($categoryId)
    {
        $supportInfo = SupportCategory::with('questions')
            ->findOrFail($categoryId);

        return view('pages.detail', compact('supportInfo'));
    }
    public function career()
    {
        return view('pages.career');
    }
}
