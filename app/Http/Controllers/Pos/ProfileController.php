<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Bengkel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function index($id_bengkel)
    {

        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Bengkel tidak ditemukan.');
        }

        $pegawai = Auth::guard('pegawai')->user();
        return view('pos.profile.index', compact('pegawai', 'bengkel'));
    }

    public function update(Request $request, $id_pegawai, $id_bengkel)
    {

        $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'email_pegawai' => 'required|email|max:255',
            'telp_pegawai' => 'nullable|string|max:15',
            'foto_pegawai' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pegawai = Pegawai::findOrFail($id_pegawai);
        $bengkel = Bengkel::findOrFail($id_bengkel);

        $pegawai->nama_pegawai = $request->input('nama_pegawai');
        $pegawai->email_pegawai = $request->input('email_pegawai');
        $pegawai->telp_pegawai = $request->input('telp_pegawai');

        if ($request->hasFile('foto_pegawai') && $request->file('foto_pegawai')->isValid()) {
            $image = $request->file('foto_pegawai');

            $imageName = 'foto_pegawai_' . date('Ymd_His') . '.webp';
            $tempPath = $image->getPathName();

            $img = imagecreatefromstring(file_get_contents($tempPath));

            if ($img) {
                $webpPath = public_path('assets/images/profile_picture/' . $imageName);

                if (imagewebp($img, $webpPath, 90)) {
                    imagedestroy($img);

                    // Simpan URL gambar ke dalam database
                    $pegawai->foto_pegawai = url('assets/images/profile_picture/' . $imageName);
                } else {
                    Log::error('Gagal mengkonversi gambar ke WebP.');
                }
            } else {
                Log::error('Gagal membuat gambar dari string.');
            }
        } else {
            Log::info('Foto pegawai tidak ada atau tidak valid.');
        }


        $pegawai->save();

        return redirect()->route('profile-pegawai', ['id_bengkel' => $bengkel->id_bengkel, 'id_pegawai' => $pegawai->id_pegawai])
        ->with('status', 'Profile updated successfully.');

    }
}
