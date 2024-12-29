<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Invoice;
use App\Models\OrderItemOnline;
use App\Models\OrderOnline;
use App\Models\Product;
use App\Models\SpareParts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $pelanggan_id = Auth::user()->id_pelanggan;

            // Ambil cart berdasarkan pelanggan
            $cart = Cart::with([
                'cartItems.produk.fotoProduk', // Pastikan foto produk ada
                'cartItems.sparepart.fotoSparepart', // Pastikan foto sparepart ada
            ])
                ->where('id_pelanggan', $pelanggan_id)
                ->first(); // Ambil satu cart yang sesuai

            // Ambil shipping address
            $shippingAddress = Auth::user()->alamatPengiriman->where("delete_alamat_pengiriman", "N");

            // Periksa apakah cart ada dan memiliki item
            $cartItems = $cart ? $cart->cartItems : collect(); // Jika cart tidak ada, buat koleksi kosong

            return view("transaction.cart", compact("cartItems", "shippingAddress"));
        } else {
            return redirect()
                ->route("login")
                ->with("status_error", "Please log in to view the cart");
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

                $cartItem = Cart::where("id_pelanggan", $pelanggan_id)
                    ->where(function ($query) use ($id_produk, $id_spare_part) {
                        if ($id_produk) {
                            $query->where("id_produk", $id_produk);
                        }
                        if ($id_spare_part) {
                            $query->where("id_spare_part", $id_spare_part);
                        }
                    })
                    ->first();

                if ($cartItem) {
                    $cartItem->quantity += $request->quantity;
                    $cartItem->total_price =
                    $cartItem->quantity *
                        ($produk
                        ? $produk->harga_produk
                        : $sparepart->harga_spare_part);
                    $cartItem->save();
                } else {
                    $cart = new Cart();
                    $cart->id_pelanggan = $pelanggan_id;
                    $cart->id_produk = $id_produk;
                    $cart->id_spare_part = $id_spare_part;
                    $cart->quantity = $request->quantity;
                    $cart->total_price =
                    ($produk
                        ? $produk->harga_produk
                        : $sparepart->harga_spare_part) *
                    $request->quantity;
                    $cart->save();
                }

                session(["last_added_item_id" => $cart->id ?? $cartItem->id]);

                $buyNow = $request->has("buy_now");

                return redirect()
                    ->route("cart.index", ["buy_now" => $buyNow])
                    ->with("status", "Product added to cart");
            } else {
                return redirect()
                    ->back()
                    ->with("status_error", "Product or spare part not found");
            }
        } else {
            return redirect()
                ->route("login")
                ->with("status_error", "Please log in to add to cart");
        }
    }

    public function removeItem(Request $request)
    {
        if (Auth::check()) {
            $pelanggan_id = Auth::user()->id_pelanggan;

            $cartItem = Cart::where("id", $request->id)
                ->where("id_pelanggan", $pelanggan_id)
                ->first();

            if ($cartItem) {
                $cartItem->delete();
                return response()->json(["status" => "success"]);
            } else {
                return response()->json([
                    "status" => "error",
                    "message" => "Item not found",
                ]);
            }
        } else {
            return response()->json([
                "status" => "error",
                "message" => "User not authenticated",
            ]);
        }
    }

    public function updateQuantity(Request $request)
    {
        if (Auth::check()) {
            $pelanggan_id = Auth::user()->id_pelanggan;

            $validated = $request->validate([
                "id" => "required|integer",
                "quantity" => "required|integer|min:1",
            ]);

            $cartItem = Cart::where("id", $request->id)
                ->where("id_pelanggan", $pelanggan_id)
                ->first();

            if ($cartItem) {
                $produk = Product::find($cartItem->id_produk);
                $sparepart = SpareParts::find($cartItem->id_spare_part);

                if ($produk) {
                    $cartItem->total_price =
                    $produk->harga_produk * $request->quantity;
                } elseif ($sparepart) {
                    $cartItem->total_price =
                    $sparepart->harga_spare_part * $request->quantity;
                }

                $cartItem->quantity = $request->quantity;
                $cartItem->save();

                return response()->json([
                    "status" => "success",
                    "total_price" => number_format(
                        $cartItem->total_price,
                        0,
                        ",",
                        "."
                    ),
                    "quantity" => $cartItem->quantity,
                ]);
            } else {
                return response()->json([
                    "status" => "error",
                    "message" => "Item not found",
                ]);
            }
        } else {
            return response()->json([
                "status" => "error",
                "message" => "User not authenticated",
            ]);
        }
    }

    public function placeOrder(Request $request)
    {
        if (Auth::check()) {
            $pelanggan_id = Auth::user()->id_pelanggan;

            $cartItems = Cart::where("id_pelanggan", $pelanggan_id)->get();

            if ($cartItems->isEmpty()) {
                return redirect()
                    ->route("cart.index")
                    ->with("error", "Keranjang Anda kosong.");
            }

            $totalPrice = 0;

            $order = new OrderOnline();
            $order->id_pelanggan = $pelanggan_id;
            $order->order_id = Str::random(10);
            $order->status_order = "PENDING";
            $order->tanggal = now();
            $order->atas_nama = $request->recipient;
            $order->alamat_pengiriman = $request->location;
            $order->provinsi = $request->province;
            $order->kabupaten = $request->city;
            $order->kecamatan = $request->district;
            $order->kode_pos = $request->postal_code;
            $order->no_telp = $request->phone;

            $firstItem = $cartItems->first();
            $product = Product::find($firstItem->id_produk);
            $sparepart = SpareParts::find($firstItem->id_spare_part);

            if ($product) {
                $order->id_bengkel = $product->id_bengkel;
            } elseif ($sparepart) {
                $order->id_bengkel = $sparepart->id_bengkel;
            }

            foreach ($cartItems as $item) {
                $product = Product::find($item->id_produk);
                $sparepart = SpareParts::find($item->id_spare_part);

                $itemPrice = 0;
                if ($product) {
                    $itemPrice = $product->harga_produk;
                } elseif ($sparepart) {
                    $itemPrice = $sparepart->harga_spare_part;
                }

                $totalPrice += $itemPrice * $item->quantity;
            }

            $order->total_harga = $totalPrice;

            $order->save();

            foreach ($cartItems as $item) {
                $product = Product::find($item->id_produk);
                $sparepart = SpareParts::find($item->id_spare_part);

                $itemPrice = 0;
                $itemId = null;

                if ($product) {
                    $itemId = $product->id_produk;
                    $itemPrice = $product->harga_produk;
                } elseif ($sparepart) {
                    $itemId = $sparepart->id_spare_part;
                    $itemPrice = $sparepart->harga_spare_part;
                }

                $orderItem = new OrderItemOnline();
                $orderItem->id_order_online = $order->id;
                $orderItem->id_bengkel = $product
                ? $product->id_bengkel
                : $sparepart->id_bengkel;
                $orderItem->id_produk = $product ? $itemId : null;
                $orderItem->id_spare_part = $sparepart ? $itemId : null;
                $orderItem->tanggal = now();
                $orderItem->qty = $item->quantity;
                $orderItem->harga_beli = $itemPrice;
                $orderItem->harga = $itemPrice;
                $orderItem->subtotal = $itemPrice * $item->quantity;
                $orderItem->save();
            }

            $invoice = new Invoice();
            $invoice->id_pelanggan = $pelanggan_id;
            $invoice->id_order = $order->order_id;
            $invoice->status_invoice = "PENDING";
            $invoice->tanggal_invoice = now();
            $invoice->jatuh_tempo = now()
                ->addDays(1)
                ->setTime(now()->hour, now()->minute, now()->second);
            $invoice->nominal_transfer = $order->grand_total;
            $invoice->save();

            $cartItems->each->delete();

            return redirect()
                ->route("payment", [
                    "order_id" => $order->order_id,
                    "id" => $invoice->id,
                ])
                ->with(
                    "status",
                    "Pesanan Anda berhasil diproses. Segera lakukan pembayaran untuk melanjutkan."
                );
        }
        return redirect()
            ->route("login")
            ->with("status_error", "Anda harus login terlebih dahulu.");
    }

    public function getCartCount()
    {
        if (Auth::check()) {
            $pelanggan_id = Auth::user()->id_pelanggan;
            $cartCount = Cart::where("id_pelanggan", $pelanggan_id)->sum(
                "quantity"
            );
            return response()->json(["count" => $cartCount]);
        }
        return response()->json(["count" => 0]);
    }
}
