@extends('pos.layouts.app')

@section('title')
    eBengkelku | POS
@stop

@php
    $header = 'Edit Order and Invoice';
@endphp

@section('content')
    <div class="container">
        <form action="{{ route('pos.order-online.update', ['id_bengkel' => $bengkel->id_bengkel, 'order_id' => $order->order_id]) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="status_order">Status Order</label>
                <select name="status_order" id="status_order" class="form-control" required>
                    <option value="PENDING" {{ $order->status_order == 'PENDING' ? 'selected' : '' }}>Pending</option>
                    <option value="Waiting_Confirmation" {{ $order->status_order == 'Waiting_Confirmation' ? 'selected' : '' }}>Waiting Confirmation</option>
                    <option value="DIKEMAS" {{ $order->status_order == 'DIKEMAS' ? 'selected' : '' }}>Dikemas</option>
                    <option value="DIKIRIM" {{ $order->status_order == 'DIKIRIM' ? 'selected' : '' }}>Dikirim</option>
                    <option value="SELESAI" {{ $order->status_order == 'SELESAI' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status_invoice">Status Invoice</label>
                <select name="status_invoice" id="status_invoice" class="form-control" required>
                    <option value="PENDING" {{ $order->invoice->status_invoice == 'PENDING' ? 'selected' : '' }}>Pending</option>
                    <option value="Waiting_Confirmation" {{ $order->invoice->status_invoice == 'Waiting_Confirmation' ? 'selected' : '' }}>Waiting Confirmation</option>
                    <option value="PAYMENT_CONFIRMED" {{ $order->invoice->status_invoice == 'PAYMENT_CONFIRMED' ? 'selected' : '' }}>Payment Confirmed</option>
                </select>
            </div>

            <!-- Info Pelanggan -->
            <div class="form-group">
                <label for="pelanggan">Nama Pelanggan</label>
                <input type="text" id="pelanggan" class="form-control" value="{{ $order->pelanggan->nama_pelanggan }}" disabled>
            </div>

            <div class="form-group">
                <label for="alamat_pengiriman">Alamat Pengiriman</label>
                <textarea id="alamat_pengiriman" class="form-control" style="resize: none; height: 100px !important;" disabled>{{ $order->alamat_pengiriman }}</textarea>
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
                                    @if($item->id_produk)
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
                <input type="text" id="total_harga" class="form-control" value="{{ formatRupiah($order->total_harga) }}" disabled>
            </div>

            <div class="form-group">
                <label for="total_harga">Grand Total</label>
                <input type="text" id="grand_total" class="form-control" value="{{ formatRupiah($order->grand_total) }}" disabled>
            </div>

            <!-- Info Invoice -->
            <div class="form-group">
                <label for="jatuh_tempo">Jatuh Tempo</label>
                <input type="text" id="jatuh_tempo" class="form-control" value="{{ $order->invoice->jatuh_tempo }}" disabled>
            </div>

            <div class="form-group">
                <label for="tanggal_invoice">Tanggal Invoice</label>
                <input type="text" id="tanggal_invoice" class="form-control" value="{{ $order->invoice->tanggal_invoice }}" disabled>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
