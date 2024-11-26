@extends('pos.layouts.app')

@section('title')
  eBengkelku | Stock Management
@stop

@php
  $header = 'Stock Management';
@endphp

@section('content')
  <div class="card">
    <div class="d-flex align-items-center justify-content-between p-4">
      <h4>List Product</h4>
      <div class="d-flex justify-content-between">
        <div class="d-flex justify-content-start mx-4">
          <input type="text" id="search" class="form-control w-100" placeholder="Search">
        </div>
        <div class="d-flex justify-content-end">
          <a href="{{ route('pos.management-stock.create', ['id_bengkel' => $bengkel->id_bengkel]) }}"
            class="btn btn-primary text-white d-flex align-items-center">Add New Stock</a>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive bg-white">
        <table class="table table-striped table-hover text-center">
          <thead>
            <tr>
              <th>No</th> <!-- Incremental Number -->
              <th>Product Name</th>
              <th>Merk Product</th> <!-- Brand Column -->
              <th>Product Photo</th> <!-- Image Column -->
              <th>Stock Quantity</th>
              <th>Description</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($products as $index => $product)
              @foreach ($product->stocks as $stock)
                <tr>
                  <td>{{ $index + 1 + ($products->currentPage() - 1) * $products->perPage() }}</td>
                  <td>{{ $product->nama_produk }}</td>
                  <td>{{ $product->merk_produk }}</td> <!-- Brand -->
                  <td>
                    <img src="{{ asset($product->foto_produk) }}" alt="Product Image" width="50" height="50">
                    <!-- Product Image -->
                  </td>
                  <td>{{ $stock->quantity }}</td>
                  <td>{{ $stock->description ?? 'No description' }}</td>
                  <td>
                    <form action="{{ route('pos.management-stock.delete', $stock->id_stock) }}" method="POST"
                      class="d-inline-block">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure you want to delete this stock entry?')">Delete</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- Pagination -->
      <div class="d-flex justify-content-end mt-4">
        {{ $products->links() }}
      </div>
    </div>
  </div>
@endsection
