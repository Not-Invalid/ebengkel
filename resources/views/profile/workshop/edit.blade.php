@extends('layouts.partials.sidebar')

@section('title')
  eBengkelku | Edit Workshop
@stop

<script>
  function toggleCloseFields() {
    const openDay = document.getElementById('open_day').value;
    const closeDay = document.getElementById('close_day');

    if (openDay === 'Every Day') {
      closeDay.value = ''; // Clear value
      closeDay.disabled = true; // Disable close day
    } else {
      closeDay.disabled = false; // Enable close day
    }
  }
</script>

@section('content')
  <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
    <h4>Edit Workshop</h4>
    <form action="{{ route('profile.workshop.update', $bengkel->id_bengkel) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="form-group mb-3">
        <label for="foto_cover_bengkel">Cover Workshop Photo</label>
        @if ($bengkel->foto_cover_bengkel)
          <img src="{{ $bengkel->foto_cover_bengkel }}" alt="Cover Workshop"
            style="max-width: 200px; height: auto; margin-top: 10px; margin-bottom:10px; display: block; margin-left: auto; margin-right: auto; border-radius:10px;">
        @endif
        <input type="file" class="form-control" name="foto_cover_bengkel">
      </div>

      <div class="form-group mb-3">
        <label for="foto_bengkel">Workshop Photo</label>
        @if ($bengkel->foto_bengkel)
          <img src="{{ $bengkel->foto_bengkel }}" alt="Workshop Photo"
            style="max-width: 200px; height: auto; margin-top: 10px; margin-bottom:10px; display: block; margin-left: auto; margin-right: auto; border-radius:10px;">
        @endif
        <input type="file" class="form-control" name="foto_bengkel">
      </div>

      <div class="form-group mb-3">
        <label for="nama_bengkel">Nama Bengkel</label>
        <input type="text" class="form-control" name="nama_bengkel" value="{{ $bengkel->nama_bengkel }}" required>
      </div>

      <div class="form-group mb-3">
        <label for="tagline_bengkel">Tagline</label>
        <input type="text" class="form-control" name="tagline_bengkel" value="{{ $bengkel->tagline_bengkel }}">
      </div>

      <div class="form-group mb-3">
        <label for="alamat_bengkel">Alamat Bengkel</label>
        <textarea class="form-control" name="alamat_bengkel" required>{{ $bengkel->alamat_bengkel }}</textarea>
      </div>

      <div class="form-group mb-3">
        <label for="gmaps">Gmaps Link</label>
        <input type="text" class="form-control" name="gmaps" value="{{ $bengkel->gmaps }}">
      </div>

      <div class="form-group mb-3 text-center">
        <label for="open_day" class="w-100">Schedule</label>
      </div>

      <div class="row mb-3">
        <div class="col-md-6 py-2">
          <label for="open_day" class="d-flex justify-content-center">Start</label>
          <select class="form-control" name="open_day" id="open_day" required onchange="toggleCloseFields()">
            <option value="{{ $bengkel->open_day }}" selected>{{ $bengkel->open_day }}</option>
            <option value="Monday">Monday</option>
            <option value="Tuesday">Tuesday</option>
            <option value="Wednesday">Wednesday</option>
            <option value="Thursday">Thursday</option>
            <option value="Friday">Friday</option>
            <option value="Saturday">Saturday</option>
            <option value="Sunday">Sunday</option>
            <option value="Every Day">Every Day</option>
          </select>
        </div>
        <div class="col-md-6 py-2">
          <label for="close_day" class="d-flex justify-content-center">End</label>
          <select class="form-control" name="close_day" id="close_day" required
            {{ $bengkel->open_day === 'Every Day' ? 'disabled' : '' }}>
            <option value="{{ $bengkel->close_day }}" selected>{{ $bengkel->close_day }}</option>
            <option value="Monday">Monday</option>
            <option value="Tuesday">Tuesday</option>
            <option value="Wednesday">Wednesday</option>
            <option value="Thursday">Thursday</option>
            <option value="Friday">Friday</option>
            <option value="Saturday">Saturday</option>
            <option value="Sunday">Sunday</option>
          </select>
        </div>
      </div>
      <div class="form-group mb-3 text-center">
        <label for="open_time" class="w-100">Clock</label>
      </div>
      <div class="row mb-3">
        <div class="col-md-6 py-2">
          <div class="form-group">
            <label for="open_time" class="d-flex justify-content-center">Start</label>
            <input type="time" class="form-control" name="open_time"
              value="{{ \Carbon\Carbon::parse($bengkel->open_time)->format('H:i') }}" required>
          </div>
        </div>
        <div class="col-md-6 py-2">
          <div class="form-group">
            <label for="close_time" class="d-flex justify-content-center">End</label>
            <input type="time" class="form-control" name="close_time"
              value="{{ \Carbon\Carbon::parse($bengkel->close_time)->format('H:i') }}" required>
          </div>
        </div>
      </div>
      <div class="form-group mb-3">
        <label for="service_available">Service Available</label>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="service_available[]"
            value="Service offline di bengkel" id="serviceOffline"
            {{ in_array('Service offline di bengkel', $bengkel->service_available) ? 'checked' : '' }}>
          <label class="form-check-label" for="serviceOffline">
            Service at Workshop
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="service_available[]"
            value="Service panggilan via telepon" id="servicePanggilan"
            {{ in_array('Service panggilan via telepon', $bengkel->service_available) ? 'checked' : '' }}>
          <label class="form-check-label" for="servicePanggilan">
            Service by Call
          </label>
        </div>
      </div>
      <div class="form-group mb-3">
        <label for="payment">Payment Methods</label>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="payment[]" value="Cash" id="paymentCash"
            {{ in_array('Cash', $bengkel->payment ?? []) ? 'checked' : '' }}>
          <label class="form-check-label" for="paymentCash">Cash</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="payment[]" value="Credit Card" id="paymentCreditCard"
            {{ in_array('Credit Card', $bengkel->payment) ? 'checked' : '' }}>
          <label class="form-check-label" for="paymentCreditCard">
            Credit Card
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="payment[]" value="Mobile Payment" id="paymentMobile"
            {{ in_array('Mobile Payment', $bengkel->payment) ? 'checked' : '' }}>
          <label class="form-check-label" for="paymentMobile">
            Mobile Payment
          </label>
        </div>
      </div>
      <div class="form-group mb-3">
        <label for="whatsapp">WhatsApp</label>
        <input type="text" class="form-control" name="whatsapp" value="{{ $bengkel->whatsapp }}"
          placeholder="62">
      </div>
      <div class="form-group mb-3">
        <label for="instagram">Instagram</label>
        <input type="text" class="form-control" name="instagram" value="{{ $bengkel->instagram }}"
          placeholder="username">
      </div>
      <button type="submit" class="btn btn-primary mt-3">Save</button>
    </form>
  </div>

@endsection
