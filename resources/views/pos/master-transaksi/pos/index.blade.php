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
            <form action="{{ route('pos.tranksaksi_pos.index', ['id_bengkel' => $id_bengkel]) }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari Produk ..."
                        value="{{ request('search') }}">
                    <button type="submit" class="btn btn-info text-white mx-3">
                        <i class="fa-solid fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="main-layout">
            <div class="row">
                <div class="col-12 col-md-8">
                    <h4 class="judul">List Item</h4>
                    <div class="row">
                        @forelse ($items as $item)
                            <div class="col-md-4 col-sm-6 mb-3 d-flex justify-content-center align-items-center">
                                <div
                                    class="custom-card shadow {{ $item->type === 'produk' ? 'product-card' : 'sparepart-card' }}">
                                    <div class="product-code d-flex justify-content-end">
                                        <span class="product-stock mb-2">Stock:
                                            {{ $item->type === 'produk' ? $item->stok_produk : $item->stok_spare_part }}
                                        </span>
                                    </div>
                                    <img src="{{ isset($item->fotoProduk) && $item->type === 'produk'
                                        ? ($item->fotoProduk->file_foto_produk_1
                                            ? url($item->fotoProduk->file_foto_produk_1)
                                            : asset('assets/images/components/image.png'))
                                        : (isset($item->fotoSparepart) && $item->fotoSparepart->file_foto_sparepart_1
                                            ? url($item->fotoSparepart->file_foto_sparepart_1)
                                            : asset('assets/images/components/image.png')) }}"
                                        alt="Item Image" class="product-image">
                                    <div class="product-title mt-3">
                                        {{ $item->type === 'produk' ? $item->nama_produk : $item->nama_spare_part }}</div>
                                    <div class="product-category">
                                        {{ $item->type === 'produk' ? $item->merk_produk : $item->merk_spare_part }}</div>
                                    <div class="product-price mb-2 mt-2">
                                        {{ $item->type === 'produk' ? formatRupiah($item->harga_produk) : formatRupiah($item->harga_spare_part) }}
                                    </div>
                                    <a class="add-button w-100"
                                        data-id="{{ $item->type === 'produk' ? $item->id_produk : $item->id_spare_part }}"
                                        data-harga="{{ $item->type === 'produk' ? $item->harga_produk : $item->harga_spare_part }}"
                                        data-tipe="{{ $item->type }}"
                                        data-stock="{{ $item->type === 'produk' ? $item->stok_produk : $item->stok_spare_part }}">
                                        <i class="fa-solid fa-bag-shopping mr-1"></i> TAMBAHKAN
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center">
                                <p>Item tidak ditemukan.</p>
                            </div>
                        @endforelse
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
                            <a href="javascript:void(0)" class="checkout-btn text-center"
                                data-id-bengkel="{{ $id_bengkel }}" id="checkoutBtn">
                                <i class="fa-solid fa-cart-shopping"></i> CHECKOUT
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('preview_url'))
        <script>
            window.open('{{ session('preview_url') }}', '_blank');
        </script>
    @endif


    <script>
        // Global cart variable
        let cart = [];

        document.addEventListener('DOMContentLoaded', () => {
            const cartContainer = document.querySelector('.order-items-container');
            const totalItemsElement = document.querySelector('.total-items');
            const totalPriceElement = document.querySelector('.total-price');
            const trashBtn = document.querySelector('.trash-btn');

            // Add to Cart event listener
            document.querySelectorAll('.add-button').forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.getAttribute('data-id');
                    const harga = parseFloat(button.getAttribute('data-harga'));
                    const stok = parseInt(button.getAttribute('data-stock'));
                    const tipe = button.getAttribute('data-tipe');
                    const nama = button.closest('.custom-card').querySelector('.product-title')
                        .textContent;
                    const merk = button.closest('.custom-card').querySelector('.product-category')
                        .textContent;
                    const uniqueKey = `${id}-${tipe}-${nama}-${merk}`;

                    if (!id) {
                        alert('ID barang tidak ditemukan!');
                        return;
                    }

                    if (stok <= 0) {
                        alert('Stok habis, tidak dapat menambahkan item ini.');
                        return;
                    }

                    const existingItemIndex = cart.findIndex(item =>
                        `${item.id}-${item.tipe}-${item.nama}-${item.merk}` === uniqueKey
                    );

                    if (existingItemIndex !== -1) {
                        if (cart[existingItemIndex].quantity < stok) {
                            cart[existingItemIndex].quantity++;
                        } else {
                            alert('Jumlah item melebihi stok yang tersedia.');
                        }
                    } else {
                        cart.push({
                            id,
                            nama,
                            harga,
                            stok,
                            tipe,
                            merk,
                            quantity: 1,
                            uniqueKey
                        });
                    }

                    renderCart();
                });
            });

            // Render cart function
            function renderCart() {
                cartContainer.innerHTML = '';
                let totalItems = 0;
                let totalPrice = 0;

                cart.forEach((item, index) => {
                    totalItems += item.quantity;
                    totalPrice += item.quantity * item.harga;

                    const cartItem = document.createElement('div');
                    cartItem.classList.add('cart-item', 'd-flex', 'justify-content-between',
                        'align-items-center', 'mb-2');
                    cartItem.innerHTML = `
                        <div>
                            <div>${item.nama} (${item.merk})</div>
                            <small>${item.quantity} x ${item.harga.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="decrease-btn" data-index="${index}">-</button>
                            <span class="mx-2">${item.quantity}</span>
                            <button class="increase-btn" data-index="${index}">+</button>
                            <button class="remove-item-btn ml-2 text-danger" data-index="${index}">
                                <i class="fa-solid fa-x"></i>
                            </button>
                        </div>
                    `;

                    cartContainer.appendChild(cartItem);
                });

                totalItemsElement.textContent = `${totalItems} Pcs`;
                totalPriceElement.textContent = totalPrice.toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                });
                attachCartEventListeners();
            }

            // Attach event listeners to cart actions
            function attachCartEventListeners() {
                document.querySelectorAll('.remove-item-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        const index = button.getAttribute('data-index');
                        cart.splice(index, 1);
                        renderCart();
                    });
                });

                document.querySelectorAll('.increase-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        const index = button.getAttribute('data-index');
                        if (cart[index].quantity < cart[index].stok) {
                            cart[index].quantity++;
                            renderCart();
                        } else {
                            alert('Jumlah item melebihi stok yang tersedia.');
                        }
                    });
                });

                document.querySelectorAll('.decrease-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        const index = button.getAttribute('data-index');
                        if (cart[index].quantity > 1) {
                            cart[index].quantity--;
                        } else {
                            cart.splice(index, 1);
                        }
                        renderCart();
                    });
                });
            }

            // Trash all items
            if (trashBtn) {
                trashBtn.addEventListener('click', () => {
                    if (confirm('Anda yakin ingin menghapus semua item?')) {
                        cart = [];
                        renderCart();
                        cartContainer.innerHTML = '';
                        totalItemsElement.textContent = '0 Pcs';
                        totalPriceElement.textContent = '0';
                    }
                });
            }

            // Checkout action
            document.getElementById('checkoutBtn').addEventListener('click', function() {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const cartData = cart;

                const id_bengkel = this.getAttribute('data-id-bengkel');

                const endpoint = `/POS/tranksaksi/pos/${id_bengkel}/checkout`;

                fetch(endpoint, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({
                            cart: cartData,
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = data.redirect;
                        } else {
                            alert(data.error || 'Terjadi kesalahan.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>

@endsection
