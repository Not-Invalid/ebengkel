<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\SpareParts;
use Illuminate\Http\Request;
use App\Services\MidtransService;
use App\Models\OrderOnline;
use App\Models\Bengkel;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Midtrans\Snap;
use App\Models\OrderItemOnline;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $pelanggan_id = Auth::user()->id_pelanggan;

            // Fetch cart items based on the user's ID
            $cartItems = Cart::where('id_pelanggan', $pelanggan_id)
                            ->with('produk', 'sparepart')  // Include product and spare part relationships
                            ->get();

            // Fetch the user's shipping address
            $shippingAddress = Auth::user()->alamatPengiriman; // Assume 'address' relationship in the User model

            return view('transaction.cart', compact('cartItems', 'shippingAddress'));
        } else {
            return redirect()->route('login')->with('status_error', 'Please log in to view the cart');
        }
    }


    public function addToCart(Request $request)
    {
        if (Auth::check()) {
            $pelanggan_id = Auth::user()->id_pelanggan;
            $produk = Product::find($request->id_produk);
            $sparepart = SpareParts::find($request->id_spare_part);

            if ($produk || $sparepart) {
                $id_produk = $produk ? $produk->id_produk : null;
                $id_spare_part = $sparepart ? $sparepart->id_spare_part : null;

                // Check if the item is already in the cart
                $cartItem = Cart::where('id_pelanggan', $pelanggan_id)
                    ->where(function($query) use ($id_produk, $id_spare_part) {
                        if ($id_produk) {
                            $query->where('id_produk', $id_produk);
                        }
                        if ($id_spare_part) {
                            $query->where('id_spare_part', $id_spare_part);
                        }
                    })
                    ->first();

                if ($cartItem) {
                    // If it exists, update the quantity
                    $cartItem->quantity += $request->quantity;
                    $cartItem->total_price = $cartItem->quantity * ($produk ? $produk->harga_produk : $sparepart->harga_spare_part);
                    $cartItem->save();
                } else {
                    // Create a new cart item
                    $cart = new Cart();
                    $cart->id_pelanggan = $pelanggan_id;
                    $cart->id_produk = $id_produk;
                    $cart->id_spare_part = $id_spare_part;
                    $cart->quantity = $request->quantity;
                    $cart->total_price = ($produk ? $produk->harga_produk : $sparepart->harga_spare_part) * $request->quantity;
                    $cart->save();
                }

                // Simpan ID item terakhir yang ditambahkan ke session
                session(['last_added_item_id' => $cart->id]);

                // Cek apakah tombol "Buy Now" diklik
                $buyNow = $request->has('buy_now');

                // Redirect ke halaman cart dengan parameter buy_now
                return redirect()->route('cart.index', ['buy_now' => $buyNow])->with('status', 'Product added to cart');
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

        // Fetch cart items based on the user's ID
        $cartItems = Cart::where('id_pelanggan', $pelanggan_id)->get();

        // Ensure there are items in the cart
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Capture shipping method details from request
        $shipping_method = $request->shipping_method;
        $shipping_courier = $request->shipping_courier;
        $shipping_cost = $request->shipping_cost;

        // Initialize total price
        $grandTotal = 0;

        // Create an order
        $order = new OrderOnline();
        $order->id_pelanggan = $pelanggan_id;
        $order->order_id = Str::random(10); // Generate a random order_id
        $order->status_order = 'PENDING';
        $order->tanggal = now();
        $order->jenis_pengiriman = $shipping_method;
        $order->kurir = $shipping_courier;
        $order->biaya_pengiriman = $shipping_cost;
        $order->grand_total = $grandTotal + $shipping_cost;
        $order->atas_nama = $request->recipient;
        $order->alamat_pengiriman = $request->location;
        $order->provinsi = $request->province;
        $order->kabupaten = $request->city;
        $order->kecamatan = $request->district;
        $order->kode_pos = $request->postal_code;
        $order->no_telp = $request->phone;

        // Tentukan id_bengkel, bisa diambil dari produk pertama atau spare part pertama di cart
        $firstItem = $cartItems->first();
        $product = Product::find($firstItem->id_produk);
        $sparepart = SpareParts::find($firstItem->id_spare_part);

        if ($product) {
            $order->id_bengkel = $product->id_bengkel;  // Set id_bengkel berdasarkan produk
        } elseif ($sparepart) {
            $order->id_bengkel = $sparepart->id_bengkel;  // Set id_bengkel berdasarkan spare part
        }

        // Simpan order
        $order->save();

        // Loop through each cart item and save to t_order_item_online
        foreach ($cartItems as $item) {
            $product = Product::find($item->id_produk);
            $sparepart = SpareParts::find($item->id_spare_part);

            // Determine the type of item (product or spare part)
            $itemPrice = 0;
            $itemId = null;
            $itemType = null;

            // Check if it's a product or spare part
            if ($product) {
                $itemId = $product->id_produk;
                $itemPrice = $product->harga_produk;
            } elseif ($sparepart) {
                $itemId = $sparepart->id_spare_part;
                $itemPrice = $sparepart->harga_spare_part;
            }

            // Save to t_order_item_online
            $orderItem = new OrderItemOnline();
            $orderItem->id_order_online = $order->id; // Relating this item to the order
            $orderItem->id_bengkel = $product ? $product->id_bengkel : $sparepart->id_bengkel;
            $orderItem->id_produk = $product ? $itemId : null;
            $orderItem->id_spare_part = $sparepart ? $itemId : null;
            $orderItem->tanggal = now();
            $orderItem->qty = $item->quantity;
            $orderItem->harga_beli = $itemPrice;
            $orderItem->harga = $itemPrice;
            $orderItem->subtotal = $itemPrice * $item->quantity;
            $orderItem->save();

            // Calculate the grand total
            $grandTotal += $orderItem->subtotal;
        }

        // Update the order's grand total
        $order->grand_total = $grandTotal + $shipping_cost;
        $order->save();

        // Create an invoice for the total order
        $invoice = new Invoice();
        $invoice->id_pelanggan = $pelanggan_id;
        $invoice->id_order = $order->order_id;
        $invoice->status_invoice = 'PENDING';
        $invoice->tanggal_invoice = now();
        $invoice->jatuh_tempo = now()->addDays(1);
        $invoice->nominal_transfer = $order->grand_total;
        $invoice->save();

        // Delete cart items after order is processed
        $cartItems->each->delete();

        return redirect()->route('payment', ['order_id' => $order->order_id, 'id' => $invoice->id])
                            ->with('status', 'Pesanan Anda berhasil diproses. Segera lakukan pembayaran untuk melanjutkan.');

    }

    return redirect()->route('login')->with('status_error', 'Anda harus login terlebih dahulu.');
}


    public function getCartCount()
{
    if (Auth::check()) {
        $pelanggan_id = Auth::user()->id_pelanggan;
        $cartCount = Cart::where('id_pelanggan', $pelanggan_id)->sum('quantity'); // Sum of all quantities
        return response()->json(['count' => $cartCount]);
    }
    return response()->json(['count' => 0]);
}


}
