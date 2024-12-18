<?php

namespace App\Http\Controllers;

use App\Models\OrderOnline;
use App\Models\OrderItemOnline;
use App\Models\Invoice;
use App\Models\Bengkel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\RajaOngkirService;

class PaymentController extends Controller
{
    public function index(Request $request, $order_id, $id, RajaOngkirService $rajaOngkirService)
{
    // Ambil data order berdasarkan order_id
    $order = OrderOnline::where('order_id', $order_id)->first();

    if (!$order) {
        return redirect()->route('home')->with('error', 'Order tidak ditemukan.');
    }

    // Ambil data invoice berdasarkan invoice_id
    $invoice = Invoice::find($id);

    if (!$invoice) {
        return redirect()->route('home')->with('error', 'Invoice tidak ditemukan.');
    }

    // Ambil data bengkel berdasarkan id_bengkel yang ada di order
    $bengkel = Bengkel::find($order->id_bengkel);

    if (!$bengkel) {
        return redirect()->route('home')->with('error', 'Bengkel tidak ditemukan untuk order ini.');
    }

    // Ambil alamat pengiriman pertama
    $shippingAddress = Auth::user()->alamatPengiriman->first();
    $shippingAddress->status_alamat_pengiriman;

    // Gunakan berat default (misalnya 1000 gram) jika tidak ada informasi berat
    $weight = 1000; // Default weight (dalam gram)


    $originCity = $bengkel->kota_id;
    echo "<script>console.log('Origin City ID: " . $originCity . "');</script>";


    $destinationCity = $order->kabupaten;
    echo "<script>console.log('Destination City ID: " . $destinationCity . "');</script>";

    // Ambil kurir yang dipilih oleh user dari request, default ke 'jne' jika tidak ada
    $courier = $request->input('shipping_courier', 'jne'); // Default to 'jne' if no courier is selected

    // Mengambil estimasi biaya pengiriman menggunakan API RajaOngkir
    $shippingCostData = $rajaOngkirService->getShippingCost($originCity, $destinationCity, $weight, $courier);

    $courierOptions = [];
    if ($shippingCostData && isset($shippingCostData['rajaongkir']['results'][0]['costs'])) {
        foreach ($shippingCostData['rajaongkir']['results'] as $result) {
            // Ambil nama kurir
            $courierName = isset($result['name']) ? $result['name'] : 'Unknown Courier';

            // Loop melalui setiap biaya pengiriman untuk kurir ini
            foreach ($result['costs'] as $cost) {
                $courierOptions[] = [
                    'courier' => $courierName,  // Nama kurir
                    'service' => $cost['service'],  // Layanan pengiriman (misalnya JTR, REG)
                    'description' => $cost['description'],  // Deskripsi layanan
                    'cost' => $cost['cost'][0]['value'],  // Biaya pengiriman
                    'delivery_time' => $cost['cost'][0]['etd'],  // Waktu estimasi pengiriman
                ];
            }
        }
    }


    // Cek apakah tanggal jatuh tempo telah lewat
    $dueDate = \Carbon\Carbon::parse($order->tanggal)->addDay(1);
    $currentDate = \Carbon\Carbon::now();
    $isDueDatePassed = $currentDate->greaterThan($dueDate);

    // Ambil item pesanan
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

    // Ambil metode pembayaran dan rekening bank dari bengkel
    $paymentMethods = $bengkel->payment ? json_decode($bengkel->payment, true) : [];
    $rekeningBank = $bengkel->rekening_bank ? json_decode($bengkel->rekening_bank, true) : [];

    // Kembalikan data untuk tampilan
    return view('transaction.payment', compact(
        'order', 'produkItem', 'sparepartItem', 'bengkel', 'paymentMethods', 'rekeningBank',
        'invoice', 'isDueDatePassed', 'courierOptions' // Pass the single address to the view
    ));
}




public function store(Request $request)
{
    // Validasi form input dengan kondisi
    $validated = $request->validate([
        'jenis_pembayaran' => 'required|string|max:50', // Jenis Pembayaran harus ada
        'nama_rekening' => 'required_if:jenis_pembayaran,Manual Transfer|string|max:100', // Hanya required jika metode pembayaran adalah Manual Transfer
        'no_rekening' => 'required_if:jenis_pembayaran,Manual Transfer|string|max:50', // Hanya required jika metode pembayaran adalah Manual Transfer
        'bank_tujuan' => 'required_if:jenis_pembayaran,Manual Transfer|string|max:100', // Hanya required jika metode pembayaran adalah Manual Transfer
        'nominal_transfer' => 'required|string',
        'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'note' => 'nullable|string',
        'id' => 'required|integer', // Validasi id invoice
    ]);

    // Retrieve the order using the order_id
    $order = OrderOnline::where('order_id', $request->order_id)->first();
    $shipping_method = $request->shipping_method;
    $shipping_courier = $request->shipping_courier;
    $shipping_cost = $request->shipping_cost ?? 0;
    $grandTotal = $order->total_harga + $shipping_cost;

    $order->jenis_pengiriman = $shipping_method;
    $order->kurir = $shipping_courier;
    $order->biaya_pengiriman = $shipping_cost;
    $order->grand_total = $grandTotal;


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

        // Open the image
        $img = imagecreatefromstring(file_get_contents($buktiBayarImage));

        if ($img) {
            // Convert the image to RGB (truecolor) if it's not
            if (imageistruecolor($img) === false) {
                // Create a new truecolor image
                $trueColorImg = imagecreatetruecolor(imagesx($img), imagesy($img));
                // Copy the old image into the new truecolor image
                imagecopy($trueColorImg, $img, 0, 0, 0, 0, imagesx($img), imagesy($img));
                imagedestroy($img); // Destroy the original image
                $img = $trueColorImg; // Assign the truecolor image to $img
            }

            // Save the image as WebP
            imagewebp($img, public_path('assets/images/bukti_bayar/' . $buktiBayarFileName), 90);
            imagedestroy($img); // Destroy the image resource after saving

            // Set the path for the saved image
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
    $invoice->nominal_transfer = $request->nominal_transfer;
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
