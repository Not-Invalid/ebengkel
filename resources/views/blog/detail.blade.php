@extends('layouts.app')

@section('title')
    eBengkelku | Blog Detail
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/detail_blog.css') }}" />
@endpush

@section('content')
    <div class="container mt-5 pt-5">
        <nav aria-label="breadcrumb" class="py-2">
            <ol class="breadcrumb-custom">
                <li class="breadcrumb-item">
                    <a href="{{ route('blog') }}">
                        <i class="bx bx-chevron-left" style="font-size: 30px; color: black;"></i>
                    </a>
                </li>
            </ol>
        </nav>
    </div>

    <div class="container">
        <h1 class="judul-1">{{ $blog->judul }}</h1>

        <div class="article-meta d-flex flex-column flex-md-row justify-content-between align-items-start">
            <div class="author-date">
                <span class="author">{{ $blog->penulis ?? 'Anonymous' }}</span>
                <span class="mx-3">{{ \Carbon\Carbon::parse($blog->tanggal_post)->format('F j, Y') }}</span>
            </div>
            <div class="social-share mt-2">
                <!-- Social media icons using BoxIcons -->
                <a href="#" class="icon-link"><i class="bx bx-link-alt" style="font-size: 24px;"></i></a>
                <a href="#" class="icon-link"><i class="bx bxl-instagram" style="font-size: 24px;"></i></a>
                <a href="#" class="icon-link"><i class="bx bxl-twitter" style="font-size: 24px;"></i></a>
                <a href="#" class="icon-link"><i class="bx bxl-facebook" style="font-size: 24px;"></i></a>
            </div>
        </div>
    </div>

    <div class="container-xl">
        <img src="{{ $blog->foto_cover ? asset($blog->foto_cover) : asset('assets/images/components/image.png') }}"
            class="article-image mt-3" />
        <div class="content">{!! $blog->konten !!}</div>
    </div>

    <div class="container mt-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-3">
            <div>
                <span class="share mx-2">Share this post</span>
                <div class="social-share mt-2 d-flex">
                    <!-- Social media icons again with BoxIcons -->
                    <a href="#" class="icon-link"><i class="bx bx-link-alt" style="font-size: 24px;"></i></a>
                    <a href="#" class="icon-link"><i class="bx bxl-instagram" style="font-size: 24px;"></i></a>
                    <a href="#" class="icon-link"><i class="bx bxl-twitter" style="font-size: 24px;"></i></a>
                    <a href="#" class="icon-link"><i class="bx bxl-facebook" style="font-size: 24px;"></i></a>
                </div>
            </div>
        </div>
        <!-- Separator -->
        <div class="separator"></div>
        <div class="author-info d-flex">
            <div class="author mx-2">{{ $blog->penulis ?? 'Anonymous' }}</div>
            <div class="mx-3">{{ \Carbon\Carbon::parse($blog->tanggal_post)->format('F j, Y') }}</div>
        </div>
    </div>

    <div class="container">
        <!-- Related Articles Section -->
        <div class="d-flex justify-content-between align-items-center mt-5">
            <h3 class="related-articles-title">Artikel Lain Buatmu</h3>
            <span class="all">See All</span>
        </div>
        <section class="articles">
            <article class="shadow">
                <a href="{{ route('blog.show', 1) }}">
                    <div class="article-wrapper">
                        <figure>
                            <img src="https://www.specialoffers.jcb/id/tips/japan/shutterstock_10.jpg"
                                alt="Sushi and sashimi" />
                        </figure>
                        <div class="article-body">
                            <span class="category-blog">Food</span>
                            <h2>Penjelasan Lengkap Tentang Sushi dan Sashimi yang Wajib Dicoba di Jepang!</h2>
                            <div class="meta">
                                <span>Bening Mata Author</span>
                                <span>Oktober 12, 2024</span>
                            </div>
                        </div>
                    </div>
                </a>
            </article>

            <article class="shadow">
                <a href="{{ route('blog.show', 2) }}">
                    <div class="article-wrapper">
                        <figure>
                            <img src="https://www.agoda.com/wp-content/uploads/2024/07/dubai-uae-featured-1244x700.jpg"
                                alt="Guide" />
                        </figure>
                        <div class="article-body">
                            <span class="category-blog">Hotel</span>
                            <h2>Panduan Lengkap untuk Memulai</h2>
                            <div class="meta">
                                <span>Bening Mata Author</span>
                                <span>Oktober 12, 2024</span>
                            </div>
                        </div>
                    </div>
                </a>
            </article>
            <!-- Add more related articles if needed -->
        </section>
    </div>

    </div>
@endsection
