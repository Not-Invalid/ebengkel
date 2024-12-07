<?php
namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\FotoProduk;
use App\Models\KategoriSparePart;
use App\Models\Product; // Import FotoProduk model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request, $id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found!');
        }

        if (!Auth::guard('pegawai')->check()) {
            return redirect()->route('pos.login');
        }

        $perPage = $request->get('per_page', 10);

        $products = Product::where('id_bengkel', $id_bengkel)
            ->where('delete_produk', 'N')
            ->with('kategoriProduk')
            ->paginate($perPage);

        $totalEntries = $products->total();
        $start = ($products->currentPage() - 1) * $perPage + 1;
        $end = min($products->currentPage() * $perPage, $totalEntries);

        return view('pos.masterdata-product.index', compact('bengkel', 'products', 'start', 'end', 'totalEntries'));
    }

    public function create($id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found!');
        }

        $categories = KategoriSparePart::all();
        return view('pos.masterdata-product.create', compact('bengkel', 'categories'));
    }

    public function store(Request $request, $id_bengkel)
    {
        $request->validate([
            'id_kategori_spare_part' => 'required|integer',
            'kualitas_produk' => 'nullable|string',
            'merk_produk' => 'nullable|string',
            'nama_produk' => 'required|string',
            'harga_produk' => 'required|integer',
            'keterangan_produk' => 'nullable|string',
            'stok_produk' => 'required|integer',
            'foto_produk_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_produk_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_produk_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_produk_4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_produk_5' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = new Product();
        $product->id_bengkel = $id_bengkel;
        $product->id_kategori_spare_part = $request->id_kategori_spare_part;
        $product->kualitas_produk = $request->kualitas_produk;
        $product->merk_produk = $request->merk_produk;
        $product->nama_produk = $request->nama_produk;
        $product->harga_produk = $request->harga_produk;
        $product->keterangan_produk = $request->keterangan_produk;
        $product->stok_produk = $request->stok_produk;
        $product->save();

        // Handle file uploads for product photos
        $fotoProduk = new FotoProduk();
        $fotoProduk->id_produk = $product->id_produk;

        // Check each photo input and upload if present
        for ($i = 1; $i <= 5; $i++) {
            $fotoKey = 'foto_produk_' . $i;
            if ($request->hasFile($fotoKey)) {
                $imageName = 'foto_produk_' . $product->id_produk . '_' . $i . '.' . $request->file($fotoKey)->extension();
                $request->file($fotoKey)->move(public_path('assets/images/products'), $imageName);
                $fotoProduk->{'file_foto_produk_' . $i} = 'assets/images/products/' . $imageName;
            }
        }

        $fotoProduk->create_file_foto_produk = now();
        $fotoProduk->save();

        return redirect()->route('pos.product.index', $id_bengkel)->with('status', 'Product successfully added!');
    }

    public function show($id_bengkel, $id_produk)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found!');
        }

        $product = Product::find($id_produk);
        $categories = KategoriSparePart::all();

        return view('pos.masterdata-product.show', compact('bengkel', 'product', 'categories'));
    }

    public function edit($id_bengkel, $id_produk)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Workshop not found!');
        }

        $product = Product::findOrFail($id_produk);
        $categories = KategoriSparePart::all();

        // Ambil data foto produk terkait
        $fotoProduk = FotoProduk::where('id_produk', $id_produk)->first();

        return view('pos.masterdata-product.edit', compact('bengkel', 'product', 'categories', 'fotoProduk'));
    }

    public function update(Request $request, $id_bengkel, $id_produk)
    {
        // Validate the input fields
        $request->validate([
            'id_kategori_spare_part' => 'required|integer',
            'kualitas_produk' => 'nullable|string',
            'merk_produk' => 'nullable|string',
            'nama_produk' => 'required|string',
            'harga_produk' => 'required|integer',
            'keterangan_produk' => 'nullable|string',
            'stok_produk' => 'required|integer',
            'foto_produk_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_produk_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_produk_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_produk_4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_produk_5' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the product to update
        $product = Product::findOrFail($id_produk);

        // Update the product details
        $product->id_kategori_spare_part = $request->id_kategori_spare_part;
        $product->kualitas_produk = $request->kualitas_produk;
        $product->merk_produk = $request->merk_produk;
        $product->nama_produk = $request->nama_produk;
        $product->harga_produk = $request->harga_produk;
        $product->keterangan_produk = $request->keterangan_produk;
        $product->stok_produk = $request->stok_produk;
        $product->save();

        // Find or create FotoProduk instance
        $fotoProduk = FotoProduk::where('id_produk', $id_produk)->first();

        if (!$fotoProduk) {
            // If no FotoProduk exists, create a new one
            $fotoProduk = new FotoProduk();
            $fotoProduk->id_produk = $id_produk;
        }

        // Handle the image file uploads
        for ($i = 1; $i <= 5; $i++) {
            $fotoKey = 'foto_produk_' . $i;

            if ($request->hasFile($fotoKey)) {
                // Delete the old image file if it exists
                if ($fotoProduk->{'file_foto_produk_' . $i} && file_exists(public_path($fotoProduk->{'file_foto_produk_' . $i}))) {
                    unlink(public_path($fotoProduk->{'file_foto_produk_' . $i}));
                }

                // Upload the new image
                $imageName = 'foto_produk_' . $id_produk . '_' . $i . '.' . $request->file($fotoKey)->extension();
                $request->file($fotoKey)->move(public_path('assets/images/products'), $imageName);
                $fotoProduk->{'file_foto_produk_' . $i} = 'assets/images/products/' . $imageName;
            }
        }

        // Update or create file_foto_produk record
        $fotoProduk->create_file_foto_produk = now();
        $fotoProduk->save();

        // Redirect back with success message
        return redirect()->route('pos.product.index', ['id_bengkel' => $id_bengkel])->with('status', 'Product successfully updated!');
    }

    public function destroy($id_bengkel, $id_produk)
    {
        $product = Product::findOrFail($id_produk);

        // Delete photos from storage
        $fotoProduk = FotoProduk::where('id_produk', $id_produk)->first();
        if ($fotoProduk) {
            for ($i = 1; $i <= 5; $i++) {
                if ($fotoProduk->{'file_foto_produk_' . $i} && file_exists(public_path($fotoProduk->{'file_foto_produk_' . $i}))) {
                    unlink(public_path($fotoProduk->{'file_foto_produk_' . $i}));
                }
            }
            $fotoProduk->delete();
        }

        $product->delete();
        return redirect()->route('pos.product.index', $id_bengkel)->with('status', 'Product Successfully deleted!');
    }
}
