@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">
@endpush

@section('title')
    eBengkelku | Cart
@stop

@section('content')
    <section class="section section-white"
        style="position: relative; overflow: hidden; padding-top: 100px; padding-bottom: 20px;">
        <div
            style="background-image: url('{{ asset('assets/images/bg/wallpaper.png') }}'); background-size: cover; background-position: center; background-attachment: fixed; background-repeat: no-repeat; position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0;">
        </div>
        <div class="bg-white" style="position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0; opacity: 0.7;">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h4 class="title-header">Cart</h4>
                </div>
            </div>
        </div>
    </section>
    <section class="my-4">
        <div class="container">
            <div class="row">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-3">
                        <h4><b>Keranjang Belanja</b></h4>
                    </div>
                    <div class="d-flex justify-content-start">
                        <span id="item-count">0 item di keranjang Anda.</span>
                    </div>
                </div>

                <!-- Bagian Produk dan Kode Kupon -->
                <div class="col-12 col-lg-8">
                    <div class="card p-4 border-0 shadow">
                        <div class="row text-muted pb-2 mb-2 d-none d-md-flex">
                            <div class="col-5"><b>Product</b></div>
                            <div class="col-3 text-center"><b>Price</b></div>
                            <div class="col-2 text-center"><b>Quantity</b></div>
                            <div class="col-2 text-end"><b>Total Price</b></div>
                        </div>

                        <!-- Produk Item 1 -->
                        @foreach($cartItems as $cartItem)
                            <div class="border-bottom py-3 product-item">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-5 col-lg-5 d-flex align-items-center mb-3 mb-md-0">
                                        <img src="{{ asset('assets/images/product/'.$cartItem->produk->foto_produk) }}" class="img-fluid me-3" alt="gambar produk" style="width: 80px; height: 120px;">
                                        <div>
                                            <p class="mb-0"><b>{{ $cartItem->produk->nama_produk }}</b></p>
                                            <small class="text-muted">{{ $cartItem->produk->merk_produk }}</small>
                                            <p class="mb-0 d-md-none">Rp {{ number_format($cartItem->produk->harga_produk, 0, ',', '.') }}</p> <!-- Harga di layar kecil -->
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-3 text-center d-none d-md-block">
                                        <p class="mb-0" style="white-space: nowrap;">Rp {{ number_format($cartItem->produk->harga_produk, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="col-6 col-md-2 d-flex align-items-center justify-content-center mb-2 mb-md-0">
                                        <button type="button" class="btn btn-sm btn-outline-secondary me-2" onclick="kurangiKuantitas(this, {{ $cartItem->produk->harga_produk }})">-</button>
                                        <span class="border px-2 quantity" data-quantity="{{ $cartItem->quantity }}" data-price="{{ $cartItem->produk->harga_produk }}">{{ $cartItem->quantity }}</span>
                                        <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="tambahKuantitas(this, {{ $cartItem->produk->harga_produk }})">+</button>
                                    </div>
                                    <div class="col-6 col-md-2 text-end mt-3 mt-md-0 total-price-wrapper">
                                        <p class="mb-0 total-item-price" style="white-space: nowrap;">
                                            <b>Rp {{ number_format($cartItem->total_price, 0, ',', '.') }}</b>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                </div>


                <!-- Kode Kupon dan Summary - Posisi di Samping untuk Tablet dan Ke Atas -->
                <div class="col-12 col-lg-4 mt-3 mt-md-0">
                    <div class="card p-4 border-0 shadow">
                        <h5><b>Kode Kupon</b></h5>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="coupon-code" placeholder="Kode Kupon">
                            <button class="btn btn-primary w-100 mt-2 mb-3" onclick="applyDiscount()">Terapkan</button>
                        </div>

                        <div class="card p-3 border-0 custom-total">
                            <h5><b>Total Keranjang</b></h5>
                            <div class="d-flex justify-content-between my-3">
                                <p class="mb-0">Subtotal</p>
                                <p class="mb-0">Rp <span id="subtotal">0</span></p>
                            </div>
                            <div class="d-flex justify-content-between my-3">
                                <p class="mb-0">Pengiriman</p>
                                <p class="mb-0">Rp <span id="shipping">0</span></p>
                            </div>
                            <div class="d-flex justify-content-between my-3">
                                <p class="mb-0">Diskon</p>
                                <p class="mb-0">Rp <span id="discount">0</span></p>
                            </div>
                            <div class="d-flex justify-content-between my-3 border-top pt-3">
                                <p class="mb-0"><b>Total Keranjang</b></p>
                                <p class="mb-0"><b><span id="grand-total">0</span></b></p>
                            </div>
                            <button class="btn btn-primary w-100 mt-3">CHECKOUT</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script>
        // Fungsi untuk menambah kuantitas produk
        function tambahKuantitas(button, pricePerItem) {
            const quantitySpan = button.previousElementSibling;
            let quantity = parseInt(quantitySpan.getAttribute("data-quantity"));
            quantity++;
            quantitySpan.setAttribute("data-quantity", quantity);
            quantitySpan.textContent = quantity;
            const totalItemPriceElement = button.closest(".product-item").querySelector(".total-item-price");
            const newItemTotal = pricePerItem * quantity;
            totalItemPriceElement.textContent = "Rp " + newItemTotal.toLocaleString('id-ID');
            updateTotalPrice();
        }

        // Fungsi untuk mengurangi kuantitas produk
        function kurangiKuantitas(button, pricePerItem) {
            const quantitySpan = button.nextElementSibling;
            let quantity = parseInt(quantitySpan.getAttribute("data-quantity"));

            if (quantity > 1) {
                quantity--;
                quantitySpan.setAttribute("data-quantity", quantity);
                quantitySpan.textContent = quantity;

                const totalItemPriceElement = button.closest(".product-item").querySelector(".total-item-price");
                const newItemTotal = pricePerItem * quantity;
                totalItemPriceElement.textContent = "Rp " + newItemTotal.toLocaleString('id-ID');
            } else {
                const productItem = button.closest(".product-item");
                productItem.remove();
            }
            updateTotalPrice();
        }


        // Fungsi untuk menghitung subtotal dan grand total
        function updateTotalPrice() {
            let subtotal = 0;
            document.querySelectorAll(".product-item").forEach(item => {
                const pricePerItem = parseFloat(item.querySelector(".quantity").getAttribute("data-price"));
                const quantity = parseInt(item.querySelector(".quantity").getAttribute("data-quantity"));
                subtotal += quantity * pricePerItem;
            });
            document.getElementById("subtotal").textContent = subtotal.toLocaleString('id-ID');

            const discountValue = parseInt(document.getElementById("discount").textContent.replace(/\D/g, '')) || 0;
            document.getElementById("grand-total").textContent = "Rp " + (subtotal - discountValue).toLocaleString('id-ID');

            updateItemCount();
        }

        // Fungsi untuk menerapkan diskon berdasarkan kode kupon
        function applyDiscount() {
            const couponCode = document.getElementById("coupon-code").value.trim();
            if (couponCode.toLowerCase() === "fathan") {
                document.getElementById("discount").textContent = "10.000";
            } else if (couponCode === "DISKON5000") {
                document.getElementById("discount").textContent = "5.000";
            } else {
                document.getElementById("discount").textContent = "0";
            }
            updateTotalPrice();
        }

        // Fungsi untuk mengupdate jumlah item di keranjang
        function updateItemCount() {
            let itemCount = 0;
            document.querySelectorAll(".product-item").forEach(item => {
                const quantity = parseInt(item.querySelector(".quantity").getAttribute("data-quantity"));
                itemCount += quantity;
            });

            const itemCountText = itemCount === 1 ? `${itemCount} item` : `${itemCount} items`;
            document.getElementById("item-count").textContent = `${itemCountText} di keranjang Anda.`;
        }

        // Event listener untuk memastikan total harga dan jumlah item terupdate setelah halaman dimuat
        document.addEventListener("DOMContentLoaded", function() {
            updateItemCount();
            updateTotalPrice();
        });
    </script>

@endsection
