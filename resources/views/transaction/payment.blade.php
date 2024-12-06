@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/payment.css') }}">
@endpush

@section('title')
    eBengkelku | Payment
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
                    <h4 class="title-header">What's In The Cart</h4>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container my-5">
            <div class="row">
                <!-- Left Column: Checkout Form -->
                <div class="col-md-8">
                    <h3>Checkout</h3>
                    <p>
                        All plans include 40+ advanced tools and features to
                        boost your product. Choose the best plan to fit your
                        needs.
                    </p>

                    <!-- Payment Method -->
                    <div class="payment-container row">
                        <div class="col-md-6">
                            <div class="payment-method d-flex align-items-center justify-content-between border p-3 mb-2">
                                <label class="form-check-label d-flex align-items-center w-100" for="manualtransfer">
                                    <input class="form-check-input me-2" type="radio" name="paymentMethod"
                                        id="manualtransfer" />
                                    <i class="fas fa-university me-2"></i>
                                    Manual Transfer
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="payment-method d-flex align-items-center justify-content-between border p-3 mb-2">
                                <label class="form-check-label d-flex align-items-center w-100" for="qris">
                                    <input class="form-check-input me-2" type="radio" name="paymentMethod"
                                        id="qris" />
                                    <i class="fas fa-qrcode me-2"></i> QRIS
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row my-3">
                        <!-- Manual Transfer: Select Bank Row -->
                        <div class="row" id="selectBankRow" style="display: none">
                            <div class="col-md-6">
                                <label for="paymentMethod" class="form-label">Select Bank</label>
                                <select class="form-select" id="paymentMethod" name="paymentMethod">
                                    <option value="BCA">BCA</option>
                                    <option value="BRI">BRI</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="accountNumber" class="form-label">Account Number</label>
                                <input type="text" class="form-control" id="accountNumber" name="accountNumber"
                                    placeholder="Enter your account number" />
                            </div>
                        </div>

                        <!-- QRIS: QR Code Image Row -->
                        <div class="row" id="qrisImageRow" style="display: none">
                            <div class="col-md-12 text-center">
                                <label for="qrisImage" class="form-label-qris">Scan QRIS</label>
                                <img src="https://cdn.pixabay.com/photo/2013/07/12/14/45/qr-code-148732_1280.png"
                                    alt="QRIS Code" class="img-fluid" id="qrisImage" />
                            </div>
                        </div>
                    </div>

                    <!-- Billing Details -->
                    <h4>Billing Details</h4>
                    <form>
                        <div class="mb-3 mt-3">
                            <label for="status_invoice" class="form-label">Status Invoice</label>
                            <input type="text" class="form-control" id="status_invoice" name="status_invoice"
                                placeholder="Enter invoice status" required>
                        </div>

                        <div class="mb-3">
                            <label for="jatuh_tempo" class="form-label">Jatuh Tempo</label>
                            <input type="date" class="form-control" id="jatuh_tempo" name="jatuh_tempo" required>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_invoice" class="form-label">Tanggal Invoice</label>
                            <input type="date" class="form-control" id="tanggal_invoice" name="tanggal_invoice" required>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_bayar" class="form-label">Tanggal Bayar</label>
                            <input type="date" class="form-control" id="tanggal_bayar" name="tanggal_bayar">
                        </div>

                        <div class="mb-3">
                            <label for="nama_rekening" class="form-label">Nama Rekening</label>
                            <input type="text" class="form-control" id="nama_rekening" name="nama_rekening"
                                placeholder="Enter account name">
                        </div>

                        <div class="mb-3">
                            <label for="no_rekening" class="form-label">No Rekening</label>
                            <input type="text" class="form-control" id="no_rekening" name="no_rekening"
                                placeholder="Enter account number">
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Note</label>
                            <textarea class="form-control" id="note" name="note" rows="3" placeholder="Enter any notes"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_transfer" class="form-label">Tanggal Transfer</label>
                            <input type="date" class="form-control" id="tanggal_transfer" name="tanggal_transfer">
                        </div>

                        <div class="mb-3">
                            <label for="nominal_transfer" class="form-label">Nominal Transfer</label>
                            <input type="number" class="form-control" id="nominal_transfer" name="nominal_transfer"
                                placeholder="Enter transfer amount">
                        </div>

                        <div class="mb-3">
                            <label for="bukti_bayar" class="form-label">Bukti Bayar</label>
                            <input type="file" class="form-control" id="bukti_bayar" name="bukti_bayar">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <!-- Right Column: Order Summary -->
                <div class="col-md-4">
                    <div class="order-summary">
                        <h4>Order Summary</h4>
                        <p>A simple start for everyone</p>
                        <h5>$59.99/month</h5>
                        <button class="btn btn-outline-primary w-100 mb-3">
                            Change Plan
                        </button>
                        <div class="d-flex justify-content-between">
                            <span>Subtotal</span>
                            <span>$85.99</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Tax</span>
                            <span>$4.99</span>
                        </div>
                        <hr />
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span>$90.98</span>
                        </div>
                        <button class="btn btn-payment w-100 mt-3">
                            Proceed With Payment
                        </button>
                        <p class="text-muted mt-3 text-center">
                            By continuing, you accept our
                            <a href="#">Terms of Services</a> and
                            <a href="#">Privacy Policy</a>. <br />
                            Please note that payments are non-refundable.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const manualTransferRadio =
                document.getElementById("manualtransfer");
            const qrisRadio = document.getElementById("qris");

            const selectBankRow = document.querySelector("#selectBankRow");
            const qrisImageRow = document.querySelector("#qrisImageRow");

            function togglePaymentMethod() {
                if (manualTransferRadio.checked) {
                    selectBankRow.style.display = "flex";
                    qrisImageRow.style.display = "none";
                } else if (qrisRadio.checked) {
                    selectBankRow.style.display = "none";
                    qrisImageRow.style.display = "flex";
                }
            }

            manualTransferRadio.addEventListener(
                "change",
                togglePaymentMethod
            );
            qrisRadio.addEventListener("change", togglePaymentMethod);

            togglePaymentMethod();
        });
    </script>
@endsection
