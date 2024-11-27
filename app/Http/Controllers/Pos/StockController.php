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
    
    $perPage = $request->get('per_page', 10);
    
    // Load products and their related stock entries using eager loading
    $products = Product::where('id_bengkel', $id_bengkel)
        ->where('delete_produk', 'N')
        ->with('stocks') // Eager load stocks relationship
        ->paginate($perPage);

    // Process uploaded product images if present
    if ($request->hasFile('foto_produk')) {
        $imageName = 'foto_produk_' . now()->format('Ymd_His') . '.' . $request->foto_produk->extension();
        $request->foto_produk->move(public_path('assets/images/products'), $imageName);
        $products->foto_produk = 'assets/images/products/' . $imageName;
    }
    
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
    
    // Pass both the products (for pagination) and the combined (for stock display) to the view
    return view('pos.management-stock.stock-inbound.index', compact('bengkel', 'products', 'combined'));
}   
    public function create($id_bengkel)
    {
        // Retrieve the bengkel and its products for adding stock
        $bengkel = Bengkel::findOrFail($id_bengkel);
        $products = Product::where('id_bengkel', $id_bengkel)->where('delete_produk', 'N')->get();

        return view('pos.management-stock.stock-inbound.create', compact('bengkel', 'products'));
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
    
        // Redirect back to the management stock page for the corresponding bengkel (workshop)
        return redirect()->route('pos.management-stock', ['id_bengkel' => $product->id_bengkel])
            ->with('success', 'Stock entry deleted successfully');
    }
}
