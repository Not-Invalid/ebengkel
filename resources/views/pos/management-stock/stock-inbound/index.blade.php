@extends('pos.layouts.app')

@section('title')
  eBengkelku | POS
@stop

@php
  $header = 'Stock';
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
      <a href="{{ route('pos.management-stock.create', ['id_bengkel' => $bengkel->id_bengkel]) }}"
        class="btn btn-info text-white px-4 py-2 mx-2">Add New Stock</a>
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
          <th class="text-center">Quantity</th>
          <th class="text-center">Description</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody id="staff-table-body">
        @if ($combined->isEmpty())
          <tr>
            <td colspan="7" class="text-center">Data Not Found</td>
          </tr>
        @else
          @foreach ($combined as $stock)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $stock->product_brand }}</td>
              <td>{{ $stock->product_name }}</td>
              <td>
                <img src="{{ $stock->product_image }}" alt="Product Image" width="50" height="50" class="rounded">
              </td>
              <td>{{ $stock->quantity }}</td>
              <td>{{ $stock->description }}</td>
              <td class="d-flex justify-content-center align-items-center">
                <form
                  action="{{ route('pos.management-stock.delete', ['id_bengkel' => $bengkel->id_bengkel, 'id_stock' => $stock->id_stock]) }}"
                  method="POST" class="delete-form">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" title="Delete Stock">
                    <i class="fas fa-trash-alt"></i> Delete
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
        @if ($products->onFirstPage())
          <li class="page-item disabled">
            <span class="page-link"><i class="fa-solid fa-chevron-left"></i></span>
          </li>
        @else
          <li class="page-item">
            <a href="{{ $products->previousPageUrl() }}" class="page-link"><i class="fa-solid fa-chevron-left"></i></a>
          </li>
        @endif

        @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
          @if ($page == $products->currentPage())
            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
          @else
            <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
          @endif
        @endforeach

        @if ($products->hasMorePages())
          <li class="page-item">
            <a href="{{ $products->nextPageUrl() }}" class="page-link"><i class="fa-solid fa-chevron-right"></i></a>
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

      filterTable('user-table-body', 1);
      filterTable('product-table-body', [1, 2]);
      filterTable('brand-table-body', [1, 2]);
      filterTable('category-table-body', [1, 2]);
      filterTable('transactions-table-body', [1, 2]);
      filterTable('receivingnotes-table-body', [1]);
      filterTable('warehouse-table-body', [1, 2]);
      filterTable('staff-table-body', [1, 2]);
      filterTable('management-stock', [1, 2]);
    });
  </script>

  <script>
    function confirmDelete(productId, bengkelId, productId) {
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
          document.getElementById('delete-form-' + productId).submit();
        }
      });
    }
  </script>
@endsection
