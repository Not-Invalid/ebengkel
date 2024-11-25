<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\KategoriSparePart;
use App\Models\SpareParts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SparePartController extends Controller
{
    public function index(Request $request, $id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found!.');
        }

        if (!Auth::guard('pegawai')->check()) {
            return redirect()->route('pos.login');
        }
        $search = $request->input('search', '');

        $sparepart = SpareParts::where('id_bengkel', $id_bengkel)
            ->where('delete_spare_part', 'N')
            ->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('nama_spare_part', 'like', "%$search%");
                }
            })
            ->with('kategoriSparePart')
            ->paginate(10);

        return view('pos.masterdata-sparepart.index', compact('bengkel', 'sparepart'));
    }

    public function create($id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found!.');
        }

        $categories = KategoriSparePart::all();
        return view('pos.masterdata-sparepart.create', compact('bengkel', 'categories'));
    }
    public function store(Request $request, $id_bengkel)
    {
        $request->validate([
            'id_kategori_spare_part' => 'required|integer',
            'kualitas_spare_part' => 'required|string',
            'merk_spare_part' => 'required|string',
            'nama_spare_part' => 'required|string',
            'harga_spare_part' => 'required|integer',
            'keterangan_spare_part' => 'nullable|string',
            'stok_spare_part' => 'required|integer',
            'foto_spare_part' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $sparePart = new SpareParts();
        $sparePart->id_bengkel = $id_bengkel;
        $sparePart->id_kategori_spare_part = $request->id_kategori_spare_part;
        $sparePart->kualitas_spare_part = $request->kualitas_spare_part;
        $sparePart->merk_spare_part = $request->merk_spare_part;
        $sparePart->nama_spare_part = $request->nama_spare_part;
        $sparePart->harga_spare_part = $request->harga_spare_part;
        $sparePart->keterangan_spare_part = $request->keterangan_spare_part;
        $sparePart->stok_spare_part = $request->stok_spare_part;

        if ($request->hasFile('foto_spare_part')) {
            $imageName = 'foto_spare_part_' . now()->format('Ymd_His') . '.' . $request->foto_spare_part->extension();
            $request->foto_spare_part->move(public_path('assets/images/spareparts'), $imageName);
            $sparePart->foto_spare_part = 'assets/images/spareparts/' . $imageName;
        }

        $sparePart->save();

        return redirect()->route('pos.sparepart.index', $id_bengkel)->with('status', 'Spare Part successfully added!.');
    }

    public function show($id_bengkel, $id_spare_part)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found!.');
        }

        $sparepart = SpareParts::find($id_spare_part);
        $categories = KategoriSparePart::all();

        return view('pos.masterdata-sparepart.show', compact('bengkel', 'sparepart', 'categories'));
    }
    public function edit($id_bengkel, $id_spare_part)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found!.');
        }

        $sparepart = SpareParts::findOrFail($id_spare_part);
        $categories = KategoriSparePart::all();
        return view('pos.masterdata-sparepart.edit', compact('bengkel', 'sparepart', 'categories'));
    }
    public function update(Request $request, $id_bengkel, $id_spare_part)
    {
        $request->validate([
            'id_kategori_spare_part' => 'required|integer',
            'kualitas_spare_part' => 'nullable|string',
            'merk_spare_part' => 'nullable|string',
            'nama_spare_part' => 'required|string',
            'harga_spare_part' => 'required|integer',
            'keterangan_spare_part' => 'nullable|string',
            'stok_spare_part' => 'required|integer',
            'foto_spare_part' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $sparepart = SpareParts::findOrFail($id_spare_part);
        $sparepart->id_kategori_spare_part = $request->id_kategori_spare_part;
        $sparepart->kualitas_spare_part = $request->kualitas_spare_part;
        $sparepart->merk_spare_part = $request->merk_spare_part;
        $sparepart->nama_spare_part = $request->nama_spare_part;
        $sparepart->harga_spare_part = $request->harga_spare_part;
        $sparepart->keterangan_spare_part = $request->keterangan_spare_part;
        $sparepart->stok_spare_part = $request->stok_spare_part;

        if ($request->hasFile('foto_spare_part')) {
            if ($sparepart->foto_spare_part && file_exists(public_path($sparepart->foto_spare_part))) {
                unlink(public_path($sparepart->foto_spare_part));
            }
            $imageName = 'foto_spare_part_' . now()->format('Ymd_His') . '.' . $request->foto_spare_part->extension();
            $request->foto_spare_part->move(public_path('assets/images/spareparts'), $imageName);
            $sparepart->foto_spare_part = 'assets/images/spareparts/' . $imageName;
        }

        $sparepart->save();

        return redirect()->route('pos.sparepart.index', ['id_bengkel' => $id_bengkel])->with('status', 'Spare Part successfully updated!');
    }

    public function destroy($id_bengkel, $id_spare_part)
    {
        $sparepart = SpareParts::findOrFail($id_spare_part);
        if ($sparepart->foto_spare_part && file_exists(public_path($sparepart->foto_spare_part))) {
            unlink(public_path($sparepart->foto_spare_part));
        }
        $sparepart->delete();
        return redirect()->route('pos.sparepart.index', $id_bengkel)->with('status', 'Spare Part Successfully deleted!');
    }
}
