@extends('pos.layouts.app')

@section('title')
    eBengkelku | POS
@stop

@php
    $header = 'Detail Spare Part';
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
            <h4>Detail Spare Part</h4>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group">
                    <label for="nama_spare_part">Spare Part Name</label>
                    <input type="text" class="form-control" name="nama_spare_part"
                        value="{{ old('nama_spare_part', $sparepart->nama_spare_part) }}" readonly>
                </div>

                <div class="form-group">
                    <label for="id_kategori_spare_part">Spare Part Type</label>
                    <select name="id_kategori_spare_part" class="form-control" disabled>
                        <option value="" disabled>Select Type</option>
                        @foreach ($categories as $kategori)
                            <option value="{{ $kategori->id_kategori_spare_part }}"
                                @if ($sparepart->id_kategori_spare_part == $kategori->id_kategori_spare_part) selected @endif>
                                {{ $kategori->nama_kategori_spare_part }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="kualitas_spare_part">Spare Part Quality</label>
                    <select name="kualitas_spare_part" class="form-control" disabled>
                        <option value="original" @if ($sparepart->kualitas_spare_part == 'original') selected @endif>Original</option>
                        <option value="aftermarket" @if ($sparepart->kualitas_spare_part == 'aftermarket') selected @endif>Aftermarket</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="merk_spare_part">Spare Part Merk</label>
                    <input type="text" class="form-control" name="merk_spare_part"
                        value="{{ old('merk_spare_part', $sparepart->merk_spare_part) }}" readonly>
                </div>

                <div class="form-group">
                    <label for="stok_spare_part">Spare Part Stock</label>
                    <input type="number" class="form-control" name="stok_spare_part"
                        value="{{ old('stok_spare_part', $sparepart->stok_spare_part) }}" readonly>
                </div>

                <div class="form-group">
                    <label for="harga_spare_part">Spare Part Price</label>
                    <input type="text" class="form-control" name="harga_spare_part" id="harga_spare_part"
                        value="{{ old('harga_spare_part', $sparepart->harga_spare_part) }}" readonly>
                </div>

                <div class="form-group">
                    <label for="keterangan_spare_part">Description</label>
                    <textarea class="form-control" name="keterangan_spare_part" readonly>{{ old('keterangan_spare_part', $sparepart->keterangan_spare_part) }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <div class="upload-box">
                        <label for="foto_spare_part" class="upload-label">Spare Part Photo</label>
                        <input type="file" class="file-input" name="foto_spare_part" id="foto_spare_part" readonly
                            onchange="previewImage('foto_spare_part', 'Spare Part')">
                        <div class="preview-container d-flex justify-content-center">
                            <img id="Spare Part" src="{{ url($sparepart->foto_spare_part) }}" alt="Spare Part Photo Preview"
                                class="image-preview" style="display: block; width: 200px; margin-top: 10px;">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('pos.sparepart.index', ['id_bengkel' => $bengkel->id_bengkel]) }}"
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
        let hargaProduk = document.getElementById('harga_spare_part').value;

        function formatRupiah(angka) {
            var rupiah = '';
            var angkarev = angka.toString().split('').reverse().join('');
            for (var i = 0; i < angkarev.length; i++)
                if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
            return 'Rp ' + rupiah.split('', rupiah.length - 1).reverse().join('');
        }

        document.getElementById('harga_spare_part').value = formatRupiah(hargaProduk);
    </script>
@endsection
