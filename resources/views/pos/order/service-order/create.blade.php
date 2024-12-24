@extends('pos.layouts.app')
@section('title')
    eBengkelku | Create Service Order
@stop
@php
    $header = 'Create Service Orders';
@endphp
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="text-danger">
                * Indicated required fields
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('pos.service-order.store', ['id_bengkel' => $bengkel->id_bengkel]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_bengkel" value="{{ $bengkel->id_bengkel }}">

                <div class="form-group">
                    <label for="tgl_pesanan">Order Date<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="tgl_pesanan" name="tgl_pesanan" readonly
                        value="{{ now()->format('Y-m-d') }}">
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
                            <option value="{{ $service->nama_services }}" data-price="{{ $service->harga_services }}"
                                data-online="{{ $service->jumlah_services_online }}"
                                data-offline="{{ $service->jumlah_services_offline }}">
                                {{ $service->nama_services }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="service_type">Service Type <span class="text-danger">*</span></label>
                    <select class="form-control" id="service_type" name="service_type" required>
                        <option value="" disabled selected hidden>Pilih Tipe Layanan</option>
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                    </select>
                </div>

                <input type="hidden" name="status" id="status">

                <div class="form-group">
                    <label for="total_pesanan">Order Price<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="total_pesanan" id="total_pesanan" readonly>
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <button type="submit" class="btn btn-custom-icon">Submit</button>
                    <a href="{{ route('pos.service-order', ['id_bengkel' => $bengkel->id_bengkel]) }}"
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
            const form = document.querySelector('form');
            const serviceSelect = document.getElementById('nama_service');
            const serviceTypeSelect = document.getElementById('service_type');
            const totalPesananInput = document.getElementById('total_pesanan');
            const statusInput = document.getElementById('status');
            const submitButton = document.querySelector('button[type="submit"]');

            function checkStockAndUpdateUI() {
                const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
                const serviceType = serviceTypeSelect.value;
                if (selectedOption && serviceType) {
                    const availableStock = serviceType === 'online' ?
                        parseInt(selectedOption.dataset.online) :
                        parseInt(selectedOption.dataset.offline);
                    if (selectedOption.dataset.price) {
                        totalPesananInput.value = parseFloat(selectedOption.dataset.price);
                    }
                    if (availableStock > 0) {
                        statusInput.value = 'pending';
                        submitButton.disabled = false;
                    } else {
                        statusInput.value = 'waiting';
                        submitButton.disabled = false;
                    }
                } else {
                    resetForm();
                }
            }

            function resetForm() {
                totalPesananInput.value = '';
                statusInput.value = '';
                submitButton.disabled = true;
            }
            if (serviceSelect) {
                serviceSelect.addEventListener('change', checkStockAndUpdateUI);
            }
            if (serviceTypeSelect) {
                serviceTypeSelect.addEventListener('change', checkStockAndUpdateUI);
            }
            if (typeof jQuery !== 'undefined' && typeof jQuery.fn.select2 !== 'undefined') {
                jQuery('.select2').select2().on('select2:select', checkStockAndUpdateUI);
            }
            form.addEventListener('submit', function(e) {
                const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
                const serviceType = serviceTypeSelect.value;
                if (selectedOption && serviceType) {
                    const availableStock = serviceType === 'online' ?
                        parseInt(selectedOption.dataset.online) :
                        parseInt(selectedOption.dataset.offline);
                    if (availableStock <= 0) {
                        if (!confirm(
                                'This service is currently out of stock. Do you want to be added to the waiting list?'
                            )) {
                            e.preventDefault();
                            return false;
                        }
                    }
                }
            });
            resetForm();
        });
    </script>

@endsection
