@extends('pos.layouts.app')
@section('title')
    eBengkelku | Create Pesanan Pos
@stop
@php
    $header = 'Create Pesanan Services';
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
                    <label for="tgl_pesanan">Order Date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="tgl_pesanan" required>
                </div>
                <div class="form-group">
                    <label for="nama_pemesan">Customer Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama_pemesan" required>
                </div>
                <div class="form-group">
                    <label for="telp_pelanggan">Customer Phone Number <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" name="telp_pelanggan" required
                        oninput="validatePhoneNumber(this)" maxlength="15">
                </div>
                <div class="form-group">
                    <label for="nama_service">Pilih Nama Service <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="nama_service" id="nama_service" required>
                        <option value="" disabled selected hidden>Pilih Layanan</option>
                        @foreach ($services as $service)
                            <option value="{{ $service->nama_services }}" data-price="{{ $service->harga_services }}">
                                {{ $service->nama_services }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Order Status <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="status" id="status" required>
                        <option value="" disabled selected hidden>Pilih Order Status</option>
                        <option value="">Pending</option>
                        <option value="">Waiting List</option>
                        <option value="">Success</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="total_pesanan">Order Price<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="total_pesanan" id="total_pesanan" required>
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
        function validatePhoneNumber(input) {
            input.value = input.value.replace(/[^0-9]/g, '');

            if (input.value.length > 15) {
                input.value = input.value.slice(0, 15);
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const serviceSelect = document.getElementById('nama_service');
            const totalPesananInput = document.getElementById('total_pesanan');

            serviceSelect.addEventListener('change', function() {
                const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
                const price = selectedOption.getAttribute('data-price');

                if (price) {
                    totalPesananInput.value = price; // Set the value
                    totalPesananInput.dispatchEvent(new Event('input')); // Trigger any bound events
                } else {
                    totalPesananInput.value = ''; // Clear if no price
                }
            });
        });
    </script>

@endsection
