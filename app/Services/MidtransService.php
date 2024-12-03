<?php

namespace App\Services;

use Midtrans\Snap;
use Midtrans\Notification;
use Midtrans\Config;
use App\Models\OrderOnline;

class MidtransService
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.serverKey');
        Config::$clientKey = config('midtrans.clientKey');
        Config::$isProduction = config('midtrans.isProduction');
    }

    /**
     * Membuat transaksi Midtrans dan mendapatkan Snap Token
     */
    public function createTransaction($order_id, $total_amount, $customer_details)
    {
        $transaction_details = array(
            'order_id' => $order_id,
            'gross_amount' => $total_amount,
        );

        $transaction_data = array(
            'payment_type' => 'qris',
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
        );

        // Mendapatkan Snap Token dari Midtrans
        $snapToken = Snap::getSnapToken($transaction_data);
        return $snapToken;
    }

    /**
     * Menangani notifikasi pembayaran Midtrans
     */
    public function handleNotification()
    {
        $notification = new Notification();

        $status = $notification->transaction_status;
        $order_id = $notification->order_id;
        $payment_type = $notification->payment_type;

        // Mendapatkan order berdasarkan order_id
        $order = OrderOnline::where('id', str_replace('order-', '', $order_id))->first();

        if ($order) {
            switch ($status) {
                case 'settlement':
                    // Pembayaran berhasil, update status order menjadi 'PAID'
                    $order->status_order = 'PAID';
                    break;
                case 'pending':
                    // Pembayaran masih pending
                    $order->status_order = 'PENDING';
                    break;
                case 'cancel':
                    // Pembayaran dibatalkan
                    $order->status_order = 'CANCELLED';
                    break;
            }

            $order->save();
        }

        return response()->json(['status' => $status]);
    }

}
