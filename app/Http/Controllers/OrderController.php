<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlamatPengiriman;

class OrderController extends Controller
{
    public function index()
    {
        $address = AlamatPengiriman::where('id_pelanggan', auth('pelanggan')->id())
                                    ->where('delete_alamat_pengiriman', 'N')
                                    ->get();


        return view('transaction.order', compact('address'));
    }
}
