<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\SpareParts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['redirect' => route('login')], 401);
        }

        $userId = Session::get('id_pelanggan');
        $productPrice = $request->id_produk ? Product::find($request->id_produk)->price : 0;
        $sparePartPrice = $request->id_spare_part ? SpareParts::find($request->id_spare_part)->price : 0;

        $cartItem = Cart::updateOrCreate(
            [
                'id_pelanggan' => $userId,
                'id_produk' => $request->id_produk,
                'id_spare_part' => $request->id_spare_part,
            ],
            [
                'quantity' => DB::raw('quantity + ' . $request->quantity),
                'total_price' => ($productPrice + $sparePartPrice) * $request->quantity,
            ]
        );

        $cartCount = Cart::where('id_pelanggan', $userId)->count();

        return response()->json([
            'message' => 'Berhasil ditambahkan ke keranjang',
            'cartCount' => $cartCount,
        ]);
    }

    public function getCartTotal()
    {
        if (!Auth::check()) {
            return response()->json(['total' => 0]);
        }

        $totalItems = Cart::where('id_pelanggan', Auth::id())->count();
        return response()->json(['total' => $totalItems]);
    }
}
