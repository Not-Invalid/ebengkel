@extends('pos.layouts.app')

@section('title')
  eBengkelku | Add New Stock Opname
@stop

@php
  $header = 'Add New Stock';
@endphp

@section('content')
  <div class="card">
    <div class="card-header">
      <h4 class="text-danger">* Indicated required fields</h4>
    </div>
    <div class="card-body">
      <form action="{{ route('pos.management-stock.opname.store', $bengkel->id_bengkel) }}" method="POST">
        @csrf
        <input type="hidden" name="id_pegawai" value="{{ Auth::guard('pegawai')->id() }}">

        <!-- Stock Type Selection -->
        <div class="form-group">
          <label for="type">Stock Type <span class="text-danger">*</span></label>
          <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
            <option value="" disabled selected hidden>Select Stock Type</option>
            <option value="product" {{ old('type') == 'product' ? 'selected' : '' }}>Product</option>
            <option value="spare_part" {{ old('type') == 'spare_part' ? 'selected' : '' }}>Spare Part</option>
          </select>
          @error('type')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Product Dropdown (Only visible if 'Product' is selected) -->
        <div class="form-group" id="product-dropdown" style="display: none;">
          <label for="product_id">Product <span class="text-danger">*</span></label>
          <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror">
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

        <!-- Spare Part Dropdown (Only visible if 'Spare Part' is selected) -->
        <div class="form-group" id="sparepart-dropdown" style="display: none;">
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

        <!-- Actual Quantity Input -->
        <div class="form-group">
          <label for="actual_quantity">Actual Quantity <span class="text-danger">*</span></label>
          <input type="number" name="actual_quantity" id="actual_quantity"
            class="form-control @error('actual_quantity') is-invalid @enderror" value="{{ old('actual_quantity') }}"
            required min="1">
          @error('actual_quantity')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Description Input -->
        <div class="form-group">
          <label for="description">Description</label>
          <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
          @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="d-flex gap-2 justify-content-end">
          <a href="{{ route('pos.management-stock.opname', ['id_bengkel' => $bengkel->id_bengkel]) }}"
            class="btn btn-cancel">Cancel</a>
          <button type="submit" class="btn btn-custom-icon">Submit</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // JavaScript to toggle visibility of product/spare part dropdowns based on selected stock type
    document.addEventListener('DOMContentLoaded', function() {
      const typeSelector = document.getElementById('type');
      const productDropdown = document.getElementById('product-dropdown');
      const sparePartDropdown = document.getElementById('sparepart-dropdown');

      // Function to handle dropdown visibility based on selected stock type
      function toggleDropdowns() {
        const selectedType = typeSelector.value;

        if (selectedType === 'product') {
          productDropdown.style.display = 'block';
          sparePartDropdown.style.display = 'none';
        } else if (selectedType === 'spare_part') {
          productDropdown.style.display = 'none';
          sparePartDropdown.style.display = 'block';
        } else {
          productDropdown.style.display = 'none';
          sparePartDropdown.style.display = 'none';
        }
      }

      // Event listener for when the stock type is changed
      typeSelector.addEventListener('change', toggleDropdowns);

      // Trigger the change event to set the correct initial state
      toggleDropdowns();
    });
  </script>
@endsection
