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
            'quantity' => $newQuantity,
            'totalAmount' => $totalAmount,
        ]);
    }

    private function calculateTotalPrice($selectedItemIds)
    {
        if (empty($selectedItemIds)) {
            return 0;
        }

        // Ambil item yang dipilih dan hitung total harga
        $selectedItems = Cart::whereIn('id', $selectedItemIds)->get();

        return $selectedItems->sum(function ($item) {
            return $item->total_price;  
        });
    }

    public function removeItemFromCart($id)
    {
        $customerId = Session::get('id_pelanggan');

        if (!$customerId) {
            return response()->json(['success' => false, 'message' => 'You must be logged in to remove an item from the cart.']);
        }

        // Find the cart item by its ID and ensure it belongs to the logged-in customer
        $cartItem = Cart::where('id', $id)->where('id_pelanggan', $customerId)->first();

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'Item not found or does not belong to this user.']);
        }

        // Delete the item from the cart
        $cartItem->delete();

        // Recalculate the total amount after removing the item
        $cartItems = Cart::with('produk')->where('id_pelanggan', $customerId)->get();
        $totalItemPrice = $cartItems->sum(function ($item) {
            return optional($item->produk)->harga * $item->quantity;
        });
        
        $couponDiscount = 0;
        $totalAmount = $totalItemPrice - $couponDiscount;

        return response()->json([
            'success' => true,
            'message' => 'Item removed successfully.',
            'totalAmount' => $totalAmount,
            'totalItemPrice' => $totalItemPrice
        ]);
    }

}
