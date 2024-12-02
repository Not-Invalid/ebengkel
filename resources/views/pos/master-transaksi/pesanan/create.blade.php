@extends('pos.layouts.app')
@section('title')
    eBengkelku | Master POS
@stop
@php
    $header = 'Master POS';
@endphp
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="text-danger">
                * Indicated required fields
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('pos.tranksaksi_pesanan.store', ['id_bengkel' => $bengkel->id_bengkel]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_bengkel" value="{{ $bengkel->id_bengkel }}">

                <div class="form-group">
                    <label for="tgl_pesanan">Tanggal Pesanan <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="tgl_pesanan" required>
                </div>
                <div class="form-group">
                    <label for="nama_pemesan">Nama Pemesan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama_pemesan" required>
                </div>
                <div class="form-group">
                    <label for="telp_pelanggan">No Telp <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" name="telp_pelanggan" required
                        oninput="validatePhoneNumber(this)" maxlength="15">
                </div>
                <div class="form-group">
                    <label for="nama_service">Nama Service <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama_service" required>
                </div>
                <div class="form-group">
                    <label for="status">Status Pesanan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="status" required>
                </div>
                <div class="form-group">
                    <label for="total_pesanan">Total Pesanan <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="total_pesanan" required>
                </div>
                <div class="d-flex gap-2 justify-content-end">
                    <button type="submit" class="btn btn-custom-icon">Submit</button>
                    <a href="{{ route('pos.tranksaksi_pesanan.index', ['id_bengkel' => $bengkel->id_bengkel]) }}"
                        class="btn btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Validasi Nomor Telepon
        function validatePhoneNumber(input) {
            // Hapus karakter selain angka
            input.value = input.value.replace(/[^0-9]/g, '');

            // Batasi panjang hingga 15 digit
            if (input.value.length > 15) {
                input.value = input.value.slice(0, 15);
            }
        }
    </script>
@endsection
