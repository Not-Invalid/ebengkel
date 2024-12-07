<?php

namespace App\Http\Controllers;

use App\Models\OrderOnline;
use App\Models\Bengkel;  // Tambahkan model Bengkel
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request, $order_id)
    {
        $order = OrderOnline::where('order_id', $order_id)->first();
    
        if (!$order) {
            return redirect()->route('home')->with('error', 'Order tidak ditemukan.');
        }
    
        // Mengambil data bengkel berdasarkan id_bengkel yang ada pada order
        $bengkel = Bengkel::find($order->id_bengkel);
    
        // Pastikan meng-decode JSON dengan aman
        $paymentMethods = json_decode($bengkel->payment, true) ?? [];
        $rekeningBank = json_decode($bengkel->rekening_bank, true) ?? [];
    
        // Ambil produk dan sparepart terkait dengan order
        $produkItem = $order->produk;  // Produk terkait
        $sparepartItem = $order->sparepart;  // Sparepart terkait
    
        return view('transaction.payment', compact('order', 'produkItem', 'sparepartItem', 'bengkel', 'paymentMethods', 'rekeningBank'));
    }

}
