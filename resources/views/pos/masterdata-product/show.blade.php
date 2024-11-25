@extends('pos.layouts.app')

@section('title')
    eBengkelku | POS
@stop

@php
    $header = 'Detail Product';
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
            <h4>Detail Product</h4>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group">
                    <label for="nama_produk">Product Name</label>
                    <input type="text" class="form-control" name="nama_produk"
                        value="{{ old('nama_produk', $product->nama_produk) }}" readonly>
                </div>

                <div class="form-group">
                    <label for="id_kategori_spare_part">Product Type</label>
                    <select name="id_kategori_spare_part" class="form-control" disabled>
                        <option value="" disabled>Select Type</option>
                        @foreach ($categories as $kategori)
                            <option value="{{ $kategori->id_kategori_spare_part }}"
                                @if ($product->id_kategori_spare_part == $kategori->id_kategori_spare_part) selected @endif>
                                {{ $kategori->nama_kategori_spare_part }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="kualitas_produk">Product Quality</label>
                    <select name="kualitas_produk" class="form-control" disabled>
                        <option value="original" @if ($product->kualitas_produk == 'original') selected @endif>Original</option>
                        <option value="aftermarket" @if ($product->kualitas_produk == 'aftermarket') selected @endif>Aftermarket</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="merk_produk">Product Merk</label>
                    <input type="text" class="form-control" name="merk_produk"
                        value="{{ old('merk_produk', $product->merk_produk) }}" readonly>
                </div>

                <div class="form-group">
                    <label for="stok_produk">Product Stock</label>
                    <input type="number" class="form-control" name="stok_produk"
                        value="{{ old('stok_produk', $product->stok_produk) }}" readonly>
                </div>

                <div class="form-group">
                    <label for="harga_produk">Product Price</label>
                    <input type="text" class="form-control" name="harga_produk" id="harga_produk"
                        value="{{ old('harga_produk', $product->harga_produk) }}" readonly>
                </div>

                <div class="form-group">
                    <label for="keterangan_produk">Description</label>
                    <textarea class="form-control" name="keterangan_produk" readonly>{{ old('keterangan_produk', $product->keterangan_produk) }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <div class="upload-box">
                        <label for="foto_produk" class="upload-label">Product Photo</label>
                        <input type="file" class="file-input" name="foto_produk" id="foto_produk" readonly
                            onchange="previewImage('foto_produk', 'product')">
                        <div class="preview-container d-flex justify-content-center">
                            <img id="product" src="{{ url($product->foto_produk) }}" alt="product Photo Preview"
                                class="image-preview" style="display: block; width: 200px; margin-top: 10px;">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('pos.product.index', ['id_bengkel' => $bengkel->id_bengkel]) }}"
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
        let hargaProduk = document.getElementById('harga_produk').value;

        function formatRupiah(angka) {
            var rupiah = '';
            var angkarev = angka.toString().split('').reverse().join('');
            for (var i = 0; i < angkarev.length; i++)
                if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
            return 'Rp ' + rupiah.split('', rupiah.length - 1).reverse().join('');
        }

        document.getElementById('harga_produk').value = formatRupiah(hargaProduk);
    </script>
@endsection
