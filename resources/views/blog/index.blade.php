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

        <!-- Hero Section (Carousel) -->
        <section class="hero-section mb-5">
            <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($blogs as $index => $blog)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card rounded-card">
                                            <img
                                                src="{{ $blog->foto_cover ? asset($blog->foto_cover) : asset('assets/images/components/image.png') }}"
                                                alt="{{ $blog->judul }}"
                                                class="img-fluid"
                                            />
                                            <div class="article-overlay">
                                                <span class="article-category">{{ $blog->kategori->nama_kategori }}</span>
                                                <h2 class="article-title text-white">{{ $blog->judul }}</h2>
                                                <div class="article-meta">
                                                    <span>{{ $blog->penulis ?: 'Anonymous' }}</span>
                                                    <span class="ms-3">{{ \Carbon\Carbon::parse($blog->tanggal_post)->format('M d, Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>


        <!-- Categories Section -->
        <div class="categories d-flex justify-content-center mb-4">
            <div id="categoryCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="category-list row justify-content-center">
                            <!-- Kategori All -->
                            <div class="col-6 col-md-auto mb-2 mt-2">
                                <a href="{{ route('blog') }}" class="text-decoration-none list-category-blog {{ !request('kategori') ? 'active' : '' }}">All</a>
                            </div>

                            <!-- Loop melalui kategori dan menambahkan active jika kategori yang dipilih sesuai -->
                            @foreach($kategoriBlogs as $kategori)
                                <div class="col-6 col-md-auto mb-2 mt-2">
                                    <a href="{{ route('blog', ['kategori' => $kategori->id]) }}" class="text-decoration-none list-category-blog {{ request('kategori') == $kategori->id ? 'active' : '' }}">
                                        {{ $kategori->nama_kategori }}
                                    </a>
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
                                <div class="meta d-flex justify-content-between">
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
        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($blogs->onFirstPage())
                        <li class="page-item">
                            <a class="page-link">Previous</a>
                        </li>
                    @else
                        <li class="page-item">
                            <a href="{{ $blogs->previousPageUrl() }}" class="page-link text-dark">Previous</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($blogs->getUrlRange(1, $blogs->lastPage()) as $page => $url)
                        @if ($page == $blogs->currentPage())
                            <li class="page-item active" aria-current="page">
                                <a class="page-link" href="{{ $url }}">{{ $page }} <span class="visually-hidden">(current)</span></a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($blogs->hasMorePages())
                        <li class="page-item">
                            <a href="{{ $blogs->nextPageUrl() }}" class="page-link">Next</a>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link">Next</a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
@endsection
