<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\Pegawai;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PesananService;
use Illuminate\Support\Facades\Guard;

class ServiceOrderController extends Controller
{
    public function index($id_bengkel, Request $request)
    {
        $bengkel = Bengkel::find($id_bengkel);
        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop Not Found.');
        }
        $perPage = $request->get('per_page', 10);

        // Eager load the pegawai relationship
        $orders = PesananService::with('pegawai')
            ->where('id_bengkel', $id_bengkel)
            ->orderBy('tgl_pesanan', 'desc')
            ->paginate($perPage);

        $totalEntries = $orders->total();
        $start = ($orders->currentPage() - 1) * $perPage + 1;
        $end = min($orders->currentPage() * $perPage, $totalEntries);
        return view('pos.order.service-order.index', compact('bengkel', 'orders', 'totalEntries', 'start', 'end', 'id_bengkel'));
    }
    public function create($id_bengkel)
    {
        $bengkel = Bengkel::findOrFail($id_bengkel);
        $services = Service::where('id_bengkel', $id_bengkel)->get();
        return view('pos.order.service-order.create', compact('bengkel', 'services'));
    }
    public function store(Request $request, $id_bengkel)
    {
        $pegawai = Auth::guard('pegawai')->user();
        if (!$pegawai) {
            return redirect()->back()->withErrors(['error' => 'Employee not authenticated.']);
        }
        $id_pegawai = $pegawai->id_pegawai;
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'telp_pelanggan' => 'required|digits_between:10,15',
            'nama_services' => 'required|exists:tb_services,id_services',
        ]);
        $service = Service::findOrFail($request->nama_services);
        $today = now()->format('Y-m-d');
        $existingOrdersCount = PesananService::where('id_bengkel', $id_bengkel)
            ->where('tgl_pesanan', $today)
            ->where('nama_services', $service->id_services)
            ->count();
        if ($existingOrdersCount >= $service->jumlah_services_offline) {
            return redirect()->back()->withErrors(['error' => 'No more offline services available for today.']);
        }
        PesananService::create([
            'id_pelanggan' => null,
            'id_bengkel' => $id_bengkel,
            'telp_pelanggan' => $request->telp_pelanggan,
            'nama_pemesan' => $request->nama_pemesan,
            'tgl_pesanan' => now(),
            'nama_services' => $service->nama_services,
            'jumlah_services_offline' => $existingOrdersCount + 1,
            'status' => 'Waiting_List',
            'total_pesanan' => $service->harga_services,
            'id_pegawai' => $id_pegawai,
        ]);
        return redirect()->route('pos.service-order', ['id_bengkel' => $id_bengkel])
            ->with('status', 'Service order created successfully.');
    }
    public function updateStatus(Request $request, $id_bengkel, $id)
    {
        $pesanan = PesananService::findOrFail($id);
        $pesanan->status = 'DONE';
        $pesanan->save();
        return redirect()->back()->with('status', 'Order status updated to DONE successfully.');
    }
    public function delete($id_bengkel)
    {
        $pesanan = PesananService::where('id_bengkel', $id_bengkel)->first();

        if (!$pesanan) {
            return redirect()->route('', ['id_bengkel' => $id_bengkel])
                ->with('status', 'No orders found for this workshop.');
        }

        $pesanan->delete();

        return redirect()->route('pos.service-order', ['id_bengkel' => $id_bengkel])
            ->with('status', 'Order deleted successfully.');
    }
}
