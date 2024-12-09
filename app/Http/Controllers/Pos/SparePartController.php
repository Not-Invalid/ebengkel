<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\FotoSparepart;
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

        $perPage = $request->get('per_page', 10);

        $sparepart = SpareParts::where('id_bengkel', $id_bengkel)
            ->where('delete_spare_part', 'N')
            ->with('kategoriSparePart')
            ->paginate(10);

        $totalEntries = $sparepart->total();
        $start = ($sparepart->currentPage() - 1) * $perPage + 1;
        $end = min($sparepart->currentPage() * $perPage, $totalEntries);

        return view('pos.masterdata-sparepart.index', compact('bengkel', 'sparepart', 'totalEntries', 'start', 'end'));
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
            'foto_spare_part_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_spare_part_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_spare_part_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_spare_part_4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_spare_part_5' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
        $sparePart->save();

        // Handle file uploads for product photos
        $fotoSparepart = new FotoSparepart();
        $fotoSparepart->id_spare_part = $sparePart->id_spare_part;

        // Check each photo input and upload if present
        for ($i = 1; $i <= 5; $i++) {
            $fotoKey = 'foto_spare_part_' . $i;
            if ($request->hasFile($fotoKey)) {
                $imageName = 'foto_spare_part_' . $sparePart->id_spare_part . '_' . $i . '.' . $request->file($fotoKey)->extension();
                $request->file($fotoKey)->move(public_path('assets/images/spareparts'), $imageName);
                $fotoSparepart->{'file_foto_spare_part_' . $i} = 'assets/images/spareparts/' . $imageName;
            }
        }

        $fotoSparepart->create_file_foto_spare_part = now();
        $fotoSparepart->save();

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
    // public function edit($id_bengkel, $id_spare_part)
    // {
    //     $bengkel = Bengkel::find($id_bengkel);

    //     if (!$bengkel) {
    //         return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found!.');
    //     }

    //     $sparepart = SpareParts::findOrFail($id_spare_part);
    //     $categories = KategoriSparePart::all();
    //     // Ambil data foto produk terkait
    //     $fotoSparepart = FotoSparepart::where('id_spare_part', $id_spare_part)->first();
    //     return view('pos.masterdata-sparepart.edit', compact('bengkel', 'sparepart', 'categories', 'fotoSparepart'));
    // }
    // public function update(Request $request, $id_bengkel, $id_spare_part)
    // {
    //     $request->validate([
    //         'id_kategori_spare_part' => 'required|integer',
    //         'kualitas_spare_part' => 'nullable|string',
    //         'merk_spare_part' => 'nullable|string',
    //         'nama_spare_part' => 'required|string',
    //         'harga_spare_part' => 'required|integer',
    //         'keterangan_spare_part' => 'nullable|string',
    //         'stok_spare_part' => 'required|integer',
    //         'foto_spare_part_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'foto_spare_part_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'foto_spare_part_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'foto_spare_part_4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'foto_spare_part_5' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $sparepart = SpareParts::findOrFail($id_spare_part);

    //     $sparepart->update($request->only([
    //         'id_kategori_spare_part',
    //         'kualitas_spare_part',
    //         'merk_spare_part',
    //         'nama_spare_part',
    //         'harga_spare_part',
    //         'keterangan_spare_part',
    //         'stok_spare_part',
    //     ]));

    //     $fotoSparepart = FotoSparepart::where('id_spare_part', $id_spare_part)->first() ?? new FotoSparepart(['id_spare_part' => $id_spare_part]);

    //     // Handle the image file uploads
    //     for ($i = 1; $i <= 5; $i++) {
    //         $fotoKey = 'foto_spare_part_' . $i;

    //         if ($request->hasFile($fotoKey)) {
    //             if ($fotoSparepart->{'file_foto_spare_part' . $i}) {
    //                 unlink(public_path($fotoSparepart->{'file_foto_spare_part' . $i}));
    //             }

    //             // Upload the new image
    //             $imageName = 'foto_spare_part_' . $id_spare_part . '_' . $i . '.' . $request->file($fotoKey)->extension();
    //             $request->file($fotoKey)->move(public_path('assets/images/spareparts'), $imageName);
    //             $fotoSparepart->{'file_foto_spare_part_' . $i} = 'assets/images/spareparts/' . $imageName;
    //         }
    //     }

    //     // Update or create file_foto_produk record
    //     $fotoSparepart->create_file_foto_spare_part = now();
    //     $fotoSparepart->save();

    //     return redirect()->route('pos.sparepart.index', ['id_bengkel' => $id_bengkel])->with('status', 'Spare Part successfully updated!');
    // }
    public function edit($id_bengkel, $id_spare_part)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found!.');
        }

        $sparepart = SpareParts::where('id_bengkel', $id_bengkel)
            ->where('id_spare_part', $id_spare_part)
            ->where('delete_spare_part', 'N')
            ->first();

        if (!$sparepart) {
            return redirect()->route('pos.sparepart.index', ['id_bengkel' => $id_bengkel])->with('error_status', 'Spare part not found!');
        }

        $fotoSparepart = FotoSparepart::where('id_spare_part', $id_spare_part)->first();

        return view('pos.masterdata-sparepart.edit', compact('bengkel', 'sparepart', 'fotoSparepart'));
    }

    public function update(Request $request, $id_bengkel, $id_spare_part)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found!.');
        }

        $sparepart = SpareParts::where('id_bengkel', $id_bengkel)
            ->where('id_spare_part', $id_spare_part)
            ->where('delete_spare_part', 'N')
            ->first();

        if (!$sparepart) {
            return redirect()->route('pos.sparepart.index', ['id_bengkel' => $id_bengkel])->with('error_status', 'Spare part not found!');
        }

        $request->validate([
            'nama_spare_part' => 'required|string|max:255',
            'kualitas_spare_part' => 'required|in:original,aftermarket',
            'merk_spare_part' => 'required|string|max:255',
            'harga_spare_part' => 'required|numeric|min:0',
            'keterangan_spare_part' => 'nullable|string',
            'foto_spare_part_1' => 'nullable|image|max:2048',
            'foto_spare_part_2' => 'nullable|image|max:2048',
            'foto_spare_part_3' => 'nullable|image|max:2048',
            'foto_spare_part_4' => 'nullable|image|max:2048',
            'foto_spare_part_5' => 'nullable|image|max:2048',
        ]);
        $sparepart = SpareParts::findOrFail($id_spare_part);
        $sparepart->update($request->only([
            'id_kategori_spare_part',
            'kualitas_spare_part',
            'merk_spare_part',
            'nama_spare_part',
            'harga_spare_part',
            'keterangan_spare_part',
            'stok_spare_part',
        ]));

        $fotoSparepart = FotoSparepart::where('id_spare_part', $id_spare_part)->first() ?? new FotoSparepart(['id_spare_part' => $id_spare_part]);

        // Handle image uploads
        for ($i = 1; $i <= 5; $i++) {
            $fotoKey = 'foto_spare_part_' . $i;

            if ($request->hasFile($fotoKey)) {
                if ($fotoSparepart->{'file_foto_spare_part_' . $i}) {
                    unlink(public_path($fotoSparepart->{'file_foto_spare_part_' . $i}));
                }

                $imageName = 'foto_spare_part_' . $id_spare_part . '_' . $i . '.' . $request->file($fotoKey)->extension();
                $request->file($fotoKey)->move(public_path('assets/images/spareparts'), $imageName);
                $fotoSparepart->{'file_foto_spare_part_' . $i} = 'assets/images/spareparts/' . $imageName;
            }
        }

        $fotoSparepart->create_file_foto_spare_part = now();
        $fotoSparepart->save();

        return redirect()->route('pos.sparepart.index', ['id_bengkel' => $id_bengkel])->with('success_status', 'Spare part updated successfully!');
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
