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

    // Check if the due date has passed
    $dueDate = \Carbon\Carbon::parse($order->tanggal)->addDay(1);
    $currentDate = \Carbon\Carbon::now();

    $isDueDatePassed = $currentDate->greaterThan($dueDate);

    // If the due date has passed, update the invoice and order status to TEMP and redirect
    if ($isDueDatePassed) {
        $invoice->status_invoice = 'TEMP';
        $invoice->save();

        $order->status_order = 'TEMP';
        $order->save();

        return redirect()->route('home')->with('error', 'Jatuh tempo sudah lewat. Pembayaran tidak dapat dilakukan.');
    }

    // Retrieve order items
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

    return view('transaction.payment', compact('order', 'produkItem', 'sparepartItem', 'bengkel', 'paymentMethods', 'rekeningBank', 'invoice', 'isDueDatePassed'));
}


public function store(Request $request)
{
    // Validasi form input dengan kondisi
    $validated = $request->validate([
        'jenis_pembayaran' => 'required|string|max:50', // Jenis Pembayaran harus ada
        'nama_rekening' => 'required_if:jenis_pembayaran,Manual Transfer|string|max:100', // Hanya required jika metode pembayaran adalah Manual Transfer
        'no_rekening' => 'required_if:jenis_pembayaran,Manual Transfer|string|max:50', // Hanya required jika metode pembayaran adalah Manual Transfer
        'bank_tujuan' => 'required_if:jenis_pembayaran,Manual Transfer|string|max:100', // Hanya required jika metode pembayaran adalah Manual Transfer
        'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'note' => 'string',
        'id' => 'required|integer', // Validasi id invoice
    ]);

    // Retrieve the order using the order_id
    $order = OrderOnline::where('order_id', $request->order_id)->first();

    if (!$order) {
        return redirect()->route('home')->with('error', 'Order tidak ditemukan.');
    }

    // Retrieve the invoice using the id from the request
    $invoice = Invoice::find($request->id);

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
    $invoice->jenis_pembayaran = $request->jenis_pembayaran; // Save the payment type
    $invoice->bank_tujuan = $request->bank_tujuan; // Save the selected bank
    $invoice->bukti_bayar = $buktiBayarPath;
    $invoice->note = $request->note;
    $invoice->status_invoice = 'Waiting_Confirmation'; // Payment is waiting for confirmation
    $invoice->save();

    // Update the order status
    $order->status_order = 'Waiting_Confirmation';
    $order->save();

    return redirect()->route('home')
        ->with('status', 'Pembayaran berhasil, tunggu konfirmasi.');
}






}
