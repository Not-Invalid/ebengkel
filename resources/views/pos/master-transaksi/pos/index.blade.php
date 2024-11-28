@extends('pos.layouts.app')
@section('title')
    eBengkelku | Master POS
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
                <div class="col-12 col-md-8">
                    <!-- Product Section -->
                    <div class="main-container">
                        <h4 class="mb-3 judul">List Produk</h4>
                        <div class="products-grid shadow p-4">
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                                @foreach ($products as $product)
                                    <div class="col-12 col-md-6">
                                        <div class="product-card shadow">
                                            <div class="custom-card shadow position-relative">
                                                <div class="image-container position-relative">
                                                    <img src="{{ $product->foto_produk }}" alt="{{ $product->nama_produk }}"
                                                        class="card-img-top">
                                                    <div class="product-code">
                                                        <span class="product-stock">Stock:
                                                            {{ $product->stok_produk }}</span>
                                                    </div>
                                                </div>
                                                <div class="product-title">{{ $product->nama_produk }}</div>
                                                <div class="d-flex justify-content-between mb-3">
                                                    <span class="product-category">{{ $product->merk_produk }}</span>
                                                    <div class="product-price">Rp
                                                        {{ number_format($product->harga_produk, 0, ',', '.') }}</div>
                                                </div>
                                                <a class="add-button w-100">TAMBAHKAN</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="cart-container shadow mt-5">
                        <h5 class="order">Active Order</h5>
                        <div class="order-items-container mb-3">
                            <!-- Item order akan ditampilkan di sini -->
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="total">Total:</span>
                            <span class="total-items">0 Pcs</span>
                            <span class="total-price">0</span>
                        </div>
                        <div class="d-flex">
                            <a class="trash-btn">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                            <button class="checkout-btn">
                                <i class="fa-solid fa-cart-shopping"></i> CHECKOUT
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let activeOrder = {
                items: [],
                total: 0,
                totalItems: 0
            };

            // Event listener untuk tombol "Tambahkan"
            document.querySelectorAll('.add-button').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Menentukan produk berdasarkan card yang diklik
                    const productCard = this.closest('.product-card');
                    const product = {
                        id: productCard.querySelector('.product-code').textContent.trim(),
                        name: productCard.querySelector('.product-title').textContent,
                        price: parseInt(productCard.querySelector('.product-price').textContent
                            .replace(/[^0-9]/g, '')),
                        stock: parseInt(productCard.querySelector('.product-stock').textContent
                            .replace(/[^0-9]/g, '')),
                        brand: productCard.querySelector('.product-category')
                            .textContent // Merk produk
                    };

                    // Menambahkan produk ke order aktif
                    addToOrder(product);
                });
            });

            function addToOrder(product) {
                const existingItem = activeOrder.items.find(item => item.id === product.id);

                if (existingItem) {
                    if (existingItem.quantity < product.stock) {
                        existingItem.quantity += 1;
                        activeOrder.total += product.price;
                        activeOrder.totalItems += 1;
                        updateActiveOrderDisplay();
                    } else {
                        alert('Stok produk tidak mencukupi!');
                    }
                } else {
                    activeOrder.items.push({
                        ...product,
                        quantity: 1
                    });
                    activeOrder.total += product.price;
                    activeOrder.totalItems += 1;
                    updateActiveOrderDisplay();
                }
            }


            function updateActiveOrderDisplay() {
                const orderItemsContainer = document.querySelector('.order-items-container');
                orderItemsContainer.innerHTML = '';

                activeOrder.items.forEach(item => {
                    const itemElement = document.createElement('div');
                    itemElement.className = 'order-item';
                    itemElement.innerHTML = `
                        <div class="order-item-details">
                            <div class="order-item-name">
                                ${item.name}
                                <div class="order-item-brand">${item.brand}</div>
                            </div>
                            <div class="order-item-total">${item.quantity}</div>
                            <div class="order-item-price">
                                Rp ${item.price.toLocaleString('id-ID')}
                            </div>
                        </div>
                    `;
                    orderItemsContainer.appendChild(itemElement);
                });


                // Update totals
                document.querySelector('.total-items').textContent = `${activeOrder.totalItems} Pcs`;
                document.querySelector('.total-price').textContent =
                    `Rp ${activeOrder.total.toLocaleString('id-ID')}`;
            }

            // Clear cart functionality
            document.querySelector('.trash-btn').addEventListener('click', function() {
                activeOrder = {
                    items: [],
                    total: 0,
                    totalItems: 0
                };
                updateActiveOrderDisplay();
            });
        });
    </script>
@endsection
