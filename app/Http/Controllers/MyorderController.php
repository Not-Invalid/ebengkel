<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OrderOnline;
use Illuminate\Http\Request;

class MyorderController extends Controller
{
    public function index(Request $request)
    {
        // Dapatkan status filter dari request, defaultnya 'PENDING'
        $status = $request->get('status', 'PENDING');

        // Pemetaan status untuk tampilan
        $statusNames = [
            'PENDING' => 'Belum Dibayar',
            'Waiting_Confirmation' => 'Menunggu Konfirmasi',
            'DIKEMAS' => 'Dikemas',
            'DIKIRIM' => 'Dikirim',
            'SELESAI' => 'Selesai'
        ];

        // Ambil semua order berdasarkan pelanggan
        $orders = OrderOnline::with(['orderItems', 'invoice', 'bengkel'])
            ->where('id_pelanggan', auth('pelanggan')->id())
            ->where('is_delete', 'N')
            ->get();

        // Kirim data order dan status ke view
        return view('profile.my-order.index', compact('orders', 'status', 'statusNames'));
    }

    public function detailOrder($orderId)
    {
        // Fetch the order with its related items and invoice
        $order = OrderOnline::with(['orderItems', 'invoice', 'bengkel'])
            ->where('order_id', $orderId)
            ->where('is_delete', 'N')
            ->firstOrFail();

        // Pass the order data to the view
        return view('profile.my-order.order_detail', compact('order'));
    }

}
