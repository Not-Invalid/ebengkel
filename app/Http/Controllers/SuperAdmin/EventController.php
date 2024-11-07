<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return view('superadmin.event.index');
    }
    public function create()
    {
        return view('superadmin.event.create');
    }
    public function store(Request $request)
    {

    }
}
