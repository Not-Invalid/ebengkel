@extends('pos.layouts.app')

@section('title')
    eBengkelku | POS
@stop

@php
    $header = 'Expense Record';
@endphp

@section('content')
<div class="row">
    <div class="col">
        <div class="card shadow">
            <div class="card-body">
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
                        <a href="{{ route('pos.expense-record.create', ['id_bengkel' => $bengkel->id_bengkel]) }}"
                          class="btn btn-info text-white px-4 py-2 mx-2">Add Expense Record</a>
                    </div>
                </div>

                <div class="table-responsive bg-white rounded shadow">
                    <table class="table table-bordered table-striped text-center">
                        <thead class="bg-light-grey text-white">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Jenis Pengeluaran</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Nominal</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Input By</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @forelse ($expenseRecords as $index => $expense)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $expense->jenisPengeluaran->nama_jenis_pengeluaran ?? 'N/A' }}</td>
                                    <td>{{ $expense->tanggal }}</td>
                                    <td>Rp {{ number_format($expense->nominal, 0, ',', '.') }}</td>
                                    <td>{{ $expense->keterangan }}</td>
                                    <td>{{ $expense->input_by }}</td>
                                    <td class="d-flex gap-3 align-items-center justify-content-center">
                                        <a href="{{ route('pos.expense-record.edit', ['id_bengkel' => $bengkel->id_bengkel, 'id_pengeluaran' => $expense->id_pengeluaran]) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>

                                        <form action="{{ route('pos.expense-record.delete', ['id_bengkel' => $bengkel->id_bengkel, 'id_pengeluaran' => $expense->id_pengeluaran]) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </form>
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

                <!-- Pagination -->
                <div class="d-flex justify-content-between mt-4">
                    <div>
                        <span>Showing {{ $start }} to {{ $end }} of {{ $totalEntries }} entries</span>
                    </div>
                    <div class="d-flex">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                @if ($expenseRecords->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="fa-solid fa-chevron-left"></i></span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a href="{{ $expenseRecords->previousPageUrl() }}" class="page-link"><i class="fa-solid fa-chevron-left"></i></a>
                                    </li>
                                @endif

                                @foreach ($expenseRecords->getUrlRange(1, $expenseRecords->lastPage()) as $page => $url)
                                    @if ($page == $expenseRecords->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                @if ($expenseRecords->hasMorePages())
                                    <li class="page-item">
                                        <a href="{{ $expenseRecords->nextPageUrl() }}" class="page-link"><i class="fa-solid fa-chevron-right"></i></a>
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
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function (event) {
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

    document.getElementById('perPage').addEventListener('change', function () {
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
                        row.children[index].textContent.toLowerCase().includes(searchText)
                    );
                    row.style.display = matches ? '' : 'none';
                });
            });
        };

        filterTable('table-body', [1, 2]);
    });
</script>

@endsection
