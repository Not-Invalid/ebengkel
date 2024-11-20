@extends('layouts.app')

@section('title')
    eBengkelku | Blog
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}" />
@endpush

@section('content')
    <div class="container py-5">
        <header class="py-5">
            <h1 class="text-center">Blog</h1>
            <p class="text-center text-muted">
                Exploring tech, design, and creative ideas
            </p>
        </header>

        <!-- Hero Section (Optional, you can remove if not needed) -->
        <section class="hero-section mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card rounded-card">
                            <img
                                src="https://www.specialoffers.jcb/id/tips/japan/shutterstock_10.jpg"
                                alt="Article image"
                                class="img-fluid"
                            />
                            <div class="article-overlay">
                                <span class="article-category">Food</span>
                                <h2 class="article-title text-white">Penjelasan Lengkap Tentang Sushi dan Sashimi yang Wajib Dicoba di Jepang!</h2>
                                <div class="article-meta">
                                    <span>Bening Mata Author</span>
                                    <span class="ms-3">Oktober 12, 2024</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Categories Section (Optional) -->
        <div class="categories d-flex justify-content-center mb-4">
            <div id="categoryCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="category-list row justify-content-center">
                            <div class="col-6 col-md-auto mb-2 mt-2">
                                <span class="category-blog active">All</span>
                            </div>
                            @foreach($kategoriBlogs as $kategori)
                                <div class="col-6 col-md-auto mb-2 mt-2">
                                    <span class="category-blog">{{ $kategori->nama_kategori }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="articles">
            @foreach($blogs as $blog)
                <article class="shadow">
                    <a href="{{ route('blog.show', $blog->slug) }}">
                        <div class="article-wrapper">
                            <figure>
                                <img
                                    src="{{ $blog->foto_cover ? asset($blog->foto_cover) : asset('assets/images/components/image.png') }}"
                                    alt="{{ $blog->judul }}"
                                />
                            </figure>
                            <div class="article-body">
                                <span class="category-blog">{{ $blog->kategori->nama_kategori }}</span>
                                <h2>{{ $blog->judul }}</h2>
                                <div class="meta">
                                    <span>{{ $blog->penulis ?: 'Anonymous' }}</span>
                                    <span>{{ \Carbon\Carbon::parse($blog->tanggal_post)->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>
            @endforeach
        </section>


        <!-- Pagination Section -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center mt-5">
                <li class="disabled">
                    <a href="#" tabindex="-1">Sebelumnya</a>
                </li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li class="ellipsis">...</li>
                <li><a href="#">10</a></li>
                <li><a href="#">Next</a></li>
            </ul>
        </nav>
    </div>
@endsection
