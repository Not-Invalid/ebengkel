<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('index');
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
        return view('pages.support_center');
    }

    public function superAdmin()
    {
        return view('superadmin.index');
    }

    public function detail()
    {
        return view('pages.detail');
    }
    public function career(){
        return view('pages.career');
    }
}
