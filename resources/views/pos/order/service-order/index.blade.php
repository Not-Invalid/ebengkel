@extends('pos.layouts.app')

@section('title')
    eBengkelku | Service Orders
@stop

@php
    $header = 'Service Orders';
@endphp

@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if ($orders->isEmpty())
                        <div class="empty-state" data-height="400" style="height: 400px;">
                            <div class="empty-state-icon">
                                <i class="fas fa-question"></i>
                            </div>
                            <h2>We couldn't find any data</h2>
                            <a href="{{ route('pos.service-order.create', $bengkel->id_bengkel) }}"
                                class="btn btn-primary mt-4">Create
                                new One Service Orders</a>
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
                                <a href="{{ route('pos.service-order.create', ['id_bengkel' => $bengkel->id_bengkel]) }}"
                                    class="btn btn-info text-white px-4 py-2 mx-2">Add Service Orders </a>
                            </div>
                        </div>
                        <div class="table-responsive bg-white rounded shadow-sm">
                            <table class="table table-bordered table-striped text-center">
                                <thead class="bg-light-grey text-white">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Order Date</th>
                                        <th class="text-center">Cashier</th>
                                        <th class="text-center">Customer Name</th>
                                        <th class="text-center">Phone Number</th>
                                        <th class="text-center">Service Name</th>
                                        <th class="text-center">Order Status</th>
                                        <th class="text-center">Order Price</th>
                                        <th class="text-center">Tools</th>
                                    </tr>
                                </thead>
                                <tbody id="order-table-body">
                                    @foreach ($orders as $index => $order)
                                        <tr>
                                            <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $index + 1 }}</td>
                                            <td>{{ $order->tgl_pesanan }}</td>
                                            <td>{{ $order->pegawai ? $order->pegawai->nama_pegawai : 'Online' }}</td>
                                            <!-- Display employee name or 'N/A' -->
                                            <td>{{ $order->nama_pemesan }}</td>
                                            <td>{{ $order->telp_pelanggan }}</td>
                                            <td>{{ $order->nama_services }}</td>
                                            <td>{{ ucfirst($order->status) }}</td>
                                            <td>Rp {{ number_format($order->total_pesanan, 2, ',', '.') }}</td>
                                            <td class="d-flex justify-content-center align-items-center gap-4">
                                                @if ($order->status === 'DONE')
                                                    <form
                                                        action="{{ route('pos.transaction-history', ['id_bengkel' => $bengkel->id_bengkel]) }}"
                                                        class="info-transaction">
                                                        <button type="submit" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-info-circle align-icon"></i> Info
                                                        </button>
                                                    </form>
                                                @else
                                                    <form
                                                        action="{{ route('pos.service-order.delete', ['id_bengkel' => $bengkel->id_bengkel]) }}"
                                                        method="POST" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash-alt"></i> Delete
                                                        </button>
                                                    </form>

                                                    <form
                                                        action="{{ route('pos.service-order.update-status', ['id_bengkel' => $bengkel->id_bengkel, 'id' => $order->id_pesanan]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="fas fa-check"></i> Done
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if (!$orders->isEmpty())
                        <div class="d-flex justify-content-between mt-4">
                            <div>
                                <span>Showing {{ $start }} to {{ $end }} of {{ $totalEntries }}
                                    entries</span>
                            </div>
                            <div class="d-flex">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        @if ($orders->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link"><i class="fa-solid fa-chevron-left"></i></span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a href="{{ $orders->previousPageUrl() }}" class="page-link"><i
                                                        class="fa-solid fa-chevron-left"></i></a>
                                            </li>
                                        @endif

                                        @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                                            @if ($page == $orders->currentPage())
                                                <li class="page-item active"><span
                                                        class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item"><a href="{{ $url }}"
                                                        class="page-link">{{ $page }}</a></li>
                                            @endif
                                        @endforeach

                                        @if ($orders->hasMorePages())
                                            <li class="page-item">
                                                <a href="{{ $orders->nextPageUrl() }}" class="page-link"><i
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

            filterTable('order-table-body', [1, 2, 3, 4, 5]);
        });
    </script>
@endsection
