<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\SpareParts;
use Illuminate\Http\Request;
use App\Models\OrderOnline;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $pelanggan_id = Auth::user()->id_pelanggan;

            // Fetch cart items based on the user's ID
            $cartItems = Cart::where('id_pelanggan', $pelanggan_id)
                            ->with('produk', 'sparepart')  // Menambahkan hubungan sparepart
                            ->get();

            return view('transaction.cart', compact('cartItems'));
        } else {
            return redirect()->route('login')->with('status_error', 'Please log in to view the cart');
        }
    }

    public function addToCart(Request $request)
    {
        // Cek apakah pengguna sudah login
        if (Auth::check()) {
            $pelanggan_id = Auth::user()->id_pelanggan;

            // Ambil data produk dan sparepart berdasarkan ID
            $produk = Product::find($request->id_produk);
            $sparepart = SpareParts::find($request->id_spare_part);

            // Cek apakah produk atau sparepart ada
            if ($produk || $sparepart) {
                // Tentukan nilai id_produk dan id_spare_part
                $id_produk = $produk ? $produk->id_produk : null;
                $id_spare_part = $sparepart ? $sparepart->id_spare_part : null;

                // Jika produk dan sparepart keduanya tidak ditemukan
                if (!$id_produk && !$id_spare_part) {
                    return redirect()->back()->with('error', 'Product or spare part not found');
                }

                // Buat cart baru
                $cart = new Cart();
                $cart->id_pelanggan = $pelanggan_id;
                $cart->id_produk = $id_produk; // Bisa null jika sparepart yang ditambahkan
                $cart->id_spare_part = $id_spare_part; // Bisa null jika produk yang ditambahkan
                $cart->quantity = $request->quantity;

                // Tentukan harga total berdasarkan produk atau sparepart
                $harga = $produk ? $produk->harga_produk : ($sparepart ? $sparepart->harga_spare_part : 0);
                $cart->total_price = $harga * $request->quantity;
                $cart->save();

                return redirect()->route('cart.index')->with('status', 'Product added to cart');
            } else {
                return redirect()->back()->with('status_error', 'Product or spare part not found');
            }
        } else {
            return redirect()->route('login')->with('status_error', 'Please log in to add to cart');
        }
    }

    public function removeItem(Request $request)
    {
        if (Auth::check()) {
            // Get the logged-in user's ID
            $pelanggan_id = Auth::user()->id_pelanggan;

            // Find the cart item by its ID
            $cartItem = Cart::where('id', $request->id)
                            ->where('id_pelanggan', $pelanggan_id)
                            ->first();

            if ($cartItem) {
                // Delete the cart item
                $cartItem->delete();
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Item not found']);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'User not authenticated']);
        }
    }

    public function updateQuantity(Request $request)
{
    if (Auth::check()) {
        $pelanggan_id = Auth::user()->id_pelanggan;

        // Validate the incoming request
        $validated = $request->validate([
            'id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        // Find the cart item based on ID and customer
        $cartItem = Cart::where('id', $request->id)
                        ->where('id_pelanggan', $pelanggan_id)
                        ->first();

        if ($cartItem) {
            // Fetch the product or spare part
            $produk = Product::find($cartItem->id_produk);
            $sparepart = SpareParts::find($cartItem->id_spare_part);

            // Recalculate the total price
            if ($produk) {
                $cartItem->total_price = $produk->harga_produk * $request->quantity;
            } elseif ($sparepart) {
                $cartItem->total_price = $sparepart->harga_spare_part * $request->quantity;
            }

            // Update the quantity
            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            // Return success response
            return response()->json([
                'status' => 'success',
                'total_price' => number_format($cartItem->total_price, 0, ',', '.'),
                'quantity' => $cartItem->quantity
            ]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Item not found']);
        }
    } else {
        return response()->json(['status' => 'error', 'message' => 'User not authenticated']);
    }
}

public function placeOrder(Request $request)
{
    if (Auth::check()) {
        $pelanggan_id = Auth::user()->id_pelanggan;

        // Fetch cart items based on the logged-in user
        $cartItems = Cart::where('id_pelanggan', $pelanggan_id)->get();

        // Ensure there are items in the cart
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Collect data for the order
        $total_qty = 0;
        $total_harga = 0;

        foreach ($cartItems as $item) {
            // Calculate total quantity and total price
            $total_qty += $item->quantity;
            $total_harga += $item->total_price;
        }

        // Create the order
        $order = new OrderOnline();
        $order->id_pelanggan = $pelanggan_id;
        $order->tanggal = now();  // Set current date and time
        $order->total_qty = $total_qty;
        $order->total_harga = $total_harga;
        $order->status_order = 'TEMP';  // Set status as 'TEMP' initially
        $order->save();

        // Transfer cart items to the order (you can add products or spare parts individually)
        foreach ($cartItems as $item) {
            // For products
            if ($item->id_produk) {
                $order->id_produk = $item->id_produk;
                $order->save(); // Save the association
            }

            // For spare parts
            if ($item->id_spare_part) {
                $order->id_spare_part = $item->id_spare_part;
                $order->save(); // Save the association
            }
        }

        // Optionally, clear the cart after the order is placed
        $cartItems->each->delete();

        return redirect()->route('order', ['order_id' => $order->id])
            ->with('status', 'Your order has been placed successfully');
    }

    return redirect()->route('login')->with('status_error', 'Please log in to place an order');
}


}
