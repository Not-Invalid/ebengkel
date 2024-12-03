<?php

namespace App\Http\Controllers;

use App\Services\MidtransService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function index(Request $request)
    {
        $snapToken = $request->get('snap_token');  // Mendapatkan snap_token dari URL query parameter

        if (!$snapToken) {
            return redirect()->route('cart.index')->with('status_error', 'Invalid payment request.');
        }

        return view('transaction.payment', compact('snapToken'));
    }

    /**
     * Handle the Midtrans notification after payment
     */
    public function notification(Request $request)
    {
        // Panggil service untuk menangani notifikasi dari Midtrans
        $status = $this->midtransService->handleNotification();

        // Anda bisa melakukan update status order di sini berdasarkan status pembayaran
        // Misalnya, update status order menjadi 'PAID' jika pembayaran berhasil
        return response()->json(['status' => $status]);
    }
}
