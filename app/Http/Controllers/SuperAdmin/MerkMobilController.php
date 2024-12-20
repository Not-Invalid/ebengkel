<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\MerkMobil;
use Illuminate\Http\Request;

class MerkMobilController extends Controller
{
    public function index()
    {
        $merks = MerkMobil::orderBy('id', 'ASC')->paginate(10);
        return view('superadmin.masterdata-merk.mobil.index', compact('merks'));
    }

    public function create()
    {
        return view('superadmin.masterdata-merk.mobil.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_merk' => 'required|string|max:255',
        ]);

        MerkMobil::create($request->all());

        return redirect()->route('merk-mobil')->with('status', __('messages-superadmin.toast_superadmin.toast_car_brand.create'));
    }

    public function edit($id)
    {
        $merk = MerkMobil::findOrFail($id);
        return view('superadmin.masterdata-merk.mobil.edit', compact('merk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_merk' => 'required|string|max:255',
        ]);

        $merk = MerkMobil::findOrFail($id);
        $merk->update($request->all());

        return redirect()->route('merk-mobil')->with('status', __('messages-superadmin.toast_superadmin.toast_car_brand.update'));
    }

    public function delete($id)
    {
        $merk = MerkMobil::findOrFail($id);
        $merk->delete();

        return redirect()->route('merk-mobil')->with('status', __('messages-superadmin.toast_superadmin.toast_car_brand.delete'));
    }
}
