@extends('layouts.partials.sidebar')

@section('title')
    Ebengkelku | Create Product
@stop
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
        content: 'Click to upload';
        display: block;
        font-size: 14px;
        color: #999;
    }
</style>
@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <h4>Add Product</h4>
        <form action="{{ route('profile.workshop.createProduct.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_bengkel" value="{{ $id_bengkel }}">
            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="id_kategori_spare_part" id="id_kategori_spare_part" class="did-floating-select">
                        <option value="" selected disabled hidden>Pilih Jenis</option>
                        @foreach ($kategoriSparePart as $kategori)
                            <option value="{{ $kategori->id_kategori_spare_part }}">
                                {{ $kategori->nama_kategori_spare_part }}
                            </option>
                        @endforeach
                    </select>
                    <label class="did-floating-label">Pilih Jenis Product</label>
                </div>
            </div>


            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="kualitas_produk" id="kualitas_produk" class="did-floating-select">
                        <option value="" selected disabled hidden>Pilih Kualitas</option>
                        <option value="original">Original</option>
                        <option value="aftermarket">Aftermarket</option>
                        <option value="kw">KW</option>
                    </select>
                    <label class="did-floating-label">Pilih Kualitas Product</label>
                </div>
            </div>


            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder=" " id="merk_produk" name="merk_produk"
                        required />
                    <label class="did-floating-label">Merk Product</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder=" " id="nama_produk" name="nama_produk"
                        required />
                    <label class="did-floating-label">Nama Product</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder=" " id="harga_produk" name="harga_produk"
                        required pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                    <label class="did-floating-label">Harga Product</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <textarea class="did-floating-input" placeholder=" " id="keterangan_produk" name="keterangan_produk" required
                        style="height: 100px!important;resize: none"></textarea>
                    <label class="did-floating-label">Keterangan Product</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="upload-box">
                    <label for="foto_produk" class="upload-label">Product Photo</label>
                    <input type="file" class="file-input" name="foto_produk" id="foto_produk"
                        onchange="previewImage('foto_produk', 'sparepart')">
                    <div class="preview-container d-flex justify-content-center">
                        <img id="sparepart" src="" alt="Workshop Photo Preview" class="image-preview"
                            style="display: none; width: 200px; margin-top: 10px;">
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="number" placeholder=" " id="stok_produk" name="stok_produk"
                        required />
                    <label class="did-floating-label">Stok Product</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('profile.workshop.detail', ['id_bengkel' => $bengkel->id_bengkel]) }}" class="btn btn-danger"
                title="detail">
                Back
            </a>
        </form>

    </div>

    <script>
        function previewImage(inputId, previewId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // Show the image preview
                };

                reader.readAsDataURL(input.files[0]); // Read the image file as a data URL
            } else {
                preview.style.display = 'none'; // Hide the preview if no file is selected
                preview.src = ''; // Clear the source
            }
        }
    </script>
@endsection
