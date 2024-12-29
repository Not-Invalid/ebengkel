<?php
namespace App\Http\Controllers;

use App\Models\OrderOnline;
use Illuminate\Http\Request;

class MyorderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'PENDING');

        $statusNames = ['PENDING' => 'Belum Dibayar', 'Waiting_Confirmation' => 'Menunggu Konfirmasi', 'DIKEMAS' => 'Dikemas', 'DIKIRIM' => 'Dikirim', 'SELESAI' => 'Selesai'];

        $ordersQuery = OrderOnline::with(['orderItems.produk.fotoProduk', 'orderItems.sparepart.fotoSparepart', 'invoice', 'bengkel'])
            ->where('id_pelanggan', auth('pelanggan')->id())
            ->where('is_delete', 'N')
            ->where('status_order', $status);

        $orders = $ordersQuery->get();

        $orders = $orders->map(function ($order) {
            $order->orderItems = $order->orderItems->map(function ($orderItem) {
                $imagePath = null;

                if ($orderItem->produk && $orderItem->produk->fotoProduk) {
                    $imagePath = $orderItem->produk->fotoProduk->file_foto_produk_1;
                } elseif ($orderItem->sparepart && $orderItem->sparepart->fotoSparepart) {
                    $imagePath = $orderItem->sparepart->fotoSparepart->file_foto_spare_part_1;
                }

                $orderItem->imageUrl = $imagePath && file_exists(public_path($imagePath)) ? asset($imagePath) : asset('assets/images/components/image.png');

                return $orderItem;
            });

            return $order;
        });

        return view('profile.my-order.index', compact('orders', 'status', 'statusNames'));
    }

    public function detailOrder($orderId)
    {
        $order = OrderOnline::with(['orderItems.produk.fotoProduk', 'orderItems.sparepart.fotoSparepart', 'invoice', 'bengkel'])
            ->where('order_id', $orderId)
            ->where('is_delete', 'N')
            ->firstOrFail();

        $order->orderItems = $order->orderItems->map(function ($orderItem) {

            $imagePath = null;

            if ($orderItem->produk && $orderItem->produk->fotoProduk) {
                $imagePath = $orderItem->produk->fotoProduk->file_foto_produk_1;
                $orderItem->id_produk = $orderItem->produk->id_produk;
            } elseif ($orderItem->sparepart && $orderItem->sparepart->fotoSparepart) {
                $imagePath = $orderItem->sparepart->fotoSparepart->file_foto_spare_part_1;
                $orderItem->id_spare_part = $orderItem->sparepart->id_spare_part;
            }

            $orderItem->imageUrl = $imagePath && file_exists(public_path($imagePath)) ? asset($imagePath) : asset('assets/images/components/image.png');

            return $orderItem;
        });

        return view('profile.my-order.order_detail', compact('order'));
    }
}
