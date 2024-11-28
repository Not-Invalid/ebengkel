<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\StockOpname;
use App\Models\Bengkel;
use App\Models\Product;
use Illuminate\Http\Request;

class StockOpnameController extends Controller
{
    public function index(Request $request, $id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Bengkel tidak ditemukan.');
        }

        if (!Auth::guard('pegawai')->check()) {
            return redirect()->route('pos.login');
        }

        $perPage = $request->get('per_page', 10);

        // Retrieve products and their stock details
        $products = Product::where('id_bengkel', $id_bengkel)
            ->where('delete_produk', 'N')
            ->with('stocks') // Eager load stocks relationship
            ->paginate($perPage);

        // Flatten the products and their stocks into a single collection
        $combined = $products->flatMap(function ($product) {
            return $product->stocks->map(function ($stock) use ($product) {
                // Add product data to each stock entry
                $stock->product_name = $product->nama_produk;
                $stock->product_brand = $product->merk_produk;
                $stock->product_image = isset($product->foto_produk) ? url($product->foto_produk) : asset('assets/images/components/image.png');
                return $stock;
            });
        });

        // Paginate the combined collection
        $combined = new \Illuminate\Pagination\LengthAwarePaginator(
            $combined->forPage(request()->get('page', 1), $perPage),
            $combined->count(),
            $perPage,
            request()->get('page', 1),
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('pos.management-stock.stock-opname.index', compact('bengkel', 'products', 'combined'));
    }

    public function create($id_bengkel)
    {
        // Retrieve bengkel and related products
        $bengkel = Bengkel::findOrFail($id_bengkel);
        $products = Product::where('id_bengkel', $id_bengkel)->where('delete_produk', 'N')->get();

        return view('pos.management-stock.stock-opname.create', compact('bengkel', 'products'));
    }

    public function store(Request $request, $id_bengkel)
    {
        // Validate the request
        $request->validate([
            'product_id' => 'required|exists:tb_produk,id_produk',
            'stock_recorded' => 'required|integer|min:0',
            'stock_actual' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        // Find the product based on the product_id
        $product = Product::findOrFail($request->product_id);

        // Calculate the difference between recorded stock and actual stock
        $difference = $request->stock_actual - $request->stock_recorded;

        // Create a new Stock Opname entry
        $stockOpname = new StockOpname([
            'id_bengkel' => $id_bengkel,
            'id_produk' => $product->id_produk,
            'stock_recorded' => $request->stock_recorded,
            'stock_actual' => $request->stock_actual,
            'difference' => $difference,
            'description' => $request->description,
        ]);
        $stockOpname->save();

        // Optionally, update the product's stock if necessary
        $product->stok_produk += $difference;
        $product->save();

        return redirect()->route('pos.stock-opname.index', $id_bengkel)->with('success', 'Stock Opname recorded successfully');
    }

    public function delete($id_opname)
    {
        // Find the Stock Opname entry
        $stockOpname = StockOpname::findOrFail($id_opname);
        $product = Product::findOrFail($stockOpname->id_produk);
    
        // Revert the product's stock if necessary
        $product->stok_produk -= $stockOpname->difference;
        $product->save();
    
        // Delete the Stock Opname entry
        $stockOpname->delete();
    
        // Redirect back to the stock opname index page for the corresponding bengkel
        return redirect()->route('pos.stock-opname.index', ['id_bengkel' => $stockOpname->id_bengkel])
            ->with('success', 'Stock Opname entry deleted successfully');
    }
    
}
