<?php

namespace App\Http\Controllers;

use App\Models\OrderOnline;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request, $order_id)
    {
        // Mengambil data order berdasarkan order_id
        $order = OrderOnline::where('order_id', $order_id)->first();

        // Jika order tidak ditemukan, redirect ke halaman lain
        if (!$order) {
            return redirect()->route('home')->with('error', 'Order tidak ditemukan.');
        }

        $orderItems = $order->id_produk ? $order->produk()->get() : $order->sparepart()->get();

        return view('transaction.payment', compact('order', 'orderItems'));
    }
}

