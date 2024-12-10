@extends('pos.layouts.app')
@section('title')
    eBengkelku | Edit Pesanan service
@stop
@php
    $header = 'Edit Pesanan Services';
@endphp
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="text-danger">
                * Indicated required fields
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('pos.tranksaksi_pesanan.update', ['id_bengkel' => $pesanan->id_bengkel]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="id_bengkel" value="{{ $pesanan->id_bengkel }}">

                <!-- Form fields -->
                <div class="form-group">
                    <label for="tgl_pesanan">Order Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="tgl_pesanan"
                        value="{{ old('tgl_pesanan', $pesanan->tgl_pesanan) }}" required>
                </div>
                <div class="form-group">
                    <label for="nama_pemesan">Order Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama_pemesan"
                        value="{{ old('nama_pemesan', $pesanan->nama_pemesan) }}" required>
                </div>
                <div class="form-group">
                    <label for="telp_pelanggan">Customer Phone Number <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" name="telp_pelanggan"
                        value="{{ old('telp_pelanggan', $pesanan->telp_pelanggan) }}" required
                        oninput="validatePhoneNumber(this)" maxlength="15">
                </div>
                <div class="form-group">
                    <label for="nama_service">Service Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama_service"
                        value="{{ old('nama_service', $pesanan->nama_service) }}" required>
                </div>
                <div class="form-group">
                    <label for="status">Order Status<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="status" value="{{ old('status', $pesanan->status) }}"
                        required>
                </div>
                <div class="form-group">
                    <label for="total_pesanan">Order Price<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="total_pesanan"
                        value="{{ old('total_pesanan', $pesanan->total_pesanan) }}" required>
                </div>
                <div class="d-flex gap-2 justify-content-end">
                    <button type="submit" class="btn btn-custom-icon">Update</button>
                    <a href="{{ route('pos.tranksaksi_pesanan.index', ['id_bengkel' => $pesanan->id_bengkel]) }}"
                        class="btn btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function validatePhoneNumber(input) {
            input.value = input.value.replace(/[^0-9]/g, '');

            if (input.value.length > 15) {
                input.value = input.value.slice(0, 15);
            }
        }
    </script>
@endsection
