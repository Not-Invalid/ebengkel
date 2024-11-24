@extends('pos.layouts.app')
@section('title')
    Ebengkelku | Master POS
@stop
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/POS/transaksi_pos.css') }}">
@endpush
@php
    $header = 'Master POS';
@endphp
@section('content')
    <div class="container-fluid py-4">
        <div class="search-container">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Scan atau Cari ...">
                <button class="btn btn-info text-white mx-3"><i class="fa-solid fa-print"></i></button>
            </div>
        </div>
        <div class="main-layout">
            <div class="row">
                <div class="col-8">
                    <!-- Product Section -->
                    <div class="main-container">
                        <h4 class="mb-3 judul">List Produk</h4>
                        <div class="products-grid shadow p-4">
                            <div class="row">
                                <!-- Product Cards -->
                                <div class="col-md-4">
                                    <div class="product-card">
                                        <div class="product-code">
                                            KH0001SH
                                            <span class="product-stock">Stock: -5</span>
                                        </div>
                                        <div class="product-title">Sahira dress</div>
                                        <div class="product-price">Price: 189,000</div>
                                        <div class="product-category">Dress</div>
                                        <a class="add-button">
                                            <i class="fa-solid fa-bag-shopping"></i> TAMBAHKAN
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="product-card">
                                        <div class="product-code">
                                            KH0002SH
                                            <span class="product-stock">Stock: 10</span>
                                        </div>
                                        <div class="product-title">Ayla top</div>
                                        <div class="product-price">Price: 120,000</div>
                                        <div class="product-category">Blouse</div>
                                        <a class="add-button">
                                            <i class="fa-solid fa-bag-shopping"></i> TAMBAHKAN
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="product-card">
                                        <div class="product-code">
                                            KH0003SH
                                            <span class="product-stock">Stock: 5</span>
                                        </div>
                                        <div class="product-title">Luna Pants</div>
                                        <div class="product-price">Price: 150,000</div>
                                        <div class="product-category">Pants</div>
                                        <a class="add-button">
                                            <i class="fa-solid fa-bag-shopping"></i> TAMBAHKAN
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="product-card">
                                        <div class="product-code">
                                            KH0003SH
                                            <span class="product-stock">Stock: 5</span>
                                        </div>
                                        <div class="product-title">Luna Pants</div>
                                        <div class="product-price">Price: 150,000</div>
                                        <div class="product-category">Pants</div>
                                        <a class="add-button">
                                            <i class="fa-solid fa-bag-shopping"></i> TAMBAHKAN
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="product-card">
                                        <div class="product-code">
                                            KH0003SH
                                            <span class="product-stock">Stock: 5</span>
                                        </div>
                                        <div class="product-title">Luna Pants</div>
                                        <div class="product-price">Price: 150,000</div>
                                        <div class="product-category">Pants</div>
                                        <a class="add-button">
                                            <i class="fa-solid fa-bag-shopping"></i> TAMBAHKAN
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="product-card">
                                        <div class="product-code">
                                            KH0003SH
                                            <span class="product-stock">Stock: 5</span>
                                        </div>
                                        <div class="product-title">Luna Pants</div>
                                        <div class="product-price">Price: 150,000</div>
                                        <div class="product-category">Pants</div>
                                        <a class="add-button">
                                            <i class="fa-solid fa-bag-shopping"></i> TAMBAHKAN
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="product-card">
                                        <div class="product-code">
                                            KH0003SH
                                            <span class="product-stock">Stock: 5</span>
                                        </div>
                                        <div class="product-title">Luna Pants</div>
                                        <div class="product-price">Price: 150,000</div>
                                        <div class="product-category">Pants</div>
                                        <a class="add-button">
                                            <i class="fa-solid fa-bag-shopping"></i> TAMBAHKAN
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="product-card">
                                        <div class="product-code">
                                            KH0003SH
                                            <span class="product-stock">Stock: 5</span>
                                        </div>
                                        <div class="product-title">Luna Pants</div>
                                        <div class="product-price">Price: 150,000</div>
                                        <div class="product-category">Pants</div>
                                        <a class="add-button">
                                            <i class="fa-solid fa-bag-shopping"></i> TAMBAHKAN
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="product-card">
                                        <div class="product-code">
                                            KH0003SH
                                            <span class="product-stock">Stock: 5</span>
                                        </div>
                                        <div class="product-title">Luna Pants</div>
                                        <div class="product-price">Price: 150,000</div>
                                        <div class="product-category">Pants</div>
                                        <a class="add-button">
                                            <i class="fa-solid fa-bag-shopping"></i> TAMBAHKAN
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="product-card">
                                        <div class="product-code">
                                            KH0003SH
                                            <span class="product-stock">Stock: 5</span>
                                        </div>
                                        <div class="product-title">Luna Pants</div>
                                        <div class="product-price">Price: 150,000</div>
                                        <div class="product-category">Pants</div>
                                        <a class="add-button">
                                            <i class="fa-solid fa-bag-shopping"></i> TAMBAHKAN
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <!-- Active Order Section -->
                    <div class="cart-container shadow mt-5">
                        <h5 class="order">Active Order</h5>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <span>Total:</span>
                            <span>0 Pcs</span>
                            <span>0</span>
                        </div>
                        <div class="d-flex mt-3">
                            <button class="trash-btn">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            <button class="checkout-btn">
                                <i class="fa-solid fa-cart-shopping"></i> CHECKOUT
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
