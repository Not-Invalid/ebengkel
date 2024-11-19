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

        <!-- Hero Section -->
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

        <!-- Categories Section -->
        <div class="categories d-flex justify-content-center mb-4">
            <div id="categoryCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="category-list row justify-content-center">
                            <div class="col-6 col-md-auto mb-2 mt-2">
                                <span class="category-blog active">All</span>
                            </div>
                            <div class="col-6 col-md-auto mb-2 mt-2">
                                <span class="category-blog">Tour</span>
                            </div>
                            <div class="col-6 col-md-auto mb-2 mt-2">
                                <span class="category-blog">Travel</span>
                            </div>
                            <div class="col-6 col-md-auto mb-2 mt-2">
                                <span class="category-blog">Adventure</span>
                            </div>
                            <div class="col-6 col-md-auto mb-2 mt-2">
                                <span class="category-blog">Food</span>
                            </div>
                            <div class="col-6 col-md-auto mb-2 mt-2">
                                <span class="category-blog">Hotel</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Navigasi Carousel dengan ukuran yang lebih kecil -->
                <button class="carousel-control-prev btn-sm" type="button" data-bs-target="#categoryCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next btn-sm" type="button" data-bs-target="#categoryCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>



        <div class="col-lg-auto mb-2 mt-2">
            <div class="search-box d-flex align-items-center w-100 w-md-25 mb-4">
                <span class="search-icon">
                    <span class="iconify" data-icon="mdi-magnify" data-inline="false"></span>
                </span>
                <input type="text" class="form-control" placeholder="Cari disini" />
            </div>
        </div>

        <!-- Articles Section -->
        <section class="articles">
            <article class="shadow">
                <a href="../blog/detail_blog.html">
                    <div class="article-wrapper">
                        <figure>
                            <img
                                src="https://www.specialoffers.jcb/id/tips/japan/shutterstock_10.jpg"
                                alt="Sushi and sashimi"
                            />
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
                <a href="#">
                    <div class="article-wrapper">
                        <figure>
                            <img src="https://www.agoda.com/wp-content/uploads/2024/07/dubai-uae-featured-1244x700.jpg" alt="Guide" />
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

            <article class="shadow">
                <a href="#">
                    <div class="article-wrapper">
                        <figure>
                            <img src="https://www.agoda.com/wp-content/uploads/2023/09/Visit-Korea-like-a-local-Cook-3-Authentic-Korean-Dishes.jpg" alt="Guide" />
                        </figure>
                        <div class="article-body">
                            <span class="category-blog">Food</span>
                            <h2>Wisata Kuliner Dunia: Destinasi Rasa yang Harus Dicoba</h2>
                            <div class="meta">
                                <span>Bening Mata Author</span>
                                <span>Oktober 12, 2024</span>
                            </div>
                        </div>
                    </div>
                </a>
            </article>

            <!-- More articles... -->

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
