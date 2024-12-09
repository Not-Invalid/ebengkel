@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/payment.css') }}">
@endpush

@section('title')
    eBengkelku | Payment
@stop

<style>
    .image-preview {
      border: 1px solid #ddd;
      border-radius: 5px;
      max-height: 200px;
    }

    .upload-box {
      border: 2px dashed var(--main-light-blue);
      border-radius: 8px;
      padding: 20px;
      text-align: center;
      transition: background-color 0.2s;
      cursor: pointer;
    }

    .upload-box:hover {
      background-color: #f9f9f9;
    }

    .upload-label {
      font-size: 16px;
      color: #555;
      margin-bottom: 10px;
      display: block;
    }

    .file-input {
      opacity: 0;
      position: absolute;
      z-index: -1;
    }

    .upload-box::after {
      content: 'Click to upload';
      display: block;
      font-size: 14px;
      color: #999;
    }

    .section-title {
      font-size: 16px;
      font-weight: 600;
      margin-bottom: 8px;
      display: block;
    }

    .options-group {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
    }

    .option-item {
      display: flex;
      align-items: center;
      padding: 8px 12px;
      border: 1px solid var(--main-light-blue);
      border-radius: 6px;
      background-color: var(--main-white);
      cursor: pointer;
      transition: background-color 0.2s, border-color 0.2s;
    }

    .option-item input {
      display: none;
    }

    .option-item span {
      font-size: 14px;
    }

    .option-item:hover {
      background-color: var(--main-white);
    }

    .option-item input:checked+span {
      color: var(--main-blue);
      font-weight: 500;
    }

    .option-item input:checked~.option-item {
      color: var(--main-blue);
      font-weight: 500;
    }

    .btn.btn-custom-2 {
      padding: 0.3rem 0.8rem !important;
      border-radius: 4px !important;
      font-size: 0.8rem !important;
      background-color: var(--main-blue) !important;
      color: var(--main-white) !important;
    }
</style>

@section('content')

    <section class="section section-white"
        style="position: relative; overflow: hidden; padding-top: 100px; padding-bottom: 20px;">
        <div
            style="background-image: url('{{ asset('assets/images/bg/wallpaper.png') }}'); background-size: cover; background-position: center; background-attachment: fixed; background-repeat: no-repeat; position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0;">
        </div>
        <div class="bg-white" style="position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0; opacity: 0.7;">
        </div>
    </section>

    <section>
        <div class="container my-5">
            <div class="row">
                <!-- Left Column: Payment Method and Billing Details -->
                <div class="col-md-8">
                    <h3 class="my-2">Checkout</h3>

                    <!-- Payment Method -->
                    <div class="row my-1">
                        @if(!empty($paymentMethods))
                            @php
                                // Check if manual transfer and QRIS exist
                                $hasManualTransfer = in_array('Manual Transfer', $paymentMethods);
                                $hasQRIS = in_array('QRIS', $paymentMethods);
                            @endphp

                            <!-- Only show Manual Transfer if it exists -->
                            @if($hasManualTransfer)
                                <div class="col-md-6">
                                    <div class="payment-method d-flex align-items-center justify-content-between border p-3">
                                        <label class="form-check-label d-flex align-items-center w-100" for="manualTransfer">
                                            <input class="form-check-input me-2" type="radio" name="paymentMethod" id="manualTransfer" />
                                            <i class="fas fa-university me-2"></i> Manual Transfer
                                        </label>
                                    </div>
                                </div>
                            @endif

                            <!-- Only show QRIS if it exists -->
                            @if($hasQRIS)
                                <div class="col-md-6">
                                    <div class="payment-method d-flex align-items-center justify-content-between border p-3">
                                        <label class="form-check-label d-flex align-items-center w-100" for="qris">
                                            <input class="form-check-input me-2" type="radio" name="paymentMethod" id="qris" />
                                            <i class="fas fa-qrcode me-2"></i> QRIS
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @else
                            <p>No payment methods available.</p>
                        @endif
                    </div>

                    <!-- Select Bank for Manual Transfer (if applicable) -->
                    @if(!empty($rekeningBank) && $hasManualTransfer)
                        <div class="row my-1" id="selectBankRow" style="display: none;">
                            <div class="col-md-6">
                                <label for="paymentMethod" class="form-label">Select Bank</label>
                                <select class="form-select" id="paymentMethod" name="paymentMethod">
                                    @foreach($rekeningBank as $rekening)
                                        <option value="{{ $rekening['nama_bank'] }}">
                                            {{ $rekening['nama_bank'] }} - {{ $rekening['atas_nama'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="accountNumber" class="form-label">Account Number</label>
                                <input type="text" class="form-control" id="accountNumber" name="accountNumber" value="{{ $rekening['no_rekening'] }}" readonly />
                            </div>
                        </div>
                    @else
                        <p>No bank details available.</p>
                    @endif

                    <!-- QRIS: QR Code Image Row (if applicable) -->
                    @if($hasQRIS)
                        <div class="row" id="qrisImageRow" style="display: none;">
                            <div class="col-md-12 text-center border">
                                <label for="qrisImage" class="form-label-qris">Scan QRIS</label>
                                <img src="{{ $bengkel->qris_qrcode }}" alt="QRIS Code" class="img-fluid border" id="qrisImage" />
                            </div>
                        </div>
                    @endif

                    <div class="form my-3">
                        <h4>Billing Details</h4>
                        <form method="POST" action="{{ route('payment.store', ['order_id' => $order->order_id, 'id' => $invoice->id]) }}" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="id" value="{{ $invoice->id }}">
                            <input type="hidden" name="jenis_pembayaran" id="jenis_pembayaran">

                            <div class="form-group my-3">
                                <div class="did-floating-label-content">
                                    <input class="did-floating-input" type="text" placeholder=" " id="status_invoice" name="status_invoice"
                                        value="{{ old('status_invoice', $invoice->status_invoice ?? 'PENDING') }}" readonly />
                                    <label class="did-floating-label">Status Invoice</label>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="did-floating-label-content">
                                    <input class="did-floating-input" type="date" placeholder=" " id="jatuh_tempo" name="jatuh_tempo"
                                        value="{{ old('jatuh_tempo', \Carbon\Carbon::parse($order->tanggal)->addDay(1)->toDateString()) }}" readonly />
                                    <label class="did-floating-label">Jatuh Tempo</label>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="did-floating-label-content">
                                    <input class="did-floating-input" type="text" placeholder=" " id="nama_rekening" name="nama_rekening" required/>
                                    <label class="did-floating-label">Nama Rekening<span class="text-danger">*</span></label>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="did-floating-label-content">
                                    <input class="did-floating-input" type="text" placeholder=" " id="no_rekening" name="no_rekening" required />
                                    <label class="did-floating-label">No Rekening<span class="text-danger">*</span></label>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="did-floating-label-content">
                                    <input class="did-floating-input" type="text" placeholder=" " id="nominal_transfer" name="nominal_transfer"
                                        value="{{ old('grand_total', formatRupiah($order->grand_total)) }}" readonly />
                                    <label class="did-floating-label">Nominal Transfer</label>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="did-floating-label-content">
                                  <textarea class="did-floating-input form-control" name="note" placeholder=" " rows="4"
                                    style="height: 100px;resize: none"></textarea>
                                  <label class="did-floating-label">Note</label>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <div class="upload-box">
                                    <label for="bukti_bayar" class="upload-label">Bukti Bayar<span class="text-danger">*</span></label>
                                    <input type="file" class="file-input" name="bukti_bayar" id="bukti_bayar"
                                        onchange="previewImage('bukti_bayar', 'buktiBayarPreview')" required>
                                    <div class="preview-container d-flex justify-content-center">
                                        <img id="buktiBayarPreview" src="" alt="Bukti Bayar Preview" class="image-preview"
                                            style="display: none; width: 200px; margin-top: 10px;">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-payment w-100 mt-3" {{ $isDueDatePassed ? 'disabled' : '' }}>
                                Proceed With Payment
                            </button>
                        </form>
                    </div>

                </div>


                <!-- Right Column: Order Summary -->
                <div class="col-md-4">
                    <div class="order-summary">
                        <h4>Order Summary</h4>
                        <ul class="order-list-unstyled">
                            @foreach($order->orderItems as $item)
                                @if($item->id_produk)
                                    <li class="d-flex justify-content-between my-3">
                                        <span>{{ $item->qty }}x {{ $item->produk ? $item->produk->nama_produk : 'Produk tidak ditemukan' }}</span>
                                        <span>{{ formatRupiah($item->harga) }}</span>
                                    </li>
                                @elseif($item->id_spare_part)
                                    <li class="d-flex justify-content-between my-3">
                                        <span>{{ $item->qty }}x {{ $item->sparepart ? $item->sparepart->nama_spare_part : 'Sparepart tidak ditemukan' }}</span>
                                        <span>{{ formatRupiah($item->harga) }}</span>
                                    </li>
                                @endif
                            @endforeach
                        </ul>

                        <hr>
                        <div class="d-flex justify-content-between">
                            <span>Shipping Price</span>
                            <span>{{ formatRupiah($order->biaya_pengiriman) }}</span>
                        </div>
                        <hr />
                        <li class="d-flex justify-content-between my-3">
                            <span><strong>Total</strong></span>
                            <span><strong>{{ formatRupiah($order->grand_total) }}</strong></span> <!-- Tampilkan total harga order -->
                        </li>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const manualTransferRadio = document.getElementById("manualTransfer");
            const qrisRadio = document.getElementById("qris");
            const jenisPembayaranInput = document.getElementById("jenis_pembayaran");

            const selectBankRow = document.querySelector("#selectBankRow");
            const qrisImageRow = document.querySelector("#qrisImageRow");

            function togglePaymentMethod() {
                // Hide Bank selection and QRIS image by default
                if (selectBankRow) {
                    selectBankRow.style.display = "none";
                }
                if (qrisImageRow) {
                    qrisImageRow.style.display = "none";
                }

                // Show or hide based on which radio button is selected
                if (manualTransferRadio && manualTransferRadio.checked && selectBankRow) {
                    selectBankRow.style.display = "flex";
                    jenisPembayaranInput.value = 'Manual Transfer'; // Set value for jenis_pembayaran
                } else if (qrisRadio && qrisRadio.checked && qrisImageRow) {
                    qrisImageRow.style.display = "flex";
                    jenisPembayaranInput.value = 'QRIS'; // Set value for jenis_pembayaran
                }
            }

            // Listen to the changes on radio buttons
            if (manualTransferRadio) {
                manualTransferRadio.addEventListener("change", togglePaymentMethod);
            }

            if (qrisRadio) {
                qrisRadio.addEventListener("change", togglePaymentMethod);
            }

            // Ensure it's correctly displayed when page loads
            togglePaymentMethod();
        });
    </script>

<script>
    function previewImage(inputId, previewId) {
      const input = document.getElementById(inputId);
      const preview = document.getElementById(previewId);

      if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
          preview.src = e.target.result;
          preview.style.display = 'block';
        };

        reader.readAsDataURL(input.files[0]);
      } else {
        preview.style.display = 'none';
        preview.src = '';
      }
    }
  </script>
@endsection
