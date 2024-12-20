@extends('pos.layouts.app')
@section('title')
    eBengkelku | Transaksi Pos
@stop
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/POS/transaksi_pos.css') }}">
    <style>
        .remove-item-btn {
            display: flex;
            background: none;
            border: none;
            color: red;
            font-size: 14px;
            cursor: pointer;
        }

        .increase-btn {
            display: flex;
            background: none;
            border: none;
            color: red;
            font-size: 14px;
            cursor: pointer;
        }

        .decrease-btn {
            display: flex;
            background: none;
            border: none;
            color: red;
            font-size: 14px;
            cursor: pointer;
        }
    </style>
@endpush
@php
    $header = 'Transaksi Pos';
@endphp
@section('content')
    <div class="container-fluid py-4">
        <div class="search-container">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Cari Produk ...">
                <button class="btn btn-info text-white mx-3" data-toggle="tooltip" title="Print"><i
                        class="fa-solid fa-print"></i></button>
            </div>
        </div>
        <div class="main-layout">
            <div class="row">
                <div class="col-12 col-md-8">
                    <!-- Product Section -->
                    <h4 class="judul">List Produk</h4>
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-md-4 col-sm-6 mb-3 d-flex align-items-center">
                                <div class="custom-card shadow product-card">
                                    <div class="product-code d-flex justify-content-end">
                                        <span class="product-stock mb-2">Stock: {{ $product->stok_produk }}</span>
                                    </div>
                                    <img src="{{ isset($product->fotoProduk) && $product->fotoProduk->file_foto_produk_1 ? url($product->fotoProduk->file_foto_produk_1) : asset('assets/images/components/image.png') }}"
                                        alt="Product Image" class="product-image">
                                    <div class="product-title mt-3">{{ $product->nama_produk }}</div>
                                    <div class="product-category">{{ $product->merk_produk }}</div>
                                    <div class="product-price mb-2 mt-2">
                                        {{ formatRupiah($product->harga_produk) }}
                                    </div>
                                    <a class="add-button w-100" data-id="{{ $product->id }}"
                                        data-harga="{{ $product->harga_produk }}" data-tipe="produk"
                                        data-stock="{{ $product->stok_produk }}">
                                        <i class="fa-solid fa-bag-shopping mr-1"></i> TAMBAHKAN
                                    </a>

                                </div>
                            </div>
                        @endforeach
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
                            <a class="trash-btn" data-toggle="tooltip" title="Delete Order">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                            <a href="{{ route('pos.tranksaksi_pos.showcheckoutpos', ['id_bengkel' => $id_bengkel]) }}"
                                class="checkout-btn text-center" id="checkoutBtn">
                                <i class="fa-solid fa-cart-shopping"></i> CHECKOUT
                            </a>
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
            document.querySelectorAll('.add-button').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productCard = this.closest('.product-card');
                    const product = {
                        id: productCard.querySelector('.product-code').textContent.trim(),
                        name: productCard.querySelector('.product-title').textContent,
                        price: parseInt(productCard.querySelector('.product-price').textContent
                            .replace(/[^0-9]/g, '')),
                        stock: parseInt(productCard.querySelector('.product-stock').textContent
                            .replace(/[^0-9]/g, '')),
                        brand: productCard.querySelector('.product-category').textContent
                    };
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
                            <div class="order-item-details d-flex justify-content-between align-items-center">
                                <div class="order-item-name">
                                    ${item.name}
                                    <div class="order-item-brand">${item.brand}</div>
                                </div>
                                <div class="order-item-quantity d-flex align-items-center">
                                    <button class="decrease-btn btn btn-sm mb-3" data-id="${item.id}">-</button>
                                    <span class="mx-2 mb-3">${item.quantity}</span>
                                    <button class="increase-btn btn btn-sm mb-3" data-id="${item.id}">+</button>
                                </div>
                                <div class="order-item-price">
                                    Rp ${(item.price * item.quantity).toLocaleString('id-ID')}
                                </div>
                                <button class="remove-item-btn btn btn-sm btn-danger mb-4" data-id="${item.id}">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        `;
                    orderItemsContainer.appendChild(itemElement);
                });

                function changeItemQuantity(itemId, change) {
                    const item = activeOrder.items.find(item => item.id === itemId);
                    if (item) {
                        if (change === -1 && item.quantity === 1) {
                            removeFromOrder(itemId);
                        } else if (change === 1 && item.quantity < item.stock) {
                            item.quantity += change;
                            activeOrder.total += item.price * change;
                            activeOrder.totalItems += change;
                            updateActiveOrderDisplay();
                        } else if (change === 1 && item.quantity >= item.stock) {
                            alert('Stok produk tidak mencukupi!');
                        } else {
                            item.quantity += change;
                            activeOrder.total += item.price * change;
                            activeOrder.totalItems += change;
                            updateActiveOrderDisplay();
                        }
                    }
                }
                document.querySelector('.total-items').textContent = `${activeOrder.totalItems} Pcs`;
                document.querySelector('.total-price').textContent =
                    `Rp ${activeOrder.total.toLocaleString('id-ID')}`;
                document.querySelectorAll('.increase-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const itemId = this.getAttribute('data-id');
                        changeItemQuantity(itemId, 1);
                    });
                });
                document.querySelectorAll('.decrease-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const itemId = this.getAttribute('data-id');
                        changeItemQuantity(itemId, -1);
                    });
                });
                document.querySelectorAll('.remove-item-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const itemId = this.getAttribute('data-id');
                        removeFromOrder(itemId);
                    });
                });
            }

            function removeFromOrder(itemId) {
                const itemIndex = activeOrder.items.findIndex(item => item.id === itemId);
                if (itemIndex !== -1) {
                    const item = activeOrder.items[itemIndex];
                    activeOrder.total -= item.price * item.quantity;
                    activeOrder.totalItems -= item.quantity;
                    activeOrder.items.splice(itemIndex, 1);
                    updateActiveOrderDisplay();
                }
            }
            document.querySelector('.trash-btn').addEventListener('click', function() {
                activeOrder = {
                    items: [],
                    total: 0,
                    totalItems: 0
                };
                updateActiveOrderDisplay();
            });
            const checkoutBtn = document.querySelector('.checkout-btn');
            checkoutBtn.addEventListener('click', function(e) {
                if (activeOrder.items.length === 0) {
                    e.preventDefault();
                    alert('Keranjang Anda kosong! Tambahkan produk terlebih dahulu.');
                }
                document.querySelector('input[name="orderData"]').value = JSON.stringify(activeOrder);
                document.querySelector('form').submit();
            });
        });
    </script>

@endsection
