@extends('pos.layouts.app')
@section('title')
    eBengkelku | POS
@stop
@php
    $header = 'Master Spare Parts';
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
            <a href="{{ route('pos.sparepart.create', ['id_bengkel' => $bengkel->id_bengkel]) }}"
                class="btn btn-info text-white px-4 py-2 mx-2">Add Product</a>
        </div>
    </div>


    <div class="table-responsive bg-white rounded shadow">
        <table class="table table-bordered table-striped text-center">
            <thead class="bg-light-grey text-white">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Sparepart Name</th>
                    <th class="text-center">Sparepart Merk</th>
                    <th class="text-center">Sparepart Photo</th>
                    <th class="text-center">Sparepart Price</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody id="staff-table-body">
                @if ($sparepart->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">Data Not Found</td>
                    </tr>
                @else
                    @foreach ($sparepart as $index => $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_spare_part }}</td>
                            <td>{{ $item->merk_spare_part }}</td>
                            <td>
                                <img src="{{ isset($item->foto_spare_part) ? url($item->foto_spare_part) : asset('assets/images/components/image.png') }}"
                                    alt="Product Image" width="50" height="50" class="rounded">
                            </td>
                            <td>Rp{{ number_format($item->harga_spare_part, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('pos.sparepart.show', ['id_bengkel' => $bengkel->id_bengkel, 'id_spare_part' => $item->id_spare_part]) }}"
                                    class="btn btn-sm btn-info"><i class="fas fa-info-circle"></i></a>
                                <a href="{{ route('pos.sparepart.edit', ['id_bengkel' => $bengkel->id_bengkel, 'id_spare_part' => $item->id_spare_part]) }}"
                                    class="btn btn-sm btn-warning"><i class="fas fa-pen-to-square"></i></a>
                                <a href="#" class="btn btn-sm btn-danger"
                                    onclick="confirmDelete('{{ $item->id_spare_part }}', '{{ $bengkel->id_bengkel }}', '{{ $item->id_spare_part }}')">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <form id="delete-form-{{ $item->id_spare_part }}"
                                    action="{{ route('pos.sparepart.destroy', ['id_bengkel' => $bengkel->id_bengkel, 'id_spare_part' => $item->id_spare_part]) }}"
                                    method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
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
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
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


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

            filterTable('user-table-body', 1);
            filterTable('product-table-body', [1, 2]);
            filterTable('brand-table-body', [1, 2]);
            filterTable('category-table-body', [1, 2]);
            filterTable('transactions-table-body', [1, 2]);
            filterTable('receivingnotes-table-body', [1]);
            filterTable('warehouse-table-body', [1, 2]);
            filterTable('staff-table-body', [1, 2]);
        });
    </script>
    <script>
        function confirmDelete(sparepartId, bengkelId, sparepartId) {
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
                    document.getElementById('delete-form-' + sparepartId).submit();
                }
            });
        }
    </script>
@endsection