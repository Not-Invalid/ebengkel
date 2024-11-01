<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductSparePartController extends Controller
{
    public function index() {
        return view('ProductSparepart.index');
    }
}
