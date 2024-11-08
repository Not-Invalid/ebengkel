<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{
    public function index()
    {
        $workshop = Bengkel::orderBy('id_bengkel', 'ASC')->paginate(10);
        return view('superadmin.masterdata-workshop.index', compact('workshop'));
    }
}
