@extends('pos.layouts.app')

@section('title')
  eBengkelku | Stock Opname
@stop

@php
  $header = 'Stock Opname';
@endphp

@section('content')
  <div class="d-flex justify-between mt-4">
    <div class="d-flex justify-start mb-4 mt-4">
      <select name="per_page" id="perPage" class="form-control w-auto mx-2">
        <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
        <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
        <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
        <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
      </select>
    </div>
    <div class="d-flex justify-center w-100 mx-2 mb-4 mt-4">
      <input type="text" id="search" class="form-control w-60" placeholder="Search">
    </div>
    <div class="d-flex justify-end mb-4 mt-4">
      <a href="{{ route('pos.management-stock.opname.create', ['id_bengkel' => $bengkel->id_bengkel]) }}"
        class="btn btn-info text-white px-4 py-2 mx-2">Add New Opname</a>
    </div>
  </div>

  <div class="table-responsive bg-white rounded shadow">
    <table class="table table-bordered table-striped text-center">
      <thead class="bg-light-grey text-white">
        <tr>
          <th class="text-center">No</th>
          <th class="text-center">Merk Product</th>
          <th class="text-center">Product Name</th>
          <th class="text-center">Type</th>
          <th class="text-center">Recorded Quantity</th>
          <th class="text-center">Actual Quantity</th>
          <th class="text-center">Difference</th>
          <th class="text-center">Input By</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody id="stock-opname-table-body">
        @if ($combined->isEmpty())
          <tr>
            <td colspan="9" class="text-center">Data Not Found</td>
          </tr>
        @else
          @foreach ($combined as $stock)
            <tr>
              <td>{{ $combined->firstItem() + $loop->iteration - 1 }}</td>
              <td>{{ $stock->product_brand }}</td>
              <td>{{ $stock->product_name }}</td>
              <td>{{ $stock->type === 'product' ? 'Product' : 'Spare Part' }}</td>
              <td>{{ $stock->quantity }}</td>
              <td>
                <input type="number" class="form-control" name="actual_quantity[{{ $stock->id_stock }}]"
                  value="{{ old('actual_quantity.' . $stock->id_stock) }}">
              </td>
              <td>
                {{-- Difference calculation --}}
                <span class="text-danger" id="difference-{{ $stock->id_stock }}">
                  {{ old('actual_quantity.' . $stock->id_stock) - $stock->quantity }}
                </span>
              </td>
              <td>{{ $stock->pegawai ? $stock->pegawai->nama_pegawai : 'N/A' }}</td>
              <td class="d-flex justify-content-center align-items-center">
                <form action="{{ route('pos.management-stock.opname.delete', ['id_opname' => $stock->id_opname]) }}"
                  method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" title="Delete Stock Opname">
                    <i class="fas fa-trash"></i> Delete
                  </button>
                </form>

              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
  </div>

  <div class="d-flex justify-content-end mt-4">
    <nav aria-label="Page navigation">
      <ul class="pagination">
        {{-- Pagination here --}}
      </ul>
    </nav>
  </div>
@endsection
