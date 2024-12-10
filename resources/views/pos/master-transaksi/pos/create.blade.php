@extends('pos.layouts.app')
@section('title')
    eBengkelku | Transaksi Pos
@stop

@php
    $header = 'Transaksi Pos';
@endphp
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="text-danger">
                * Indicated required fields
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('pos.tranksaksi_pos.storecheckout', ['id_bengkel' => $bengkel->id_bengkel]) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_bengkel" value="{{ $bengkel->id_bengkel }}">

                <!-- Nama Customer -->
                <div class="mb-3">
                    <label for="nama_customer" class="form-label">Nama Customer</label>
                    <input type="text" class="form-control" id="nama_customer" name="nama_customer" required>
                </div>

                <!-- Tanggal -->
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" required
                        value="{{ now()->format('Y-m-d') }}">
                </div>

                <!-- Tipe -->
                <div class="mb-3">
                    <label for="tipe" class="form-label">Tipe</label>
                    <select class="form-control" id="tipe" name="tipe" required>
                        <option value="produk">Produk</option>
                        <option value="spare_part">Spare Part</option>
                    </select>
                </div>

                <!-- Jenis Pembayaran -->
                <div class="mb-3">
                    <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran</label>
                    <select class="form-control" id="jenis_pembayaran" name="jenis_pembayaran" required>
                        <option value="tunai">Tunai</option>
                        <option value="kredit">Kredit</option>
                    </select>
                </div>

                <!-- Nomor Kartu (hanya jika pembayaran kredit) -->
                <div class="mb-3" id="no_kartu_group" style="display: none;">
                    <label for="no_kartu" class="form-label">Nomor Kartu</label>
                    <input type="text" class="form-control" id="no_kartu" name="no_kartu">
                </div>

                <!-- Harga -->
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga" required>
                </div>

                <!-- Diskon -->
                <div class="mb-3">
                    <label for="diskon" class="form-label">Diskon (%)</label>
                    <input type="number" class="form-control" id="diskon" name="diskon" value="0" min="0">
                </div>

                <!-- PPN -->
                <div class="mb-3">
                    <label for="ppn" class="form-label">PPN (%)</label>
                    <input type="number" class="form-control" id="ppn" name="ppn" value="0" min="0">
                </div>

                <!-- Total Harga -->
                <div class="mb-3">
                    <label for="total_harga" class="form-label">Total Harga</label>
                    <input type="text" class="form-control" id="total_harga" name="total_harga" readonly>
                </div>

                <!-- Total Qty -->
                <div class="mb-3">
                    <label for="total_qty" class="form-label">Total Quantity</label>
                    <input type="number" class="form-control" id="total_qty" name="total_qty" value="1"
                        min="1">
                </div>

                <!-- Nominal Bayar -->
                <div class="mb-3">
                    <label for="nominal_bayar" class="form-label">Nominal Bayar</label>
                    <input type="number" class="form-control" id="nominal_bayar" name="nominal_bayar" required>
                </div>

                <!-- Kembali -->
                <div class="mb-3">
                    <label for="kembali" class="form-label">Kembali</label>
                    <input type="text" class="form-control" id="kembali" name="kembali" readonly>
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <button type="submit" class="btn btn-custom-icon">Submit</button>
                    <a href="{{ route('pos.tranksaksi_pos.index', ['id_bengkel' => $bengkel->id_bengkel]) }}"
                        class="btn btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hargaInput = document.getElementById('harga');
            const diskonInput = document.getElementById('diskon');
            const ppnInput = document.getElementById('ppn');
            const totalQtyInput = document.getElementById('total_qty');
            const nominalBayarInput = document.getElementById('nominal_bayar');
            const totalHargaInput = document.getElementById('total_harga');
            const kembaliInput = document.getElementById('kembali');
            const noKartuGroup = document.getElementById('no_kartu_group');
            const jenisPembayaranSelect = document.getElementById('jenis_pembayaran');

            function hitungTotalHarga() {
                const harga = parseFloat(hargaInput.value) || 0;
                const diskon = parseFloat(diskonInput.value) || 0;
                const ppn = parseFloat(ppnInput.value) || 0;
                const qty = parseInt(totalQtyInput.value) || 1;
                let total = harga * qty;
                total -= total * (diskon / 100);
                total += total * (ppn / 100);
                totalHargaInput.value = total.toFixed(2);
            }

            function hitungKembali() {
                const totalHarga = parseFloat(totalHargaInput.value) || 0;
                const nominalBayar = parseFloat(nominalBayarInput.value) || 0;
                const kembali = nominalBayar - totalHarga;
                kembaliInput.value = kembali >= 0 ? kembali.toFixed(2) : 0;
            }
            hargaInput.addEventListener('input', hitungTotalHarga);
            diskonInput.addEventListener('input', hitungTotalHarga);
            ppnInput.addEventListener('input', hitungTotalHarga);
            totalQtyInput.addEventListener('input', hitungTotalHarga);
            nominalBayarInput.addEventListener('input', hitungKembali);
            jenisPembayaranSelect.addEventListener('change', function() {
                if (this.value === 'kredit') {
                    noKartuGroup.style.display = 'block';
                } else {
                    noKartuGroup.style.display = 'none';
                }
            });
            hitungTotalHarga();
            hitungKembali();
        });
    </script>

@endsection
