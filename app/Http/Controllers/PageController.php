<?php

namespace App\Http\Controllers;

use App\Models\SupportCategory;
use App\Models\SupportInfo;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Bengkel;
use App\Models\Event;

class PageController extends Controller
{
    public function index()
    {
        $bengkels = Bengkel::where('delete_bengkel', 'N')->get();
        $events = Event::all();
        return view('index', compact('bengkels', 'events'));
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
        return view('pages.support_center',  compact('categories'));
    }

    public function superAdmin()
    {
        return view('superadmin.index');
    }

    public function detail($categoryId)
    {
        $supportInfo = SupportCategory::with('questions')
                                ->findOrFail($categoryId);

        return view('pages.detail', compact('supportInfo'));
    }
    public function career(){
        return view('pages.career');
    }
}
