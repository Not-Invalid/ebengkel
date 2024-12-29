<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\Order;
use App\Models\OrderOnline;
use App\Models\Pegawai;
use App\Models\PesananService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionHistoryController extends Controller
{

    public function index(Request $request, $id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);
        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }

        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        $pesanan = Order::where('id_order', $id_bengkel)
            ->where('is_delete', false)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();

        $pesanan_service = PesananService::where('id_bengkel', $id_bengkel)
            ->whereBetween('tgl_pesanan', [$startDate, $endDate])
            ->get();

        $order_online = OrderOnline::where('id_bengkel', $id_bengkel)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();

        $transactions = [];

        foreach ($pesanan as $order) {
            $transactions[] = [
                'id' => $order->id_order,
                'customer_name' => $order->nama_customer,
                'transaction_type' => $order->tipe,
                'payment_method' => $order->jenis_pembayaran,
                'total_price' => $order->total_harga,
                'cashier' => $order->input_by,
            ];
        }

        $pegawaiData = Pegawai::where('id_bengkel', $id_bengkel)->get()->keyBy('id_pegawai');
        foreach ($pesanan_service as $service) {
            $cashier = $pegawaiData->get($service->id_pegawai);
            $transactions[] = [
                'id' => $service->id_pesanan_service,
                'customer_name' => $service->nama_pemesan,
                'transaction_type' => 'Service',
                'payment_method' => 'Cash',
                'total_price' => $service->total_pesanan,
                'cashier' => $cashier ? $cashier->nama_pegawai : 'Online Order',
            ];
        }

        foreach ($order_online as $online_order) {
            $transactions[] = [
                'id' => $online_order->id_order_online,
                'customer_name' => $online_order->atas_nama,
                'transaction_type' => 'Online Order',
                'payment_method' => 'Manual Transfer',
                'total_price' => $online_order->total_harga,
                'cashier' => '-',
            ];
        }

        $perPage = $request->get('per_page', 10);
        $currentPage = $request->get('page', 1);
        $totalEntries = count($transactions);
        $paginatedItems = new LengthAwarePaginator(
            collect($transactions)->forPage($currentPage, $perPage),
            $totalEntries,
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $start = $paginatedItems->firstItem();
        $end = $paginatedItems->lastItem();

        return view('pos.reports.transaction-history.index', compact(
            'bengkel',
            'paginatedItems',
            'id_bengkel',
            'startDate',
            'endDate',
            'start',
            'transactions',
            'end',
            'totalEntries'
        ));
    }

    public function downloadPdf($id_bengkel)
    {

        $pesanan = Order::where('id_order', $id_bengkel)
            ->where('is_delete', false)
            ->get(['id_order', 'nama_customer', 'tipe', 'jenis_pembayaran', 'total_harga', 'input_by']);
        $pesanan_service = PesananService::where('id_bengkel', $id_bengkel)
            ->get(['id_pelanggan', 'nama_pemesan', 'status', 'total_pesanan']);
        $order_online = OrderOnline::where('id_bengkel', $id_bengkel)
            ->get(['id_pelanggan', 'total_harga', 'status_order', 'atas_nama']);

        $transactions = [];
        foreach ($pesanan as $order) {
            $transactions[] = [
                'customer_name' => $order->nama_customer,
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
            'transaction' => $transactions,
        ];

        $html = view('pos.download.Transaction-history-pdf', $data)->render();

        $mpdf = new Mpdf();

        $mpdf->WriteHTML($html);

        return response($mpdf->Output('Transaction-history-pdf.pdf', 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Transaction-history-pdf.pdf"',
        ]);
    }

    public function downloadExcel($id_bengkel)
    {
        $pesanan = Order::where('id_order', $id_bengkel)
            ->where('is_delete', false)
            ->get(['id_order', 'nama_customer', 'tipe', 'jenis_pembayaran', 'total_harga', 'input_by']);
        $pesanan_service = PesananService::where('id_bengkel', $id_bengkel)
            ->get(['id_pelanggan', 'nama_pemesan', 'status', 'total_pesanan']);
        $order_online = OrderOnline::where('id_bengkel', $id_bengkel)
            ->get(['id_pelanggan', 'total_harga', 'status_order', 'atas_nama']);
        $transactions = [];
        foreach ($pesanan as $order) {
            $transactions[] = [
                'customer_name' => $order->nama_customer,
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
        return Excel::download(new class($transactions) implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnWidths
        {
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

    public function printRowPdf($id)
    {

        $transaction = $this->getTransactionById($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $data = [
            'title' => 'Transaction Detail',
            'date' => date('d/m/Y'),
            'transaction' => $transaction,
        ];

        $html = view('pos.download.transaction-row-pdf', $data)->render();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);

        return response($mpdf->Output('Transaction-row.pdf', 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Transaction-row.pdf"',
        ]);
    }

    public function printRowExcel($id)
    {
        $transaction = $this->getTransactionById($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        return Excel::download(new class([$transaction]) implements FromCollection, WithHeadings
        {
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
        }, 'Transaction-row.xlsx');
    }

    private function getTransactionById($id)
    {
        $order = Order::find($id);
        if ($order) {
            return [
                'id' => $order->id_order,
                'customer_name' => $order->nama_customer,
                'transaction_type' => $order->tipe,
                'payment_method' => $order->jenis_pembayaran,
                'total_price' => $order->total_harga,
                'cashier' => $order->input_by,
            ];
        }

        $service = PesananService::find($id);
        if ($service) {
            return [
                'id' => $service->id_pesanan_service,
                'customer_name' => $service->nama_pemesan,
                'transaction_type' => 'Service',
                'payment_method' => 'Cash',
                'total_price' => $service->total_pesanan,
                'cashier' => $service->id_bengkel,
            ];
        }

        $onlineOrder = OrderOnline::find($id);
        if ($onlineOrder) {
            return [
                'id' => $onlineOrder->id_order_online,
                'customer_name' => $onlineOrder->atas_nama,
                'transaction_type' => 'Online Order',
                'payment_method' => $onlineOrder->status_order,
                'total_price' => $onlineOrder->total_harga,
                'cashier' => $onlineOrder->id_bengkel,
            ];
        }

        return null;
    }

}
