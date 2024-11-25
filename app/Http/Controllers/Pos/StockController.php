<?php
namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use App\Models\Bengkel;
use Illuminate\Http\Request;

class StockController extends Controller
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
    
        $search = $request->input('search', '');
    
        // Load products and their related stock entries
        $products = Product::where('id_bengkel', $id_bengkel)
            ->where('delete_produk', 'N')
            ->with('stocks')  // Ensure you load related stock entries
            ->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('nama_produk', 'like', "%$search%");
                }
            })
            ->paginate(10);
    
        return view('pos.management-stock.index', compact('bengkel', 'products'));
    }
    public function create($id_bengkel)
    {
        // Retrieve the bengkel and its products for adding stock
        $bengkel = Bengkel::findOrFail($id_bengkel);
        $products = Product::where('id_bengkel', $id_bengkel)->where('delete_produk', 'N')->get();

        return view('pos.management-stock.create', compact('bengkel', 'products'));
    }

    public function store(Request $request, $id_bengkel)
    {
        // Validate the request
        $request->validate([
            'product_id' => 'required|exists:tb_produk,id_produk',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);
    
        // Find the product based on the product_id passed in the request
        $product = Product::findOrFail($request->product_id);
    
        // Create a new stock entry with the correct foreign key
        $stock = new Stock([
            'id_bengkel' => $id_bengkel,
            'id_produk' => $product->id_produk,  // Use 'id_produk' here
            'quantity' => $request->quantity,
            'description' => $request->description,
        ]);
        $stock->save();
    
        // Update the product's stock
        $product->stok_produk += $request->quantity;
        $product->save();
    
        return redirect()->route('pos.management-stock', $id_bengkel)->with('success', 'Stock added successfully');
    }

    public function delete($id_stock)
    {
        // Find the stock entry using the id_stock
        $stock = Stock::findOrFail($id_stock);
        $product = Product::findOrFail($stock->id_produk);  // Assuming product is related via 'id_produk'
    
        // Deduct the stock from the product's total stock
        $product->stok_produk -= $stock->quantity;
        $product->save();
    
        // Delete the stock entry
        $stock->delete();
    
        return redirect()->route('pos.management-stock', $product->id_bengkel)->with('success', 'Stock entry deleted successfully');
    }
    
}
