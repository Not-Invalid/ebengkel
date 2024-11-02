<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class WorkshopController extends Controller
{
    public function show()
    {
        return view('workshop.index');
    }
    public function detail()
    {
        return view('workshop.detail');
    }

}
