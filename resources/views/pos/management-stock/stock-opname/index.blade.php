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
        class="btn btn-info text-white px-4 py-2 mx-2">Add Stock Opname</a>
    </div>
  </div>

  <div class="table-responsive bg-white rounded shadow">
    <table class="table table-bordered table-striped text-center">
      <thead class="bg-light-grey text-white">
        <tr>
          <th class="text-center">No</th>
          <th class="text-center">Merk Product</th>
          <th class="text-center">Product Name</th>
          <th class="text-center">Product Photo</th>
          <th class="text-center">Stock Recorded</th>
          <th class="text-center">Stock Actual</th>
          <th class="text-center">Difference</th>
          <th class="text-center">Status</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody id="stock-opname-table-body">
        @if ($combined->isEmpty())
          <tr>
            <td colspan="9" class="text-center">Data Not Found</td>
          </tr>
        @else
          @foreach ($combined as $opname)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $opname->product_brand }}</td>
              <td>{{ $opname->product_name }}</td>
              <td>
                <img src="{{ $opname->product_image }}" alt="Product Image" width="50" height="50" class="rounded">
              </td>
              <td>{{ $opname->stock_recorded }}</td>
              <td>{{ $opname->stock_actual }}</td>
              <td>{{ $opname->stock_actual - $opname->stock_recorded }}</td>
              <td>
                @if ($opname->stock_actual == $opname->stock_recorded)
                  <span class="badge badge-success">Matched</span>
                @else
                  <span class="badge badge-warning">Mismatch</span>
                @endif
              </td>
              <td class="d-flex justify-content-center align-items-center">
                <form action="{{ route('pos.stock-opname.delete', ['id_opname' => $opname->id_opname]) }}" method="POST"
                  class="delete-form">
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

  <!-- Pagination -->
  <div class="d-flex justify-content-end mt-4">
    <nav aria-label="Page navigation">
      <ul class="pagination">
        @if ($combined->onFirstPage())
          <li class="page-item disabled">
            <span class="page-link"><i class="fa-solid fa-chevron-left"></i></span>
          </li>
        @else
          <li class="page-item">
            <a href="{{ $stockOpname->previousPageUrl() }}" class="page-link"><i
                class="fa-solid fa-chevron-left"></i></a>
          </li>
        @endif

        @foreach ($combined->getUrlRange(1, $stockOpname->lastPage()) as $page => $url)
          @if ($page == $stockOpname->currentPage())
            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
          @else
            <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
          @endif
        @endforeach

        @if ($combined->hasMorePages())
          <li class="page-item">
            <a href="{{ $stockOpname->nextPageUrl() }}" class="page-link"><i class="fa-solid fa-chevron-right"></i></a>
          </li>
        @else
          <li class="page-item disabled">
            <span class="page-link"><i class="fa-solid fa-chevron-right"></i></span>
          </li>
        @endif
      </ul>
    </nav>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Real-time filter dropdown for number of records per page
    document.getElementById('perPage').addEventListener('change', function() {
      const perPageValue = this.value;
      const url = new URL(window.location.href);
      url.searchParams.set('per_page', perPageValue); // Set the per_page parameter
      window.location.href = url; // Reload page with new query
    });

    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('search');

      const filterTable = (tableBodyId, columnIndices) => {
        const tableBody = document.getElementById(tableBodyId);

        searchInput.addEventListener('input', function() {
          const searchText = searchInput.value.toLowerCase();

          Array.from(tableBody.children).forEach(row => {
            const matches = columnIndices.some(index =>
              row.children[index].textContent.toLowerCase().includes(
                searchText)
            );
            row.style.display = matches ? '' : 'none';
          });
        });
      };

      filterTable('stock-opname-table-body', [1, 2, 3]);
    });
  </script>

  <script>
    function confirmDelete(opnameId, bengkelId) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        reverseButtons: true,
        customClass: {
          confirmButton: 'btn btn-custom-icon',
          cancelButton: 'btn btn-cancel'
        },
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('delete-form-' + opnameId).submit();
        }
      });
    }
  </script>
@endsection
