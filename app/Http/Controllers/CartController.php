<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\SpareParts;
use Illuminate\Http\Request;
use App\Services\MidtransService;
use App\Models\OrderOnline;
use App\Models\Bengkel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Midtrans\Snap;

class CartController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }
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

        $bengkel = Bengkel::find($bengkel_id);
        if (!$bengkel) {
            return redirect()->route('cart.index')->with('error', 'Bengkel tidak ditemukan.');
        }

        // Create order
        $order = new OrderOnline();
        $order->id_pelanggan = $pelanggan_id;
        $order->id_bengkel = $bengkel_id;
        $order->tanggal = now();
        $order->total_qty = $total_qty;
        $order->total_harga = $total_harga;
        $order->status_order = 'TEMP';  // Initial status

        // Capture shipping address details
        $order->atas_nama = $request->recipient;
        $order->alamat_pengiriman = $request->location;
        $order->provinsi = $request->province;
        $order->kabupaten = $request->district;
        $order->kecamatan = $request->sub_district;
        $order->kode_pos = $request->postal_code;
        $order->no_telp = $request->phone;

        $order->save();

        // Transfer cart items to order
        foreach ($cartItems as $item) {
            $order->id_produk = $item->id_produk ? $item->id_produk : null;  // Ensure id_produk or id_spare_part is set
            $order->id_spare_part = $item->id_spare_part ? $item->id_spare_part : null;
            $order->save();
        }

        // Delete cart items after order is created
        $cartItems->each->delete();

        // Use Midtrans service to create transaction
        $customer_details = [
            'first_name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'phone' => Auth::user()->no_telp,
        ];

        // Create QRIS transaction and get Snap Token
        $snapToken = $this->midtransService->createTransaction(
            'order-' . $order->id,
            $total_harga,
            $customer_details
        );

        // Save Snap Token in order
        $order->midtrans_snap_token = $snapToken;
        $order->save();

        return redirect()->route('payment', ['snap_token' => $snapToken])
            ->with('status', 'Pesanan berhasil diproses. Silakan lakukan pembayaran.');
    }

    return redirect()->route('login')->with('status_error', 'Anda harus login terlebih dahulu.');
}


}
