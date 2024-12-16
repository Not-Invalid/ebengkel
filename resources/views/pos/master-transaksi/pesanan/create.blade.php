@extends('pos.layouts.app')
@section('title')
  eBengkelku | Create Pesanan Pos
@stop
@php
  $header = 'Create Pesanan Services';
@endphp
@section('content')
  <div class="card">
    <div class="card-header">
      <h4 class="text-danger">
        * Indicated required fields
      </h4>
    </div>
    <div class="card-body">
      <form action="{{ route('pos.transaksi_pesanan.store', ['id_bengkel' => $bengkel->id_bengkel]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id_bengkel" value="{{ $bengkel->id_bengkel }}">
        <input type="hidden" name="id_pegawai" value="{{ Auth::guard('pegawai')->id() }}">


        <div class="form-group">
          <label for="tgl_pesanan">Order Date<span class="text-danger">*</span></label>
          <input type="date" class="form-control" name="tgl_pesanan" required>
        </div>
        <div class="form-group">
          <label for="nama_pemesan">Customer Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="nama_pemesan" required>
        </div>
        <div class="form-group">
          <label for="telp_pelanggan">Customer Phone Number <span class="text-danger">*</span></label>
          <input type="tel" class="form-control" name="telp_pelanggan" required oninput="validatePhoneNumber(this)"
            maxlength="15">
        </div>
        <div class="form-group">
          <label for="nama_services">Service Name<span class="text-danger">*</span></label>
          <select class="form-control" name="nama_services" id="nama_services" required onchange="updateTotalPrice()">
            @if ($services->isEmpty())
              <option value="" disabled selected hidden>No Service Available</option>
            @else
              <option value="" disabled selected hidden>Select Service</option>
              @foreach ($services as $service)
                <option value="{{ $service->id_services }}" data-price="{{ $service->harga_services }}">
                  {{ $service->nama_services }}
                </option>
              @endforeach
            @endif
          </select>
        </div>
        <div class="form-group">
          <label for="status">Order Status <span class="text-danger">*</span></label>
          <select class="form-control" name="status" required>
            <option value="" disabled selected hidden>Select Status</option>
            @foreach ($statusNames as $key => $value)
              <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="total_pesanan">Order Price<span class="text-danger">*</span></label>
          <input type="number" class="form-control" name="total_pesanan" id="total_pesanan" required readonly>
        </div>

        <div class="d-flex gap-2 justify-content-end">
          <a href="{{ route('pos.transaksi_pesanan.index', ['id_bengkel' => $bengkel->id_bengkel]) }}"
            class="btn btn-cancel">Cancel</a>
          <button type="submit" class="btn btn-custom-icon">Submit</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function validatePhoneNumber(input) {
      input.value = input.value.replace(/[^0-9]/g, '');
      if (input.value.length > 15) {
        input.value = input.value.slice(0, 15);
      }
    }

    function updateTotalPrice() {
      var serviceSelect = document.getElementById('nama_services');
      var selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
      var price = selectedOption.getAttribute('data-price');
      document.getElementById('total_pesanan').value = price;
    }
  </script>
@endsection
