<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\PesananService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiPesananController extends Controller
{
    // Define the status options globally
    protected $statusNames = [
        'Pending' => 'Pending',
        'Waiting_List' => 'Waiting List',
        'Done' => 'Done',
    ];

// In TransaksiPesananController

    public function index($id_bengkel, Request $request)
    {
        $bengkel = Bengkel::find($id_bengkel);
        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop Not Found.');
        }

        $perPage = $request->get('per_page', 10);

        $orders = PesananService::with('service') // Eager load service relationship
            ->where('id_bengkel', $id_bengkel)
            ->orderBy('tgl_pesanan', 'desc')
            ->paginate($perPage);

        $totalEntries = $orders->total();
        $start = ($orders->currentPage() - 1) * $perPage + 1;
        $end = min($orders->currentPage() * $perPage, $totalEntries);

        return view('pos.master-transaksi.pesanan.index', compact('bengkel', 'orders', 'totalEntries', 'start', 'end', 'id_bengkel'));
    }

    public function create($id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }
        $services = $bengkel->services;

        return view('pos.master-transaksi.pesanan.create', [
            'bengkel' => $bengkel,
            'statusNames' => $this->statusNames,
            'services' => $services, // Pass services to the view
        ]);
    }

    public function store(Request $request, $id_bengkel)
    {
        // Validate the request
        $validStatuses = array_keys($this->statusNames);
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'tgl_pesanan' => 'required|date',
            'telp_pelanggan' => 'required|numeric',
            'nama_services' => 'required|exists:tb_services,id_services',
            'status' => ['required', 'in:' . implode(',', $validStatuses)],
            'total_pesanan' => 'required|numeric|min:0',
            'id_pelanggan' => 'nullable|exists:pelanggan,id',
        ]);

        // Store the PesananService
        $pesananService = PesananService::create([
            'id_bengkel' => $id_bengkel,
            'tgl_pesanan' => $request->tgl_pesanan,
            'nama_pemesan' => $request->nama_pemesan,
            'telp_pelanggan' => $request->telp_pelanggan,
            'nama_services' => $request->nama_services,
            'status' => $request->status,
            'total_pesanan' => $request->total_pesanan,
            'id_pelanggan' => $request->id_pelanggan,
            'id_pegawai' => Auth::guard('pegawai')->id(),
        ]);
        // Add to transaction history with payment method "cash" and cashier name
        $transactions[] = [
            'customer_name' => $pesananService->nama_pemesan,
            'transaction_type' => 'Service',
            'payment_method' => 'Cash',
            'total_price' => $pesananService->total_pesanan,

            'action' => 'View',
        ];

        // Redirect with success message
        return redirect()->route('pos.transaksi_pesanan.index', ['id_bengkel' => $id_bengkel])
            ->with('status', 'Order successfully created!');
    }

    public function edit($id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }

        $pesanan = PesananService::where('id_bengkel', $id_bengkel)->first();

        if (!$pesanan) {
            return redirect()->route('pos.transaksi_pesanan.index', ['id_bengkel' => $id_bengkel])
                ->with('status', 'No orders found for this workshop.');
        }

        // Retrieve the services related to the bengkel
        $services = $bengkel->services;

        // Pass services, statusNames, and pesanan to the view
        return view('pos.master-transaksi.pesanan.edit', [
            'bengkel' => $bengkel,
            'pesanan' => $pesanan,
            'statusNames' => $this->statusNames,
            'services' => $services, // Pass services to the view
        ]);
    }

    public function update(Request $request, $id_bengkel)
    {
        $validStatuses = array_keys($this->statusNames); // Use keys from statusNames
        $pesanan = PesananService::where('id_bengkel', $id_bengkel)->first();

        if (!$pesanan) {
            return redirect()->route('pos.transaksi_pesanan.index', ['id_bengkel' => $id_bengkel])
                ->with('status', 'Order Not Found.');
        }

        $request->validate([
            'tgl_pesanan' => 'required|date',
            'nama_pemesan' => 'required|string|max:255',
            'telp_pelanggan' => 'required|numeric',
            'nama_services' => 'required|string|max:255',
            'status' => ['required', 'in:' . implode(',', $validStatuses)], // Validate status
            'total_pesanan' => 'required|numeric|min:0',
        ]);

        $pesanan->update([
            'tgl_pesanan' => $request->tgl_pesanan,
            'nama_pemesan' => $request->nama_pemesan,
            'telp_pelanggan' => $request->telp_pelanggan,
            'nama_services' => $request->nama_services,
            'status' => $request->status, // The selected status value from the form
            'total_pesanan' => $request->total_pesanan,
        ]);

        return redirect()->route('pos.transaksi_pesanan.index', ['id_bengkel' => $id_bengkel])
            ->with('status', 'Order Updated Successfully.');
    }

    public function delete($id_bengkel)
    {
        $pesanan = PesananService::where('id_bengkel', $id_bengkel)->first();

        if (!$pesanan) {
            return redirect()->route('pos.transaksi_pesanan.index', ['id_bengkel' => $id_bengkel])
                ->with('status', 'No orders found for this workshop.');
        }

        $pesanan->delete();

        return redirect()->route('pos.transaksi_pesanan.index', ['id_bengkel' => $id_bengkel])
            ->with('status', 'Order deleted successfully.');
    }
}
