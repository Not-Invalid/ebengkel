<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\KategoriBlog;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('kategori')->latest()->get();
        $kategoriBlogs = KategoriBlog::all();

        return view('blog.index', compact('blogs', 'kategoriBlogs'));
    }

    public function show($judul)
    {
        // Cari blog berdasarkan judul yang sudah diubah menjadi slug
        $blog = Blog::where('slug', $judul)->firstOrFail();  // Menggunakan 'slug' untuk mencari blog

        // Mengembalikan tampilan dengan data blog
        return view('blog.detail', compact('blog'));
    }



}
