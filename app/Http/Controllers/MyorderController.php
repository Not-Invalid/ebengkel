<?php

namespace App\Http\Controllers;

use App\Models\Bengkel;
use App\Models\OrderOnline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
            'orderItems.produk', // Pastikan produk ada
            'orderItems.sparepart', // Pastikan sparepart ada
            'orderItems.produk.fotoProduk', // Jika ada foto produk
            'orderItems.sparepart.fotoSparepart', // Jika ada foto sparepart
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
        // Ambil id_pelanggan dari sesi
        $id_pelanggan = Session::get('id_pelanggan');

        // Ambil bengkel terkait pelanggan
        $bengkel = Bengkel::where('id_pelanggan', $id_pelanggan)->first();

        // Pemetaan status
        $statusNames = [
            'PENDING' => 'Belum Dibayar',
            'Waiting_Confirmation' => 'Menunggu Konfirmasi',
            'DIKEMAS' => 'Dikemas',
            'DIKIRIM' => 'Dikirim',
            'SELESAI' => 'Selesai',
        ];

        // Ambil order dengan relasi orderItems, produk, sparepart, invoice, bengkel
        $order = OrderOnline::with([
            'orderItems.produk', // Produk yang dipesan
            'orderItems.sparepart', // Sparepart yang dipesan
            'orderItems.produk.fotoProduk', // Foto produk jika ada
            'orderItems.sparepart.fotoSparepart', // Foto sparepart jika ada
            'invoice', // Relasi invoice untuk mendapatkan bukti pembayaran
            'bengkel', // Relasi bengkel
        ])
            ->where('order_id', $orderId)
            ->where('is_delete', 'N')
            ->firstOrFail();

        // Proses setiap item order untuk memasukkan URL gambar
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
            ? asset($imagePath) // Gambar yang valid
            : asset('assets/images/components/image.png'); // Gambar fallback

            return $orderItem;
        });

        // Ambil bukti bayar dari invoice
        if ($order->invoice && $order->invoice->bukti_bayar) {
            // Periksa apakah file bukti bayar ada di server
            $buktiBayarPath = $order->invoice->bukti_bayar;
            $order->invoice->bukti_bayar_url = file_exists(public_path($buktiBayarPath))
            ? asset($buktiBayarPath) // Gambar bukti bayar yang valid
            : asset('assets/images/components/image.png'); // Gambar fallback
        } else {
            // Jika tidak ada bukti bayar, tampilkan gambar fallback
            $order->invoice->bukti_bayar_url = asset('assets/images/components/image.png');
        }

        // Kirim data order ke tampilan
        return view('profile.my-order.order_detail', compact('order', 'statusNames', 'bengkel'));
    }

}
