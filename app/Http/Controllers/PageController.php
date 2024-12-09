<?php

namespace App\Http\Controllers;

use App\Models\Bengkel;
use App\Models\Blog;
use App\Models\Event;
use App\Models\MerkMobil;
use App\Models\Product;
use App\Models\SpareParts;
use App\Models\SupportCategory;
use App\Models\UsedCar;
use Illuminate\Routing\Controller;

class PageController extends Controller
{
    public function index()
    {
        $bengkels = Bengkel::where('delete_bengkel', 'N')->orderBy('id_bengkel', 'DESC')->take(4)->get();
        $events = Event::latest()->take(4)->get();
        $products = Product::where('delete_produk', 'N')->orderBy('id_produk', 'DESC')->take(4)->get();
        $sparepart = SpareParts::where('delete_spare_part', 'N')->orderBy('id_spare_part', 'DESC')->take(4)->get();
        $mobilList = UsedCar::where('delete_mobil', 'N')
            ->with('merkMobil')
            ->orderBy('create_date', 'asc')
            ->take(9)
            ->get();
        $merks = MerkMobil::all();

        $latestBlogs = Blog::latest()->take(6)->get();

        return view('index', compact('bengkels', 'events', 'products', 'sparepart', 'mobilList', 'merks', 'latestBlogs'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function about()
    {
        return view('pages.about');
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