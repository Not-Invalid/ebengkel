<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsedCarController extends Controller
{
    public function index() {
        return view('usedCar.index');
    }
    public function detail() {
        return view('usedCar.detail_car');
    }
}
