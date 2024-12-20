@extends('pos.layouts.app')

@section('title')
    eBengkelku | POS
@stop

@php
    $header = 'Edit Order and Invoice';
@endphp

@push('css')
    <style>
        .form-control:disabled:focus, .form-control[readonly]:focus {
            background-color: #e9ecef;
            opacity: 1;
        },
    </style>
@endpush

@section('content')
    <div class="container">
        <form
            action="{{ route('pos.order-online.update', ['id_bengkel' => $bengkel->id_bengkel, 'order_id' => $order->order_id]) }}"
            id="orderForm" method="POST">
            @csrf
            <div class="form-group">
                <label for="status_invoice">Status Invoice</label>
                <select name="status_invoice" id="status_invoice" class="form-control" required>
                    <option value="PENDING" {{ $order->invoice->status_invoice == 'PENDING' ? 'selected' : '' }}>Pending
                    </option>
                    <option value="Waiting_Confirmation"
                        {{ $order->invoice->status_invoice == 'Waiting_Confirmation' ? 'selected' : '' }}>Waiting
                        Confirmation</option>
                    <option value="PAYMENT_CONFIRMED"
                        {{ $order->invoice->status_invoice == 'PAYMENT_CONFIRMED' ? 'selected' : '' }}>Payment Confirmed
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="status_order">Status Order</label>
                <select name="status_order" id="status_order" class="form-control" required>
                    <option value="PENDING" {{ $order->status_order == 'PENDING' ? 'selected' : '' }}>Pending</option>
                    <option value="Waiting_Confirmation"
                        {{ $order->status_order == 'Waiting_Confirmation' ? 'selected' : '' }}>Waiting Confirmation</option>
                    <option value="DIKEMAS" {{ $order->status_order == 'DIKEMAS' ? 'selected' : '' }}>Dikemas</option>
                    <option value="DIKIRIM" {{ $order->status_order == 'DIKIRIM' ? 'selected' : '' }}>Dikirim</option>
                    <option value="SELESAI" {{ $order->status_order == 'SELESAI' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="form-group">
                <label for="nomor_resi">Nomor Resi <span class="text-danger">*</span></label>
                <input type="text" id="nomor_resi" name="nomor_resi" class="form-control" value="{{ old('nomor_resi', $order->no_resi) }}"
                @if($order->no_resi) readonly @endif>
                <p class="error-text text-danger mt-1" id="nomorResiError" style="display: none;"></p>
            </div>

            <!-- Info Pelanggan -->
            <div class="form-group">
                <label for="pelanggan">Nama Pelanggan</label>
                <input type="text" id="pelanggan" class="form-control" value="{{ $order->pelanggan->nama_pelanggan }}"
                    readonly>
            </div>

            <div class="form-group">
                <label for="alamat_pengiriman">Alamat Pengiriman</label>
                <textarea id="alamat_pengiriman" class="form-control" style="resize: none; height: 100px !important;" readonly>{{ $order->alamat_pengiriman }}</textarea>
            </div>

            <!-- Info Item Order -->
            <div class="form-group">
                <label for="order_items">Items Order</label>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Produk / Sparepart</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                            <tr>
                                <td>
                                    @if ($item->id_produk)
                                        {{ $item->produk->nama_produk }}
                                    @elseif($item->id_spare_part)
                                        {{ $item->sparepart->nama_spare_part }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ formatRupiah($item->harga) }}</td>
                                <td>{{ formatRupiah($item->subtotal) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Info Total Harga -->
            <div class="form-group">
                <label for="total_harga">Total Harga</label>
                <input type="text" id="total_harga" class="form-control" value="{{ formatRupiah($order->total_harga) }}"
                    readonly>
            </div>

            <div class="form-group">
                <label for="total_harga">Grand Total</label>
                <input type="text" id="grand_total" class="form-control" value="{{ formatRupiah($order->grand_total) }}"
                    readonly>
            </div>

            <!-- Info Invoice -->
            <div class="form-group">
                <label for="jatuh_tempo">Jatuh Tempo</label>
                <input type="text" id="jatuh_tempo" class="form-control" value="{{ $order->invoice->jatuh_tempo }}"
                    readonly>
            </div>

            <div class="form-group">
                <label for="tanggal_invoice">Tanggal Invoice</label>
                <input type="text" id="tanggal_invoice" class="form-control"
                    value="{{ $order->invoice->tanggal_invoice }}" readonly>
            </div>

            <div class="form-group">
                <label for="bukti_bayar">Bukti Pembayaran</label>
                <div class="preview-container d-flex justify-content-center">
                    <img src="{{ old('bukti_bayar', isset($order->invoice->bukti_bayar) ? asset($order->invoice->bukti_bayar) : asset('assets/images/components/image.png')) }}"
                        alt="Bukti Bayar Preview" class="image-preview"
                        style="display: block; margin-top: 10px; cursor: pointer;" id="imagePreview">
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('pos.order-online', ['id_bengkel' => $bengkel->id_bengkel]) }}" id="backButton"
                    class="btn btn-danger">Back</a>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>

    <div id="fire-modal-1" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bukti Pembayaran</h5>
                    <button type="button" class="close" id="closeModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" src="" alt="Bukti Pembayaran" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusOrderInput = document.getElementById('status_order');
            const statusOrderCurrent = "{{ $order->status_order }}"; // Ambil status order saat ini
            const statusOrderSequence = ['PENDING', 'Waiting_Confirmation', 'DIKEMAS', 'DIKIRIM', 'SELESAI']; // Urutan status yang valid

            // Fungsi untuk memeriksa apakah transisi status valid
            function isValidStatusTransition(currentStatus, newStatus) {
                const currentIndex = statusOrderSequence.indexOf(currentStatus);
                const newIndex = statusOrderSequence.indexOf(newStatus);
                return newIndex === currentIndex + 1; // Pastikan status baru adalah status berikutnya dalam urutan
            }

            // Event listener saat status order berubah
            statusOrderInput.addEventListener('change', function() {
                const newStatus = statusOrderInput.value;

                // Cek apakah transisi status valid
                if (!isValidStatusTransition(statusOrderCurrent, newStatus)) {
                    // Tampilkan pesan error menggunakan Toastr jika status tidak valid
                    toastr.error('Transisi status tidak valid. Ikuti urutan status yang benar.');

                    // Kembalikan status ke yang sebelumnya
                    statusOrderInput.value = statusOrderCurrent;
                }
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('orderForm');
            const statusOrderInput = document.getElementById('status_order');
            const nomorResiInput = document.getElementById('nomor_resi');
            const nomorResiError = document.getElementById('nomorResiError');

            const statusInvoice = document.getElementById('status_invoice');

            if (!form || !statusOrderInput || !nomorResiInput || !nomorResiError) {
                console.error("Form atau elemen yang diperlukan tidak ditemukan.");
                return;
            }

            function showError(message) {
                nomorResiError.style.display = 'block';
                nomorResiError.textContent = message;
            }

            function hideError() {
                nomorResiError.style.display = 'none';
            }


            form.addEventListener('submit', function(e) {
                const statusOrderValue = statusOrderInput.value;

                if (statusOrderValue === 'DIKIRIM' && !nomorResiInput.value.trim()) {
                    e.preventDefault();
                    showError('Nomor Resi wajib diinput ketika status order adalah DIKIRIM.');

                    nomorResiInput.focus();
                    nomorResiInput.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

                } else {
                    hideError();
                }
            });

            statusOrderInput.addEventListener('change', function() {
                if (statusOrderInput.value === 'DIKIRIM' && !nomorResiInput.value.trim()) {
                    showError('Nomor Resi wajib diisi ketika status order adalah "DIKIRIM". Pastikan tidak ada kesalahan saat menginput Nomor Resi.');
                } else {
                    hideError();
                }

                if (statusOrderInput.value !== 'DIKIRIM') {
                    nomorResiInput.disabled = true;
                } else {
                    nomorResiInput.disabled = false;
                }
            });

            if (statusOrderInput.value !== 'DIKIRIM') {
                nomorResiInput.disabled = true;
            } else {
                nomorResiInput.disabled = false;
            }

            statusInvoice.addEventListener('change', function() {
                if (statusInvoice.value !== 'PAYMENT_CONFIRMED') {
                    statusOrderInput.disabled = true;
                } else {
                    statusOrderInput.disabled = false;
                }
            });

            if (statusInvoice.value !== 'PAYMENT_CONFIRMED') {
                statusOrderInput.disabled = true;
            } else {
                statusOrderInput.disabled = false;
            }
        });
    </script>

    <script>
        const imagePreview = document.getElementById('imagePreview');
        const modal = document.getElementById('fire-modal-1');
        const modalImage = document.getElementById('modalImage');
        const closeModal = document.getElementById('closeModal');
        const closeModalFooter = document.getElementById('closeModalFooter');

        function openModal(imageSrc) {
            modal.style.display = 'block';
            modal.classList.add('show');
            modal.setAttribute('aria-hidden', 'false');
            modalImage.src = imageSrc;
        }

        function closeModalFunc() {
            modal.classList.remove('show');
            modal.setAttribute('aria-hidden', 'true');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        imagePreview.addEventListener('click', function() {
            const imageSrc = this.src;
            openModal(imageSrc);
        });

        closeModal.addEventListener('click', closeModalFunc);
        closeModalFooter.addEventListener('click', closeModalFunc);

        window.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModalFunc();
            }
        });
    </script>

@endsection
