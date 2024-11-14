<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;

class DataPelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::orderBy('id_pelanggan', 'ASC')->paginate(10);
        return view('superadmin.management-user.data-pelanggan.index', compact('pelanggan'));
    }
}
