@extends('pos.layouts.app')

@section('title')
  eBengkelku | POS
@stop

@php
  $header = 'Transaction History';
@endphp

@section('content')
  <div class="row">
    <div class="col">
      <div class="card shadow">
        <div class="card-body">
          <div class="d-flex justify-start mb-4">
            <div class="form-group">
              <label class="d-block">Date Range Picker With Button</label>
              <a href="javascript:;" class="btn btn-primary daterange-btn icon-left btn-icon"><i class="fas fa-calendar"></i>
                Choose Date
              </a>
            </div>
          </div>

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
              <select name="download_format" id="downloadFormat" class="form-control w-auto mx-2"
                onchange="handleDownload(this)">
                <option value="" disabled selected hidden>Download</option>
                <option value="pdf" onclick="">PDF</option>
                <option value="excel">Excel</option>
              </select>
            </div>
          </div>
          <input type="hidden" id="id_bengkel" value="{{ $bengkel->id_bengkel }}">

          <div class="table-responsive bg-white rounded shadow">
            <table class="table table-bordered table-striped text-center">
              <thead class="bg-light-grey text-white">
                <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">Customer Name</th>
                  <th class="text-center">Transaction Type</th>
                  <th class="text-center">Payment Method</th>
                  <th class="text-center">Total Price</th>
                  <th class="text-center">Cashier</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody id="transaction-table-body">
                @forelse ($transactions as $index => $transaction)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $transaction['customer_name'] }}</td>
                    <td>{{ $transaction['transaction_type'] }}</td>
                    <td>{{ $transaction['payment_method'] }}</td>
                    <td>Rp {{ number_format($transaction['total_price'], 2, ',', '.') }}</td>
                    <td>{{ $transaction['cashier'] }}</td>
                    <td class="d-flex justify-content-center align-items-center gap-4">
                      <a role="button" class="btn btn-danger text-white" data-toggle="tooltip" title="Print PDF"
                        onclick="printRow(this)">
                        <i class="fas fa-file-pdf"> </i>
                      </a>
                      <a rolone="button" class="btn btn-success text-white" data-toggle="tooltip" title="Print Excel"
                        onclick="printRow(this)">
                        <i class="fas fa-file-excel"> </i>
                      </a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-center">Data Not Found</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <!-- Showing Entries Info -->
          {{-- <div class="d-flex justify-content-between mt-4">
                    <div>
                        <span>Showing {{ $start }} to {{ $end }} of {{ $totalEntries }} entries</span>
                    </div>
                    <div class="d-flex">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                @if ($items->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="fa-solid fa-chevron-left"></i></span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a href="{{ $items->previousPageUrl() }}" class="page-link"><i class="fa-solid fa-chevron-left"></i></a>
                                    </li>
                                @endif

                                @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
                                    @if ($page == $items->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                <!-- Next Page Button -->
                                @if ($items->hasMorePages())
                                    <li class="page-item">
                                        <a href="{{ $items->nextPageUrl() }}" class="page-link"><i class="fa-solid fa-chevron-right"></i></a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="fa-solid fa-chevron-right"></i></span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div> --}}
        </div>
      </div>
    </div>
  </div>

  <script>
    function handleDownload(select) {
      const value = select.value;
      const id_bengkel = document.getElementById('id_bengkel').value;
      if (value === 'pdf') {
        let url = '{{ route('pos.transaction-history.pdf', ':id_bengkel') }}';
        url = url.replace(':id_bengkel', id_bengkel);
        window.location.href = url;
      }
      if (value === 'excel') {
        let url = '{{ route('pos.transaction-history.excel', ':id_bengkel') }}';
        url = url.replace(':id_bengkel', id_bengkel);
        window.location.href = url;
      }
    }
  </script>

  {{-- <script>
        function printRow(button) {
            const row = button.closest('tr'); // Get the closest row
            const rowData = Array.from(row.children).map(cell => cell.innerText); // Extract text from each cell

            const printWindow = window.open('', '_blank');
            printWindow.document.write('<html><head><title>Transaction Print</title></head><body>');
            printWindow.document.write('<h3>Transaction Details</h3>');
            printWindow.document.write(
                '<table border="1" style="width: 100%; text-align: left; border-collapse: collapse;">');
            printWindow.document.write(
                '<tr><th>No</th><th>Customer Name</th><th>Transaction Type</th><th>Payment Method</th><th>Total Price</th><th>Cashier</th></tr>'
            );
            printWindow.document.write('<tr>');
            rowData.forEach(data => {
                printWindow.document.write(`<td>${data}</td>`);
            });
            printWindow.document.write('</tr>');
            printWindow.document.write('</table>');
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script> --}}

  <script>
    document.getElementById('perPage').addEventListener('change', function() {
      const perPageValue = this.value;
      const url = new URL(window.location.href);
      url.searchParams.set('per_page', perPageValue);
      window.location.href = url;
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

      filterTable('transaction-table-body', [1, 2]);
    });
  </script>
@endsection
