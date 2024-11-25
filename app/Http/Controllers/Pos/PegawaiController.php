<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bengkel;
use App\Models\Pegawai;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    public function index($id_bengkel, Request $request)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }

        $perPage = $request->get('per_page', 10);

        $pegawai = Pegawai::where('id_bengkel', $id_bengkel)
                            ->where('delete_pegawai', 'N')
                            ->whereIn('role', ['Administrator', 'Cashier'])
                            ->paginate($perPage);

        return view('pos.management-staff.index', compact('bengkel', 'pegawai'));
    }

    public function create($id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }

        $randomPassword = Str::random(8);

        return view('pos.management-staff.create', compact('bengkel', 'randomPassword'));
    }

    public function store(Request $request, $id_bengkel)
    {

        $validatedData = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'email_pegawai' => 'required|email|unique:tb_pegawai,email_pegawai',
            'telp_pegawai' => 'required|string|max:15',
            'role' => 'required|in:Administrator,Cashier,Outlet',
        ]);

        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }

        $randomPassword = Str::random(8);

        $hashedPassword = Hash::make($randomPassword);

        $pegawai = new Pegawai();
        $pegawai->id_bengkel = $id_bengkel;
        $pegawai->nama_pegawai = $validatedData['nama_pegawai'];
        $pegawai->email_pegawai = $validatedData['email_pegawai'];
        $pegawai->telp_pegawai = $validatedData['telp_pegawai'];
        $pegawai->role = $validatedData['role'];
        $pegawai->password_pegawai = $hashedPassword;
        $pegawai->delete_pegawai = 'N';
        $pegawai->save();

        return redirect()->route('pos.management-staff', ['id_bengkel' => $id_bengkel])
            ->with('status', 'Staff successfully added.');
    }

    public function edit($id_bengkel, $id_pegawai)
    {

        $bengkel = Bengkel::findOrFail($id_bengkel);
        $pegawai = Pegawai::findOrFail($id_pegawai);

        return view('pos.management-staff.edit', compact('bengkel', 'pegawai'));
    }

    public function update(Request $request, $id_bengkel, $id_pegawai)
    {
        $validated = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'email_pegawai' => 'required|email|unique:tb_pegawai,email_pegawai,' . $id_pegawai . ',id_pegawai',
            'telp_pegawai' => 'required|string|max:20',
            'role' => 'required|string|in:Administrator,Cashier',
        ]);

        $pegawai = Pegawai::findOrFail($id_pegawai);

        $pegawai->nama_pegawai = $validated['nama_pegawai'];
        $pegawai->email_pegawai = $validated['email_pegawai'];
        $pegawai->telp_pegawai = $validated['telp_pegawai'];
        $pegawai->role = $validated['role'];
        $pegawai->save();

        return redirect()->route('pos.management-staff', ['id_bengkel' => $id_bengkel])
                        ->with('status', 'Staff updated successfully');
    }

    public function delete($id_bengkel, $id_pegawai)
    {

        $pegawai = Pegawai::findOrFail($id_pegawai);

        $pegawai->delete();

        return redirect()->route('pos.management-staff', ['id_bengkel' => $id_bengkel])->with('status', 'Staff deleted successfully');
    }
}
