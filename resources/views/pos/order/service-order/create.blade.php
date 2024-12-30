@extends('pos.layouts.app')
@section('title')
    eBengkelku | Create Service Order
@stop
@php
    $header = 'Create Service Orders';
@endphp
@section('content')
    <div class="card">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
                <input type="hidden" name="jenis" value="offline">

                <div class="form-group">
                    <label for="tgl_pesanan">Order Date<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="tgl_pesanan" name="tgl_pesanan" readonly
                        value="{{ now()->format('Y-m-d') }}">
                </div>

                <div class="form-group">
                    <label for="nama_pemesan">Customer Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama_pemesan" required
                        value="{{ old('nama_pemesan') }}">
                </div>

                <div class="form-group">
                    <label for="telp_pelanggan">Customer Phone Number <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" name="telp_pelanggan" required
                        oninput="validatePhoneNumber(this)" maxlength="15" value="{{ old('telp_pelanggan') }}">
                </div>

                <div class="form-group">
                    <label for="nama_services">Choose Service Name <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="nama_services" id="nama_services" required
                        onchange="updateTotalOrder()">
                        <option value="" disabled selected hidden>Choose Service</option>
                        @foreach ($services as $service)
                            <option value="{{ $service->id_services }}" data-price="{{ $service->harga_services }}">
                                {{ $service->nama_services }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="total_pesanan">Total Order Price</label>
                    <input type="text" class="form-control" id="total_pesanan" name="total_pesanan" readonly>
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

        function updateTotalOrder() {
            const select = document.getElementById('nama_services');
            const selectedOption = select.options[select.selectedIndex];
            const price = selectedOption ? selectedOption.getAttribute('data-price') : 0;
            document.getElementById('total_pesanan').value = price ? price : '';
        }
    </script>
@endsection
