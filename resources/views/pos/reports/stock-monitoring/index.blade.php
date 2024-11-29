@extends('pos.layouts.app')

@section('title')
    eBengkelku | POS
@stop

@php
    $header = 'Stock Monitoring';
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
                    <div class="d-flex justify-start mb-4">
                        <select name="type" id="type" class="form-control w-auto mx-2" onchange="filterType()">
                            <option value="10" {{ $type == '10' ? 'selected' : '' }}>Product</option>
                            <option value="25" {{ $type == '25' ? 'selected' : '' }}>Sparepart</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive bg-white rounded shadow">
                    <table class="table table-bordered table-striped text-center">
                        <thead class="bg-light-grey text-white">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Photo</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @forelse ($items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $type == '10' ? $item->nama_produk : $item->nama_spare_part }}</td>
                                    <td>
                                        @if ($type == '10')
                                            <img src="{{ isset($item->foto_produk) && $item->foto_produk ? url($item->foto_produk) : asset('assets/images/components/image.png') }}"
                                                 alt="Product Image" width="50" height="50" class="rounded">
                                        @else
                                            <img src="{{ isset($item->foto_spare_part) && $item->foto_spare_part ? url($item->foto_spare_part) : asset('assets/images/components/image.png') }}"
                                                 alt="Sparepart Image" width="50" height="50" class="rounded">
                                        @endif
                                    </td>
                                    <td>{{ $type == '10' ? $item->stok_produk : $item->stok_spare_part }}</td>
                                    <td>
                                        Rp {{ number_format($type == '10' ? $item->harga_produk : $item->harga_spare_part, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <span class="text-white badge {{ $item->status == 'Available' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $item->status }}
                                        </span>
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
                <div class="d-flex justify-content-between mt-4">
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
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function filterType() {
        const type = document.getElementById('type').value;
        const perPage = document.getElementById('perPage').value;
        const search = document.getElementById('search').value;

        const url = new URL(window.location.href);
        url.searchParams.set('type', type);
        url.searchParams.set('per_page', perPage);
        if (search) {
            url.searchParams.set('search', search);
        }

        window.location.href = url.toString();
    }

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
