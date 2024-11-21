<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\KategoriBlog;

class BlogController extends Controller
{
    public function index(Request $request)
    {

        $kategoriId = $request->input('kategori');

        if ($kategoriId) {
            $blogs = Blog::with('kategori')
                ->where('id_kategori', $kategoriId)
                ->latest()
                ->paginate(10);
        } else {

            $blogs = Blog::with('kategori')->latest()->paginate(10);
        }

        $kategoriBlogs = KategoriBlog::all();

        return view('blog.index', compact('blogs', 'kategoriBlogs'));
    }

    public function show($judul)
    {

        $blog = Blog::where('slug', $judul)->firstOrFail();

        return view('blog.detail', compact('blog'));
    }
}
