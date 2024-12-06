@extends('pos.layouts.app')
@section('title')
    eBengkelku | Master POS
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
    </style>
@endpush
@php
    $header = 'Master POS';
@endphp
@section('content')
    <div class="container-fluid py-4">
        <div class="search-container">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Scan atau Cari ...">
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
                            <div class="col-md-4 col-sm-6 mb-3 d-flex align-items-stretch">
                                <div class="custom-card shadow product-card">
                                    <div class="product-code d-flex justify-content-between">
                                        <span>{{ $product->id_produk }}</span>
                                        <span class="product-stock">Stock: {{ $product->stok_produk }}</span>
                                    </div>
                                    <div class="product-title mt-3">{{ $product->nama_produk }}</div>
                                    <div class="product-price">Price : Rp
                                        {{ number_format($product->harga_produk, 0, ',', '.') }}</div>
                                    <div class="product-category mb-2">{{ $product->merk_produk }}</div>
                                    <a class="add-button w-100"><i class="fa-solid fa-bag-shopping mr-1"
                                            style="color: "></i>TAMBAHKAN</a>
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
                            <a href="{{ route('pos.tranksaksi_pesanan.checkout', ['id_bengkel' => $id_bengkel]) }}"
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
                        brand: productCard.querySelector('.product-category')
                            .textContent
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
                        <div class="order-item-details">
                            <div class="order-item-name">
                                ${item.name}
                                <div class="order-item-brand">${item.brand}</div>
                            </div>
                            <div class="order-item-total">${item.quantity}</div>
                            <div class="order-item-price">
                                Rp ${item.price.toLocaleString('id-ID')}
                            </div>
                            <button class="remove-item-btn" data-id="${item.id}">
                                <i class="fa fa-times"></i> <!-- Ikon X -->
                            </button>
                        </div>
                    `;
                    orderItemsContainer.appendChild(itemElement);
                });

                // Update total harga dan jumlah item
                document.querySelector('.total-items').textContent = `${activeOrder.totalItems} Pcs`;
                document.querySelector('.total-price').textContent = `Rp ${activeOrder.total.toLocaleString('id-ID')}`;

                // Menambahkan event listener untuk tombol hapus (X)
                document.querySelectorAll('.remove-item-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const itemId = this.getAttribute('data-id');
                        removeFromOrder(itemId);
                    });
                });
            }

            function removeFromOrder(itemId) {
                // Mencari item di activeOrder berdasarkan id
                const itemIndex = activeOrder.items.findIndex(item => item.id === itemId);
                if (itemIndex !== -1) {
                    // Mengurangi total harga dan jumlah item
                    const item = activeOrder.items[itemIndex];
                    activeOrder.total -= item.price * item.quantity;
                    activeOrder.totalItems -= item.quantity;

                    // Menghapus item dari array activeOrder
                    activeOrder.items.splice(itemIndex, 1);

                    // Memperbarui tampilan
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
            document.querySelector('.checkout-btn').addEventListener('click', function() {
                const orderData = {
                    items: activeOrder.items,
                    total_qty: activeOrder.totalItems,
                    total_harga: activeOrder.total,
                    tanggal: new Date().toISOString().split('T')[0],
                };
                fetch('/tranksaksi/pesanan/store/{id_bengkel}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify(orderData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Pesanan berhasil dibuat!');
                            activeOrder = {
                                items: [],
                                total: 0,
                                totalItems: 0
                            };
                            updateActiveOrderDisplay();
                        } else {
                            alert('Terjadi kesalahan saat membuat pesanan.');
                        }
                    })
                    .catch(error => {
                        alert('Terjadi kesalahan.');
                        console.error('Error:', error);
                    });
            });
        });
    </script>

@endsection
