<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\Cart;
use App\Models\KategoriSparePart;
use App\Models\Product;
use App\Models\SpareParts;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductSparePartController extends Controller
{

    public function index(Request $request)
    {
        $querySparepart = SpareParts::where('delete_spare_part', 'N')->with('bengkel');
        $queryProduct = Product::where('delete_produk', 'N')->with('bengkel');
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $querySparepart->where('nama_spare_part', 'LIKE', '%' . $search . '%');
            $queryProduct->where('nama_produk', 'LIKE', '%' . $search . '%');
        }
    
        $sparepart = $querySparepart->get();
        $product = $queryProduct->get();
    
        return view('ProductSparepart.index', compact('sparepart', 'product'));
    }
    
    public function detail($type, $id)
    {
        if ($type == 'product') {
            $data = Product::where('id_produk', $id)->first();
        } elseif ($type == 'sparepart') {
            $data = SpareParts::where('id_spare_part', $id)->first();
        } else {
            abort(404);
        }

        $data->load('bengkel');

        return view('ProductSparepart.detail-ProductSparePart', compact('data'));
    }

    public function createSparepart()
    {
        if (!Session::has('id_pelanggan')) {
            return redirect()->route('home')->with('error_status', 'You must be logged in.');
        }

        $id_pelanggan = Session::get('id_pelanggan');
        $bengkel = Bengkel::where('id_pelanggan', $id_pelanggan)->first();

        if (!$bengkel) {
            return redirect()->route('home')->with('error_status', 'No associated workshop found.');
        }

        $id_bengkel = $bengkel->id_bengkel;

        $kategoriSparePart = KategoriSparePart::all();
        return view('profile.workshop.workshopSET.Sparepart.create', compact('kategoriSparePart', 'id_bengkel', 'bengkel'));
    }
    public function saveSparePart(Request $request)
    {
        $request->validate([
            'id_bengkel' => 'nullable|integer',
            'id_kategori_spare_part' => 'nullable|integer',
            'kualitas_spare_part' => 'nullable|string',
            'merk_spare_part' => 'nullable|string',
            'nama_spare_part' => 'nullable|string',
            'harga_spare_part' => 'nullable|integer',
            'keterangan_spare_part' => 'nullable|string',
            'stok_spare_part' => 'nullable|integer',
            'foto_spare_part' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $sparePart = new SpareParts();
        $sparePart->id_bengkel = $request->id_bengkel;
        $sparePart->id_kategori_spare_part = $request->id_kategori_spare_part;
        $sparePart->kualitas_spare_part = $request->kualitas_spare_part;
        $sparePart->merk_spare_part = $request->merk_spare_part;
        $sparePart->nama_spare_part = $request->nama_spare_part;
        $sparePart->harga_spare_part = $request->harga_spare_part;
        $sparePart->keterangan_spare_part = $request->keterangan_spare_part;
        $sparePart->stok_spare_part = $request->stok_spare_part;

        if ($request->hasFile('foto_spare_part')) {
            $imageName = 'foto_spare_part_' . now()->format('Ymd_His') . '.' . $request->foto_spare_part->extension();
            $request->foto_spare_part->move(public_path('assets/images/spareparts'), $imageName);
            $sparePart->foto_spare_part = 'assets/images/spareparts/' . $imageName;
        }

        $sparePart->save();

        return redirect()->route('profile.workshop.detail', ['id_bengkel' => $sparePart->id_bengkel])
            ->with('status', 'Spare part berhasil ditambahkan.');
    }
    public function editSparepart($id_spare_part)
    {
        if (!Session::has('id_pelanggan')) {
            return redirect()->route('home')->with('error_status', 'You must be logged in .');
        }

        $id_pelanggan = Session::get('id_pelanggan');
        $bengkel = Bengkel::where('id_pelanggan', $id_pelanggan)->first();
        $sparePart = SpareParts::findOrFail($id_spare_part);

        $kategoriSparePart = KategoriSparePart::all();
        return view('profile.workshop.workshopSET.Sparepart.edit', compact('sparePart', 'kategoriSparePart', 'bengkel'));
    }

    public function updateSparepart(Request $request, $id)
    {
        $request->validate([
            'id_kategori_spare_part' => 'nullable|integer',
            'kualitas_spare_part' => 'nullable|string',
            'merk_spare_part' => 'nullable|string',
            'nama_spare_part' => 'nullable|string',
            'harga_spare_part' => 'nullable|integer',
            'keterangan_spare_part' => 'nullable|string',
            'stok_spare_part' => 'nullable|integer',
            'foto_spare_part' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $sparePart = SpareParts::findOrFail($id);
        $sparePart->id_kategori_spare_part = $request->id_kategori_spare_part;
        $sparePart->kualitas_spare_part = $request->kualitas_spare_part;
        $sparePart->merk_spare_part = $request->merk_spare_part;
        $sparePart->nama_spare_part = $request->nama_spare_part;
        $sparePart->harga_spare_part = $request->harga_spare_part;
        $sparePart->keterangan_spare_part = $request->keterangan_spare_part;
        $sparePart->stok_spare_part = $request->stok_spare_part;

        if ($request->hasFile('foto_spare_part')) {
            $imageName = 'foto_spare_part_' . now()->format('Ymd_His') . '.' . $request->foto_spare_part->extension();
            $request->foto_spare_part->move(public_path('assets/images/spareparts'), $imageName);
            $sparePart->foto_spare_part = 'assets/images/spareparts/' . $imageName;
        }

        $sparePart->save();

        return redirect()->route('profile.workshop.detail', ['id_bengkel' => $sparePart->id_bengkel])
            ->with('status', 'Spare part berhasil diupdate.');
    }
    public function delete($id_spare_part)
    {
        $sparePart = DB::table('tb_spare_part')->where('id_spare_part', $id_spare_part)->first();

        if ($sparePart) {
            DB::table('tb_spare_part')->where('id_spare_part', $id_spare_part)->update([
                'delete_spare_part' => 'Y',
            ]);
            return back()->with('status', 'Spare part deleted successfully.');
        } else {
            return back()->with('error_status', 'Address not found.');
        }
    }

    public function createProduct()
    {
        if (!Session::has('id_pelanggan')) {
            return redirect()->route('home')->with('error_status', 'You must be logged in to add a service.');
        }

        $id_pelanggan = Session::get('id_pelanggan');
        $bengkel = Bengkel::where('id_pelanggan', $id_pelanggan)->first();

        if (!$bengkel) {
            return redirect()->route('home')->with('error_status', 'No associated workshop found.');
        }

        $id_bengkel = $bengkel->id_bengkel;

        $kategoriSparePart = KategoriSparePart::all();
        return view('profile.workshop.workshopSET.products.create', compact('kategoriSparePart', 'id_bengkel', 'bengkel'));
    }

    public function saveProduct(Request $request)
    {
        $request->validate([
            'id_bengkel' => 'nullable|integer',
            'id_kategori_spare_part' => 'nullable|integer',
            'kualitas_produk' => 'nullable|string',
            'merk_produk' => 'nullable|string',
            'nama_produk' => 'nullable|string',
            'harga_produk' => 'nullable|integer',
            'keterangan_produk' => 'nullable|string',
            'stok_produk' => 'nullable|integer',
            'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $Produk = new Product();
        $Produk->id_bengkel = $request->id_bengkel;
        $Produk->id_kategori_spare_part = $request->id_kategori_spare_part;
        $Produk->kualitas_produk = $request->kualitas_produk;
        $Produk->merk_produk = $request->merk_produk;
        $Produk->nama_produk = $request->nama_produk;
        $Produk->harga_produk = $request->harga_produk;
        $Produk->keterangan_produk = $request->keterangan_produk;
        $Produk->stok_produk = $request->stok_produk;

        if ($request->hasFile('foto_produk')) {
            $imageName = 'foto_produk_' . now()->format('Ymd_His') . '.' . $request->foto_produk->extension();
            $request->foto_produk->move(public_path('assets/images/product'), $imageName);
            $Produk->foto_produk = 'assets/images/product/' . $imageName;
        }

        $Produk->save();

        return redirect()->route('profile.workshop.detail', ['id_bengkel' => $Produk->id_bengkel])
            ->with('status', 'Produk berhasil ditambahkan.');
    }
    public function editProduct($id_product)
    {
        if (!Session::has('id_pelanggan')) {
            return redirect()->route('home')->with('error_status', 'You must be logged in .');
        }

        $id_pelanggan = Session::get('id_pelanggan');
        $bengkel = Bengkel::where('id_pelanggan', $id_pelanggan)->first();

        $product = Product::findOrFail($id_product);
        $kategoriSparePart = KategoriSparePart::all();
        return view('profile.workshop.workshopSET.products.edit', compact('product', 'kategoriSparePart', 'bengkel'));
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'id_kategori_spare_part' => 'nullable|integer',
            'kualitas_produk' => 'nullable|string',
            'merk_produk' => 'nullable|string',
            'nama_produk' => 'nullable|string',
            'harga_produk' => 'nullable|integer',
            'keterangan_produk' => 'nullable|string',
            'stok_produk' => 'nullable|integer',
            'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->id_kategori_spare_part = $request->id_kategori_spare_part;
        $product->kualitas_produk = $request->kualitas_produk;
        $product->merk_produk = $request->merk_produk;
        $product->nama_produk = $request->nama_produk;
        $product->harga_produk = $request->harga_produk;
        $product->keterangan_produk = $request->keterangan_produk;
        $product->stok_produk = $request->stok_produk;

        if ($request->hasFile('foto_produk')) {
            $imageName = 'foto_produk_' . now()->format('Ymd_His') . '.' . $request->foto_produk->extension();
            $request->foto_produk->move(public_path('assets/images/spareparts'), $imageName);
            $product->foto_produk = 'assets/images/spareparts/' . $imageName;
        }

        $product->save();

        return redirect()->route('profile.workshop.detail', ['id_bengkel' => $product->id_bengkel])
            ->with('status', 'Product berhasil diupdate.');
    }
    public function deleteProduct($id_produk)
    {
        $produk = DB::table('tb_produk')->where('id_produk', $id_produk)->first();

        if ($produk) {
            DB::table('tb_produk')->where('id_produk', $id_produk)->update([
                'delete_produk' => 'Y',
            ]);
            return back()->with('status', 'Product deleted successfully.');
        } else {
            return back()->with('error_status', 'Address not found.');
        }
    }


    public function addToCart(Request $request)
    {
        Log::info('Add to cart request data:', $request->all());
        
        try {
            // Get the inputs from the request
            $productId = $request->input('id_produk');
            $quantity = $request->input('quantity');
            $userId = Session::get('id_pelanggan');
            
            // Log the received data
            Log::info("Product ID: $productId, Quantity: $quantity, User ID: $userId");
    
            // Validate the inputs
            if (empty($productId) || empty($quantity) || $quantity <= 0) {
                Log::error("Invalid input: Product ID or quantity is missing or invalid");
                return response()->json(['success' => false, 'message' => 'Invalid input. Please provide a valid product and quantity.']);
            }
    
            // Find the product by ID
            $product = Product::find($productId);
    
            // Check if the product exists
            if (!$product) {
                Log::error("Product not found: ID $productId");
                return response()->json(['success' => false, 'message' => 'Product not found.']);
            }
    
            // Check if the quantity is available
            if ($quantity > $product->stok_produk) {
                Log::error("Not enough stock for product: ID $productId");
                return response()->json(['success' => false, 'message' => 'Not enough stock available.']);
            }
    
            // Calculate the total price
            $totalPrice = $product->harga_produk * $quantity;
    
            // Log the calculated total price for debugging
            Log::info("Calculated total price: Rp " . number_format($totalPrice, 0, ',', '.'));
    
            // Check if totalPrice is calculated correctly
            if ($totalPrice <= 0) {
                Log::error("Calculated total price is not valid: " . $totalPrice);
                return response()->json(['success' => false, 'message' => 'Failed to calculate total price.']);
            }
    
            // Add the product to the cart
            $cart = Cart::create([
                'id_pelanggan' => $userId,
                'id_produk' => $productId,
                'quantity' => $quantity,
                'total_price' => $totalPrice, // Ensure total_price is passed correctly
            ]);
    
            // Log the cart creation
            Log::info("Product added to cart: Cart ID {$cart->id}, User ID $userId");
    
            // Return success response
            return response()->json(['success' => true, 'message' => 'Product added to cart!']);
        } catch (\Exception $e) {
            // Log any errors
            Log::error("Error adding to cart: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred. Please try again.']);
        }
    }
    
    
    
}
