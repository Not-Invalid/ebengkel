@extends('pos.layouts.app')
@section('title')
  eBengkelku | Edit Pesanan Service
@stop
@php
  $header = 'Edit Pesanan Services';
@endphp
@section('content')
  <div class="card">
    <div class="card-header">
      <h4 class="text-danger">
        * Indicated required fields
      </h4>
    </div>
    <div class="card-body">
      <form action="{{ route('pos.transaksi_pesanan.update', ['id_bengkel' => $pesanan->id_bengkel]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" name="id_bengkel" value="{{ $pesanan->id_bengkel }}">

        <!-- Order Date -->
        <div class="form-group">
          <label for="tgl_pesanan">Order Date <span class="text-danger">*</span></label>
          <input type="date" class="form-control" name="tgl_pesanan"
            value="{{ old('tgl_pesanan', $pesanan->tgl_pesanan) }}" required>
        </div>

        <!-- Customer Name -->
        <div class="form-group">
          <label for="nama_pemesan">Customer Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="nama_pemesan"
            value="{{ old('nama_pemesan', $pesanan->nama_pemesan) }}" required>
        </div>

        <!-- Customer Phone -->
        <div class="form-group">
          <label for="telp_pelanggan">Customer Phone Number <span class="text-danger">*</span></label>
          <input type="tel" class="form-control" name="telp_pelanggan"
            value="{{ old('telp_pelanggan', $pesanan->telp_pelanggan) }}" required oninput="validatePhoneNumber(this)"
            maxlength="15">
        </div>
        <!-- Service Name -->
        <div class="form-group">
          <label for="nama_services">Service Name <span class="text-danger">*</span></label>
          <select class="form-control" name="nama_services" id="nama_services" required onchange="updateTotalPrice()">
            @if ($services->isEmpty())
              <option value="">No services available</option>
            @else
              @foreach ($services as $service)
                <option value="{{ $service->id_services }}" data-price="{{ $service->harga_services }}"
                  @if (old('nama_services', $pesanan->nama_services) == $service->id_services) selected @endif>
                  {{ $service->nama_services }}
                </option>
              @endforeach
            @endif
          </select>
        </div>



        <!-- Order Status -->
        <div class="form-group">
          <label for="status">Order Status <span class="text-danger">*</span></label>
          <select class="form-control" name="status" required>
            @foreach ($statusNames as $key => $value)
              <option value="{{ $key }}" @if ($pesanan->status == $key) selected @endif>
                {{ $value }}
              </option>
            @endforeach
          </select>
        </div>

        <!-- Total Price -->
        <div class="form-group">
          <label for="total_pesanan">Order Price<span class="text-danger">*</span></label>
          <input type="number" class="form-control" name="total_pesanan" id="total_pesanan"
            value="{{ old('total_pesanan', $pesanan->total_pesanan) }}" required readonly>
        </div>

        <!-- Submit and Cancel Buttons -->
        <div class="d-flex gap-2 justify-content-end">
          <a href="{{ route('pos.transaksi_pesanan.index', ['id_bengkel' => $pesanan->id_bengkel]) }}"
            class="btn btn-cancel">Cancel</a>
          <button type="submit" class="btn btn-custom-icon">Update</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Function to validate phone number input
    function validatePhoneNumber(input) {
      input.value = input.value.replace(/[^0-9]/g, '');
      if (input.value.length > 15) {
        input.value = input.value.slice(0, 15);
      }
    }

    // Function to update total price based on selected service
    function updateTotalPrice() {
      var serviceSelect = document.getElementById('nama_services');
      var selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
      var price = selectedOption.getAttribute('data-price');

      // Update the total price field
      document.getElementById('total_pesanan').value = price;
    }

    // Initialize total price on page load in case the form is pre-filled
    window.onload = function() {
      updateTotalPrice();
    }
  </script>
@endsection
