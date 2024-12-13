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
            <form action="{{ route('pos.tranksaksi_pos.store', ['id_bengkel' => $bengkel->id_bengkel]) }}" method="POST">
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
                    <input type="date" class="form-control" id="tanggal" name="tanggal"
                        value="{{ now()->format('Y-m-d') }}">
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
                    <label for="harga" class="form-label">Harga (Total)</label>
                    <input type="number" class="form-control" id="harga" name="harga"
                        value="{{ $order->total_harga }}" readonly>
                </div>

                <!-- Qty -->
                <div class="mb-3">
                    <label for="qty" class="form-label">Qty (Total)</label>
                    <input type="number" class="form-control" id="qty" name="qty" value="{{ $order->total_qty }}"
                        readonly>
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
                    <label for="total_harga" class="form-label">Total Harga</label>
                    <input type="hidden" id="total_harga" name="total_harga">
                    <input type="text" class="form-control" id="total_harga_display" readonly>
                </div>

                <!-- Nominal Bayar -->
                <div class="mb-3">
                    <label for="nominal_bayar" class="form-label">Nominal Bayar</label>
                    <input type="number" class="form-control" id="nominal_bayar" name="nominal_bayar">
                </div>

                <!-- Kembali -->
                <div class="mb-3">
                    <label for="kembali" class="form-label">Kembali</label>
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
            const diskonInput = document.getElementById('diskon');
            const ppnInput = document.getElementById('ppn');
            const totalHargaInput = document.getElementById('total_harga');
            const totalHargaDisplay = document.getElementById('total_harga_display');
            const nominalBayarInput = document.getElementById('nominal_bayar');
            const kembaliInput = document.getElementById('kembali');
            const kembaliDisplay = document.getElementById('kembali_display');

            function calculateTotal() {
                const harga = parseFloat(hargaInput.value) || 0;
                const diskon = parseFloat(diskonInput.value) || 0;
                const ppn = parseFloat(ppnInput.value) || 0;

                // Perhitungan total harga
                const hargaDiskon = harga - (harga * (diskon / 100));
                const hargaTotal = hargaDiskon + (hargaDiskon * (ppn / 100));

                // Update hasil
                totalHargaInput.value = hargaTotal.toFixed(2);
                totalHargaDisplay.value = hargaTotal.toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                });
            }

            function calculateKembali() {
                const totalHarga = parseFloat(totalHargaInput.value) || 0;
                const nominalBayar = parseFloat(nominalBayarInput.value) || 0;

                const kembali = nominalBayar - totalHarga;

                // Update hasil
                kembaliInput.value = kembali.toFixed(2);
                kembaliDisplay.value = kembali.toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                });
            }

            // Event Listeners
            diskonInput.addEventListener('input', calculateTotal);
            ppnInput.addEventListener('input', calculateTotal);
            nominalBayarInput.addEventListener('input', calculateKembali);
        });
    </script>

@endsection
