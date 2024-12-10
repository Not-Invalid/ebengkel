<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bengkel;
use App\Models\PesananService;
use App\Models\Order;
use App\Models\OrderOnline;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\Border;

class TransactionHistoryController extends Controller
{
    public function index(Request $request, $id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);
        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }
        $pesanan = Order::where('id_order', $id_bengkel)
            ->where('is_delete', false)
            ->get(['id_order', 'nama', 'tipe', 'jenis_pembayaran', 'total_harga', 'input_by']);
        $pesanan_service = PesananService::where('id_bengkel', $id_bengkel)
            ->get(['id_pelanggan', 'nama_pemesan', 'status', 'total_pesanan']);
        $order_online = OrderOnline::where('id_bengkel', $id_bengkel)
            ->get(['id_pelanggan', 'total_harga', 'atas_nama']);
        $transactions = [];
        foreach ($pesanan as $order) {
            $transactions[] = [
                'customer_name' => $order->nama,
                'transaction_type' => $order->tipe,
                'payment_method' => $order->jenis_pembayaran,
                'total_price' => $order->total_harga,
                'cashier' => $order->input_by,
                'action' => 'View',
            ];
        }
        foreach ($pesanan_service as $service) {
            $transactions[] = [
                'customer_name' => $service->nama_pemesan,
                'transaction_type' => 'Service',
                'payment_method' => $service->status,
                'total_price' => $service->total_pesanan,
                'cashier' => $service->id_bengkel,
                'action' => 'View',
            ];
        }
        foreach ($order_online as $online_order) {
            $transactions[] = [
                'customer_name' => $online_order->atas_nama,
                'transaction_type' => 'Online Order',
                'payment_method' => 'transfer',
                'total_price' => $online_order->total_harga,
                'cashier' => $online_order->id_bengkel,
                'action' => 'View',
            ];
        }
        return view('pos.reports.transaction-history.index', compact('bengkel', 'transactions', 'id_bengkel'));
    }
    public function downloadPdf($id_bengkel)
    {
        $pesanan = Order::where('id_order', $id_bengkel)
            ->where('is_delete', false)
            ->get(['id_order', 'nama', 'tipe', 'jenis_pembayaran', 'total_harga', 'input_by']);
        $pesanan_service = PesananService::where('id_bengkel', $id_bengkel)
            ->get(['id_pelanggan', 'nama_pemesan', 'status', 'total_pesanan']);
        $order_online = OrderOnline::where('id_bengkel', $id_bengkel)
            ->get(['id_pelanggan', 'total_harga', 'status_order', 'atas_nama']);
        $transactions = [];
        foreach ($pesanan as $order) {
            $transactions[] = [
                'customer_name' => $order->nama,
                'transaction_type' => $order->tipe,
                'payment_method' => $order->jenis_pembayaran,
                'total_price' => $order->total_harga,
                'cashier' => $order->input_by,
                'action' => 'View',
            ];
        }
        foreach ($pesanan_service as $service) {
            $transactions[] = [
                'customer_name' => $service->nama_pemesan,
                'transaction_type' => 'Service',
                'payment_method' => $service->status,
                'total_price' => $service->total_pesanan,
                'cashier' => $service->id_bengkel,
                'action' => 'View',
            ];
        }
        foreach ($order_online as $online_order) {
            $transactions[] = [
                'customer_name' => $online_order->atas_nama,
                'transaction_type' => 'Online Order',
                'payment_method' => $online_order->status_order,
                'total_price' => $online_order->total_harga,
                'cashier' => $online_order->id_bengkel,
                'action' => 'View',
            ];
        }
        $data = [
            'title' => 'Checkout Transaction',
            'date' => date('d/m/Y'),
            'transaction' => $transactions
        ];
        $pdf = Pdf::loadView('pos.download.Transaction-history-pdf', $data);
        return $pdf->download('Transaction-history-pdf.pdf');
    }
    public function downloadExcel($id_bengkel)
    {
        $pesanan = Order::where('id_order', $id_bengkel)
            ->where('is_delete', false)
            ->get(['id_order', 'nama', 'tipe', 'jenis_pembayaran', 'total_harga', 'input_by']);
        $pesanan_service = PesananService::where('id_bengkel', $id_bengkel)
            ->get(['id_pelanggan', 'nama_pemesan', 'status', 'total_pesanan']);
        $order_online = OrderOnline::where('id_bengkel', $id_bengkel)
            ->get(['id_pelanggan', 'total_harga', 'status_order', 'atas_nama']);
        $transactions = [];
        foreach ($pesanan as $order) {
            $transactions[] = [
                'customer_name' => $order->nama,
                'transaction_type' => $order->tipe,
                'payment_method' => $order->jenis_pembayaran,
                'total_price' => $order->total_harga,
                'cashier' => $order->input_by,
            ];
        }
        foreach ($pesanan_service as $service) {
            $transactions[] = [
                'customer_name' => $service->nama_pemesan,
                'transaction_type' => 'Service',
                'payment_method' => $service->status,
                'total_price' => $service->total_pesanan,
                'cashier' => $service->id_bengkel,
            ];
        }
        foreach ($order_online as $online_order) {
            $transactions[] = [
                'customer_name' => $online_order->atas_nama,
                'transaction_type' => 'Online Order',
                'payment_method' => $online_order->status_order,
                'total_price' => $online_order->total_harga,
                'cashier' => $online_order->id_bengkel,
            ];
        }
        return Excel::download(new class($transactions) implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnWidths {
            protected $transactions;
            public function __construct($transactions)
            {
                $this->transactions = $transactions;
            }
            public function collection()
            {
                return collect($this->transactions);
            }
            public function headings(): array
            {
                return [
                    'Customer Name',
                    'Transaction Type',
                    'Payment Method',
                    'Total Price',
                    'Cashier',
                ];
            }
            public function title(): string
            {
                return 'Transaction History';
            }
            public function styles(Worksheet $sheet)
            {
                $sheet->getStyle('A2:E' . (count($this->transactions) + 1))
                    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle('A1:E1')->getFont()->setBold(true);
                $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A2:E' . (count($this->transactions) + 1))
                    ->getAlignment()->setHorizontal('center');
            }
            public function columnWidths(): array
            {
                return [
                    'A' => 20,
                    'B' => 20,
                    'C' => 20,
                    'D' => 20,
                    'E' => 20,
                ];
            }
            public function beforeExport(Worksheet $sheet)
            {
                $sheet->mergeCells('A1:E1');
                $sheet->setCellValue('A1', 'Transaction History');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
            }
        }, 'Transaction-History.xlsx');
    }
}
