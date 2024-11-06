<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\UsedCar;
use App\Models\FotoMobil;
use Illuminate\Http\Request;

class UsedCarController extends Controller
{
    public function index(Request $request)
    {
        $query = UsedCar::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('location', 'like', '%' . $request->search . '%');
        }

        if ($request->has('brand') && is_array($request->brand)) {
            $query->whereIn('brand', $request->brand);
        }

        if ($request->has('price_range')) {
            switch ($request->price_range) {
                case '<100':
                    $query->where('price', '<', 100000000);
                    break;
                case '100-250':
                    $query->whereBetween('price', [100000000, 250000000]);
                    break;
            }
        }

        $cars = $query->paginate(10);

        return view('usedCar.index', compact('cars'));
    }

    public function detail()
    {
        return view('usedCar.detail_car');
    }

    public function showUsedCar()
    {
        $userId = Auth::id();
        $mobilList = UsedCar::where('id_pelanggan', $userId)
                            ->where('delete_mobil', 'N')
                            ->get();

        return view('profile.used-car.index', compact('mobilList'));
    }

    public function create()
    {
        return view('profile.used-car.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'nama_mobil' => 'required|string|max:255',
            'merk_mobil' => 'required|string|max:255',
            'harga_mobil' => 'required|numeric',
            'plat_nomor_mobil' => 'required|string|max:255',
            'tahun_mobil' => 'required|integer',
            'km_mobil' => 'required|integer',
            'nomor_rangka_mobil' => 'required|string|max:255',
            'nomor_mesin_mobil' => 'required|string|max:255',
            'kapasitas_mesin_mobil' => 'required|string|max:255',
            'bahan_bakar_mobil' => 'required|string',
            'jenis_transmisi_mobil' => 'required|string|max:255',
            'bulan_pajak_mobil' => 'required|date',
            'tahun_pajak_mobil' => 'required|integer',
            'terakhir_pajak_mobil' => 'required|date',
            'keterangan_mobil' => 'nullable|string',
            'lokasi_mobil' => 'nullable|string',
            'file_foto_mobil_1' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_foto_mobil_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_foto_mobil_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_foto_mobil_4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_foto_mobil_5' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Retrieve id_pelanggan from session
        $customerId = Session::get('id_pelanggan');

        // Check if id_pelanggan is present in the session
        if (!$customerId) {
            return redirect()->back()->with('error', 'User ID is missing. Please log in again.');
        }

        // Prepare data for UsedCar model
        $data = $request->except('file_foto_mobil_1', 'file_foto_mobil_2', 'file_foto_mobil_3', 'file_foto_mobil_4', 'file_foto_mobil_5');
        $data['id_pelanggan'] = $customerId;

        // Create new UsedCar entry
        $usedCar = UsedCar::create($data);

        // Prepare data for FotoMobil model with a default empty string for each file field
        $fotoMobilData = [
            'id_mobil' => $usedCar->id_mobil,
            'id_pelanggan' => $customerId,
            'file_foto_mobil_1' => '',
            'file_foto_mobil_2' => '',
            'file_foto_mobil_3' => '',
            'file_foto_mobil_4' => '',
            'file_foto_mobil_5' => ''
        ];

        // Loop through uploaded files and save file paths
        for ($i = 1; $i <= 5; $i++) {
            $fileKey = 'file_foto_mobil_' . $i;
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                $fileName = time() . '_' . $file->getClientOriginalName();

                // Move file to fotomobil directory
                $file->move(public_path('fotomobil'), $fileName);

                // Store file path in fotoMobilData
                $fotoMobilData[$fileKey] = 'fotomobil/' . $fileName;
            }
        }

        // Save FotoMobil entry
        FotoMobil::create($fotoMobilData);

        return redirect()->route('profile-used-car')->with('success', 'Used car added successfully!');
    }


}
