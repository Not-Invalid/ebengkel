<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bengkel;
use App\Models\JenisPengeluaran;

class JenisPengeluaranController extends Controller
{
    public function index($id_bengkel, Request $request)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }

        $perPage = $request->get('per_page', 10);

        $jenisPengeluaran = JenisPengeluaran::where('is_delete', 'N')
            ->paginate($perPage);


        $totalEntries = $jenisPengeluaran->total();
        $start = ($jenisPengeluaran->currentPage() - 1) * $perPage + 1;
        $end = min($jenisPengeluaran->currentPage() * $perPage, $totalEntries);

        return view('pos.masterdata-expense-type.index', compact('bengkel', 'jenisPengeluaran', 'totalEntries', 'start', 'end'));
    }


    public function create($id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }

        return view('pos.masterdata-expense-type.create', compact('bengkel'));
    }

    public function store(Request $request, $id_bengkel)
    {
        $request->validate([
            'nama_jenis_pengeluaran' => 'required|string|max:100',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }

        JenisPengeluaran::create([
            'nama_jenis_pengeluaran' => $request->nama_jenis_pengeluaran,
            'keterangan' => $request->keterangan,
            'is_delete' => 'N',
        ]);

        return redirect()->route('pos.expense-type', ['id_bengkel' => $id_bengkel])
            ->with('status', 'Expense Type created successfully!');
    }


    public function edit($id_bengkel, $id_jenis_pengeluaran)
    {
        $bengkel = Bengkel::find($id_bengkel);
        $jenisPengeluaran = JenisPengeluaran::find($id_jenis_pengeluaran);

        if (!$bengkel || !$jenisPengeluaran) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop or Expense Type not found.');
        }

        return view('pos.masterdata-expense-type.edit', compact('bengkel', 'jenisPengeluaran'));
    }


    public function update(Request $request, $id_bengkel, $id_jenis_pengeluaran)
    {
        $request->validate([
            'nama_jenis_pengeluaran' => 'required|string|max:100',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $bengkel = Bengkel::find($id_bengkel);
        $jenisPengeluaran = JenisPengeluaran::find($id_jenis_pengeluaran);

        if (!$bengkel || !$jenisPengeluaran) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop or Expense Type not found.');
        }

        $jenisPengeluaran->update([
            'nama_jenis_pengeluaran' => $request->nama_jenis_pengeluaran,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('pos.expense-type', ['id_bengkel' => $id_bengkel])
            ->with('status', 'Expense Type updated successfully!');
    }

    public function destroy($id_bengkel, $id_jenis_pengeluaran)
    {
        $bengkel = Bengkel::find($id_bengkel);
        $jenisPengeluaran = JenisPengeluaran::find($id_jenis_pengeluaran);

        if (!$bengkel || !$jenisPengeluaran) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop or Expense Type not found.');
        }

        $jenisPengeluaran->update([
            'is_delete' => 'Y',
        ]);

        return redirect()->route('pos.expense-type', ['id_bengkel' => $id_bengkel])
            ->with('status', 'Expense Type deleted successfully!');
    }
}
