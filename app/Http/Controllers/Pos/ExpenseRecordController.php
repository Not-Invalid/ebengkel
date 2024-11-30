<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bengkel;
use App\Models\ExpenseRecord;
use App\Models\JenisPengeluaran;
use Illuminate\Support\Facades\Auth;

class ExpenseRecordController extends Controller
{
    public function index($id_bengkel, Request $request)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }

        $perPage = $request->input('per_page', 10);

        $expenseRecords = ExpenseRecord::where('id_bengkel', $id_bengkel)
            ->where('is_delete', 'N')
            ->with('jenisPengeluaran')
            ->paginate($perPage);

        $totalEntries = $expenseRecords->total();
        $start = ($expenseRecords->currentPage() - 1) * $perPage + 1;
        $end = min($expenseRecords->currentPage() * $perPage, $totalEntries);


        return view('pos.accounting.expense-record.index', compact('bengkel', 'expenseRecords', 'totalEntries', 'start', 'end'));
    }

    public function create($id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }

        $expenseTypes = JenisPengeluaran::all();

        return view('pos.accounting.expense-record.create', compact('bengkel', 'expenseTypes'));
    }

    public function store($id_bengkel, Request $request)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }

        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:1000',
            'nominal' => 'required|integer',
            'id_jenis_pengeluaran' => 'required|integer|exists:m_jenis_pengeluaran,id_jenis_pengeluaran',
        ]);

        ExpenseRecord::create([
            'id_jenis_pengeluaran' => $request->input('id_jenis_pengeluaran'),
            'id_bengkel' => $id_bengkel,
            'keterangan' => $request->input('keterangan'),
            'tanggal' => $request->input('tanggal'),
            'nominal' => $request->input('nominal'),
            'input_by' => Auth::guard('pegawai')->user()->nama_pegawai,
            'input_date' => now(),
            'is_delete' => 'N',
        ]);

        return redirect()->route('pos.expense-record', ['id_bengkel' => $id_bengkel])
                         ->with('status', 'Expense record added successfully.');
    }

    public function edit($id_bengkel, $id)
    {
        $bengkel = Bengkel::find($id_bengkel);
        $expenseRecord = ExpenseRecord::find($id);

        if (!$bengkel || !$expenseRecord) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop or Expense record not found.');
        }

        $expenseTypes = JenisPengeluaran::all();

        return view('pos.accounting.expense-record.edit', compact('bengkel', 'expenseRecord', 'expenseTypes'));
    }

    public function update($id_bengkel, $id, Request $request)
    {
        $bengkel = Bengkel::find($id_bengkel);
        $expenseRecord = ExpenseRecord::find($id);

        if (!$bengkel || !$expenseRecord) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop or Expense record not found.');
        }

        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:1000',
            'nominal' => 'required|integer',
            'id_jenis_pengeluaran' => 'required|integer|exists:m_jenis_pengeluaran,id_jenis_pengeluaran',
        ]);

        $expenseRecord->update([
            'id_jenis_pengeluaran' => $request->input('id_jenis_pengeluaran'),
            'keterangan' => $request->input('keterangan'),
            'tanggal' => $request->input('tanggal'),
            'nominal' => $request->input('nominal'),
            'input_by' => Auth::guard('pegawai')->user()->nama_pegawai,
            'input_date' => now(),
        ]);

        return redirect()->route('pos.expense-record', ['id_bengkel' => $id_bengkel])
                         ->with('status', 'Expense record updated successfully.');
    }


    public function delete($id_bengkel, $id)
    {
        $bengkel = Bengkel::find($id_bengkel);
        $expenseRecord = ExpenseRecord::find($id);

        if (!$bengkel || !$expenseRecord) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop or Expense record not found.');
        }

        $expenseRecord->update(['is_delete' => 'Y']);

        return redirect()->route('pos.expense-record', ['id_bengkel' => $id_bengkel])
                         ->with('status', 'Expense record deleted successfully.');
    }
}
