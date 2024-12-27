@extends('pos.layouts.app')

@section('title')
    eBengkelku | POS
@stop

@php
    $header = 'Laporan Laba Rugi';
@endphp

@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    @if ($labarugi->isEmpty())
                        <div class="empty-state" data-height="400" style="height: 400px;">
                            <div class="empty-state-icon">
                                <i class="fas fa-question"></i>
                            </div>
                            <h2>We couldn't find any data</h2>
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
                                <a href="{{ route('labarugi.export.pdf', ['id_bengkel' => $bengkel->id_bengkel]) }}"
                                    class="btn btn-danger text-white px-4 py-2 mx-2" data-toggle="tooltip"
                                    data-placement="top" title="PDF">
                                    <i class="fa-solid fa-file-pdf fa-xl"></i>
                                </a>
                                <a href="{{ route('labarugi.export.excel', ['id_bengkel' => $bengkel->id_bengkel]) }}"
                                    class="btn btn-success text-white px-4 py-2 mx-2" data-toggle="tooltip"
                                    data-placement="top" title="Excel">
                                    <i class="fa-solid fa-file-excel fa-xl"></i>
                                </a>
                            </div>
                        </div>

                        <div class="table-responsive bg-white rounded shadow">
                            <table class="table table-bordered table-striped text-center">
                                <thead class="bg-light-grey text-white">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Keterangan</th>
                                        <th class="text-center">Nominal Debit</th>
                                        <th class="text-center">Nominal Kredit</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    @forelse ($labarugi as $index => $item)
                                        <tr>
                                            <td>{{ $start + $index }}</td>
                                            <td>{{ $item->tanggal }}</td>
                                            <td>{{ $item->keterangan }}</td>
                                            <td>{{ formatRupiah($item->nominal_debit) }}</td>
                                            <td>{{ formatRupiah($item->nominal_kredit) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right font-weight-bold">Total</td>
                                        <td></td>
                                        <td></td>
                                        <td class="font-weight-bold">{{ formatRupiah($totalDebit) }}</td>
                                        <td class="font-weight-bold">{{ formatRupiah($totalKredit) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between mt-4">
                            <div>
                                <span>Showing {{ $start }} to {{ $end }} of {{ $totalEntries }}
                                    entries</span>
                            </div>
                            <div class="d-flex">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        @if ($labarugi->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link"><i class="fa-solid fa-chevron-left"></i></span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a href="{{ $labarugi->previousPageUrl() }}" class="page-link"><i
                                                        class="fa-solid fa-chevron-left"></i></a>
                                            </li>
                                        @endif

                                        @foreach ($labarugi->getUrlRange(1, $labarugi->lastPage()) as $page => $url)
                                            @if ($page == $labarugi->currentPage())
                                                <li class="page-item active"><span
                                                        class="page-link">{{ $page }}</span></li>
                                            @else
                                                <li class="page-item"><a href="{{ $url }}"
                                                        class="page-link">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endforeach

                                        @if ($labarugi->hasMorePages())
                                            <li class="page-item">
                                                <a href="{{ $labarugi->nextPageUrl() }}" class="page-link"><i
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

            filterTable('table-body', [1, 2]);
        });
    </script>

@endsection
