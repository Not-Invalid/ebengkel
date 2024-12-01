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
                    <div class="main-container mt-3">
                        <h4 class="judul">List Produk</h4>
                        <div class="products-grid shadow p-4">
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                                @foreach ($products as $product)
                                    <div class="col-12 col-md-6">
                                        <div class="custom-card shadow position-relative">
                                            <div class="product-code d-flex justify-content-between">
                                                <span
                                                    style="font-weight: 600; color: #000;">{{ $product->id_produk }}</span>
                                                <span class="product-stock">Stock: {{ $product->stok_produk }}</span>
                                            </div>
                                            <div class="product-title mt-3">{{ $product->nama_produk }}</div>
                                            <div class="mb-2">
                                                <div class="product-price">Price : Rp
                                                    {{ number_format($product->harga_produk, 0, ',', '.') }}</div>
                                                <div class="product-category">{{ $product->merk_produk }}</div>
                                            </div>
                                            <a class="add-button w-100"><i
                                                    class="fa-solid fa-bag-shopping mr-1"></i>TAMBAHKAN</a>
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

    <!-- Modal -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkoutModalLabel">Konfirmasi Checkout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin melanjutkan checkout?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Lanjutkan</button>
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

            // Checkout button click event
            document.querySelector('.checkout-btn').addEventListener('click', function() {
                // Collect order data
                const orderData = {
                    items: activeOrder.items,
                    total_qty: activeOrder.totalItems,
                    total_harga: activeOrder.total,
                    tanggal: new Date().toISOString().split('T')[0], // Example: "2024-11-29"
                    // Add any additional fields here (e.g., customer info)
                };

                // Send order data to the backend
                fetch('/tranksaksi/pesanan/store/{id_bengkel}', { // Update the URL with the actual ID
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
                            // Optionally, redirect or clear the cart
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
