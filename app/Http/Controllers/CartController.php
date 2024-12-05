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
                        $query->where('id_produk', $id_produk)
                            ->orWhere('id_spare_part', $id_spare_part);
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

        // Fetch cart items based on the user's ID
        $cartItems = Cart::where('id_pelanggan', $pelanggan_id)->get();

        // Ensure there are items in the cart
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Calculate total quantity and price
        $total_qty = 0;
        $total_harga = 0;
        $bengkel_id = null;

        foreach ($cartItems as $item) {
            $total_qty += $item->quantity;
            $total_harga += $item->total_price;

            $produk = Product::find($item->id_produk);
            $sparepart = SpareParts::find($item->id_spare_part);
            if ($produk) {
                $bengkel_id = $produk->id_bengkel;
            } elseif ($sparepart) {
                $bengkel_id = $sparepart->id_bengkel;
            }
        }

        // Ensure that bengkel exists
        $bengkel = Bengkel::find($bengkel_id);
        if (!$bengkel) {
            return redirect()->route('cart.index')->with('error', 'Bengkel tidak ditemukan.');
        }

        // Capture shipping method details from request
        $shipping_method = $request->shipping_method; // e.g., Reguler
        $shipping_courier = $request->shipping_courier; // e.g., J&T Express
        $shipping_cost = $request->shipping_cost; // e.g., 11000

        // Calculate grand total (total price + shipping cost)
        $grand_total = $total_harga + $shipping_cost;

        // Create order
        $order = new OrderOnline();
        $order->id_pelanggan = $pelanggan_id;
        $order->id_bengkel = $bengkel_id;
        $order->tanggal = now();
        $order->total_qty = $total_qty;
        $order->total_harga = $total_harga;
        $order->status_order = 'PENDING';  // Set status to PENDING or something appropriate
        $order->order_id = Str::random(10); // Generate a random string for order_id

        // Store shipping details
        $order->jenis_pengiriman = $shipping_method;
        $order->kurir = $shipping_courier;
        $order->biaya_pengiriman = $shipping_cost;
        $order->grand_total = $grand_total;

        // Capture additional address details
        $order->atas_nama = $request->recipient; // Name of the recipient
        $order->alamat_pengiriman = $request->location; // Shipping address
        $order->provinsi = $request->province; // Province
        $order->kabupaten = $request->district; // District
        $order->kecamatan = $request->city; // Sub-district
        $order->kode_pos = $request->postal_code; // Postal code
        $order->no_telp = $request->phone; // Recipient phone

        // Save the order
        $order->save();

        // Link invoice to order by order_id
        $invoice = new Invoice();
        $invoice->id_pelanggan = $pelanggan_id;
        $invoice->id_order = $order->order_id;  // Use order_id to link to t_invoice
        $invoice->status_invoice = 'PENDING';
        $invoice->tanggal_invoice = now();
        $invoice->jatuh_tempo = now()->addDays(7);  // Example: 7 days from now
        $invoice->save();

        // Delete cart items after order is processed
        $cartItems->each->delete();

        // Redirect to a payment page or confirmation page
        return redirect()->route('payment', ['order_id' => $order->order_id])
            ->with('status', 'Pesanan berhasil diproses. Harap tunggu konfirmasi.');
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
