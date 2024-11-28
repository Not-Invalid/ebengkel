@extends('pos.layouts.app')

@section('title')
  eBengkelku | Management Stock
@stop

@php
  $header = 'Add New Stock';
@endphp
{{-- select2 --}}
<link href="{{ asset('template_pos/modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" />

<script>
  $(document).ready(function() {
    $('.select2').select2();
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Handle showing appropriate dropdown based on selected stock type
    document.getElementById('type').addEventListener('change', function() {
      var type = this.value;

      // Show/hide divs based on the selected type
      if (type === 'product') {
        document.getElementById('product-div').style.display = 'block';
        document.getElementById('spare-part-div').style.display = 'none';
      } else if (type === 'spare_part') {
        document.getElementById('product-div').style.display = 'none';
        document.getElementById('spare-part-div').style.display = 'block';
      } else {
        document.getElementById('product-div').style.display = 'none';
        document.getElementById('spare-part-div').style.display = 'none';
      }
    });

    // Trigger the change event on page load to handle pre-selected values
    document.getElementById('type').dispatchEvent(new Event('change'));
  });
</script>


@section('content')
  <div class="card">
    <div class="card-header">
      <h4 class="text-danger">* Indicated required fields
      </h4>
    </div>
    <div class="card-body">
      <form action="{{ route('pos.management-stock.inbound.store', $bengkel->id_bengkel) }}" method="POST">
        @csrf

        <!-- Stock Type Selection -->
        <input type="hidden" name="id_pegawai" value="{{ Auth::guard('pegawai')->id() }}">

        <div class="form-group">
          <label for="type">Stock Type <span class="text-danger">*</span></label>
          <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
            <option value=""disabled selected hidden>Select Stock Type</option>
            <option value="product" {{ old('type') == 'product' ? 'selected' : '' }}>Product</option>
            <option value="spare_part" {{ old('type') == 'spare_part' ? 'selected' : '' }}>Spare Part</option>
          </select>
          @error('type')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Product Dropdown (Only visible if product is selected) -->
        <div id="product-div" class="form-group" style="display: none;">
          <label for="product_id">Product <span class="text-danger">*</span></label>
          <select name="product_id" id="product_id"
            class="form-control select2 @error('product_id') is-invalid @enderror">
            <option value="" disabled selected hidden>Select Product</option>
            @foreach ($products as $product)
              <option value="{{ $product->id_produk }}" {{ old('product_id') == $product->id_produk ? 'selected' : '' }}>
                {{ $product->merk_produk }} - {{ $product->nama_produk }}
              </option>
            @endforeach
          </select>
          @error('product_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Spare Part Dropdown (Only visible if spare part is selected) -->
        <div id="spare-part-div" class="form-group" style="display: none;">
          <label for="spare_part_id">Spare Part <span class="text-danger">*</span></label>
          <select name="spare_part_id" id="spare_part_id"
            class="form-control @error('spare_part_id') is-invalid @enderror">
            <option value="" disabled selected hidden>Select Spare Part</option>
            @foreach ($spareParts as $sparePart)
              <option value="{{ $sparePart->id_spare_part }}"
                {{ old('spare_part_id') == $sparePart->id_spare_part ? 'selected' : '' }}>
                {{ $sparePart->merk_spare_part }} - {{ $sparePart->nama_spare_part }}
              </option>
            @endforeach
          </select>
          @error('spare_part_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="quantity">Quantity <span class="text-danger">*</span></label>
          <input type="number" name="quantity" id="quantity"
            class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" required
            min="1">
          @error('quantity')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="description">Description</label>
          <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
          @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="d-flex gap-2 justify-content-end">
          <a href="{{ route('pos.management-stock.inbound', ['id_bengkel' => $bengkel->id_bengkel]) }}"
            class="btn btn-cancel">Cancel</a>
          <button type="submit" class="btn btn-custom-icon">Submit</button>
        </div>
      </form>
    </div>
  </div>
@endsection
