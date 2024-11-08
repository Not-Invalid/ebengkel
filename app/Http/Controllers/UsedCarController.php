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
        // Mendapatkan ID pelanggan dari sesi
        $pelanggan = Session::get('id_pelanggan');

        // Mengambil data input dari form
        $nama_mobil = $request->nama_mobil;
        $merk_mobil = $request->merk_mobil;
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

        // Set foto default jika tidak ada file yang diunggah
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

        // Simpan data mobil ke dalam tabel tb_mobil
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
        ]);

        // Simpan data foto mobil ke dalam tabel tb_foto_mobil
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

        // Redirect dengan pesan sukses
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

        return view('profile.used-car.edit', compact('mobil'));
    }

    public function update(Request $request, $id)
    {
        // Mengambil data mobil berdasarkan ID yang diterima dari parameter
        $mobil = UsedCar::findOrFail($id);

        // Mengambil data dari form request
        $nama_mobil = $request->nama_mobil;
        $merk_mobil = $request->merk_mobil;
        $harga_mobil = str_replace('.', '', $request->harga_mobil); // Menghilangkan titik pada harga
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

        // Memperbarui data mobil
        $mobil->update([
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
            'terakhir_pajak_mobil' => $terakhir_pajak_mobil,
            'keterangan_mobil' => $keterangan_mobil,
            'lokasi_mobil' => $lokasi_mobil,
        ]);

        // Menangani file upload foto mobil
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

        // Cek apakah mobil sudah memiliki entri fotos
        if ($mobil->fotos) {
            // Jika sudah ada, update foto mobil di tabel foto_mobil
            $mobil->fotos->update([
                'file_foto_mobil_1' => $fileUrls['file_foto_mobil_1'] ?? $mobil->fotos->file_foto_mobil_1,
                'file_foto_mobil_2' => $fileUrls['file_foto_mobil_2'] ?? $mobil->fotos->file_foto_mobil_2,
                'file_foto_mobil_3' => $fileUrls['file_foto_mobil_3'] ?? $mobil->fotos->file_foto_mobil_3,
                'file_foto_mobil_4' => $fileUrls['file_foto_mobil_4'] ?? $mobil->fotos->file_foto_mobil_4,
                'file_foto_mobil_5' => $fileUrls['file_foto_mobil_5'] ?? $mobil->fotos->file_foto_mobil_5,
            ]);
        } else {
            // Jika foto mobil belum ada, buat entri foto baru
            $mobil->fotos()->create([
                'file_foto_mobil_1' => $fileUrls['file_foto_mobil_1'],
                'file_foto_mobil_2' => $fileUrls['file_foto_mobil_2'],
                'file_foto_mobil_3' => $fileUrls['file_foto_mobil_3'],
                'file_foto_mobil_4' => $fileUrls['file_foto_mobil_4'],
                'file_foto_mobil_5' => $fileUrls['file_foto_mobil_5'],
            ]);
        }

        // Redirect ke halaman profile dengan pesan sukses
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
            $files = array_diff(scandir($folderPath), array('.', '..'));

            if (empty($files)) {
                rmdir($folderPath);
            }
        }
    }
}
