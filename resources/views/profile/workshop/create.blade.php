@extends('layouts.partials.sidebar')

@section('title')
  eBengkelku | Create Workshop
@stop
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
  function toggleCloseFields() {
    const openDay = document.getElementById('open_day').value;
    const closeDay = document.getElementById('close_day');

    if (openDay === 'Every Day') {
      closeDay.value = '';
      closeDay.disabled = true;
    } else {
      closeDay.disabled = false;
    }
  }
</script>
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

@section('content')
  <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
    <h4>Add Workshop</h4>
    <p class="text-danger">*indicates required fields</p>
    <form action="{{ route('profile.workshop.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-group mb-4">
        <div class="upload-box">
          <label for="foto_cover_bengkel" class="upload-label">Cover Workshop Photo</label>
          <input type="file" class="file-input" name="foto_cover_bengkel" id="foto_cover_bengkel"
            onchange="previewImage('foto_cover_bengkel', 'coverPreview')">
          <div class="preview-container d-flex justify-content-center">
            <img id="coverPreview" src="" alt="Cover Photo Preview" class="image-preview"
              style="display: none; width: 200px; margin-top: 10px;">
          </div>
        </div>
      </div>

      <div class="form-group mb-4">
        <div class="upload-box">
          <label for="foto_bengkel" class="upload-label">Workshop Photo</label>
          <input type="file" class="file-input" name="foto_bengkel" id="foto_bengkel"
            onchange="previewImage('foto_bengkel', 'bengkelPreview')">
          <div class="preview-container d-flex justify-content-center">
            <img id="bengkelPreview" src="" alt="Workshop Photo Preview" class="image-preview"
              style="display: none; width: 200px; margin-top: 10px;">
          </div>
        </div>
      </div>


      <div class="form-group mb-3">
        <div class="did-floating-label-content">
          <input class="did-floating-input" type="text" placeholder=" " id="nama_bengkel" name="nama_bengkel" required />
          <label class="did-floating-label">Workshop Name<span class="text-danger">*</span></label>
        </div>
      </div>
      <div class="form-group mb-3">
        <div class="did-floating-label-content">
          <input class="did-floating-input" type="text" placeholder=" " id="tagline_bengkel" name="tagline_bengkel" />
          <label class="did-floating-label">Workshop Tagline</label>
        </div>
      </div>
      <div class="form-group mb-3">
        <div class="did-floating-label-content">
          <textarea class="did-floating-input form-control" name="alamat_bengkel" placeholder=" " rows="4" required
            style="height: 100px;resize: none"></textarea>
          <label class="did-floating-label">Workshop Address<span class="text-danger">*</span></label>
        </div>
      </div>
      <div class="form-group mb-3">
        <div class="did-floating-label-content">
          <input class="did-floating-input" type="text" placeholder="https://" id="gmaps" name="gmaps"
            required />
          <label class="did-floating-label">Google Maps Link<span class="text-danger">*</span></label>
        </div>
      </div>

      <div class="form-group mb-3 text-center">
        <label for="open_day" class="w-100">Open Day<span class="text-danger">*</span></label>
      </div>

      <div class="row mb-3">
        <div class="col-md-6 py-2">
          <div class="did-floating-label-content">
            <select class="did-floating-select" name="open_day" id="open_day" required onchange="toggleCloseFields()">
              <option value="" selected disabled hidden></option>
              <option value="Monday">Monday</option>
              <option value="Tuesday">Tuesday</option>
              <option value="Wednesday">Wednesday</option>
              <option value="Thursday">Thursday</option>
              <option value="Friday">Friday</option>
              <option value="Saturday">Saturday</option>
              <option value="Sunday">Sunday</option>
              <option value="Every Day">Every Day</option>
            </select>
            <label class="did-floating-label">Start</label>
          </div>
        </div>
        <div class="col-md-6 py-2">

          <div class="did-floating-label-content">
            <select class="did-floating-select" name="close_day" id="close_day" required disabled>
              <option value="" selected disabled hidden></option>
              <option value="Monday">Monday</option>
              <option value="Tuesday">Tuesday</option>
              <option value="Wednesday">Wednesday</option>
              <option value="Thursday">Thursday</option>
              <option value="Friday">Friday</option>
              <option value="Saturday">Saturday</option>
              <option value="Sunday">Sunday</option>
            </select>
            <label class="did-floating-label">End</label>
          </div>
        </div>
      </div>
      <div class="form-group mb-3 text-center">
        <label for="open_time" class="w-100">Open Hour<span class="text-danger">*</span></label>
      </div>
      <div class="row mb-3">
        <div class="col-md-6 py-2">
          <div class="form-group">
            <div class="did-floating-label-content">
              <input type="time" class="did-floating-input" name="open_time" required>
            </div>
          </div>
        </div>
        <div class="col-md-6 py-2">
          <div class="form-group">
            <div class="did-floating-label-content">
              <input type="time" class="did-floating-input" name="close_time" required>
            </div>
          </div>
        </div>
      </div>


      <div class="form-group mb-4">
        <label for="service_available" class="section-title">Service Available<span class="text-danger">*</span></label>
        <div class="options-group">
          <label class="option-item">
            <input type="checkbox" name="service_available[]" value="Service at Workshop" id="serviceOffline">
            <span>Service at Workshop</span>
          </label>
          <label class="option-item">
            <input type="checkbox" name="service_available[]" value="Service by Call" id="servicePanggilan">
            <span>Service by Call</span>
          </label>
        </div>
      </div>

      <div class="form-group mb-4">
        <label for="payment" class="section-title">Payment Methods<span class="text-danger">*</span></label>
        <div class="options-group">
          <label class="option-item">
            <input type="checkbox" name="payment[]" value="Cash" id="paymentCash">
            <span>Cash</span>
          </label>
          <label class="option-item">
            <input type="checkbox" name="payment[]" value="Credit Card" id="paymentCreditCard">
            <span>Credit Card</span>
          </label>
          <label class="option-item">
            <input type="checkbox" name="payment[]" value="Mobile Payment" id="paymentMobile">
            <span>Mobile Payment</span>
          </label>
        </div>
      </div>

      <div class="form-group mb-3">
        <div class="did-floating-label-content">
          <input class="did-floating-input" type="text" name="whatsapp" placeholder="62" required pattern="[0-9]*"
            oninput="this.value = this.value.replace(/[^0-9]/g, '');" required />
          <label class="did-floating-label">WhatsApp<span class="text-danger">*</span></label>
        </div>
      </div>

      <div class="form-group mb-3">
        <div class="did-floating-label-content">
          <input class="did-floating-input" type="text" placeholder="username" id="instagram"
            name="instagram" />
          <label class="did-floating-label">Instagram</label>
        </div>
      </div>
      <div class="form-group">
            <div class="d-flex justify-content-end align-items-center gap-2">
                <a href="{{ route('profile.workshop') }}" class="btn btn-cancel">Cancel</a>
                <button type="submit" class="btn btn-custom-icon">
                    Submit
                    <i class="bx bxs-send fs-5"></i>
                </button>
            </div>
        </div>
    </form>
  </div>

@endsection
