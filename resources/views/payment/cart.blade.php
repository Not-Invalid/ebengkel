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
    </section>
    <section class="h-100 py-2">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12">
                    <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-lg-8">
                                    <div class="p-5">
                                        <div class="d-flex justify-content-between align-items-center mb-5">
                                            <h1 class="fw-bold mb-0">Shopping Cart</h1>
                                            <h6 class="mb-0 text-muted">{{ count($cartItems) }} items</h6>
                                        </div>
                                        <hr class="my-4">

                                        <!-- Loop through Cart Items -->
                                        @foreach ($cartItems as $item)
                                            <div class="row mb-4 d-flex justify-content-between align-items-center">
                                                <div class="col-md-2 col-lg-2 col-xl-2">
                                                    <img src="{{ isset($item->produk->foto_produk) ? url($item->produk->foto_produk) : (isset($item->produk->foto_spare_part) ? url($item->produk->foto_spare_part) : asset('assets/images/components/image.png')) }}"
                                                        class="img-fluid rounded-3 border" alt="{{ $item->produk->nama_produk }}">
                                                </div>
                                                <div class="col-md-3 col-lg-3 col-xl-3">
                                                    <h6 class="text-muted">
                                                        @if($item->produk && $item->produk->kategoriProduct)
                                                            {{ $item->produk->kategoriProduct->nama_kategori_spare_part }}
                                                        @else
                                                            No category
                                                        @endif
                                                    </h6>
                                                    <h6 class="mb-0">{{ $item->produk ? $item->produk->nama_produk : 'No product' }}</h6>
                                                </div>
                                                <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                                    <button class="btn btn-link px-2" onclick="decreaseQuantity({{ $item->id }})">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input id="quantity-{{ $item->id }}" name="quantity" type="text" value="{{ $item->quantity }}" class="form-control form-control-sm quantity-input" onchange="updateCartItemQuantity({{ $item->id }}, this.value)" pattern="\d*" data-stock="{{ $item->produk->stok_produk }}" />
                                                    <button class="btn btn-link px-2" onclick="increaseQuantity({{ $item->id }})">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                                <div class="col-md-3 col-lg-2 col-xl-2">
                                                    <p class="mb-0 fw-semibold price">Rp {{ number_format($item->produk->harga_produk * $item->quantity, 0, ',', '.') }}</p> <!-- Display in Rupiah -->
                                                </div>
                                                <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-muted" style="background: none; border: none; padding: 0;">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            <hr class="my-4">
                                        @endforeach


                                        <div class="pt-5">
                                            <h6 class="mb-0"><a href="" class="text-body text-decoration-none"><i class="fas fa-long-arrow-alt-left me-2"></i>Back to shop</a></h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 bg-body-tertiary">
                                    <div class="p-5">
                                        <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
                                        <hr class="my-4">
                                        <div class="d-flex justify-content-between mb-4">
                                            <h5 class="text-uppercase">items {{ count($cartItems) }}</h5>
                                            <h5>Rp {{ number_format($totalPrice, 0, ',', '.') }}</h5> <!-- Example: € to IDR conversion rate 1€ = 16,000 IDR -->
                                        </div>

                                        <h5 class="text-uppercase mb-3">Shipping</h5>
                                        <div class="mb-4 pb-2">
                                            <select data-mdb-select-init>
                                                <option value="1">Standard-Delivery - Rp 10,000</option> <!-- Adjusted to Rupiah -->
                                                <option value="2">Express Delivery - Rp 20,000</option> <!-- Adjusted to Rupiah -->
                                            </select>
                                        </div>

                                        <h5 class="text-uppercase mb-3">Code Voucher</h5>
                                        <div class="mb-5">
                                            <div data-mdb-input-init class="form-outline">
                                                <input type="text" id="form3Examplea2" class="form-control form-control-lg" placeholder="Enter your code" />
                                            </div>
                                        </div>

                                        <hr class="my-4">

                                        <div class="d-flex justify-content-between mb-5">
                                            <h5 class="text-uppercase">Total price</h5>
                                            <h5>Rp {{ number_format($totalPrice, 0, ',', '.') }}</h5> <!-- Assuming fixed shipping fee and conversion rate -->
                                        </div>

                                        <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-block btn-lg" data-mdb-ripple-color="dark">
                                            Checkout
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



    <script>
        // Fungsi untuk menambah kuantitas produk



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

        // Function to handle the increment (plus) button click
        function increaseQuantity(itemId) {
            const quantityInput = document.querySelector(`#quantity-${itemId}`);
            let quantity = parseInt(quantityInput.value) || 0;
            const maxStock = parseInt(quantityInput.getAttribute('data-stock'));

            if (quantity < maxStock) {
                quantity++;
                quantityInput.value = quantity;
                updateCartItemQuantity(itemId, quantity);
            } else {
                alert(`Maksimum kuantitas yang tersedia adalah ${maxStock}`);
            }
        }

        // Function to handle the decrement (minus) button click
        function decreaseQuantity(itemId) {
            const quantityInput = document.querySelector(`#quantity-${itemId}`);
            let quantity = parseInt(quantityInput.value) || 1;

            if (quantity > 1) {
                quantity--;
                quantityInput.value = quantity;
                updateCartItemQuantity(itemId, quantity);
            } else {
                alert('Kuantitas tidak boleh kurang dari 1.');
            }
        }

        // Function to update the cart item quantity
        function updateCartItemQuantity(itemId, quantity) {
            // Convert quantity to integer and validate
            quantity = parseInt(quantity) || 1;
            const quantityInput = document.querySelector(`#quantity-${itemId}`);
            const maxStock = parseInt(quantityInput.getAttribute('data-stock'));

            if (quantity > maxStock) {
                alert(`Maksimum kuantitas yang tersedia adalah ${maxStock}`);
                quantityInput.value = maxStock;
                return;
            }

            if (quantity < 1) {
                alert('Kuantitas tidak boleh kurang dari 1.');
                quantityInput.value = 1;
                return;
            }

            // Kirim permintaan ke server untuk memperbarui kuantitas
            fetch(`/cart/update/${itemId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ quantity: quantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Perbarui UI dengan harga dan kuantitas baru
                    document.querySelector(`#quantity-${itemId}`).value = data.newQuantity;
                    updateTotalPrice();
                } else {
                    alert('Terjadi kesalahan saat memperbarui item di keranjang');
                }
            });
        }

        // Allow only numeric input in the text field
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('input', function () {
                this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
            });
        });



        // Event listener untuk memastikan total harga dan jumlah item terupdate setelah halaman dimuat
        document.addEventListener("DOMContentLoaded", function() {
            updateItemCount();
            updateTotalPrice();
        });

        function removeFromCart(cartItemId) {
            fetch(`/cart/remove/${cartItemId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart UI with new item count and total price
                    document.querySelector('#cart-count').innerText = data.cartCount;
                    document.querySelector('#total-price').innerText = `€ ${data.totalPrice}`;

                    // Optionally, update cart items list
                    updateCartItems(data.cartItems);
                } else {
                    alert('Error removing item from cart');
                }
            });
        }

    </script>

@endsection
