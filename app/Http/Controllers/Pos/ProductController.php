<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Bengkel;
use App\Models\KategoriSparePart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
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

        $products = Product::where('id_bengkel', $id_bengkel)
            ->where('delete_produk', 'N')
            ->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('nama_produk', 'like', "%$search%");
                }
            })
            ->with('kategoriProduk')
            ->paginate(10);

        return view('pos.masterdata-product.index', compact('bengkel', 'products'));
    }

    public function create($id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Bengkel tidak ditemukan.');
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
            'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

        if ($request->hasFile('foto_produk')) {
            $imageName = 'foto_produk_' . now()->format('Ymd_His') . '.' . $request->foto_produk->extension();
            $request->foto_produk->move(public_path('assets/images/products'), $imageName);
            $product->foto_produk = 'assets/images/products/' . $imageName;
        }

        $product->save();

        return redirect()->route('pos.product.index', $id_bengkel)->with('status', 'Produk berhasil ditambahkan.');
    }

    public function edit($id_bengkel, $id_produk)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('error_status', 'Bengkel tidak ditemukan.');
        }

        $product = Product::findOrFail($id_produk);
        $categories = KategoriSparePart::all();
        return view('pos.masterdata-product.edit', compact('bengkel', 'product', 'categories'));
    }

    public function update(Request $request, $id_bengkel, $id_produk)
    {
        $request->validate([
            'id_kategori_spare_part' => 'required|integer',
            'kualitas_produk' => 'nullable|string',
            'merk_produk' => 'nullable|string',
            'nama_produk' => 'required|string',
            'harga_produk' => 'required|integer',
            'keterangan_produk' => 'nullable|string',
            'stok_produk' => 'required|integer',
            'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id_produk);
        $product->id_kategori_spare_part = $request->id_kategori_spare_part;
        $product->kualitas_produk = $request->kualitas_produk;
        $product->merk_produk = $request->merk_produk;
        $product->nama_produk = $request->nama_produk;
        $product->harga_produk = $request->harga_produk;
        $product->keterangan_produk = $request->keterangan_produk;
        $product->stok_produk = $request->stok_produk;

        if ($request->hasFile('foto_produk')) {
            $imageName = 'foto_produk_' . now()->format('Ymd_His') . '.' . $request->foto_produk->extension();
            $request->foto_produk->move(public_path('assets/images/products'), $imageName);
            $product->foto_produk = 'assets/images/products/' . $imageName;
        }

        $product->save();

        return redirect()->route('pos.product.index', ['id_bengkel' => $id_bengkel])->with('status', 'Produk berhasil diperbarui.');
    }

    public function destroy($id_bengkel, $id_produk)
    {
        $product = Product::findOrFail($id_produk);

        if ($product) {
            $product->delete_produk = 'Y';
            $product->save();
            return redirect()->route('pos.product.index', $id_bengkel)->with('status', 'Produk berhasil dihapus.');
        }

        return back()->with('error_status', 'Produk tidak ditemukan.');
    }

}
