<?php

namespace App\Http\Controllers;

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
        'SELESAI' => 'Selesai',
    ];

    // Query untuk mengambil data order dengan relasi produk, sparepart, invoice, bengkel
    $ordersQuery = OrderOnline::with([
        'orderItems.produk.fotoProduk', // Pastikan fotoProduk ada pada produk
        'orderItems.sparepart.fotoSparepart', // Pastikan fotoSparepart ada pada sparepart
        'invoice',
        'bengkel',
    ])
        ->where('id_pelanggan', auth('pelanggan')->id())
        ->where('is_delete', 'N')
        ->where('status_order', $status);

    // Ambil data order yang sudah difilter
    $orders = $ordersQuery->get();

    // Proses data untuk setiap order dan order item
    $orders = $orders->map(function ($order) {
        $order->orderItems = $order->orderItems->map(function ($orderItem) {
            // Tentukan path gambar berdasarkan produk atau sparepart
            $imagePath = null;

            // Cek apakah produk memiliki foto
            if ($orderItem->produk && $orderItem->produk->fotoProduk) {
                $imagePath = $orderItem->produk->fotoProduk->file_foto_produk_1;
            }
            // Cek apakah sparepart memiliki foto
            elseif ($orderItem->sparepart && $orderItem->sparepart->fotoSparepart) {
                $imagePath = $orderItem->sparepart->fotoSparepart->file_foto_spare_part_1;
            }

            // Tentukan URL gambar
            $orderItem->imageUrl = $imagePath && file_exists(public_path($imagePath))
            ? asset($imagePath) // URL gambar yang valid
            : asset('assets/images/components/image.png'); // Gambar default jika tidak ada

            return $orderItem;
        });

        return $order;
    });

    // Kirim data order dan status ke view
    return view('profile.my-order.index', compact('orders', 'status', 'statusNames'));
}


    public function detailOrder($orderId)
    {
        // Fetch the order with its related items, invoice, and bengkel
        $order = OrderOnline::with([
            'orderItems.produk.fotoProduk', // Eager load foto produk
            'orderItems.sparepart.fotoSparepart', // Eager load foto sparepart
            'invoice',
            'bengkel',
        ])
            ->where('order_id', $orderId)
            ->where('is_delete', 'N')
            ->firstOrFail();

        // Proses data order untuk memasukkan imageUrl ke setiap order item
        $order->orderItems = $order->orderItems->map(function ($orderItem) {
            // Tentukan path gambar berdasarkan produk atau sparepart
            $imagePath = null;

            if ($orderItem->produk && $orderItem->produk->fotoProduk) {
                $imagePath = $orderItem->produk->fotoProduk->file_foto_produk_1;
            } elseif ($orderItem->sparepart && $orderItem->sparepart->fotoSparepart) {
                $imagePath = $orderItem->sparepart->fotoSparepart->file_foto_spare_part_1;
            }

            // Tentukan URL gambar
            $orderItem->imageUrl = $imagePath && file_exists(public_path($imagePath))
            ? asset($imagePath)
            : asset('assets/images/components/image.png'); // Gambar fallback

            return $orderItem;
        });

        // Kirim data order ke view
        return view('profile.my-order.order_detail', compact('order'));
    }
}
