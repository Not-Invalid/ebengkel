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

                    <div class="d-flex justify-end mb-4">
                        <form method="get" action="{{ route('pos.order-online', ['id_bengkel' => $bengkel->id_bengkel]) }}">
                            <select name="status_order" id="status_order" class="form-control w-auto mx-2" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="PENDING" {{ request('status_order') == 'PENDING' ? 'selected' : '' }}>Pending</option>
                                <option value="Waiting_Confirmation" {{ request('status_order') == 'Waiting_Confirmation' ? 'selected' : '' }}>Waiting Confirmation</option>
                                <option value="DIKEMAS" {{ request('status_order') == 'DIKEMAS' ? 'selected' : '' }}>Dikemas</option>
                                <option value="DIKIRIM" {{ request('status_order') == 'DIKIRIM' ? 'selected' : '' }}>Dikirim</option>
                                <option value="SELESAI" {{ request('status_order') == 'SELESAI' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </form>
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
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Grand Total</th>
                                <th class="text-center">Jenis Pembayaran</th>
                                <th class="text-center">Status Order</th>
                                <th class="text-center">Tanggal Order</th>
                                <th class="text-center">Tools</th>
                            </tr>
                        </thead>
                        <tbody id="order-table-body">
                            @if ($orderonline->isEmpty())
                                <tr>
                                    <td colspan="10" class="text-center">Data Not Found</td>
                                </tr>
                            @else
                                @foreach ($orderonline as $index => $order)
                                    <tr>
                                        <td style="font-size: 12px;">{{ $loop->iteration }}</td>
                                        <td style="font-size: 13px;">
                                            @if ($order->orderItems->isNotEmpty())
                                                @foreach ($order->orderItems as $item)
                                                    @if ($item->produk)
                                                        {{ $item->produk->nama_produk }} ({{ $item->qty }})
                                                    @elseif ($item->sparepart)
                                                        {{ $item->sparepart->nama_spare_part }} ({{ $item->qty }})
                                                    @endif
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td style="font-size: 13px;">{{ $order->order_id }}</td>
                                        <td style="font-size: 13px;">{{ $order->pelanggan->nama_pelanggan ?? 'N/A' }}</td>
                                        <td style="font-size: 13px;">{{ $order->orderItems->sum('qty') }}</td>
                                        <td style="font-size: 13px;">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</td>
                                        <td style="font-size: 13px;">{{ $order->invoice->jenis_pembayaran }} - {{ $order->invoice->bank_tujuan }} </td>

                                        <td class="d-flex align-items-center justify-content-center">
                                            @php
                                                $statusNames = [
                                                    'PENDING' => 'Pending',
                                                    'Waiting_Confirmation' => 'Waiting Confirmation',
                                                    'DIKEMAS' => 'Dikemas',
                                                    'DIKIRIM' => 'Dikirim',
                                                    'SELESAI' => 'Selesai'
                                                ];
                                            @endphp

                                            @if (array_key_exists($order->status_order, $statusNames))
                                                <div class="badge fixed-width
                                                    @if ($order->status_order == 'PENDING') badge-secondary
                                                    @elseif ($order->status_order == 'Waiting_Confirmation') badge-warning
                                                    @elseif ($order->status_order == 'DIKEMAS') badge-primary
                                                    @elseif ($order->status_order == 'DIKIRIM') badge-info
                                                    @elseif ($order->status_order == 'SELESAI') badge-success
                                                    @else badge-secondary
                                                    @endif">
                                                    {{ $statusNames[$order->status_order] }}
                                                </div>
                                            @else
                                                <div class="badge badge-secondary fixed-width">Unknown</div>
                                            @endif
                                        </td>
                                        <td style="font-size: 13px;">{{ $order->tanggal ? \Carbon\Carbon::parse($order->tanggal)->format('d-m-Y') : 'N/A' }}</td>

                                        <td class="d-flex justify-content-center align-items-center gap-4">
                                            <a href="{{ route('pos.order-online.edit', ['id_bengkel' => $bengkel->id_bengkel, 'order_id' => $order->order_id]) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
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
                                @if ($orderonline->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="fa-solid fa-chevron-left"></i></span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a href="{{ $orderonline->previousPageUrl() }}" class="page-link"><i class="fa-solid fa-chevron-left"></i></a>
                                    </li>
                                @endif

                                @foreach ($orderonline->getUrlRange(1, $orderonline->lastPage()) as $page => $url)
                                    @if ($page == $orderonline->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                @if ($orderonline->hasMorePages())
                                    <li class="page-item">
                                        <a href="{{ $orderonline->nextPageUrl() }}" class="page-link"><i class="fa-solid fa-chevron-right"></i></a>
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
                row.children[index].textContent.toLowerCase().includes(searchText)
                );
                row.style.display = matches ? '' : 'none';
            });
            });
        };

        filterTable('order-table-body', [1, 2, 3, 6, 7]);
    });
</script>
@endsection
