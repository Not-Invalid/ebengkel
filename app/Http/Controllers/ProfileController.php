<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function show()
    {
        if (!Session::has('id_pelanggan')) {
            return redirect()->back()->withErrors('Customer ID not found in session.');
        }

        $data_pelanggan = DB::table('ebengkel_pkl.tb_pelanggan')
            ->where('id_pelanggan', Session::get('id_pelanggan'))
            ->first();

        if (!$data_pelanggan) {
            return redirect()->back()->withErrors('Customer data not found.');
        }

        return view('profile.index', compact('data_pelanggan'));
    }


}
