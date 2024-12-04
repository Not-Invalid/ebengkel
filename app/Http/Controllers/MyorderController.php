<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyorderController extends Controller
{
    public function index(){
        return view('profile.my-order.index');
    }
    public function detailOrder(){
        return view('profile.my-order.order_detail');
    }
}
