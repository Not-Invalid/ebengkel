@extends('pos.layouts.app')

@section('title')
  eBengkelku | POS
@stop

@php
  $header = 'Edit Sparepart';
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
        action="{{ route('pos.sparepart.update', ['id_bengkel' => $bengkel->id_bengkel, 'id_spare_part' => $sparepart->id_spare_part]) }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="id_bengkel" value="{{ $bengkel->id_bengkel }}">

        <div class="form-group">
          <label for="nama_spare_part">Sparepart Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="nama_spare_part"
            value="{{ old('nama_spare_part', $sparepart->nama_spare_part) }}" required>
        </div>
        <!-- Product Category -->
        <div class="form-group">
          <label for="id_kategori_spare_part">Sparepart Type <span class="text-danger">*</span></label>
          <select name="id_kategori_spare_part" class="form-control" required>
            <option value="" disabled>Select Type</option>
            @foreach ($categories as $kategori)
              <option value="{{ $kategori->id_kategori_spare_part }}" @if ($sparepart->id_kategori_spare_part == $kategori->id_kategori_spare_part) selected @endif>
                {{ $kategori->nama_kategori_spare_part }}
              </option>
            @endforeach
          </select>
        </div>

        <!-- Product Quality -->
        <div class="form-group">
          <label for="kualitas_spare_part">Sparepart Quality <span class="text-danger">*</span></label>
          <select name="kualitas_spare_part" class="form-control" required>
            <option value="original" @if ($sparepart->kualitas_spare_part == 'original') selected @endif>Original</option>
            <option value="aftermarket" @if ($sparepart->kualitas_spare_part == 'aftermarket') selected @endif>Aftermarket</option>
          </select>
        </div>
        <!-- Other fields -->
        <div class="form-group">
          <label for="merk_spare_part">Sparepart Merk <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="merk_spare_part"
            value="{{ old('merk_spare_part', $sparepart->merk_spare_part) }}" required>
        </div>
        <div class="form-group">
          <label for="stok_spare_part">Sparepart Stock <span class="text-danger">*</span></label>
          <input type="number" class="form-control" name="stok_spare_part"
            value="{{ old('stok_spare_part', $sparepart->stok_spare_part) }}" readonly>
        </div>

        <div class="form-group">
          <label for="harga_spare_part">Sparepart Price <span class="text-danger">*</span></label>
          <input type="number" class="form-control" name="harga_spare_part"
            value="{{ old('harga_spare_part', $sparepart->harga_spare_part) }}" required>
        </div>

        <div class="form-group">
          <label for="keterangan_spare_part">Description</label>
          <textarea class="form-control" style="resize: none; height: 100px !important;" name="keterangan_spare_part">{{ old('keterangan_spare_part', $sparepart->keterangan_spare_part) }}</textarea>
        </div>


        <!-- sparepart Photos -->
        <div class="form-group">
          <div class="upload-box">
            <label for="foto_spare_part_1" class="upload-label">Sparepart Photo 1 <span
                class="text-danger">*</span></label>
            <input type="file" class="file-input" name="foto_spare_part_1" id="foto_spare_part_1"
              onchange="previewImage('foto_spare_part_1', 'preview_1')">

            <div class="preview-container d-flex justify-content-center">
              <img id="preview_1"
                src="{{ old('foto_spare_part_1', isset($fotoSparepart->file_foto_spare_part_1) ? asset($fotoSparepart->file_foto_spare_part_1) : asset('assets/images/components/image.png')) }}"
                alt="Sparepart Photo Preview" class="image-preview"
                style="display: block; width: 200px; margin-top: 10px;">
            </div>
          </div>
        </div>
        <!-- Sparepart Photo 2 -->
        <div class="form-group">
          <div class="upload-box">
            <label for="foto_spare_part_2" class="upload-label">Sparepart Photo 2 <span
                class="text-danger">*</span></label>
            <input type="file" class="file-input" name="foto_spare_part_2" id="foto_spare_part_2"
              onchange="previewImage('foto_spare_part_2', 'preview_2')">

            <div class="preview-container d-flex justify-content-center">
              <img id="preview_2"
                src="{{ old('foto_spare_part_2', isset($fotoSparepart->file_foto_spare_part_2) ? asset($fotoSparepart->file_foto_spare_part_2) : asset('assets/images/components/image.png')) }}"
                alt="Sparepart Photo Preview" class="image-preview"
                style="display: block; width: 200px; margin-top: 10px;">
            </div>
          </div>
        </div>

        <!-- Sparepart Photo 3 -->
        <div class="form-group">
          <div class="upload-box">
            <label for="foto_spare_part_3" class="upload-label">Sparepart Photo 3 <span
                class="text-danger">*</span></label>
            <input type="file" class="file-input" name="foto_spare_part_3" id="foto_spare_part_3"
              onchange="previewImage('foto_spare_part_3', 'preview_3')">

            <div class="preview-container d-flex justify-content-center">
              <img id="preview_3"
                src="{{ old('foto_spare_part_3', isset($fotoSparepart->file_foto_spare_part_3) ? asset($fotoSparepart->file_foto_spare_part_3) : asset('assets/images/components/image.png')) }}"
                alt="Sparepart Photo Preview" class="image-preview"
                style="display: block; width: 200px; margin-top: 10px;">
            </div>
          </div>
        </div>

        <!-- Sparepart Photo 4 -->
        <div class="form-group">
          <div class="upload-box">
            <label for="foto_spare_part_4" class="upload-label">Sparepart Photo 4</label>
            <input type="file" class="file-input" name="foto_spare_part_4" id="foto_spare_part_4"
              onchange="previewImage('foto_spare_part_4', 'preview_4')">

            <div class="preview-container d-flex justify-content-center">
              <img id="preview_4"
                src="{{ old('foto_spare_part_4', isset($fotoSparepart->file_foto_spare_part_4) ? asset($fotoSparepart->file_foto_spare_part_4) : asset('assets/images/components/image.png')) }}"
                alt="Sparepart Photo Preview" class="image-preview"
                style="display: block; width: 200px; margin-top: 10px;">
            </div>
          </div>
        </div>

        <!-- Sparepart Photo 5 -->
        <div class="form-group">
          <div class="upload-box">
            <label for="foto_spare_part_5" class="upload-label">Sparepart Photo 5</label>
            <input type="file" class="file-input" name="foto_spare_part_5" id="foto_spare_part_5"
              onchange="previewImage('foto_spare_part_5', 'preview_5')">

            <div class="preview-container d-flex justify-content-center">
              <img id="preview_5"
                src="{{ old('foto_spare_part_5', isset($fotoSparepart->file_foto_spare_part_5) ? asset($fotoSparepart->file_foto_spare_part_5) : asset('assets/images/components/image.png')) }}"
                alt="Sparepart Photo Preview" class="image-preview"
                style="display: block; width: 200px; margin-top: 10px;">
            </div>
          </div>
        </div>

        <div class="d-flex gap-2 justify-content-end">
          <a href="{{ route('pos.sparepart.index', ['id_bengkel' => $bengkel->id_bengkel]) }}" id="backButton"
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
