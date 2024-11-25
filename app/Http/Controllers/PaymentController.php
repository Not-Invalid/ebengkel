<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $cartItems = session('cart', []); // Data cart dari sesi
        $totalAmount = array_sum(array_column($cartItems, 'total_price')); // Hitung total hargareturn view('payment.payment', compact('cartItems', 'totalAmount'));
        return view('payment.payment', compact('cartItems', 'totalAmount'));

    }
}
