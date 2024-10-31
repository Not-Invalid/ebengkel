<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function show()
    {
        return view('event.index');
    }
    public function detail()
    {
        return view('event.detail');
    }

}
