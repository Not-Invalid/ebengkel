<?php
namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\StockInbound;
use App\Models\Bengkel;
use App\Models\Product;
use App\Models\SpareParts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockInboundController extends Controller
{
    public function index(Request $request, $id_bengkel)
{
    $bengkel = Bengkel::find($id_bengkel);

    // Handle case when bengkel is not found
    if (!$bengkel) {
        return redirect()->route('profile.workshop')->with('error_status', 'Bengkel tidak ditemukan.');
    }

    // Ensure that the user is authenticated as an employee
    if (!Auth::guard('pegawai')->check()) {
        return redirect()->route('pos.login');
    }

    // Get the 'per_page' value from the request (default to 10)
    $perPage = $request->get('per_page', 10);

    // Load products and spare parts for the bengkel
    $products = Product::where('id_bengkel', $id_bengkel)
        ->where('delete_produk', 'N')
        ->get(); // Use get() instead of paginate

    $spareParts = SpareParts::where('id_bengkel', $id_bengkel)
        ->where('delete_spare_part', 'N')
        ->get(); // Use get() instead of paginate

    // Combine both products and spare parts, adding 'type' dynamically
    $combined = $products->flatMap(function ($product) {
        return $product->stocks->map(function ($stock) use ($product) {
            $stock->product_name = $product->nama_produk;
            $stock->product_brand = $product->merk_produk;
            $stock->type = 'product';  // Add a type for products
            return $stock;
        });
    });

    $sparePartStocks = $spareParts->flatMap(function ($sparePart) {
        $stocks = optional($sparePart->stocks)->map(function ($stock) use ($sparePart) {
            $stock->product_name = $sparePart->nama_spare_part;
            $stock->product_brand = $sparePart->merk_spare_part;
            $stock->type = 'spare_part';  // Add a type for spare parts
            return $stock;
        });

        return $stocks ?? collect();
    });

    // Merge both collections
    $combined = $combined->merge($sparePartStocks);

    // Apply pagination after combining both collections
    $combined = new \Illuminate\Pagination\LengthAwarePaginator(
        $combined->forPage(request()->get('page', 1), $perPage),
        $combined->count(),
        $perPage,
        request()->get('page', 1),
        ['path' => request()->url(), 'query' => request()->query()]
    );

    return view('pos.management-stock.stock-inbound.index', compact('bengkel', 'combined'));
}

    public function create($id_bengkel)
    {
        $bengkel = Bengkel::findOrFail($id_bengkel);
        $products = Product::where('id_bengkel', $id_bengkel)->where('delete_produk', 'N')->get();
        $spareParts = SpareParts::where('id_bengkel', $id_bengkel)->where('delete_spare_part', 'N')->get();

        return view('pos.management-stock.stock-inbound.create', compact('bengkel', 'products', 'spareParts'));
    }
    public function store(Request $request, $id_bengkel)
{
    // Validate request
    $request->validate([
        'product_id' => 'nullable|exists:tb_produk,id_produk',
        'spare_part_id' => 'nullable|exists:tb_spare_part,id_spare_part',
        'quantity' => 'required|integer|min:1',
        'description' => 'nullable|string',
    ]);

    $stock = new StockInbound([
        'id_bengkel' => $id_bengkel,
        'quantity' => $request->quantity,
        'description' => $request->description,
        'id_pegawai' => Auth::guard('pegawai')->id(),  // Automatically get the authenticated employee's ID
    ]);
    

    // If it's a product
    if ($request->type === 'product') {
        $product = Product::findOrFail($request->product_id);
        $stock->id_produk = $product->id_produk;
        $product->stok_produk += $request->quantity;
        $product->save();
        $stock->type = 'product';
    }

    // If it's a spare part
    if ($request->type === 'spare_part') {
        $sparePart = SpareParts::findOrFail($request->spare_part_id);
        $stock->id_spare_part = $sparePart->id_spare_part;
        $sparePart->stok_spare_part += $request->quantity;
        $sparePart->save();
        $stock->type = 'spare_part';
    }

    $stock->save();

    return redirect()->route('pos.management-stock.inbound', $id_bengkel)->with('status', 'Stock added successfully');
}

    public function delete($id_stock)
    {
        $stock = StockInbound::findOrFail($id_stock);

        if ($stock->type === 'product') {
            $product = Product::findOrFail($stock->id_produk);
            $product->stok_produk -= $stock->quantity;
            $product->save();
        }

        if ($stock->type === 'spare_part') {
            $sparePart = SpareParts::findOrFail($stock->id_spare_part);
            $sparePart->stok_spare_part -= $stock->quantity;
            $sparePart->save();
        }

        $stock->delete();

        return redirect()->route('pos.management-stock.inbound', ['id_bengkel' => $stock->id_bengkel])
            ->with('status', 'Stock entry deleted successfully');
    }
}
