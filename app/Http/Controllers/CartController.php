<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function showCart()
{
    $customerId = Session::get('id_pelanggan');

    if (!$customerId) {
        return redirect()->route('login')->with('error', 'You must be logged in to view your cart.');
    }

    // Fetch updated cart items from the database along with the stock of the product
    $cartItems = Cart::with('produk')->where('id_pelanggan', $customerId)->get();

    // Calculate the total price of the items in the cart
    $totalItemPrice = $cartItems->sum(function ($item) {
        return optional($item->produk)->harga * $item->quantity;
    });

    $couponDiscount = 0;
    $totalAmount = $totalItemPrice - $couponDiscount;

    return view('payment.cart', compact('cartItems', 'totalItemPrice', 'couponDiscount', 'totalAmount'));
}

//     public function showCart()
// {
//     $customerId = Session::get('id_pelanggan');

//     if (!$customerId) {
//         return redirect()->route('login')->with('error', 'You must be logged in to view your cart.');
//     }

//     // Fetch updated cart items from the database
//     $cartItems = Cart::with('produk')->where('id_pelanggan', $customerId)->get();

//     // Calculate the total price of the items in the cart
//     $totalItemPrice = $cartItems->sum(function ($item) {
//         return optional($item->produk)->harga * $item->quantity;
//     });

//     $couponDiscount = 0;
//     $totalAmount = $totalItemPrice - $couponDiscount;

//     return view('payment.cart', compact('cartItems', 'totalItemPrice', 'couponDiscount', 'totalAmount'));
// }


    public function updateQuantityAjax(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid quantity input.']);
        }

        // Temukan item keranjang berdasarkan ID
        $cartItem = Cart::findOrFail($id);
        $newQuantity = $request->input('quantity');

        // Update kuantitas item di keranjang
        $cartItem->quantity = $newQuantity;

        // Hitung ulang total harga berdasarkan kuantitas yang baru
        $product = $cartItem->produk;  // Ambil produk terkait
        $totalItemPrice = $product->harga * $newQuantity;


        // Perbarui total harga di database
        $cartItem->total_price = $totalItemPrice;
        $cartItem->save();    

        // Menghitung total harga untuk semua item keranjang yang dipilih
        $selectedItemIds = $request->input('selectedItemIds', []);
        $totalAmount = $this->calculateTotalPrice($selectedItemIds);

        return response()->json([
            'success' => true,
            'cartCount' => $cartCount,
            'totalPrice' => number_format($totalPrice, 2, ',', '.'),
            'cartItems' => $cartItems,
        ]);
    }

    public function updateCartItem(Request $request, $id)
    {
        $cartItem = Cart::findOrFail($id);
        $product = $cartItem->produk;
        $quantity = $request->quantity;

        if ($quantity > $product->stok_produk) {
            return response()->json(['success' => false, 'message' => 'Kuantitas yang diminta melebihi stok yang tersedia.']);
        }

        // Find the cart item by its ID and ensure it belongs to the logged-in customer
        $cartItem = Cart::where('id', $id)->where('id_pelanggan', $customerId)->first();

        return response()->json(['success' => true, 'message' => 'Keranjang berhasil diperbarui.']);
    }

    public function removeFromCart($id)
    {

        $cartItem = Cart::find($id);

        if ($cartItem) {

            $cartItem->delete();

            return redirect()->route('cart')->with('status', 'Item removed successfully');
        }

        return redirect()->route('cart')->with('status_error', 'Item not found');
    }
    
    //midtrans
    private function generateOrderId($prefix = 'ORDER')
    {
        return $prefix . '-' . strtoupper(uniqid());
    }

    public function payment(Request $request) {
        $pelanggan = auth('pelanggan')->user();
    
        // Periksa apakah pelanggan sudah login
        if (!$pelanggan) {
            return redirect()->route('login')->with('status_error', 'You need to be logged in to proceed with payment.');
        }
    
        // Ambil data dari keranjang
        $cartItems = Cart::with('produk')->where('id_pelanggan', $pelanggan->id_pelanggan)->get();
        $totalPrice = $cartItems->sum('total_price');
    
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false); // Pastikan ini true
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
      
    
        // Buat parameter transaksi
        $params = [
            'transaction_details' => [
                'order_id' => $this->generateOrderId(),  // Pastikan ini menghasilkan ID yang unik dan valid
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $pelanggan->nama_pelanggan,
                'email' => $pelanggan->email,
                'phone' => $pelanggan->nomor_telepon,
            ],
        ];        
    
        // Dapatkan Snap Token dari Midtrans
        // $snapToken = \Midtrans\Snap::getSnapToken($params);
    
        // Kirim data ke view
        return view('payment.payment', compact( 'cartItems', 'totalPrice'));
    }
}
