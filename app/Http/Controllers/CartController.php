<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\KategoriSparePart;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function showCart()
    {
        $pelanggan = auth('pelanggan')->user();

        if (!$pelanggan) {
            return redirect()->route('login')->with('status_error', 'You need to be logged in to view your cart.');
        }

        $kategoriSparePart = KategoriSparePart::all();

        $cartItems = Cart::with('produk.kategoriProduct')
                        ->where('id_pelanggan', $pelanggan->id_pelanggan)
                        ->get();
        $totalPrice = $cartItems->sum('total_price');

        return view('payment.cart', compact('cartItems', 'totalPrice', 'kategoriSparePart'));
    }
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

        $cartItems = Cart::with('produk')
                        ->where('id_pelanggan', $pelanggan->id_pelanggan)
                        ->get();
        $cartCount = $cartItems->count();
        $totalPrice = $cartItems->sum('total_price');

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

        $cartItem->quantity = $quantity;
        $cartItem->save();

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

}
