@extends('pos.layouts.app')

@section('title')
  eBengkelku | Add Stock
@stop

@php
  $header = 'Create Stock';
@endphp

@section('content')
  <div class="card">
    <div class="card-header">
      <h4>Add Stock
        <span>
          <br>
          <small class="text-danger">* Indicated requred fields</small>
        </span>
      </h4>

    </div>
    <div class="card-body">
      <form action="{{ route('pos.management-stock.store', $bengkel->id_bengkel) }}" method="POST">
        @csrf

        <div class="form-group">
          <label for="product_id">Product <span class="text-danger">*</span></label>
          <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror">
            <option value="">Select Product</option>
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
          <button type="submit" class="btn btn-custom-icon">Submit</button>
          <a href="{{ route('pos.management-stock', ['id_bengkel' => $bengkel->id_bengkel]) }}"
            class="btn btn-cancel">Cancel</a>
        </div>
      </form>
    </div>
  </div>
@endsection
