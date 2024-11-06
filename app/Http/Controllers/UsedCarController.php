<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FotoMobil;
use App\Models\UsedCar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
        if (!Session::has('id_pelanggan')) {
            return redirect()->route('home')->with('error_status', 'You must be logged in to add an usedcar');
        }
        $mobilList = UsedCar::with('pelanggan')
            ->where('id_pelanggan', Session::get('id_pelanggan'))
            ->where('delete_mobil', 'N')
            ->get();
        return view('profile.used-car.index', compact('mobilList'));
    }

    public function create()
    {
        if (!Session::has('id_pelanggan')) {
            return redirect()->route('home')->with('error_status', 'You must be logged in to add an usedcar.');
        }
        return view('profile.used-car.create');
    }

    public function store(Request $request)
    {
        $pelanggan = Session::get('id_pelanggan');

        $nama_mobil = $request->nama_mobil;
        $merk_mobil = $request->merk_mobil;
        $harga_mobil = str_replace('.', '', $request->harga_mobil); // Remove thousands separator
        $harga_mobil = is_numeric($harga_mobil) ? (float) $harga_mobil : 0;
        $tahun_mobil = $request->tahun_mobil;
        $plat_nomor_mobil = $request->plat_nomor_mobil;
        $nomor_rangka_mobil = $request->nomor_rangka_mobil;
        $nomor_mesin_mobil = $request->nomor_mesin_mobil;
        $kapasitas_mesin_mobil = $request->kapasitas_mesin_mobil;
        $bahan_bakar_mobil = $request->bahan_bakar_mobil;
        $jenis_transmisi_mobil = $request->jenis_transmisi_mobil;
        $km_mobil = $request->km_mobil;
        $bulan_pajak_mobil = $request->bulan_pajak_mobil;
        $tahun_pajak_mobil = $request->tahun_pajak_mobil;
        $terakhir_service_mobil = $request->terakhir_service_mobil;
        $terakhir_pajak_mobil = $request->terakhir_pajak_mobil;
        $keterangan_mobil = $request->keterangan_mobil;
        $lokasi_mobil = $request->lokasi_mobil;
        $kodepos_mobil = $request->kodepos_mobil;

        // Set default foto mobil
        $foto = url('logos/image.png');
        $fileUrls = [
            'file_foto_mobil' => $foto,
            'file_foto_mobil_2' => $foto,
            'file_foto_mobil_3' => $foto,
            'file_foto_mobil_4' => $foto,
            'file_foto_mobil_5' => $foto,
        ];

        // Cek apakah ada file foto_mobil yang diunggah
        if ($request->hasFile('file_foto_mobil')) {
            $file = $request->file('file_foto_mobil');
            if ($file->isValid()) {
                $filename = 'tb_mobil_' . date('Ymd_His') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/images/Foto_mobil'), $filename);
                $foto = url('assets/images/Foto_mobil/' . $filename); // Perbaiki URL path
                $fileUrls['file_foto_mobil'] = $foto;
            }
        }

        // Cek apakah ada foto tambahan
        if ($request->hasFile('file_foto_mobil_2')) {
            $fotoFiles = $request->file('file_foto_mobil_2');
            foreach ($fotoFiles as $index => $file) {
                if ($file->isValid()) {
                    $filename = 'tb_foto_mobil_' . ($index + 1) . '_' . date('Ymd_His') . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('assets/images/Foto_mobil'), $filename); // Perbaiki path
                    $fotoUrl = url('assets/images/Foto_mobil/' . $filename); // Perbaiki URL path
                    $fileUrls['file_foto_mobil_' . ($index + 2)] = $fotoUrl;
                }
            }
        }

        // Menyimpan data mobil ke dalam tabel tb_mobil menggunakan model UsedCar
        $mobil = UsedCar::create([
            'id_pelanggan' => $pelanggan,
            'nama_mobil' => $nama_mobil,
            'merk_mobil' => $merk_mobil,
            'harga_mobil' => $harga_mobil,
            'tahun_mobil' => $tahun_mobil,
            'plat_nomor_mobil' => $plat_nomor_mobil,
            'nomor_rangka_mobil' => $nomor_rangka_mobil,
            'nomor_mesin_mobil' => $nomor_mesin_mobil,
            'kapasitas_mesin_mobil' => $kapasitas_mesin_mobil,
            'bahan_bakar_mobil' => $bahan_bakar_mobil,
            'jenis_transmisi_mobil' => $jenis_transmisi_mobil,
            'km_mobil' => $km_mobil,
            'bulan_pajak_mobil' => $bulan_pajak_mobil,
            'tahun_pajak_mobil' => $tahun_pajak_mobil,
            'terakhir_service_mobil' => $terakhir_service_mobil,
            'terakhir_pajak_mobil' => $terakhir_pajak_mobil,
            'keterangan_mobil' => $keterangan_mobil,
            'lokasi_mobil' => $lokasi_mobil,
            'kodepos_mobil' => $kodepos_mobil,
            'approv_mobil' => 'Y',
            'status_mobil' => 'available',
            'sold_out_mobil' => null,
            'create_date' => now(),
            'delete_mobil' => 'N',
            'foto_mobil' => $foto,
        ]);

        // Menyimpan data foto mobil ke dalam tabel tb_foto_mobil menggunakan model FotoMobil
        $fotoMobil = new FotoMobil([
            'id_pelanggan' => $pelanggan,
            'file_foto_mobil_1' => $fileUrls['file_foto_mobil'],
            'file_foto_mobil_2' => $fileUrls['file_foto_mobil_2'],
            'file_foto_mobil_3' => $fileUrls['file_foto_mobil_3'],
            'file_foto_mobil_4' => $fileUrls['file_foto_mobil_4'],
            'file_foto_mobil_5' => $fileUrls['file_foto_mobil_5'],
            'create_file_foto_mobil' => now(),
            'delete_file_foto_mobil' => 'N',
        ]);

        // Relasikan FotoMobil dengan UsedCar yang baru dibuat
        $mobil->fotos()->save($fotoMobil);

        // Redirect dengan pesan sukses
        return redirect()->route('profile-used-car')->with('success', 'Mobil berhasil ditambahkan');
    }

}
