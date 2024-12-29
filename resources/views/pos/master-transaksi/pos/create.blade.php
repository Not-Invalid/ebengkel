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
            <form
                action="{{ route('pos.tranksaksi_pos.update', ['id_bengkel' => $bengkel->id_bengkel, 'id_order' => $order->id_order]) }}"
                method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_bengkel" value="{{ $bengkel->id_bengkel }}">

                <!-- Nama Customer -->
                <div class="mb-3">
                    <label for="nama_customer" class="form-label">Nama Customer <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nama_customer" name="nama_customer" required>
                </div>

                <!-- Tanggal -->
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                    <input type="datetime-local" class="form-control" id="tanggal" name="tanggal"
                        value="{{ now()->format('Y-m-d\TH:i') }}">
                </div>

                <div class="mb-3">
                    <label for="Items">Items </label>
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

                <!-- Harga -->
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga (Total) <span class="text-danger">*</span></label>
                    <input type="hidden" id="harga" name="harga" value="{{ $order->total_harga }}">
                    <input type="text" class="form-control" id="harga_display"
                        value="{{ number_format($order->total_harga, 0, ',', '.') }}" readonly>
                </div>

                <!-- Qty -->
                <div class="mb-3">
                    <label for="qty" class="form-label">Qty (Total) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="qty" name="qty"
                        value="{{ $order->total_qty }}" readonly>
                </div>

                <!-- Diskon -->
                <div class="mb-3">
                    <label for="diskon" class="form-label">Diskon (%)</label>
                    <input type="number" class="form-control" id="diskon" name="diskon" min="0" max="100">
                </div>

                <!-- PPN -->
                <div class="mb-3">
                    <label for="ppn" class="form-label">PPN (%)</label>
                    <input type="number" class="form-control" id="ppn" name="ppn" min="0" max="100">
                </div>

                <!-- Total Harga -->
                <div class="mb-3">
                    <label for="total_harga" class="form-label">Total Harga <span class="text-danger">*</span></label>
                    <input type="hidden" id="total_harga" name="total_harga">
                    <input type="text" class="form-control" id="total_harga_display" readonly>
                </div>

                <!-- Nominal Bayar -->
                <div class="mb-3">
                    <label for="nominal_bayar" class="form-label">Nominal Bayar <span class="text-danger">*</span></label>
                    <input type="hidden" id="nominal_bayar_hidden" name="nominal_bayar">
                    <input type="text" class="form-control" id="nominal_bayar" value="0">
                </div>

                <!-- Kembali -->
                <div class="mb-3">
                    <label for="kembali" class="form-label">Kembali <span class="text-danger">*</span></label>
                    <input type="hidden" id="kembali" name="kembali">
                    <input type="text" class="form-control" id="kembali_display" readonly>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hargaInput = document.getElementById('harga');
            const hargaDisplay = document.getElementById('harga_display');
            const diskonInput = document.getElementById('diskon');
            const ppnInput = document.getElementById('ppn');
            const totalHargaInput = document.getElementById('total_harga');
            const totalHargaDisplay = document.getElementById('total_harga_display');
            const nominalBayarInput = document.getElementById('nominal_bayar');
            const nominalBayarHidden = document.getElementById('nominal_bayar_hidden'); // Hidden input
            const kembaliInput = document.getElementById('kembali');
            const kembaliDisplay = document.getElementById('kembali_display');

            function formatRupiah(angka) {
                return angka.toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                });
            }

            function parseRupiah(value) {
                return parseFloat(value.replace(/[^,\d]/g, '').replace(',', '.')) || 0;
            }

            function calculateTotal() {
                const harga = parseRupiah(hargaDisplay.value) || 0;
                const diskon = parseFloat(diskonInput.value) || 0;
                const ppn = parseFloat(ppnInput.value) || 0;

                const hargaDiskon = harga - (harga * (diskon / 100));
                const hargaTotal = hargaDiskon + (hargaDiskon * (ppn / 100));

                totalHargaInput.value = hargaTotal.toFixed(2);
                totalHargaDisplay.value = formatRupiah(hargaTotal);
            }

            function calculateKembali() {
                const totalHarga = parseRupiah(totalHargaDisplay.value);
                const nominalBayar = parseRupiah(nominalBayarInput.value);

                const kembali = nominalBayar - totalHarga;

                kembaliInput.value = kembali.toFixed(2);
                kembaliDisplay.value = formatRupiah(kembali);
            }

            nominalBayarInput.addEventListener('input', function() {
                const nominalBayar = parseRupiah(this.value);
                nominalBayarHidden.value = nominalBayar;
                this.value = formatRupiah(nominalBayar);
                calculateKembali();
            });

            diskonInput.addEventListener('input', calculateTotal);
            ppnInput.addEventListener('input', calculateTotal);

            hargaDisplay.value = formatRupiah(parseFloat(hargaInput.value));
        });
    </script>

@endsection
