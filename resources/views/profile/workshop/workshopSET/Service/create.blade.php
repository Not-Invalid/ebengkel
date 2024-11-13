@extends('layouts.partials.sidebar')

@section('title')
  eBengkelku | Create Service
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

  .section-title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 8px;
    display: block;
  }

  .options-group {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
  }

  .option-item {
    display: flex;
    align-items: center;
    padding: 8px 12px;
    border: 1px solid var(--main-light-blue);
    border-radius: 6px;
    background-color: var(--main-white);
    cursor: pointer;
    transition: background-color 0.2s, border-color 0.2s;
  }

  .option-item input {
    display: none;
  }

  .option-item span {
    margin-left: 6px;
    font-size: 14px;
  }

  .option-item:hover {
    background-color: var(--main-white);
  }

  .option-item input:checked+span {
    color: var(--main-blue);
    font-weight: 500;
  }

  .option-item input:checked~.option-item {
    color: var(--main-blue);
    font-weight: 500;
  }

  .btn.btn-custom-2 {
    padding: 0.3rem 0.8rem !important;
    border-radius: 4px !important;
    font-size: 0.8rem !important;
    background-color: var(--main-blue) !important;
    color: var(--main-white) !important;
  }
</style>
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
@section('content')
  <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
    <h4>Add Service</h4>
    <form action="{{ route('profile.workshop.workshopSET.service.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="form-group mb-4">
        <div class="upload-box">
          <label for="foto_services" class="upload-label">Service Photo</label>
          <input type="file" class="file-input" name="foto_services" id="foto_services"
            onchange="previewImage('foto_services', 'servicePreview')">
          <div class="preview-container d-flex justify-content-center">
            <img id="servicePreview" src="" alt="Service Photo Preview" class="image-preview"
              style="display: none; width: 200px; margin-top: 10px;">
          </div>
        </div>
      </div>

      <div class="form-group mb-3">
        <div class="did-floating-label-content">
          <input type="hidden" name="id_bengkel" value="{{ $id_bengkel }}">
          <input class="did-floating-input" type="text" placeholder=" " id="nama_services" name="nama_services"
            required />
          <label class="did-floating-label">Service Name</label>
        </div>
      </div>

      <div class="form-group mb-3">
        <div class="did-floating-label-content">
          <textarea class="did-floating-input form-control" name="keterangan_services" placeholder=" " rows="4" required
            style="height: 100px; resize: none;"></textarea>
          <label class="did-floating-label">Service Description</label>
        </div>
      </div>



      <div class="form-group mb-3">
        <div class="did-floating-label-content">
          <input class="did-floating-input" type="text" name="harga_services" placeholder="" required pattern="[0-9]*"
            oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
          <label class="did-floating-label">Price</label>
        </div>
      </div>

      <div class="mt-3 d-flex gap-2">
        <button type="submit" class="btn btn-custom-icon">Save</button>
        <a href="{{ route('profile.workshop.detail', ['id_bengkel' => $id_bengkel]) }}" class="btn btn-cancel">Cancel</a>
      </div>

    </form>

  </div>
@endsection
