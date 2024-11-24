@extends('layouts.partials.sidebar')

@section('title')
  Ebengkelku | Edit Product
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
    <h4>Edit Product</h4>
    <form action="{{ route('profile.workshop.product.update', $product->id_produk) }}" method="POST"
      enctype="multipart/form-data">
      @csrf
      @method('POST')
      <div class="form-group mb-3">
        <div class="upload-box">
          <label for="foto_produk" class="upload-label">Photo Product</label>
          <input type="file" class="file-input" name="foto_produk" id="foto_produk"
            onchange="previewImage('foto_produk', 'product')">
          <div class="preview-container d-flex justify-content-center">
            <img id="product" src="{{ url($product->foto_produk) }}" alt="product Photo Preview" class="image-preview"
              style="display: block; width: 200px; margin-top: 10px;">
          </div>
        </div>
      </div>
      <div class="form-group mb-3">
        <div class="did-floating-label-content">
          <input class="did-floating-input" type="text" placeholder=" " id="nama_produk" name="nama_produk"
            value="{{ $product->nama_produk }}" required />
          <label class="did-floating-label">Product Name</label>
        </div>
      </div>
      <div class="form-group mb-3">
        <div class="did-floating-label-content">
          <input class="did-floating-input" type="text" placeholder=" " id="merk_produk" name="merk_produk"
            value="{{ $product->merk_produk }}" required />
          <label class="did-floating-label">Merk Product</label>
        </div>
      </div>
      <div class="form-group mb-3">
        <div class="did-floating-label-content">
          <select name="kualitas_produk" id="kualitas_produk" class="did-floating-select">
            <option value="original" {{ $product->kualitas_produk == 'original' ? 'selected' : '' }}>
              Original</option>
            <option value="aftermarket" {{ $product->kualitas_produk == 'aftermarket' ? 'selected' : '' }}>
              Aftermarket</option>
            <option value="kw" {{ $product->kualitas_produk == 'kw' ? 'selected' : '' }}>KW</option>
          </select>
          <label class="did-floating-label">Product Category</label>
        </div>
      </div>
      <div class="form-group mb-3">
        <div class="did-floating-label-content">
          <select name="id_kategori_spare_part" id="id_kategori_spare_part" class="did-floating-select">
            <option value="" disabled hidden>Select Quality</option>
            @foreach ($kategoriSparePart as $kategori)
              <option value="{{ $kategori->id_kategori_spare_part }}"
                {{ $product->id_kategori_spare_part == $kategori->id_kategori_spare_part ? 'selected' : '' }}>
                {{ $kategori->nama_kategori_spare_part }}
              </option>
            @endforeach
          </select>
          <label class="did-floating-label">Product Quality</label>
        </div>
      </div>
      <div class="form-group mb-3">
        <div class="did-floating-label-content">
          <textarea class="did-floating-input" placeholder=" " id="keterangan_produk" name="keterangan_produk" required
            style="height: 100px!important;resize: none">{{ $product->keterangan_produk }}</textarea>
          <label class="did-floating-label">Product Description</label>
        </div>
      </div>
      <div class="form-group mb-3">
        <div class="did-floating-label-content">
          <input class="did-floating-input" type="number" placeholder=" " id="stok_produk" name="stok_produk"
            value="{{ $product->stok_produk }}" required />
          <label class="did-floating-label">Product Stock</label>
        </div>
      </div>
      <div class="form-group mb-3">
        <div class="did-floating-label-content">
          <input class="did-floating-input" type="text" placeholder=" " id="harga_produk" name="harga_produk"
            value="{{ $product->harga_produk }}" required />
          <label class="did-floating-label">Price</label>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
      <a href="{{ route('profile.workshop.detail', ['id_bengkel' => $bengkel->id_bengkel]) }}" class="btn btn-danger"
        title="detail">
        Cancel
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
