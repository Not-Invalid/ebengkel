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
                        <a href="javascript:;" class="btn btn-primary daterange-btn icon-left btn-icon"><i class="fas fa-calendar"></i> Choose Date
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
                        <select name="download_format" id="downloadFormat" class="form-control w-auto mx-2">
                            <option value="" disabled selected>Download</option>
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                        </select>
                    </div>
                </div>

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
                        <tbody id="table-body">
                            {{-- @forelse ($items as $index => $item) --}}
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            {{-- @empty
                                <tr>
                                    <td colspan="7" class="text-center">Data Not Found</td>
                                </tr>
                            @endforelse --}}
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
@endsection
