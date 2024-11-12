<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\KategoriSparePart;
use App\Models\SpareParts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductSparePartController extends Controller
{
    public function index()
    {
        return view('ProductSparepart.index');
    }
    public function detail()
    {
        return view('ProductSparepart.detail-ProductSparePart');
    }
    public function createSparepart()
    {
        if (!Session::has('id_pelanggan')) {
            return redirect()->route('home')->with('error_status', 'You must be logged in to add a service.');
        }

        $id_pelanggan = Session::get('id_pelanggan');
        $bengkel = Bengkel::where('id_pelanggan', $id_pelanggan)->first();

        if (!$bengkel) {
            return redirect()->route('home')->with('error_status', 'No associated workshop found.');
        }

        $id_bengkel = $bengkel->id_bengkel;

        $kategoriSparePart = KategoriSparePart::all();
        return view('profile.workshop.workshopSET.Sparepart.create', compact('kategoriSparePart', 'id_bengkel'));
    }
    public function saveSparePart(Request $request)
    {
        $request->validate([
            'id_bengkel' => 'nullable|integer',
            'id_kategori_spare_part' => 'nullable|integer',
            'kualitas_spare_part' => 'nullable|string',
            'merk_spare_part' => 'nullable|string',
            'nama_spare_part' => 'nullable|string',
            'harga_spare_part' => 'nullable|integer',
            'keterangan_spare_part' => 'nullable|string',
            'stok_spare_part' => 'nullable|integer',
            'foto_spare_part' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $sparePart = new SpareParts();
        $sparePart->id_bengkel = $request->id_bengkel;
        $sparePart->id_kategori_spare_part = $request->id_kategori_spare_part;
        $sparePart->kualitas_spare_part = $request->kualitas_spare_part;
        $sparePart->merk_spare_part = $request->merk_spare_part;
        $sparePart->nama_spare_part = $request->nama_spare_part;
        $sparePart->harga_spare_part = $request->harga_spare_part;
        $sparePart->keterangan_spare_part = $request->keterangan_spare_part;
        $sparePart->stok_spare_part = $request->stok_spare_part;

        if ($request->hasFile('foto_spare_part')) {
            $imageName = time() . '.' . $request->foto_spare_part->extension();
            $request->foto_spare_part->move(public_path('assets/images/spareparts'), $imageName);
            $sparePart->foto_spare_part = 'assets/images/spareparts/' . $imageName;
        }

        $sparePart->save();

        return redirect()->route('profile.workshop.detail', ['id_bengkel' => $sparePart->id_bengkel])
            ->with('status', 'Spare part berhasil ditambahkan.');
    }
    public function editSparepart($id_spare_part)
    {
        $sparePart = SpareParts::findOrFail($id_spare_part);
        $kategoriSparePart = KategoriSparePart::all();
        return view('profile.workshop.workshopSET.Sparepart.edit', compact('sparePart', 'kategoriSparePart'));
    }

    public function updateSparepart(Request $request, $id)
    {
        $request->validate([
            'id_kategori_spare_part' => 'nullable|integer',
            'kualitas_spare_part' => 'nullable|string',
            'merk_spare_part' => 'nullable|string',
            'nama_spare_part' => 'nullable|string',
            'harga_spare_part' => 'nullable|integer',
            'keterangan_spare_part' => 'nullable|string',
            'stok_spare_part' => 'nullable|integer',
            'foto_spare_part' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $sparePart = SpareParts::findOrFail($id);
        $sparePart->id_kategori_spare_part = $request->id_kategori_spare_part;
        $sparePart->kualitas_spare_part = $request->kualitas_spare_part;
        $sparePart->merk_spare_part = $request->merk_spare_part;
        $sparePart->nama_spare_part = $request->nama_spare_part;
        $sparePart->harga_spare_part = $request->harga_spare_part;
        $sparePart->keterangan_spare_part = $request->keterangan_spare_part;
        $sparePart->stok_spare_part = $request->stok_spare_part;

        if ($request->hasFile('foto_spare_part')) {
            $imageName = time() . '.' . $request->foto_spare_part->extension();
            $request->foto_spare_part->move(public_path('assets/images/spareparts'), $imageName);
            $sparePart->foto_spare_part = 'assets/images/spareparts/' . $imageName;
        }

        $sparePart->save();

        return redirect()->route('profile.workshop.detail', ['id_bengkel' => $sparePart->id_bengkel])
            ->with('status', 'Spare part berhasil diupdate.');
    }
    public function delete($id_spare_part)
    {
        $sparePart = DB::table('tb_spare_part')->where('id_spare_part', $id_spare_part)->first();

        if ($sparePart) {
            DB::table('tb_spare_part')->where('id_spare_part', $id_spare_part)->update([
                'delete_spare_part' => 'Y',
            ]);
            return back()->with('status', 'Address deleted successfully.');
        } else {
            return back()->with('error_status', 'Address not found.');
        }
    }
}