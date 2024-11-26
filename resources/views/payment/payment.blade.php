@extends('layouts.app')

@section('title')
    eBengkelku | Payment
@stop

@section('content')

    <section class="section section-white" style="position: relative; overflow: hidden; padding-top: 100px; padding-bottom: 20px;">
        <div style="background-image: url('assets/images/bg/wallpaper.png'); background-size: cover; background-position: center; background-attachment: fixed; background-repeat: no-repeat; position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0;">
        </div>
        <div class="bg-white" style="position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0; opacity: 0.7;">
        </div>

        <!-- Kontainer untuk Payment -->
        <div class="container py-5" style="position: relative; z-index: 2;">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow">
                        <div class="card-body">
                            <!-- Header -->
                            <div class="text-center mb-4">
                                <div class="col-auto">
                                    <img src="assets/images/logo/icon.png" alt="Produk" class="img-fluid rounded" style="width: 80px; height: 80px;">
                                </div>
                                <h3>Pembayaran eBengkel</h3>
                            </div>
                            <div class="card-body ">
                                <!-- Shipping Address Section -->
                                <div class="checkout-section">
                                    <h6 class="d-flex justify-content-between align-items-center">
                                        <span>Informasi Pengiriman</span>
                                    </h6>
                                    <p class="mt-2">
                                        <strong>Thans</strong> (+62) 878-6697-4026
                                    </p>
                                    <p class="mb-0">Jalan Moh Thamrin Kampung Warung mangga, RT.003/RW.002, Panunggangan, Pinang, kode pos 15143.</p>
                                    <p class="mb-0">KOTA TANGERANG - TANGERANG, BANTEN, ID 40534</p>
                                </div>
                                <hr>

                                <!-- Order Details Section -->
                                <div class="checkout-section">
                                    <div class="row align-items-center bg-light p-2 rounded">
                                        <h6 class="text-start mb-1"><i class="bi bi-shop me-2"></i>Thans Racing</h6>
                                        <div class="col-auto">
                                            <img src="{{ asset('assets/images/components/image.png') }}" alt="Gambar Produk" class="img-fluid rounded" style="width: 60px; height: 65px; object-fit: cover;">
                                        </div>
                                        <div class="col">
                                            <p class="mb-0 fw-bold">olinol</p>
                                            <p class="mb-0 text-danger">Rp39.900</p>
                                        </div>
                                        <div class="col-auto">
                                            <p class="mb-0 text-muted">x1</p>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                        
                                <!-- Shipping Method Section -->
                                <div class="checkout-section">
                                    <h6 class="mb-3">Opsi Pengiriman</h6>
                                    <div class="dropdown">
                                        <button class="btn btn-outline-border dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center" type="button" id="shippingOptionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <div>
                                                <p class="mb-0 fw-bold" id="selectedShippingName">Reguler</p>
                                                <p class="mb-0 text-muted" id="selectedShippingCourier" style="font-size: 14px;">J&T Express</p>
                                                <p class="mb-0 text-muted" style="font-size: 12px;" id="deliveryDate">Akan diterima pada tanggal 23 Ags - 24 Ags</p>
                                            </div>
                                            <div class="text-end">
                                                <p class="mb-0 fw-bold" id="selectedShippingPrice">Rp 11.000</p>
                                            </div>
                                        </button>
                                        <ul class="dropdown-menu w-100" aria-labelledby="shippingOptionsDropdown" style="z-index: 1050;">
                                            <li>
                                                <a class="dropdown-item" data-shipping="Reguler" data-price="Rp 11.000" data-courier="J&T Express" data-time="2-4 Hari" onclick="updateShipping('Reguler', 11000, 'J&T Express', '2-4 Hari')">
                                                    Reguler (Rp 11.000) - J&T Express
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" data-shipping="Ekspres" data-price="Rp 25.000" data-courier="Gojek Xpress" data-time="1-2 Hari" onclick="updateShipping('Ekspres', 25000, 'Gojek Xpress', '1-2 Hari')">
                                                    Ekspres (Rp 25.000) - Gojek Xpress
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" data-shipping="Same Day" data-price="Rp 50.000" data-courier="JNE Super Speed" data-time="Hari yang sama" onclick="updateShipping('Same Day', 50000, 'JNE Super Speed', 'Hari yang sama')">
                                                    Same Day (Rp 50.000) - JNE Super Speed
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    
                                    
                                    <!-- Kode Voucher Section (Dibawah Dropdown) -->
                                    <div class="voucher-section" style="margin-top: 20px;">
                                        <h6 class="mb-2">Gunakan Kode Voucher</h6>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="voucherCode" placeholder="Masukkan kode voucher">
                                            <button class="btn btn-primary" id="applyVoucherButton" onclick="applyVoucher()">Gunakan</button>
                                        </div>
                                        <p id="voucherMessage" class="mt-2 text-muted" style="font-size: 14px;"></p>
                                    </div>                                    
                                </div>
                                <hr>
                            
                                <!-- Ringkasan Total Biaya -->
                                <div class="checkout-section">
                                    <h6>Ringkasan Total Biaya</h6>
                                    <p><strong>Subtotal:</strong> <span id="subtotal">Rp 39.900</span></p>
                                    <p><strong>Biaya Pengiriman:</strong> <span id="shippingFee">Rp 11.000</span></p>
                                    <p><strong>Diskon:</strong> <span id="discount">Rp 0</span></p>
                                    <p><strong>Total:</strong> <span id="total">Rp 50.900</span></p>
                                </div>
                            </div>
        
                            <!-- Tombol Bayar -->
                            <button id="payButton" class="btn btn-dark btn-block btn-lg mt-4">Bayar Sekarang</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
   <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Elemen HTML
            const shippingOptions = document.querySelectorAll('.dropdown-item');
            const selectedShippingName = document.getElementById('selectedShippingName');
            const selectedShippingCourier = document.getElementById('selectedShippingCourier');
            const selectedShippingPrice = document.getElementById('selectedShippingPrice');
            const subtotalElement = document.getElementById('subtotal');
            const shippingFeeElement = document.getElementById('shippingFee');
            const discountElement = document.getElementById('discount');
            const totalElement = document.getElementById('total');
            const voucherCodeInput = document.getElementById('voucherCode');
            const voucherMessage = document.getElementById('voucherMessage');

            // Data Awal
            let subtotal = 39900; // Contoh subtotal
            let shippingFee = 11000; // Default biaya pengiriman
            let discount = 0;

            // Fungsi untuk menghitung total
            const calculateTotal = () => {
                const total = subtotal + shippingFee - discount;
                subtotalElement.textContent = `Rp ${subtotal.toLocaleString()}`;
                shippingFeeElement.textContent = `Rp ${shippingFee.toLocaleString()}`;
                discountElement.textContent = `Rp ${discount.toLocaleString()}`;
                totalElement.textContent = `Rp ${total.toLocaleString()}`;
            };

            // Event listener untuk opsi pengiriman
            shippingOptions.forEach(option => {
                option.addEventListener('click', (e) => {
                    const shippingName = e.target.dataset.shipping;
                    const shippingPrice = parseInt(e.target.dataset.price.replace(/\D/g, '')); // Ambil angka
                    const shippingCourier = e.target.dataset.courier;
                    const shippingTime = e.target.dataset.time;

                    // Update data pengiriman
                    selectedShippingName.textContent = shippingName;
                    selectedShippingCourier.textContent = shippingCourier;
                    selectedShippingPrice.textContent = `Rp ${shippingPrice.toLocaleString()}`;
                    shippingFee = shippingPrice;

                    // Hitung ulang total
                    calculateTotal();
                });
            });

            // Event listener untuk kode voucher
            document.getElementById('applyVoucherButton').addEventListener('click', () => {
                const voucherCode = voucherCodeInput.value.trim();

                // Validasi kode voucher
                if (voucherCode === "DISKON50") {
                    voucherMessage.textContent = "Kode voucher berhasil digunakan! Anda mendapatkan diskon Rp 50.000.";
                    voucherMessage.classList.remove('text-danger');
                    voucherMessage.classList.add('text-success');
                    discount = 5000; // Set diskon ke Rp 50.000
                } else {
                    voucherMessage.textContent = "Kode voucher tidak valid.";
                    voucherMessage.classList.remove('text-success');
                    voucherMessage.classList.add('text-danger');
                    discount = 0; // Reset diskon jika kode tidak valid
                }

                // Hitung ulang total
                calculateTotal();
            });

            // Hitung total awal
            calculateTotal();
        });
        function updateShipping(shippingName, shippingPrice, courierName, deliveryTime) {
            // Mengupdate tampilan teks berdasarkan pilihan
            document.getElementById('selectedShippingName').textContent = shippingName;
            document.getElementById('selectedShippingCourier').textContent = courierName;
            document.getElementById('deliveryDate').textContent = `Akan diterima dalam ${deliveryTime}`;
            document.getElementById('selectedShippingPrice').textContent = `Rp ${shippingPrice.toLocaleString()}`;
        }

        document.getElementById('payButton').addEventListener('click', function (e) {
            e.preventDefault(); // Mencegah form submit default

            // Ambil Snap Token yang dikirim dari controller
            var snapToken = "{{ $snapToken }}"; // Pastikan kamu sudah mengirimkan snapToken ke view
            
            // Panggil Midtrans Snap
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    // Handle sukses pembayaran
                    alert("Pembayaran sukses! ID Transaksi: " + result.transaction_id);
                    // Redirect atau tampilkan pesan sukses
                },
                onPending: function(result) {
                    // Handle status pembayaran pending
                    alert("Pembayaran sedang diproses. Status: " + result.transaction_status);
                },
                onError: function(result) {
                    // Handle error pembayaran
                    alert("Pembayaran gagal. Kesalahan: " + result.status_message);
                }
            });
        });

   </script>
@endsection
