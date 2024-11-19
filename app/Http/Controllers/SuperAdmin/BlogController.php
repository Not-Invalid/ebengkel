<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\KategoriBlog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('kategori')->paginate(10);

        return view('superadmin.blog.index', compact('blogs'));
    }

    public function create()
    {
        $kategoriBlogs = KategoriBlog::all();

        return view('superadmin.blog.create', compact('kategoriBlogs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'konten' => 'required|string',
            'id_kategori' => 'required|exists:tb_kategori_blog,id',
        ]);

        $blog = new Blog();
        $blog->judul = $request->judul;
        $blog->penulis = $request->penulis;
        $blog->konten = $request->konten;
        $blog->id_kategori = $request->id_kategori;
        $blog->tanggal_post = now();
        $blog->save();

        return redirect()->route('blog-admin')->with('success', 'Blog berhasil ditambahkan.');
    }

}
