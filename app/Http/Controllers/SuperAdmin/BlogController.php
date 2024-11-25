<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\KategoriBlog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'foto_cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'konten' => 'required|string',
            'id_kategori' => 'required|exists:tb_kategori_blog,id',
        ]);

        $slug = Str::slug($request->judul, '-');

        $coverPath = null;

        if ($request->hasFile('foto_cover')) {
            $coverImage = $request->file('foto_cover');
            $coverImageName = 'cover_blog_' . uniqid() . '.webp';
            $img = imagecreatefromstring(file_get_contents($coverImage));

            if ($img && imageistruecolor($img) === false) {
                imagepalettetotruecolor($img);
            }

            if ($img) {
                $destinationPath = public_path('assets/images/blog/' . $coverImageName);
                imagewebp($img, $destinationPath, 90);
                imagedestroy($img);
                $coverPath = 'assets/images/blog/' . $coverImageName;
            }
        }

        $blog = new Blog();
        $blog->judul = $request->judul;
        $blog->slug = $slug;
        $blog->penulis = $request->penulis;
        $blog->konten = $request->konten;
        $blog->id_kategori = $request->id_kategori;
        $blog->foto_cover = $coverPath;
        $blog->tanggal_post = now();
        $blog->save();

        return redirect()->route('blog-admin')->with('status', 'Blog has been successfully created.');
    }

    public function edit($id)
    {

        $blog = Blog::findOrFail($id);

        $kategoriBlogs = KategoriBlog::all();

        return view('superadmin.blog.edit', compact('blog', 'kategoriBlogs'));
    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'foto_cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'konten' => 'required|string',
            'id_kategori' => 'required|exists:tb_kategori_blog,id',
        ]);

        $blog = Blog::findOrFail($id);

        $coverPath = $blog->foto_cover;

        if ($request->hasFile('foto_cover')) {

            if ($blog->foto_cover && file_exists(public_path($blog->foto_cover))) {
                unlink(public_path($blog->foto_cover));
            }

            $coverImage = $request->file('foto_cover');
            $coverImageName = 'cover_blog_' . uniqid() . '.webp';

            $img = imagecreatefromstring(file_get_contents($coverImage));

            if ($img && imageistruecolor($img) === false) {
                imagepalettetotruecolor($img);
            }

            if ($img) {

                $destinationPath = public_path('assets/images/blog/' . $coverImageName);

                imagewebp($img, $destinationPath, 90);

                imagedestroy($img);

                $coverPath = 'assets/images/blog/' . $coverImageName;
            }
        }

        $blog->judul = $request->judul;
        $blog->penulis = $request->penulis;
        $blog->konten = $request->konten;
        $blog->id_kategori = $request->id_kategori;
        $blog->foto_cover = $coverPath;
        $blog->save();

        return redirect()->route('blog-admin')->with('status', 'Blog has been successfully updated.');
    }

    public function delete($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->foto_cover && file_exists(public_path($blog->foto_cover))) {
            unlink(public_path($blog->foto_cover));
        }

        $blog->delete();

        return redirect()->route('blog-admin')->with('status', 'Blog has been successfully deleted.');
    }


}
