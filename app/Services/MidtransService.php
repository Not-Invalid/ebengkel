<?php

namespace App\Services;

use Midtrans\Snap;
use Midtrans\Notification;
use Midtrans\Config;

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

        // Dapatkan status pembayaran
        $status = $notification->transaction_status;
        $order_id = $notification->order_id;
        $payment_type = $notification->payment_type;

        // Logika untuk menghandle status pembayaran, misal update status order
        if ($status == 'settlement') {
            // Pembayaran berhasil, update status order menjadi "paid"
            // Update database order di sini
        } elseif ($status == 'pending') {
            // Pembayaran masih pending
        } elseif ($status == 'cancel') {
            // Pembayaran dibatalkan
        }

        // Kembali ke aplikasi dengan status notifikasi
        return $status;
    }
}
