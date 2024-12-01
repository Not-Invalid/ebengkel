<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\StockOpname;
use App\Models\Product;
use App\Models\SpareParts;
use App\Models\Bengkel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockOpnameController extends Controller
{
    public function index($id_bengkel)
    {
        $bengkel = Bengkel::findOrFail($id_bengkel);
        $combined = StockOpname::where('id_bengkel', $id_bengkel)
            ->with('product', 'sparePart', 'pegawai')
            ->paginate(10);

        return view('pos.management-stock.stock-opname.index', compact('bengkel', 'combined'));
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
        $request->validate([
            'type' => 'required|in:product,spare_part',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'product_id' => 'nullable|exists:tb_produk,id_produk',
            'spare_part_id' => 'nullable|exists:tb_spare_part,id_spare_part',
        ]);
    
        // Debug: Mengecek isi request
        // dd($request->all());
    
        try {
            // Create Stock Opname entry
            $stockOpname = new StockOpname([
                'id_bengkel' => $id_bengkel,
                'quantity' => $request->quantity,
                'description' => $request->description,
                'id_pegawai' => Auth::guard('pegawai')->id(),
            ]);
    
            // Handle Product Stock Opname
            if ($request->type == 'product') {
                $product = Product::findOrFail($request->product_id);
                $stockOpname->id_produk = $product->id_produk;
                $product->stok_produk += $request->quantity;
                $product->save();
            }
    
            // Handle Spare Part Stock Opname
            if ($request->type == 'spare_part') {
                $sparePart = SpareParts::findOrFail($request->spare_part_id);
                $stockOpname->id_spare_part = $sparePart->id_spare_part;
                $sparePart->stok_spare_part += $request->quantity;
                $sparePart->save();
            }
    
            $stockOpname->save();
    
            // Redirect after saving
            return redirect()->route('pos.management-stock.opname', ['id_bengkel' => $id_bengkel])
                             ->with('success', 'Stock Opname has been added successfully!');
        } catch (\Exception $e) {
            // Debug: Menangani error
            dd($e->getMessage()); // Melihat error yang terjadi
        }
    }
    
    public function destroy($id_bengkel, $id_opname)
    {
        $opname = StockOpname::findOrFail($id_opname);
        $opname->delete();

        return redirect()->route('pos.management-stock.stock-opname', ['id_bengkel' => $id_bengkel])
            ->with('success', 'Stock Opname successfully deleted.');
    }
}
