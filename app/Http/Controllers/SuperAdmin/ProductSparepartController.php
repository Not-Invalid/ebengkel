<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\KategoriSparePart;
use Illuminate\Http\Request;

class ProductSparepartController extends Controller
{
    public function showCategory()
    {
        $categories = KategoriSparePart::where('deleted_kategori_spare_part', 'N')->orderBy('id_kategori_spare_part', 'ASC')->paginate(10);

        return view('superadmin.masterdata-category.product-sparepart.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('superadmin.masterdata-category.product-sparepart.create');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'nama_kategori_spare_part' => 'required|string|max:255',
        ]);

        KategoriSparePart::create([
            'nama_kategori_spare_part' => $request->nama_kategori_spare_part,
            'created_date' => now(),
            'updated_date' => now(),
            'deleted_kategori_spare_part' => 'N',
        ]);

        return redirect()->route('product-sparepart-category')->with('success', 'Kategori Spare Part berhasil ditambahkan.');
    }

    public function editCategory($id)
    {
        $category = KategoriSparePart::findOrFail($id);

        return view('superadmin.masterdata-category.product-sparepart.edit', compact('category'));
    }

    public function updateCategory(Request $request, $id){
        $request->validate([
            'nama_kategori_spare_part' => 'required|string|max:255',
        ]);

        $category = KategoriSparePart::findOrFail($id);

        $category->nama_kategori_spare_part = $request->nama_kategori_spare_part;
        $category->updated_date = now();
        $category->save();

        return redirect()->route('product-sparepart-category')->with('success', 'Kategori Spare Part berhasil diupdate.');
    }

    public function deleteCategory($id)
    {
        $category = KategoriSparePart::findOrFail($id);
        $category->delete();

        return redirect()->route('product-sparepart-category')->with('success', 'Kategori Spare Part berhasil dihapus.');
    }
}
