<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function superAdmin()
    {
        $ttl_bengkel = Bengkel::count();
        $ttl_user = Pelanggan::count();
        return view('superadmin.index', compact('ttl_bengkel', 'ttl_user'));
    }
}
