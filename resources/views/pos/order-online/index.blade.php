@extends('pos.layouts.app')

@section('title')
    eBengkelku | POS
@stop

@php
    $header = 'List Order Online';
@endphp

@section('content')

    <div class="row">
        <div class="col">
            <div class="card shadow-sm">
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
                    </div>

                    <div class="table-responsive bg-white rounded shadow-sm">
                        <table class="table table-bordered table-striped text-center">
                            <thead class="bg-light-grey text-white">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Item Name</th>
                                    <th class="text-center">Order ID</th>
                                    <th class="text-center">Nama Pemesan</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Grand Total</th>
                                    <th class="text-center">Tools</th>
                                </tr>
                            </thead>
                            <tbody id="sparepart-table-body">
                            </tbody>
                        </table>
                    </div>

                    {{-- <div class="d-flex justify-content-between mt-4">
                        <div>
                            <span>Showing {{  }} to {{  }} of {{  }}
                                entries</span>
                        </div>
                        <div class="d-flex">
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    @if ($sparepart->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="fa-solid fa-chevron-left"></i></span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a href="{{ $sparepart->previousPageUrl() }}" class="page-link"><i
                                                    class="fa-solid fa-chevron-left"></i></a>
                                        </li>
                                    @endif

                                    @foreach ($sparepart->getUrlRange(1, $sparepart->lastPage()) as $page => $url)
                                        @if ($page == $sparepart->currentPage())
                                            <li class="page-item active"><span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item"><a href="{{ $url }}"
                                                    class="page-link">{{ $page }}</a></li>
                                        @endif
                                    @endforeach

                                    @if ($sparepart->hasMorePages())
                                        <li class="page-item">
                                            <a href="{{ $sparepart->nextPageUrl() }}" class="page-link"><i
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
                    </div> --}}
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

            filterTable('sparepart-table-body', [1, 2]);
        });
    </script>

@endsection
