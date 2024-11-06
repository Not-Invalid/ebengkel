@extends('layouts.partials.sidebar')

@section('title')
  eBengkelku | Create Workshop
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
    <h4>Add Workshop</h4>
    <form action="{{ route('profile.workshop.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-group mb-3">
        <label for="foto_cover_bengkel">Cover Workshop Photo</label>
        <input type="file" class="form-control" name="foto_cover_bengkel">
      </div>

      <div class="form-group mb-3">
        <label for="foto_bengkel">Workshop Photo</label>
        <input type="file" class="form-control" name="foto_bengkel">
      </div>

      <div class="form-group mb-3">
        <label for="nama_bengkel">Nama Bengkel</label>
        <input type="text" class="form-control" name="nama_bengkel" required>
      </div>

      <div class="form-group mb-3">
        <label for="tagline_bengkel">Tagline</label>
        <input type="text" class="form-control" name="tagline_bengkel">
      </div>

      <div class="form-group mb-3">
        <label for="alamat_bengkel">Alamat Bengkel</label>
        <textarea class="form-control" name="alamat_bengkel" required></textarea>
      </div>

      <div class="form-group mb-3">
        <label for="gmaps">Gmaps Link</label>
        <input type="text" class="form-control" name="gmaps">
      </div>

      <div class="form-group mb-3 text-center">
        <label for="open_day" class="w-100">Schedule</label>
      </div>

      <div class="row mb-3">
        <div class="col-md-6 py-2">
          <label for="open_day" class="d-flex justify-content-center">Start</label>
          <select class="form-control" name="open_day" id="open_day" required onchange="toggleCloseFields()">
            <option value="" selected disabled hidden>Choose Day</option>
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
          <select class="form-control" name="close_day" id="close_day" required disabled>
            <option value="" selected disabled hidden>Choose Day</option>
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
            <input type="time" class="form-control" name="open_time" required>
          </div>
        </div>
        <div class="col-md-6 py-2">
          <div class="form-group">
            <label for="close_time" class="d-flex justify-content-center">End</label>
            <input type="time" class="form-control" name="close_time" required>
          </div>
        </div>
      </div>


      <div class="form-group mb-3">
        <label for="service_available">Service Available</label>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="service_available[]" value="Service offline di bengkel"
            id="serviceOffline">
          <label class="form-check-label" for="serviceOffline">
            Service at Workshop
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="service_available[]"
            value="Service panggilan via telepon" id="servicePanggilan">
          <label class="form-check-label" for="servicePanggilan">
            Service by Call
          </label>
        </div>
      </div>

      <div class="form-group mb-3">
        <label for="payment">Payment Methods</label>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="payment[]" value="Cash" id="paymentCash">
          <label class="form-check-label" for="paymentCash">
            Cash
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="payment[]" value="Credit Card"
            id="paymentCreditCard">
          <label class="form-check-label" for="paymentCreditCard">
            Credit Card
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="payment[]" value="Mobile Payment" id="paymentMobile">
          <label class="form-check-label" for="paymentMobile">
            Mobile Payment
          </label>
        </div>
      </div>

      <div class="form-group mb-3">
        <label for="whatsapp">WhatsApp</label>
        <input type="text" class="form-control" name="whatsapp" placeholder="62">
      </div>

      <div class="form-group mb-3">
        <label for="instagram">Instagram</label>
        <input type="text" class="form-control" name="instagram" placeholder="username">
      </div>
      <button type="submit" class="btn btn-primary mt-3">Save</button>
    </form>
  </div>

@endsection
