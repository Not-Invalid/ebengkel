@extends('pos.layouts.app')

@section('title')
  eBengkelku | POS
@stop

@php
  $header = 'Edit Product';
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
    content: 'Click to upload';
    display: block;
    font-size: 14px;
    color: #999;
  }

  .hidden {
    display: none !important;
  }

  .image-preview-container {
    display: flex;
    gap: 15px;
    justify-content: space-between;
    flex-wrap: wrap;
  }

  .image-preview-container img {
    width: 100px;
    height: auto;
  }
</style>

@section('content')
  <div class="card">
    <div class="card-header">
      <h4 class="text-danger">
        * Indicated required fields
      </h4>
    </div>
    <div class="card-body">
      <form
        action="{{ route('pos.product.update', ['id_bengkel' => $bengkel->id_bengkel, 'id_produk' => $product->id_produk]) }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="id_bengkel" value="{{ $bengkel->id_bengkel }}">

        <!-- Product Name -->
        <div class="form-group">
          <label for="nama_produk">Product Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="nama_produk"
            value="{{ old('nama_produk', $product->nama_produk) }}" required>
        </div>

        <!-- Product Category -->
        <div class="form-group">
          <label for="id_kategori_spare_part">Product Type <span class="text-danger">*</span></label>
          <select name="id_kategori_spare_part" class="form-control" required>
            <option value="" disabled>Select Type</option>
            @foreach ($categories as $kategori)
              <option value="{{ $kategori->id_kategori_spare_part }}" @if ($product->id_kategori_spare_part == $kategori->id_kategori_spare_part) selected @endif>
                {{ $kategori->nama_kategori_spare_part }}
              </option>
            @endforeach
          </select>
        </div>

        <!-- Product Quality -->
        <div class="form-group">
          <label for="kualitas_produk">Product Quality <span class="text-danger">*</span></label>
          <select name="kualitas_produk" class="form-control" required>
            <option value="original" @if ($product->kualitas_produk == 'original') selected @endif>Original</option>
            <option value="aftermarket" @if ($product->kualitas_produk == 'aftermarket') selected @endif>Aftermarket</option>
          </select>
        </div>

        <!-- Other fields -->
        <div class="form-group">
          <label for="merk_produk">Product Merk <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="merk_produk"
            value="{{ old('merk_produk', $product->merk_produk) }}" required>
        </div>

        <div class="form-group">
          <label for="stok_produk">Product Stock <span class="text-danger">*</span></label>
          <input type="number" class="form-control" name="stok_produk"
            value="{{ old('stok_produk', $product->stok_produk) }}" readonly>
        </div>

        <div class="form-group">
          <label for="harga_produk">Product Price <span class="text-danger">*</span></label>
          <input type="number" class="form-control" name="harga_produk"
            value="{{ old('harga_produk', $product->harga_produk) }}" required>
        </div>

        <div class="form-group">
          <label for="keterangan_produk">Description</label>
          <textarea class="form-control" style="resize: none; height: 100px !important;" name="keterangan_produk">{{ old('keterangan_produk', $product->keterangan_produk) }}</textarea>
        </div>

        <!-- Product Photos -->
        <div class="form-group">
          <div class="upload-box">
            <label for="foto_produk_1" class="upload-label">Product Photo 1</label>
            <input type="file" class="file-input" name="foto_produk_1" id="foto_produk_1"
              onchange="previewImage('foto_produk_1', 'preview_1')">

            <div class="preview-container d-flex justify-content-center">
              <img id="preview_1"
                src="{{ old('foto_produk_1', isset($fotoProduk->file_foto_produk_1) ? asset($fotoProduk->file_foto_produk_1) : asset('assets/images/components/image.png')) }}"
                alt="Product Photo Preview" class="image-preview" style="display: block; width: 200px; margin-top: 10px;">
            </div>
          </div>
        </div>
        <!-- Product Photo 2 -->
        <div class="form-group">
          <div class="upload-box">
            <label for="foto_produk_2" class="upload-label">Product Photo 2</label>
            <input type="file" class="file-input" name="foto_produk_2" id="foto_produk_2"
              onchange="previewImage('foto_produk_2', 'preview_2')">

            <div class="preview-container d-flex justify-content-center">
              <img id="preview_2"
                src="{{ old('foto_produk_2', isset($fotoProduk->file_foto_produk_2) ? asset($fotoProduk->file_foto_produk_2) : asset('assets/images/components/image.png')) }}"
                alt="Product Photo Preview" class="image-preview" style="display: block; width: 200px; margin-top: 10px;">
            </div>
          </div>
        </div>

        <!-- Product Photo 3 -->
        <div class="form-group">
          <div class="upload-box">
            <label for="foto_produk_3" class="upload-label">Product Photo 3</label>
            <input type="file" class="file-input" name="foto_produk_3" id="foto_produk_3"
              onchange="previewImage('foto_produk_3', 'preview_3')">

            <div class="preview-container d-flex justify-content-center">
              <img id="preview_3"
                src="{{ old('foto_produk_3', isset($fotoProduk->file_foto_produk_3) ? asset($fotoProduk->file_foto_produk_3) : asset('assets/images/components/image.png')) }}"
                alt="Product Photo Preview" class="image-preview"
                style="display: block; width: 200px; margin-top: 10px;">
            </div>
          </div>
        </div>

        <!-- Product Photo 4 -->
        <div class="form-group">
          <div class="upload-box">
            <label for="foto_produk_4" class="upload-label">Product Photo 4</label>
            <input type="file" class="file-input" name="foto_produk_4" id="foto_produk_4"
              onchange="previewImage('foto_produk_4', 'preview_4')">

            <div class="preview-container d-flex justify-content-center">
              <img id="preview_4"
                src="{{ old('foto_produk_4', isset($fotoProduk->file_foto_produk_4) ? asset($fotoProduk->file_foto_produk_4) : asset('assets/images/components/image.png')) }}"
                alt="Product Photo Preview" class="image-preview"
                style="display: block; width: 200px; margin-top: 10px;">
            </div>
          </div>
        </div>

        <!-- Product Photo 5 -->
        <div class="form-group">
          <div class="upload-box">
            <label for="foto_produk_5" class="upload-label">Product Photo 5</label>
            <input type="file" class="file-input" name="foto_produk_5" id="foto_produk_5"
              onchange="previewImage('foto_produk_5', 'preview_5')">

            <div class="preview-container d-flex justify-content-center">
              <img id="preview_5"
                src="{{ old('foto_produk_5', isset($fotoProduk->file_foto_produk_5) ? asset($fotoProduk->file_foto_produk_5) : asset('assets/images/components/image.png')) }}"
                alt="Product Photo Preview" class="image-preview"
                style="display: block; width: 200px; margin-top: 10px;">
            </div>
          </div>
        </div>


        <div class="d-flex gap-2 justify-content-end">
          <a href="{{ route('pos.product.index', ['id_bengkel' => $bengkel->id_bengkel]) }}" id="backButton"
            class="btn btn-danger">Back</a>
          <button id="editButton" type="button" class="btn btn-primary">Edit</button>
          <button id="cancelButton" type="button" class="btn btn-danger hidden">Cancel</button>
          <button id="saveButton" type="submit" class="btn btn-primary hidden">Save</button>
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
    document.addEventListener('DOMContentLoaded', () => {
      const backButton = document.getElementById('backButton');
      const editButton = document.getElementById('editButton');
      const cancelButton = document.getElementById('cancelButton');
      const saveButton = document.getElementById('saveButton');

      const formElements = document.querySelectorAll('form input, form select, form textarea');

      formElements.forEach(element => {
        element.disabled = true;
      });

      editButton.addEventListener('click', () => {
        formElements.forEach(element => {
          element.disabled = false;
        });

        backButton.classList.add('hidden');
        editButton.classList.add('hidden');
        saveButton.classList.remove('hidden');
        cancelButton.classList.remove('hidden');
      });

      cancelButton.addEventListener('click', () => {
        formElements.forEach(element => {
          element.disabled = true;
        });
        backButton.classList.remove('hidden');
        editButton.classList.remove('hidden');
        saveButton.classList.add('hidden');
        cancelButton.classList.add('hidden');
      });
    });
  </script>
@endsection
