@extends('pos.layouts.app')

@section('title')
  eBengkelku | Management Stock
@stop

@php
  $header = 'Stock Inbound';
@endphp

@section('content')
  <div class="row">
    <div class="col">
      <div class="card shadow-sm">
        <div class="card-body">
          {{-- Show Empty Data if No Stocks --}}
          @if ($combined->isEmpty())
            <div class="empty-state" data-height="400" style="height: 400px;">
              <div class="empty-state-icon">
                <i class="fas fa-question"></i>
              </div>
              <h2>We couldn't find any data</h2>
              <a href="{{ route('pos.management-stock.inbound.create', $bengkel->id_bengkel) }}"
                class="btn btn-primary mt-4">Create new One</a>
            </div>
          @else
            <div class="d-flex justify-between">
              <div class="d-flex justify-start mb-4">
                <select name="per_page" id="perPage" class="form-control w-auto mx-2">
                  <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                  <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                  <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                  <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                </select>
              </div>
              <div class="d-flex justify-center w-100 mx-2 mb-4">
                <input type="text" id="search" class="form-control w-60" placeholder="Search">
              </div>

              <div class="d-flex justify-end mb-4">
                <a href="{{ route('pos.management-stock.inbound.create', $bengkel->id_bengkel) }}"
                  class="btn btn-info text-white px-4 py-2 mx-2">Add New Stock</a>
              </div>
            </div>

            <div class="table-responsive bg-white rounded shadow-sm">
              <table class="table table-bordered table-striped text-center">
                <thead class="bg-light-grey text-white">
                  <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Merk</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Input By</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody id="inbound-table-body">

                  @foreach ($combined as $stock)
                    <tr>
                      <td>{{ $combined->firstItem() + $loop->iteration - 1 }}</td>
                      <td>{{ $stock->product_brand }}</td>
                      <td>{{ $stock->product_name }}</td>
                      <td>
                        {{-- Display type --}}
                        @if ($stock->type === 'product')
                          Product
                        @elseif ($stock->type === 'spare_part')
                          Spare Part
                        @endif
                      </td>
                      <td>{{ $stock->quantity }}</td>
                      <td>{{ $stock->pegawai ? $stock->pegawai->nama_pegawai : 'N/A' }}</td>
                      <td>{{ $stock->description }}</td>
                      <td class="d-flex justify-content-center align-items-center">
                        <form
                          action="{{ route('pos.management-stock.inbound.delete', ['id_bengkel' => $bengkel->id_bengkel, 'id_stock' => $stock->id_stock]) }}"
                          method="POST" class="delete-form">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger" title="Delete Stock">
                            <i class="fas fa-trash"></i> Delete
                          </button>
                        </form>
                      </td>
                    </tr>
                  @endforeach

                </tbody>
              </table>
            </div>

            <div class="d-flex justify-content-between mt-4">
              <div>
                <span>Showing {{ $start }} to {{ $end }} of {{ $totalEntries }} entries</span>
              </div>
              <div class="d-flex">
                <nav aria-label="Page navigation">
                  <ul class="pagination">
                    @if ($combined->onFirstPage())
                      <li class="page-item disabled">
                        <span class="page-link"><i class="fa-solid fa-chevron-left"></i></span>
                      </li>
                    @else
                      <li class="page-item">
                        <a href="{{ $combined->previousPageUrl() }}" class="page-link"><i
                            class="fa-solid fa-chevron-left"></i></a>
                      </li>
                    @endif

                    @foreach ($combined->getUrlRange(1, $combined->lastPage()) as $page => $url)
                      @if ($page == $combined->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                      @else
                        <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a>
                        </li>
                      @endif
                    @endforeach

                    @if ($combined->hasMorePages())
                      <li class="page-item">
                        <a href="{{ $combined->nextPageUrl() }}" class="page-link"><i
                            class="fa-solid fa-chevron-right"></i></a>
                      </li>
                    @else
                      <li class="page-item disabled">
                        <span class="page-link"><i class="fa-solid fa-chevron-right"></i></span>
                      </li>
                    @endif
                  </ul>
                </nav>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>



  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const deleteForms = document.querySelectorAll('.delete-form');
      deleteForms.forEach(form => {
        form.addEventListener('submit', function(event) {
          event.preventDefault();
          Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              form.submit();
            }
          });
        });
      });
    });
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

        if (!tableBody) return; // Ensure the table body exists

        searchInput.addEventListener('input', function() {
          const searchText = searchInput.value.toLowerCase();

          Array.from(tableBody.children).forEach(row => {
            const matches = columnIndices.some(index =>
              row.children[index].textContent.toLowerCase().includes(searchText)
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
      filterTable('inbound-table-body', [1, 2]);
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
