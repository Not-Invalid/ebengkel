<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bengkel;
use App\Models\Order;
use App\Models\OrderOnline;
use App\Models\PesananService;
use App\Models\ExpenseRecord;
use Carbon\Carbon;

class AchievementSummaryController extends Controller
{
    public function index($id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }

        $currentYear = Carbon::now()->year;

        // Data revenue
        $salesOnlineCurrentYear = OrderOnline::whereYear('tanggal', $currentYear)
            ->where('status_order', 'SELESAI')
            ->selectRaw('MONTH(tanggal) as month, SUM(total_harga) as total_sales, COUNT(*) as total_qty')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $salesOrderCurrentYear = Order::whereYear('tanggal', $currentYear)
            ->where('status', 'SUCCESS')
            ->selectRaw('MONTH(tanggal) as month, SUM(total_harga) as total_sales, SUM(total_qty) as total_qty')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $salesServiceCurrentYear = PesananService::whereYear('tgl_pesanan', $currentYear)
            ->where('status', 'COMPLETED')
            ->selectRaw('MONTH(tgl_pesanan) as month, SUM(total_pesanan) as total_sales, COUNT(*) as total_qty')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Menghitung total revenue
        $totalRevenue = $this->calculateTotalRevenue($salesOnlineCurrentYear, $salesOrderCurrentYear, $salesServiceCurrentYear);

        // Menghitung total qty
        $totalQty = $this->calculateTotalQty($salesOnlineCurrentYear, $salesOrderCurrentYear, $salesServiceCurrentYear);

        $totalExpenses = $this->calculateTotalExpenses($id_bengkel, $currentYear);

        // Data untuk grafik
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $chartData = [
            'labels' => $months,
            'data' => [
                'current_year' => [
                    'order_online' => $this->getMonthlyData($salesOnlineCurrentYear),
                    'order' => $this->getMonthlyData($salesOrderCurrentYear),
                    'service' => $this->getMonthlyData($salesServiceCurrentYear),
                ],
            ],
        ];

        return view('pos.reports.achievement-summary.index', compact('bengkel', 'chartData', 'currentYear', 'totalRevenue', 'totalQty', 'totalExpenses'));
    }

    private function calculateTotalQty($salesOnline, $salesOrder, $salesService)
    {
        $totalQty = 0;

        foreach ($salesOnline as $sale) {
            $totalQty += $sale->total_qty;
        }

        foreach ($salesOrder as $sale) {
            $totalQty += $sale->total_qty;
        }

        foreach ($salesService as $sale) {
            $totalQty += $sale->total_qty;
        }

        return $totalQty;
    }


    private function getMonthlyData($sales)
    {
        $monthlyData = array_fill(0, 12, 0);

        foreach ($sales as $sale) {
            $monthlyData[$sale->month - 1] = (int) $sale->total_sales;
        }

        return $monthlyData;
    }

    private function calculateTotalRevenue($salesOnline, $salesOrder, $salesService)
    {
        $totalRevenue = 0;


        foreach ($salesOnline as $sale) {
            $totalRevenue += $sale->total_sales;
        }

        foreach ($salesOrder as $sale) {
            $totalRevenue += $sale->total_sales;
        }

        foreach ($salesService as $sale) {
            $totalRevenue += $sale->total_sales;
        }

        return $totalRevenue;
    }

    protected function calculateTotalExpenses($id_bengkel, $currentYear)
    {

            $totalExpenses = ExpenseRecord::whereYear('tanggal', $currentYear)
            ->where('id_bengkel', $id_bengkel)
            ->where('is_delete', 'N')
            ->sum('nominal');

        return $totalExpenses;
    }

}
