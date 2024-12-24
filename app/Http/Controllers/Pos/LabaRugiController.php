<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\LabaRugi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class LabaRugiController extends Controller
{
    public function index(Request $request, $id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found!');
        }

        if (!Auth::guard('pegawai')->check()) {
            return redirect()->route('pos.login');
        }

        $perPage = $request->get('per_page', 10);

        $query = LabaRugi::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('tanggal', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $labarugi = $query->paginate($perPage);

        $totalEntries = $labarugi->total();
        $start = ($labarugi->currentPage() - 1) * $perPage + 1;
        $end = min($labarugi->currentPage() * $perPage, $totalEntries);

        $totalDebit = $query->sum('nominal_debit');
        $totalKredit = $query->sum('nominal_kredit');

        return view('pos.accounting.laporan-laba-rugi', compact('bengkel', 'labarugi', 'start', 'end', 'totalEntries', 'totalDebit', 'totalKredit'));
    }

    public function exportPdf(Request $request, $id_bengkel)
    {
        $bengkel = Bengkel::findOrFail($id_bengkel);
        $query = LabaRugi::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('tanggal', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $labarugi = $query->get();
        $totalDebit = $query->sum('nominal_debit');
        $totalKredit = $query->sum('nominal_kredit');

        $pdf = Pdf::loadView('pos.download.laporan-laba-rugi-pdf', compact('bengkel', 'labarugi', 'totalDebit', 'totalKredit'));
        return $pdf->download('laporan_laba_rugi.pdf');
    }

    public function exportExcel($id_bengkel)
    {
        $bengkel = Bengkel::findOrFail($id_bengkel);
        $query = LabaRugi::query();
        $labarugi = $query->get();
        $totalDebit = $query->sum('nominal_debit');
        $totalKredit = $query->sum('nominal_kredit');

        $fileName = 'laporan_laba_rugi.xlsx';

        return Excel::create($fileName, function ($excel) use ($labarugi, $totalDebit, $totalKredit) {
            $excel->sheet('Laporan Laba Rugi', function ($sheet) use ($labarugi, $totalDebit, $totalKredit) {
                $sheet->row(1, ['No', 'Tanggal', 'Keterangan', 'Nominal Debit', 'Nominal Kredit']);

                $row = 2;
                foreach ($labarugi as $index => $item) {
                    $sheet->row($row++, [
                        $index + 1,
                        $item->tanggal,
                        $item->keterangan,
                        $item->nominal_debit,
                        $item->nominal_kredit,
                    ]);
                }

                $sheet->row($row, ['Total', '', '', $totalDebit, $totalKredit]);
            });
        })->export('xlsx');
    }
}
