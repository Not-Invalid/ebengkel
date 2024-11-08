@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Workshop Data
@stop

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>List Registered Workshop</h2>
    </div>
    <table class="table table-bordered">
        <thead class="field-title">
            <tr>
                <th>No</th>
                <th>Nama Bengkel</th>
                <th>Pemilik</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($workshop as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->nama_bengkel }}</td>
                    <td>{{ $data->pelanggan ? $data->pelanggan->nama_pelanggan : 'Unknown' }}</td>
                    <td class="text-center">
                        <a href="{{-- route('bengkel.show', $data->id_bengkel) --}}" class="btn btn-custom-3 my-2" title="Detail" data-bs-toggle="tooltip">
                            <i class="fas fa-circle-info text-primary"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-end mt-4">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                @if ($workshop->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link bg-light border-0 rounded-pill"><i class="fas fa-chevron-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a href="{{ $workshop->previousPageUrl() }}" class="page-link bg-light border-0 rounded-pill hover:bg-danger text-dark"><i class="fas fa-chevron-left"></i></a>
                    </li>
                @endif

                @foreach ($workshop->getUrlRange(1, $workshop->lastPage()) as $page => $url)
                    @if ($page == $workshop->currentPage())
                        <li class="page-item active">
                            <span class="page-num page-link text-white border-0 rounded-pill">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a href="{{ $url }}" class="page-link bg-light border-0 rounded-pill hover:bg-danger text-dark">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach

                @if ($workshop->hasMorePages())
                    <li class="page-item">
                        <a href="{{ $workshop->nextPageUrl() }}" class="page-link bg-light border-0 rounded-pill hover:bg-danger text-dark"><i class="fas fa-chevron-right"></i></a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link bg-light border-0 rounded-pill"><i class="fas fa-chevron-right"></i></span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</div>
@endsection
