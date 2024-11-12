<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FotoMobil;
use App\Models\UsedCar;
use App\Models\MerkMobil;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UsedCarController extends Controller
{
    public function index(Request $request)
    {
        $mobilList = UsedCar::where('delete_mobil', 'N')->with('merkMobil')->get();
        return view('usedcar.index', compact('mobilList'));
    }

    public function formatPhoneNumber($phone)
    {
        if (strpos($phone, '08') === 0) {
            $phone = '62' . substr($phone, 1);
        }
        return $phone;
    }

    public function detail($id)
    {
        $mobilList = UsedCar::where('id_mobil', $id)
            ->where('delete_mobil', 'N')
            ->with('pelanggan')
            ->first();

        if (!$mobilList) {
            return redirect()->route('used-car')->with('error_status', 'Workshop not found.');
        }
        // Format nomor telepon pelanggan
        if ($mobilList->pelanggan) {
            $mobilList->pelanggan->telp_pelanggan = $this->formatPhoneNumber($mobilList->pelanggan->telp_pelanggan);
        }

        return view('usedCar.detail_car', compact('mobilList'));
    }

    public function showUsedCar()
    {
        if (!Session::has('id_pelanggan')) {
            return redirect()->route('home')->with('error_status', 'You must be logged in to add an usedcar');
        }
        $mobilList = UsedCar::with('pelanggan')
            ->where('id_pelanggan', Session::get('id_pelanggan'))
            ->where('delete_mobil', 'N')
            ->with('merkMobil')
            ->get();
        return view('profile.used-car.index', compact('mobilList'));
    }

    public function create()
    {
        if (!Session::has('id_pelanggan')) {
            return redirect()->route('home')->with('error_status', 'You must be logged in to add an usedcar.');
        }

        $carMerks = MerkMobil::all();
        return view('profile.used-car.create', compact('carMerks'));
    }

    public function store(Request $request)
    {
        $pelanggan = Session::get('id_pelanggan');

        $nama_mobil = $request->nama_mobil;
        $merk_mobil_id = $request->merk_mobil_id;
        $harga_mobil = str_replace('.', '', $request->harga_mobil);
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

        $defaultFoto = url('public/assets/images/components/image.png');
        $fileUrls = [
            'file_foto_mobil_1' => $defaultFoto,
            'file_foto_mobil_2' => $defaultFoto,
            'file_foto_mobil_3' => $defaultFoto,
            'file_foto_mobil_4' => $defaultFoto,
            'file_foto_mobil_5' => $defaultFoto,
        ];
        if ($request->hasFile('file_foto_mobil_1')) {
            $file = $request->file('file_foto_mobil_1');
            if ($file->isValid()) {
                $filename = 'tb_mobil_' . date('Ymd_His') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/images/Foto_mobil'), $filename);
                $fileUrls['file_foto_mobil_1'] = url('assets/images/Foto_mobil/' . $filename);
            }
        }
        $fotoTambahanFields = ['file_foto_mobil_2', 'file_foto_mobil_3', 'file_foto_mobil_4', 'file_foto_mobil_5'];
        foreach ($fotoTambahanFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                if ($file->isValid()) {
                    $filename = 'tb_mobil_' . $field . '_' . date('Ymd_His') . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('assets/images/Foto_mobil'), $filename);
                    $fileUrls[$field] = url('assets/images/Foto_mobil/' . $filename);
                }
            }
        }

        $mobil = UsedCar::create([
            'id_pelanggan' => $pelanggan,
            'nama_mobil' => $nama_mobil,
            'merk_mobil_id' => $merk_mobil_id,
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
        ]);

        $fotoMobil = new FotoMobil([
            'id_pelanggan' => $pelanggan,
            'id_mobil' => $mobil->id_mobil,
            'file_foto_mobil_1' => $fileUrls['file_foto_mobil_1'],
            'file_foto_mobil_2' => $fileUrls['file_foto_mobil_2'],
            'file_foto_mobil_3' => $fileUrls['file_foto_mobil_3'],
            'file_foto_mobil_4' => $fileUrls['file_foto_mobil_4'],
            'file_foto_mobil_5' => $fileUrls['file_foto_mobil_5'],
            'create_file_foto_mobil' => now(),
            'delete_file_foto_mobil' => 'N',
        ]);
        $fotoMobil->save();

        return redirect()->route('profile-used-car')->with('status', 'Used car successfully added!');
    }

    public function edit($id)
    {
        $customerId = Session::get('id_pelanggan');

        $mobil = UsedCar::where('id_mobil', $id)
            ->where('id_pelanggan', $customerId)
            ->with('fotos')
            ->first();

        if (!$mobil) {
            return redirect()->route('profile-used-car')->with('error_status', 'Used car not found.');
        }

        $carMerks = MerkMobil::all();

        return view('profile.used-car.edit', compact('mobil', 'carMerks'));
    }

    public function update(Request $request, $id)
    {
        $mobil = UsedCar::findOrFail($id);

        $nama_mobil = $request->nama_mobil;
        $merk_mobil_id = $request->merk_mobil_id;
        $harga_mobil = str_replace('.', '', $request->harga_mobil);
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
        $terakhir_pajak_mobil = $request->terakhir_pajak_mobil;
        $keterangan_mobil = $request->keterangan_mobil;
        $lokasi_mobil = $request->lokasi_mobil;

        $mobil->update([
            'nama_mobil' => $nama_mobil,
            'merk_mobil_id' => $merk_mobil_id,
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
            'terakhir_pajak_mobil' => $terakhir_pajak_mobil,
            'keterangan_mobil' => $keterangan_mobil,
            'lokasi_mobil' => $lokasi_mobil,
        ]);

        $fileUrls = [
            'file_foto_mobil_1' => null,
            'file_foto_mobil_2' => null,
            'file_foto_mobil_3' => null,
            'file_foto_mobil_4' => null,
            'file_foto_mobil_5' => null
        ];

        $fotoFields = ['file_foto_mobil_1', 'file_foto_mobil_2', 'file_foto_mobil_3', 'file_foto_mobil_4', 'file_foto_mobil_5'];

        foreach ($fotoFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                if ($file->isValid()) {
                    $filename = 'tb_mobil_' . $field . '_' . date('Ymd_His') . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('assets/images/Foto_mobil'), $filename);
                    $fileUrls[$field] = url('assets/images/Foto_mobil/' . $filename);
                }
            }
        }

        if ($mobil->fotos) {
            $mobil->fotos->update([
                'file_foto_mobil_1' => $fileUrls['file_foto_mobil_1'] ?? $mobil->fotos->file_foto_mobil_1,
                'file_foto_mobil_2' => $fileUrls['file_foto_mobil_2'] ?? $mobil->fotos->file_foto_mobil_2,
                'file_foto_mobil_3' => $fileUrls['file_foto_mobil_3'] ?? $mobil->fotos->file_foto_mobil_3,
                'file_foto_mobil_4' => $fileUrls['file_foto_mobil_4'] ?? $mobil->fotos->file_foto_mobil_4,
                'file_foto_mobil_5' => $fileUrls['file_foto_mobil_5'] ?? $mobil->fotos->file_foto_mobil_5,
            ]);
        } else {
            $mobil->fotos()->create([
                'file_foto_mobil_1' => $fileUrls['file_foto_mobil_1'],
                'file_foto_mobil_2' => $fileUrls['file_foto_mobil_2'],
                'file_foto_mobil_3' => $fileUrls['file_foto_mobil_3'],
                'file_foto_mobil_4' => $fileUrls['file_foto_mobil_4'],
                'file_foto_mobil_5' => $fileUrls['file_foto_mobil_5'],
            ]);
        }

        return redirect()->route('profile-used-car')->with('status', 'Mobil berhasil diperbarui!');
    }

    public function delete($id)
    {
        $mobil = UsedCar::find($id);

        if (!$mobil) {
            return redirect()->route('profile-used-car')->with('error', 'Mobil tidak ditemukan!');
        }

        if ($mobil->delete_mobil === 'Y') {
            return redirect()->route('profile-used-car')->with('error', 'Mobil sudah dihapus sebelumnya!');
        }

        $mobil->delete_mobil = 'Y';
        $mobil->save();

        if ($mobil->fotos) {
            foreach (['file_foto_mobil_1', 'file_foto_mobil_2', 'file_foto_mobil_3', 'file_foto_mobil_4', 'file_foto_mobil_5'] as $foto) {
                $filePath = public_path('assets/images/Foto_mobil/' . basename($mobil->fotos->$foto));
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            $mobil->fotos->delete();
        }

        $this->deleteFolderIfEmpty(public_path('assets/images/Foto_mobil'));

        return redirect()->route('profile-used-car')->with('status', 'Mobil berhasil dihapus!');
    }

    private function deleteFolderIfEmpty($folderPath)
    {
        if (is_dir($folderPath)) {
            if (count(scandir($folderPath)) == 2) { // Hanya '.' dan '..' yang ada
                rmdir($folderPath);
            }
        }
    }
}
