<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'id_produk' => 'required|exists:tb_produk,id_produk',
            'quantity' => 'required|integer|min:1',
        ]);

        $pelanggan = auth('pelanggan')->user();

        if (!$pelanggan) {
            return response()->json(['success' => false, 'message' => 'You need to be logged in to add products to the cart.']);
        }

        $produk = Product::findOrFail($validated['id_produk']);
        $totalPrice = $produk->harga_produk * $validated['quantity'];

        $cartItem = Cart::where('id_pelanggan', $pelanggan->id_pelanggan)
                        ->where('id_produk', $produk->id_produk)
                        ->first();

        if ($cartItem) {
            $cartItem->quantity += $validated['quantity'];
            $cartItem->total_price += $totalPrice;
            $cartItem->save();
        } else {
            Cart::create([
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'id_produk' => $produk->id_produk,
                'quantity' => $validated['quantity'],
                'total_price' => $totalPrice,
            ]);
        }

        // Return updated cart count
        $cartCount = Cart::where('id_pelanggan', $pelanggan->id_pelanggan)->count();

        return response()->json(['success' => true, 'cartCount' => $cartCount]);
    }


    public function showCart()
    {

        $pelanggan = auth('pelanggan')->user();

        if (!$pelanggan) {
            return redirect()->route('login')->with('error', 'You need to be logged in to view your cart.');
        }

        $cartItems = Cart::with('produk')
                         ->where('id_pelanggan', $pelanggan->id_pelanggan)
                         ->get();

        return view('payment.cart', compact('cartItems'));
    }

    public function removeFromCart($id)
    {

        Cart::destroy($id);

        return redirect()->route('cart')->with('success', 'Item removed from cart!');
    }
}
