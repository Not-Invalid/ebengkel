<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\PesananService;

class ServiceOrderController extends Controller
{
    public function index($id_bengkel, Request $request)
    {
        $bengkel = Bengkel::find($id_bengkel);
        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop Not Found.');
        }
        $perPage = $request->get('per_page', 10);

        $orders = PesananService::with('pelanggan')
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
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }

        $services = Service::where('id_bengkel', $id_bengkel)
            ->where('delete_services', 'N')
            ->get();

        return view('pos.order.service-order.create', compact('bengkel', 'services'));
    }

    public function store(Request $request, $id_bengkel)
    {
        $request->validate([
            'nama_pemesan'   => 'required|string|max:255',
            'tgl_pesanan'    => 'required|date',
            'telp_pelanggan' => 'required|numeric',
            'nama_service'   => 'required|string|max:255',
            'service_type'   => 'required|string',
            'status'         => 'required|string|max:50',
            'total_pesanan'  => 'required|numeric|min:0',
        ]);

        // Cari service berdasarkan nama_service yang dipilih
        $service = Service::where('nama_services', $request->nama_service)->first();

        // Jika service tidak ditemukan
        if (!$service) {
            return back()->withInput()->with('status', 'Service tidak ditemukan!');
        }

        // Tentukan stok yang sesuai berdasarkan tipe layanan (online atau offline)
        if ($request->service_type === 'online') {
            $stok = $service->jumlah_services_online;
        } else {
            $stok = $service->jumlah_services_offline;
        }

        // Cek apakah stok tersedia
        if ($stok > 0) {
            // Kurangi stok jika tersedia
            if ($request->service_type === 'online') {
                $service->jumlah_services_online -= 1;
            } else {
                $service->jumlah_services_offline -= 1;
            }
            $service->save();

            // Simpan pesanan
            PesananService::create([
                'id_bengkel'     => $id_bengkel,
                'tgl_pesanan'    => $request->tgl_pesanan,
                'nama_pemesan'   => $request->nama_pemesan,
                'telp_pelanggan' => $request->telp_pelanggan,
                'nama_service'   => $request->nama_service,
                'service_type'   => $request->service_type,
                'status'         => $request->status,
                'total_pesanan'  => $request->total_pesanan,
            ]);

            return redirect()->route('pos.service-order', ['id_bengkel' => $id_bengkel])
                ->with('status', 'Order Waiting List!');
        }

        // Jika stok tidak tersedia
        return back()->withInput()->with('status', 'Tidak ada stok!');
    }

    public function edit($id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }

        $pesanan = PesananService::where('id_bengkel', $id_bengkel)->first();

        if (!$pesanan) {
            return redirect()->route('pos.tranksaksi_pesanan.index', ['id_bengkel' => $id_bengkel])
                ->with('status', 'No orders found for this workshop.');
        }

        return view('', compact('bengkel', 'pesanan'));
    }

    public function update(Request $request, $id_bengkel)
    {
        $pesanan = PesananService::where('id_bengkel', $id_bengkel)->first();

        if (!$pesanan) {
            return redirect()->route('pos.tranksaksi_pesanan.index', ['id_bengkel' => $id_bengkel])
                ->with('status', 'Order Not Found.');
        }

        $request->validate([
            'tgl_pesanan'    => 'required|date',
            'nama_pemesan'   => 'required|string|max:255',
            'telp_pelanggan' => 'required|numeric',
            'nama_service'   => 'required|string|max:255',
            'status'         => 'required|string|max:50',
            'total_pesanan'  => 'required|numeric|min:0',
        ]);

        $pesanan->update([
            'tgl_pesanan'    => $request->tgl_pesanan,
            'nama_pemesan'   => $request->nama_pemesan,
            'telp_pelanggan' => $request->telp_pelanggan,
            'nama_service'   => $request->nama_service,
            'status'         => $request->status,
            'total_pesanan'  => $request->total_pesanan,
        ]);

        return redirect()->route('', ['id_bengkel' => $id_bengkel])
            ->with('status', 'Order Updated Successfully.');
    }

    public function delete($id_bengkel)
    {
        $pesanan = PesananService::where('id_bengkel', $id_bengkel)->first();

        if (!$pesanan) {
            return redirect()->route('', ['id_bengkel' => $id_bengkel])
                ->with('status', 'No orders found for this workshop.');
        }

        $pesanan->delete();

        return redirect()->route('', ['id_bengkel' => $id_bengkel])
            ->with('status', 'Order deleted successfully.');
    }
}
