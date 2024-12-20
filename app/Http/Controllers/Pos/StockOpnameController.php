<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\Product;
use App\Models\SpareParts;
use App\Models\StockOpname;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockOpnameController extends Controller
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

        $combined = $products->flatMap(function ($product) {
            return $product->stocksOpname->map(function ($stock) use ($product) {
                $stock->product_name = $product->nama_produk;
                $stock->product_brand = $product->merk_produk;
                $stock->type = 'product';
                $stock->quantity = $product->stok_produk;
                return $stock;
            });
        });

        $sparePartStocks = $spareParts->flatMap(function ($sparePart) {
            $stocks = optional($sparePart->stocksOpname)->map(function ($stock) use ($sparePart) {
                $stock->product_name = $sparePart->nama_spare_part;
                $stock->product_brand = $sparePart->merk_spare_part;
                $stock->type = 'spare_part';
                $stock->quantity = $sparePart->stok_spare_part;
                return $stock;
            });

            return $stocks ?? collect();
        });

        // Gabungkan kedua koleksi
        $combined = $combined->merge($sparePartStocks);

        // Urutkan berdasarkan created_at (waktu input)
        $combined = $combined->sortBy('created_at'); // Mengurutkan berdasarkan tanggal input (created_at)

        // Pagination
        $combined = new \Illuminate\Pagination\LengthAwarePaginator(
            $combined->forPage(request()->get('page', 1), $perPage),
            $combined->count(),
            $perPage,
            request()->get('page', 1),
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // Pagination variables
        $totalEntries = $combined->total();
        $start = ($combined->currentPage() - 1) * $perPage + 1;
        $end = min($combined->currentPage() * $perPage, $totalEntries);

        // Return the view with pagination data
        return view('pos.management-stock.stock-opname.index', compact('bengkel', 'combined', 'totalEntries', 'start', 'end'));
    }

    public function create($id_bengkel)
    {
        $bengkel = Bengkel::findOrFail($id_bengkel);
        $products = Product::where('id_bengkel', $id_bengkel)->where('delete_produk', 'N')->get();
        $spareParts = SpareParts::where('id_bengkel', $id_bengkel)->where('delete_spare_part', 'N')->get();

        return view('pos.management-stock.stock-opname.create', compact('bengkel', 'products', 'spareParts'));
    }
    public function store(Request $request, $id_bengkel)
    {
        // Validasi request
        $validatedData = $request->validate([
            'type' => 'required|in:product,spare_part',
            'actual_quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'product_id' => 'nullable|exists:tb_produk,id_produk',
            'spare_part_id' => 'nullable|exists:tb_spare_part,id_spare_part',
        ]);

        if ($validatedData) {
            // Jangan cek apakah StockOpname sudah ada, karena kita ingin membuat entri baru
            $stockOpname = new StockOpname([
                'id_bengkel' => $id_bengkel,
                'actual_quantity' => $request->actual_quantity,
                'description' => $request->description,
                'id_pegawai' => Auth::guard('pegawai')->id(),
                'type' => $request->type,
            ]);

            if ($request->type === 'product') {
                // Untuk produk, ambil produk yang dipilih
                $product = Product::findOrFail($request->product_id);
                $stockOpname->id_produk = $product->id_produk;

                // Set the recorded_quantity to the current stock of the product
                $stockOpname->recorded_quantity = $product->stok_produk; // Store the product's current stock

            }

            if ($request->type === 'spare_part') {
                // Untuk spare part, ambil spare part yang dipilih
                $sparePart = SpareParts::findOrFail($request->spare_part_id);
                $stockOpname->id_spare_part = $sparePart->id_spare_part;

                // Set the recorded_quantity to the current stock of the spare part
                $stockOpname->recorded_quantity = $sparePart->stok_spare_part; // Store the spare part's current stock
            }

            $stockOpname->created_at = now(); // Mengatur waktu secara manual

            // Simpan stock opname baru tanpa menambah quantity pada yang lama
            $stockOpname->save();

            // Kembalikan ke halaman dengan pesan sukses
            return redirect()->route('pos.management-stock.opname', $id_bengkel)
                ->with('status', 'Stock Opname berhasil ditambahkan');
        }

        // Jika validasi gagal, Laravel akan otomatis mengarahkan kembali dengan pesan error
    }

    public function delete($id_bengkel, $id_opname)
    {
        // Try to find the StockOpname by the id_opname
        $stock = StockOpname::where('id_opname', $id_opname)
            ->where('id_bengkel', $id_bengkel)
            ->first();

        // If not found, redirect with an error message
        if (!$stock) {
            return redirect()->route('pos.management-stock.opname', $id_bengkel)
                ->with('error', 'Stock Opname not found in this Bengkel.');
        }

        // Delete the stock entry
        $stock->delete();

        // Redirect back with success message
        return redirect()->route('pos.management-stock.opname', ['id_bengkel' => $id_bengkel])
            ->with('success', 'Stock Opname successfully deleted.');
    }

}
