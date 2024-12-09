<?php

namespace App\Http\Controllers;

use App\Models\OrderOnline;
use App\Models\OrderItemOnline;
use App\Models\Invoice;
use App\Models\Bengkel;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request, $order_id, $id)
    {
        // Retrieve the order using the order_id
        $order = OrderOnline::where('order_id', $order_id)->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Order tidak ditemukan.');
        }

        // Retrieve the invoice using the invoice_id
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return redirect()->route('home')->with('error', 'Invoice tidak ditemukan.');
        }

        $bengkel = Bengkel::find($order->id_bengkel);

        if (!$bengkel) {
            return redirect()->route('home')->with('error', 'Bengkel tidak ditemukan untuk order ini.');
        }

        $orderItems = OrderItemOnline::with(['produk', 'sparepart'])
            ->where('id_order_online', $order->id)
            ->get();

        $produkItem = null;
        $sparepartItem = null;
        foreach ($orderItems as $item) {
            if ($item->id_produk) {
                $produkItem = $item->produk;
            } else {
                $sparepartItem = $item->sparepart;
            }
        }

        $paymentMethods = $bengkel->payment ? json_decode($bengkel->payment, true) : [];
        $rekeningBank = $bengkel->rekening_bank ? json_decode($bengkel->rekening_bank, true) : [];

        return view('transaction.payment', compact('order', 'produkItem', 'sparepartItem', 'bengkel', 'paymentMethods', 'rekeningBank', 'invoice'));
    }

    public function store(Request $request)
{
    // Validate form input
    $validated = $request->validate([
        'nama_rekening' => 'required|string|max:100',
        'no_rekening' => 'required|string|max:50',
        'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'id' => 'required|integer', // Validasi id invoice (menggunakan id bukan invoice_id)
    ]);

    // Retrieve the order using the order_id
    $order = OrderOnline::where('order_id', $request->order_id)->first();

    if (!$order) {
        return redirect()->route('home')->with('error', 'Order tidak ditemukan.');
    }

    // Retrieve the invoice using the id from the request
    $invoice = Invoice::find($request->id);  // Perbaiki di sini, menggunakan `id`

    if (!$invoice) {
        return redirect()->route('payment', ['order_id' => $order->order_id, 'invoice_id' => $request->id])
            ->with('error', 'Invoice tidak ditemukan.');
    }

    // Process payment (file upload, status change, etc.)
    $buktiBayarPath = null;
    if ($request->hasFile('bukti_bayar')) {
        $buktiBayarImage = $request->file('bukti_bayar');
        $buktiBayarFileName = 'bukti_bayar_' . now()->format('Ymd_His') . '.webp';

        // Process and save the proof of payment image
        $img = imagecreatefromstring(file_get_contents($buktiBayarImage));
        if ($img) {
            imagewebp($img, public_path('assets/images/bukti_bayar/' . $buktiBayarFileName), 90);
            imagedestroy($img);
            $buktiBayarPath = url('assets/images/bukti_bayar/' . $buktiBayarFileName);
        }
    }

    // Update the invoice with payment data
    $invoice->tanggal_bayar = now();
    $invoice->tanggal_transfer = now()->format('Y-m-d');
    $invoice->nama_rekening = $request->nama_rekening;
    $invoice->no_rekening = $request->no_rekening;
    $invoice->bukti_bayar = $buktiBayarPath;
    $invoice->status_invoice = 'PENDING'; // Payment is waiting for confirmation
    $invoice->save();

    // Update the order status
    $order->status_order = 'Menunggu Konfirmasi Pembayaran';
    $order->save();

    return redirect()->route('home')
        ->with('status', 'Pembayaran berhasil, tunggu konfirmasi.');
}





}
