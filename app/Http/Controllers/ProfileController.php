<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AlamatPengiriman;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        if (!Session::has('id_pelanggan')) {
            return redirect()->back()->withErrors('Customer ID not found in session.');
        }

        $data_pelanggan = DB::table('ebengkel_pkl.tb_pelanggan')
            ->where('id_pelanggan', Session::get('id_pelanggan'))
            ->first();

        if (!$data_pelanggan) {
            return redirect()->back()->withErrors('Customer data not found.');
        }

        $bulan = $request->input('bulan', date('Y-m'));
        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $logCounts = [];

        foreach ($days as $day) {
            $logCount = DB::table('tb_pelanggan')
                ->join('tb_log_pelanggan', 'tb_log_pelanggan.id_pelanggan', '=', 'tb_pelanggan.id_pelanggan')
                ->where('tb_log_pelanggan.delete_log_pelanggan', '=', 'N')
                ->whereRaw('date_format(tb_log_pelanggan.tgl_log_pelanggan, \'%Y-%m\') = ?', [$bulan])
                ->whereRaw('date_format(tb_log_pelanggan.tgl_log_pelanggan, \'%a\') = ?', [$day])
                ->where('tb_log_pelanggan.id_pelanggan', '=', Session::get('id_pelanggan'))
                ->count();

            $logCounts[$day] = $logCount;
        }

        return view('profile.index', [
            'data_pelanggan' => $data_pelanggan,
            'logCounts' => $logCounts,
            'days' => $days,
            'page' => 'dashboard',
        ]);
    }

    public function updateProfile(Request $request)
    {
        $pelanggan = Pelanggan::where('delete_pelanggan', 'N')
            ->where('id_pelanggan', Session::get('id_pelanggan'))
            ->first();

        if (!$pelanggan) {
            return back()->withErrors('User not found.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telp' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $pelanggan->nama_pelanggan = $request->input('nama');
        $pelanggan->telp_pelanggan = $request->input('telp');
        $pelanggan->email_pelanggan = $request->input('email');

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageName = 'foto_pelanggan_' . date('Ymd_His') . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/profile_picture'), $imageName);
            $pelanggan->foto_pelanggan = url('assets/images/profile_picture/' . $imageName);
        }

        $pelanggan->save();

        return back()->with('alert', 'success_Success to change your profile.');
    }
    public function showAddress()
    {
        $address = AlamatPengiriman::with('pelanggan')
            ->where('id_pelanggan', Session::get('id_pelanggan'))
            ->where('delete_alamat_pengiriman', 'N')
            ->get();
        return view('profile.address.index', compact('address'));
    }

    public function addAddress()
    {
        return view('profile.address.create');
    }
    public function storeAddress(Request $request)
    {
        // Validasi data
        $request->validate([
            'nama_alamat_pengiriman' => 'nullable|string',
            'kodepos_alamat_pengiriman' => 'nullable|string',
            'lat_alamat_pengiriman' => 'nullable|string',
            'long_alamat_pengiriman' => 'nullable|string',
            'lokasi_alamat_pengiriman' => 'nullable|string',
            'status_alamat_pengiriman' => 'nullable|string',
            'kota' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'kecamatan' => 'nullable|string',
        ]);

        // Ambil id pelanggan dari session
        $customerId = Session::get('id_pelanggan');

        // Simpan data ke dalam tabel
        AlamatPengiriman::create([
            'id_pelanggan' => $customerId,
            'nama_alamat_pengiriman' => $request->nama_alamat_pengiriman,
            'kodepos_alamat_pengiriman' => $request->kodepos_alamat_pengiriman,
            'lat_alamat_pengiriman' => $request->lat_alamat_pengiriman,
            'long_alamat_pengiriman' => $request->long_alamat_pengiriman,
            'lokasi_alamat_pengiriman' => $request->lokasi_alamat_pengiriman,
            'status_alamat_pengiriman' => $request->status_alamat_pengiriman,
            'kota' => $request->kota,
            'provinsi' => $request->provinsi,
            'kecamatan' => $request->kecamatan,
            'delete_alamat_pengiriman' => 'N',
        ]);

        return redirect()->route('profile.address')->with('success', 'Alamat pengiriman berhasil disimpan.');
    }
}
