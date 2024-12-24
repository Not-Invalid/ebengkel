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
    .shipping:hover {
        background-color: var(--main-light-grey) !important;
        color: var(--main-dark-blue) !important;
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
    <h3 class="my-2">Checkout</h3>
    <div class="row">
        <div class="col-md-8">
            <div class="cart-summary">
                <h5 class="mb-3 fs-5">Shipping Info</h5>

                <!-- Address Dropdown -->
                <div class="mb-3">
                    <div class="address-display border p-3">
                        <p class="mb-0 fw-bold">
                            {{ $order->atas_nama }} | {{ $order->no_telp }}</p>
                        <p class="mb-0 text-muted" style="font-size: 14px;">
                            {{ $order->alamat_pengiriman }}<br>
                            <br>
                        </p>
                    </div>
                </div>


                <!-- Shipping Options Dropdown -->
                <div class="dropdown border">
                    <button class="btn btn-outline-border dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center"
                            type="button" id="shippingOptionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div>
                            <p class="mb-0 fw-bold" id="selectedShippingName">Pilih Jasa</p>
                            <p class="mb-0 text-muted" id="selectedShippingCourier" style="font-size: 14px;"></p>
                            <p class="mb-0 text-muted" style="font-size: 12px;" id="deliveryDate"></p>
                        </div>
                        <div class="text-end">
                            <p class="mb-0 fw-bold" id="selectedShippingPrice">Rp 0</p>
                        </div>
                    </button>
                    <ul class="dropdown-menu w-100" aria-labelledby="shippingOptionsDropdown" style="z-index: 1050;">
                        @if(!empty($courierOptions))
                            @foreach ($courierOptions as $option)
                                <li>
                                    <a class="dropdown-item shipping"
                                    data-shipping="{{ $option['service'] }}"
                                    data-price="{{ $option['cost'] }}"
                                    data-courier="{{ $option['courier'] }}"
                                    data-time="{{ $option['delivery_time'] }}"
                                    onclick="updateShipping('{{ $option['description'] }}', {{ $option['cost'] }}, '{{ $option['courier'] }}', '{{ $option['delivery_time'] }}')">
                                        <strong>{{ $option['description'] }}</strong>
                                        (Rp {{ number_format($option['cost'], 0, ',', '.') }}) -
                                        <span>{{ $option['courier'] }}</span><br>
                                        <small>Delivery Time: {{ $option['delivery_time'] }} days</small>
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <p class="ms-2">No shipping options available.</p>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="row my-3">
                <h5 class="mb-3 fs-5">Payment Methods</h5>
                @if(!empty($paymentMethods))
                    @php
                        $hasManualTransfer = in_array('Manual Transfer', $paymentMethods);
                    @endphp

                    @if($hasManualTransfer)
                        <div class="col">
                            <div class="payment-method d-flex align-items-center justify-content-between border p-3">
                                <label class="form-check-label d-flex align-items-center w-100" for="manualTransfer">
                                    <input class="form-check-input me-2" type="radio" name="paymentMethod" id="manualTransfer" />
                                    <i class="fas fa-university me-2"></i> Manual Transfer
                                </label>
                            </div>
                        </div>
                    @endif
                @else
                    <p>No payment methods available.</p>
                @endif
            </div>

            @if(!empty($rekeningBank) && $hasManualTransfer)
                <div class="row my-3" id="selectBankRow" style="display: none;">
                    <div class="col">
                        <div class="did-floating-label-content">
                            <select class="did-floating-input" id="bank_tujuan" name="bank_tujuan">
                                <option value="" disabled selected>Select Destination Bank</option>
                                @foreach($rekeningBank as $rekening)
                                    <option value="{{ $rekening['nama_bank'] }}" data-rekening="{{ $rekening['no_rekening'] }}">
                                        {{ $rekening['nama_bank'] }} - {{ $rekening['atas_nama'] }}
                                    </option>
                                @endforeach
                            </select>
                            <label class="did-floating-label">Destination Bank<span class="text-danger">*</span></label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="text" class="form-control" id="accountNumber" name="accountNumber" value="" readonly  />
                            <label class="did-floating-label">Bank Account Number</label>
                        </div>
                    </div>
                </div>
            @endif

            <div class="form my-3">
                <h5 class="mb-3 fs-5">Billing Details</h5>
                <form method="POST" action="{{ route('payment.store', ['order_id' => $order->order_id, 'id' => $invoice->id]) }}" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{ $invoice->id }}">
                    <input type="hidden" id="order_id" value="{{ $order->order_id }}">
                    <input type="hidden" name="jenis_pembayaran" id="jenis_pembayaran">
                    <input type="hidden" name="bank_tujuan" id="hiddenBankTujuan">
                    <input type="hidden" name="shipping_method" id="shipping_method">
                    <input type="hidden" name="shipping_courier" id="shipping_courier">
                    <input type="hidden" name="shipping_cost" id="shipping_cost">

                    <div class="form-group mb-3">
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

                    <div class="form-group mb-3" id="namaRekeningGroup">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="text" placeholder=" " id="nama_rekening" name="nama_rekening" />
                            <label class="did-floating-label">Nama Rekening Pembeli<span class="text-danger">*</span></label>
                        </div>
                    </div>

                    <div class="form-group mb-3" id="noRekeningGroup">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="text" placeholder=" " id="no_rekening" name="no_rekening" />
                            <label class="did-floating-label">No Rekening Pembeli<span class="text-danger">*</span></label>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="text" placeholder=" " id="nominal_transfer" name="nominal_transfer"
                                value="" readonly />
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
                <li class="d-flex justify-content-between my-3">
                    <span><strong>Total</strong></span>
                    <span id="orderSubtotal" value="{{ $order->total_harga }}"><strong>{{ formatRupiah($order->total_harga) }}</strong></span>
                </li>
                <li class="d-flex justify-content-between my-3">
                    <span><strong>Shipping Price</strong></span>
                    <span id="orderSummaryShippingPrice">Rp 0</span>
                </li>
                <li class="d-flex justify-content-between my-3">
                    <span><strong>Grand Total</strong></span>
                    <span id="grandTotal"><strong>Rp 0</strong></span>
                </li>
            </div>
        </div>



    </div>
</div>
</section>

<script>
    document.getElementById('no_rekening').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function formatRupiahJS(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function updateShipping(serviceDescription, price, courier, deliveryTime) {
        // Update UI elements with service description
        document.getElementById("selectedShippingName").innerText = serviceDescription;
        document.getElementById("selectedShippingCourier").innerText = courier;
        document.getElementById("deliveryDate").innerText = 'Delivery Time: ' + deliveryTime + ' days';
        document.getElementById("selectedShippingPrice").innerHTML = `<strong>${formatRupiahJS(price)}</strong>`;
        document.getElementById("orderSummaryShippingPrice").innerHTML = `<strong>${formatRupiahJS(price)}</strong>`;

        // Update the hidden form fields
        document.getElementById("shipping_method").value = serviceDescription;
        document.getElementById("shipping_courier").value = courier;
        document.getElementById("shipping_cost").value = price;

        // Calculate and update the grand total
        var orderSubtotal = parseInt(document.getElementById("orderSubtotal").getAttribute("value")) || 0;
        var grandTotal = orderSubtotal + price;
        document.getElementById("grandTotal").innerHTML = `<strong>${formatRupiahJS(grandTotal)}</strong>`;
        document.getElementById("nominal_transfer").value = formatRupiahJS(grandTotal);
    }


    window.onload = function() {
        const subtotal = parseInt(document.getElementById('orderSubtotal').getAttribute('value')) || 0;
        const grandTotal = subtotal;

        document.getElementById('grandTotal').innerHTML = `<strong>${formatRupiahJS(grandTotal)}</strong>`;

        document.getElementById('nominal_transfer').value = formatRupiahJS(grandTotal);
    };


</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const manualTransferRadio = document .getElementById("manualTransfer");
    const jenisPembayaranInput = document.getElementById("jenis_pembayaran");
    const hiddenBankTujuan = document.getElementById("hiddenBankTujuan");
    const selectBankRow = document.querySelector("#selectBankRow");
    const bankTujuanSelect = document.getElementById("bank_tujuan");
    const accountNumberInput = document.getElementById("accountNumber");

    const namaRekeningGroup = document.getElementById("namaRekeningGroup");
    const noRekeningGroup = document.getElementById("noRekeningGroup");

    function togglePaymentMethod() {
        if (selectBankRow) {
            selectBankRow.style.display = "none";
        }

        if (namaRekeningGroup) {
            namaRekeningGroup.style.display = "none";
        }
        if (noRekeningGroup) {
            noRekeningGroup.style.display = "none";
        }

        if (manualTransferRadio && manualTransferRadio.checked) {
            selectBankRow.style.display = "flex";
            jenisPembayaranInput.value = 'Manual Transfer';
            if (namaRekeningGroup) {
                namaRekeningGroup.style.display = "block";
            }
            if (noRekeningGroup) {
                noRekeningGroup.style.display = "block";
            }
        }
    }

    if (manualTransferRadio) {
        manualTransferRadio.addEventListener("change", togglePaymentMethod);
    }

    togglePaymentMethod();

    if (bankTujuanSelect) {
        bankTujuanSelect.addEventListener("change", function() {
            const selectedOption = bankTujuanSelect.options[bankTujuanSelect.selectedIndex];
            const rekening = selectedOption.getAttribute("data-rekening");
            hiddenBankTujuan.value = bankTujuanSelect.value;

            if (rekening) {
                accountNumberInput.value = rekening;
            } else {
                accountNumberInput.value = '';
            }
        });
    }
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
