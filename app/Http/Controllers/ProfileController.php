<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function show()
    {

        $data_pelanggan = DB::table('ebengkel_pkl.tb_pelanggan')
            ->where('id_pelanggan', Session::get('id_pelanggan'))
            ->first();

        return view('profile.index', compact('data_pelanggan'));
    }

}