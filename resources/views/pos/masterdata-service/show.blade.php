@extends('pos.layouts.app')

@section('title')
    eBengkelku | POS
@stop

@php
    $header = 'Detail Service';
@endphp
<style>
    .image-preview {
        border: 1px solid #ddd;
        border-radius: 5px;
        max-height: 200px;
    }

    .upload-box {
        border: 2px dashed var(--main-light-blue);
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        transition: background-color 0.2s;
        cursor: pointer;
    }

    .upload-box:hover {
        background-color: #f9f9f9;
    }

    .upload-label {
        font-size: 16px;
        color: #555;
        margin-bottom: 10px;
        display: block;
    }

    .file-input {
        opacity: 0;
        position: absolute;
        z-index: -1;
    }

    .upload-box::after {
        display: block;
        font-size: 14px;
        color: #999;
    }
</style>
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Detail Service</h4>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group">
                    <label for="nama_services">Service Name</label>
                    <input type="text" class="form-control" name="nama_services"
                        value="{{ old('nama_services', $service->nama_services) }}" readonly>
                </div>

                <div class="form-group">
                    <label for="harga_services">Service Price</label>
                    <input type="text" class="form-control" name="harga_services" id="harga_services"
                        value="{{ old('harga_services', $service->harga_services) }}" readonly>
                </div>

                <div class="form-group">
                    <label for="keterangan_services">Description</label>
                    <textarea class="form-control" name="keterangan_services" readonly>{{ old('keterangan_services', $service->keterangan_services) }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <div class="upload-box">
                        <label for="foto_services" class="upload-label">Service Photo</label>
                        <input type="file" class="file-input" name="foto_services" id="foto_services" readonly
                            onchange="previewImage('foto_services', 'Spare Part')">
                        <div class="preview-container d-flex justify-content-center">
                            <img id="Spare Part" src="{{ url($service->foto_services) }}" alt="Spare Part Photo Preview"
                                class="image-preview" style="display: block; width: 200px; margin-top: 10px;">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('pos.service.index', ['id_bengkel' => $bengkel->id_bengkel]) }}"
                        class="btn btn-cancel">Back</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        function previewImage(inputId, previewId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
                preview.src = '';
            }
        }
    </script>
    <script>
        let hargaProduk = document.getElementById('harga_service').value;

        function formatRupiah(angka) {
            var rupiah = '';
            var angkarev = angka.toString().split('').reverse().join('');
            for (var i = 0; i < angkarev.length; i++)
                if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
            return 'Rp ' + rupiah.split('', rupiah.length - 1).reverse().join('');
        }

        document.getElementById('harga_service').value = formatRupiah(hargaProduk);
    </script>
@endsection
