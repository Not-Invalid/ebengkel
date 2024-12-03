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

            // Ambil data keranjang belanja berdasarkan pelanggan
            $cartItems = Cart::where('id_pelanggan', $pelanggan_id)->get();

            // Pastikan ada barang di keranjang
            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
            }

            // Menghitung total quantity dan harga total
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

            // Buat order
            $order = new OrderOnline();
            $order->id_pelanggan = $pelanggan_id;
            $order->id_bengkel = $bengkel_id;
            $order->tanggal = now();
            $order->total_qty = $total_qty;
            $order->total_harga = $total_harga;
            $order->status_order = 'TEMP';  // Status awal
            $order->save();

            // Transfer cart items ke order
            foreach ($cartItems as $item) {
                if ($item->id_produk) {
                    $order->id_produk = $item->id_produk;
                }
                if ($item->id_spare_part) {
                    $order->id_spare_part = $item->id_spare_part;
                }
                $order->save();
            }

            // Hapus cart items setelah order dibuat
            $cartItems->each->delete();

            // Menggunakan service Midtrans untuk membuat transaksi
            $customer_details = [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->no_telp,
            ];

            // Membuat transaksi QRIS dan mendapatkan Snap Token
            $snapToken = $this->midtransService->createTransaction(
                'order-' . $order->id,
                $total_harga,
                $customer_details
            );

            // Menyimpan Snap Token di order
            $order->midtrans_snap_token = $snapToken;
            $order->save();

            return redirect()->route('payment', ['snap_token' => $snapToken])
                ->with('status', 'Pesanan berhasil diproses. Silakan lakukan pembayaran.');
        }

        return redirect()->route('login')->with('status_error', 'Anda harus login terlebih dahulu.');
    }


}
