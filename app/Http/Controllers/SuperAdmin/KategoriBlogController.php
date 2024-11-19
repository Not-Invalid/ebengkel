<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriBlog;

class KategoriBlogController extends Controller
{
    public function index()
    {
        $category = KategoriBlog::orderBy('id', 'ASC')->paginate(10);

        return view('superadmin.masterdata-category.blog.index', compact('category'));
    }

    public function create()
    {
        return view('superadmin.masterdata-category.blog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        KategoriBlog::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('blog-category')->with('status', 'Kategori Blog berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $category = KategoriBlog::findOrFail($id);

        return view('superadmin.masterdata-category.blog.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $category = KategoriBlog::findOrFail($id);

        $category->nama_kategori = $request->nama_kategori;
        $category->save();

        return redirect()->route('blog-category')->with('status', 'Kategori Blog berhasil diupdate.');
    }

    public function delete($id)
    {
        $category = KategoriBlog::findOrFail($id);
        $category->delete();

        return redirect()->route('blog-category')->with('status', 'Kategori Blog berhasil dihapus.');
    }
}
