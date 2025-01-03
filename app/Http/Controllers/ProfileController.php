<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AlamatPengiriman;
use App\Models\Bengkel;
use App\Models\Pelanggan;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
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
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pelanggan->nama_pelanggan = $request->input('nama');
        $pelanggan->telp_pelanggan = $request->input('telp');
        $pelanggan->email_pelanggan = $request->input('email');

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageName = 'foto_pelanggan_' . date('Ymd_His') . '.webp';

            $img = imagecreatefromstring(file_get_contents($image));

            if ($img) {
                if (!imageistruecolor($img)) {
                    $trueColorImg = imagecreatetruecolor(imagesx($img), imagesy($img));
                    imagecopy($trueColorImg, $img, 0, 0, 0, 0, imagesx($img), imagesy($img));
                    imagedestroy($img);
                    $img = $trueColorImg;
                }

                imagewebp($img, public_path('assets/images/profile_picture/' . $imageName), 90);
                imagedestroy($img);
            }

            $pelanggan->foto_pelanggan = url('assets/images/profile_picture/' . $imageName);
        }

        $pelanggan->save();

        return back()->with('status', 'Update profile is successful!');
    }


    public function showAddress()
    {
        if (!Session::has('id_pelanggan')) {
            return redirect()->route('home')->with('error_status', 'You must be logged in to add an address.');
        }
        $address = AlamatPengiriman::with('pelanggan')
            ->where('id_pelanggan', Session::get('id_pelanggan'))
            ->where('delete_alamat_pengiriman', 'N')
            ->get();
        return view('profile.address.index', compact('address'));
    }

    public function addAddress()
    {
        if (!Session::has('id_pelanggan')) {
            return redirect()->route('home')->with('error_status', 'You must be logged in to add an address.');
        }
        $provinces = Provinsi::all();
        return view('profile.address.create', compact('provinces'));
    }
    public function getLocations(Request $request)
    {
        $response = [];

        if ($request->has('province_id')) {
            $cities = Kota::where('province_id', $request->province_id)->get();
            $response['cities'] = $cities;
        }

        if ($request->has('city_id')) {
            $subdistricts = Kecamatan::where('city_id', $request->city_id)->get();
            $response['subdistricts'] = $subdistricts;
        }

        return response()->json($response);
    }
    public function storeAddress(Request $request)
    {
        // Validasi data
        $request->validate([
            'nama_penerima' => 'nullable|string',
            'telp_penerima' => 'nullable|string',
            'lokasi_alamat_pengiriman' => 'nullable|string',
            'kodepos_alamat_pengiriman' => 'nullable|string',
            'lat_alamat_pengiriman' => 'nullable|string',
            'long_alamat_pengiriman' => 'nullable|string',
            'status_alamat_pengiriman' => 'nullable|string',
            'provinsi_id' => 'nullable|string',
            'kota_id' => 'nullable|string',
            'kecamatan_id' => 'nullable|string',
        ]);

        // Ambil id pelanggan dari session
        $customerId = Session::get('id_pelanggan');

        // Simpan data ke dalam tabel
        AlamatPengiriman::create([
            'id_pelanggan' => $customerId,
            'nama_penerima' => $request->nama_penerima,
            'telp_penerima' => $request->telp_penerima,
            'lokasi_alamat_pengiriman' => $request->lokasi_alamat_pengiriman,
            'kodepos_alamat_pengiriman' => $request->kodepos_alamat_pengiriman,
            'lat_alamat_pengiriman' => $request->lat_alamat_pengiriman,
            'long_alamat_pengiriman' => $request->long_alamat_pengiriman,
            'status_alamat_pengiriman' => $request->status_alamat_pengiriman,
            'provinsi_id' => $request->provinsi_id,
            'kota_id' => $request->kota_id,
            'kecamatan_id' => $request->kecamatan_id,
            'delete_alamat_pengiriman' => 'N',
        ]);

        return redirect()->route('profile.address')->with('status', 'Shipping address successfully saved.');
    }
    public function editAddress($id)
    {
        $customerId = Session::get('id_pelanggan');

        $address = AlamatPengiriman::where('id_alamat_pengiriman', $id)
            ->where('id_pelanggan', $customerId)
            ->first();

        if (!$address) {
            return redirect()->route('profile.address')->with('error_status', 'Address not found.');
        }

        $provinces = Provinsi::all();
        $cities = Kota::where('province_id', $address->provinsi_id)->get();
        $subdistricts = Kecamatan::where('city_id', $address->kota_id)->get();

        return view('profile.address.edit', compact('address', 'provinces', 'cities', 'subdistricts'));
    }
    public function updateAddress(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'nama_penerima' => 'nullable|string',
            'telp_penerima' => 'nullable|string',
            'lokasi_alamat_pengiriman' => 'nullable|string',
            'kodepos_alamat_pengiriman' => 'nullable|string',
            'lat_alamat_pengiriman' => 'nullable|string',
            'long_alamat_pengiriman' => 'nullable|string',
            'status_alamat_pengiriman' => 'nullable|string',
            'provinsi_id' => 'nullable|string',
            'kota_id' => 'nullable|string',
            'kecamatan_id' => 'nullable|string',
        ]);

        $customerId = Session::get('id_pelanggan');

        // Pastikan alamat adalah milik pelanggan yang sedang login
        $address = AlamatPengiriman::where('id_alamat_pengiriman', $id)
            ->where('id_pelanggan', $customerId)
            ->first();

        if (!$address) {
            return redirect()->route('profile.address')->with('status_error', 'Address not found or no access.');
        }

        $address->update([
            'nama_penerima' => $request->nama_penerima,
            'telp_penerima' => $request->telp_penerima,
            'lokasi_alamat_pengiriman' => $request->lokasi_alamat_pengiriman,
            'kodepos_alamat_pengiriman' => $request->kodepos_alamat_pengiriman,
            'lat_alamat_pengiriman' => $request->lat_alamat_pengiriman,
            'long_alamat_pengiriman' => $request->long_alamat_pengiriman,
            'status_alamat_pengiriman' => $request->status_alamat_pengiriman,
            'provinsi_id' => $request->provinsi_id,
            'kota_id' => $request->kota_id,
            'kecamatan_id' => $request->kecamatan_id,
        ]);

        return redirect()->route('profile.address')->with('status', 'Shipping address successfully updated.');
    }
    public function delete($id_alamat_pengiriman)
    {
        $address = DB::table('tb_alamat_pengiriman')->where('id_alamat_pengiriman', $id_alamat_pengiriman)->first();

        if ($address) {
            DB::table('tb_alamat_pengiriman')->where('id_alamat_pengiriman', $id_alamat_pengiriman)->update([
                'delete_alamat_pengiriman' => 'Y',
            ]);
            return back()->with('status', 'Address deleted successfully.');
        } else {
            return back()->with('error_status', 'Address not found.');
        }
    }
    public function showSetting(Request $request)
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

        return view('profile.setting.index', [
            'data_pelanggan' => $data_pelanggan,
            'logCounts' => $logCounts,
            'days' => $days,
        ]);
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'currentPassword' => 'required|string',
            'newPassword' => 'required|string|min:8|confirmed',
        ]);

        $pelanggan = Pelanggan::where('id_pelanggan', Session::get('id_pelanggan'))->first();

        if (!$pelanggan) {
            return back()->withErrors('User not found.');
        }

        if (!password_verify($request->input('currentPassword'), $pelanggan->password_pelanggan)) {
            return back()->withErrors('Current password is incorrect.');
        }

        $pelanggan->update([
            'password_pelanggan' => Hash::make($request->input('newPassword')),
        ]);

        Auth::guard('pelanggan')->logout();

        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Password successfully reset! Please login again.');
    }

}
