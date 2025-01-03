<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\LabaRugi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;

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

        return view('pos.accounting.report-profit-loss', compact('bengkel', 'labarugi', 'start', 'end', 'totalEntries', 'totalDebit', 'totalKredit'));
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

        $html = view('pos.download.laporan-laba-rugi-pdf', compact('bengkel', 'labarugi', 'totalDebit', 'totalKredit'))->render();

        // Generate PDF using mPDF
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('laporan_laba_rugi.pdf', 'D');
    }

    public function exportExcel(Request $request, $id_bengkel)
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

        // Menyiapkan data untuk Excel
        $data = [];
        $data[] = ['No', 'Tanggal', 'Keterangan', 'Nominal Debit', 'Nominal Kredit'];

        foreach ($labarugi as $index => $item) {
            $data[] = [
                $index + 1,
                $item->tanggal,
                $item->keterangan,
                $item->nominal_debit,
                $item->nominal_kredit,
            ];
        }

        // Tambahkan baris total
        $data[] = ['Total', '', '', $totalDebit, $totalKredit];

        // Generate Excel dengan Laravel Excel
        return Excel::download(new class($data) implements \Maatwebsite\Excel\Concerns\FromArray
        {
            protected $data;

            public function __construct(array $data)
            {
                $this->data = $data;
            }

            public function array(): array
            {
                return $this->data;
            }
        }, 'laporan_laba_rugi.xlsx');
    }

}
