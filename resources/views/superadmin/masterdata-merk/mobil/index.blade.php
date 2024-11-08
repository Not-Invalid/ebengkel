@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Merk Mobil
@stop

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>List Merk Mobil</h2>
            <a href="{{ route('merk-mobil-create') }}" class="btn btn-custom-2 btn-sm">
                <i class="fas fa-plus"></i> Tambah Merk Baru
            </a>
        </div>

        <table class="table table-bordered">
            <thead class="field-title">
                <tr>
                    <th>No</th>
                    <th>Nama Merk</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($merks as $index => $merk)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $merk->nama_merk }}</td>
                        <td class="text-center">
                            <a href="{{ route('merk-mobil-edit', $merk->id) }}" class="btn btn-custom-3 my-2" title="Edit" category-bs-toggle="tooltip">
                                <i class="fas fa-edit text-primary"></i>
                            </a>

                            <form action="{{ route('merk-mobil-delete', $merk->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete" title="Delete" data-bs-toggle="tooltip" style="border: none; background: none;">
                                    <i class="fas fa-trash-alt text-white"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-4">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                @if ($merks->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link bg-light border-0 rounded-pill"><i class="fas fa-chevron-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a href="{{ $merks->previousPageUrl() }}" class="page-link bg-light border-0 rounded-pill hover:bg-danger text-dark"><i class="fas fa-chevron-left"></i></a>
                    </li>
                @endif

                @foreach ($merks->getUrlRange(1, $merks->lastPage()) as $page => $url)
                    @if ($page == $merks->currentPage())
                        <li class="page-item active">
                            <span class="page-num page-link text-white border-0 rounded-pill">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a href="{{ $url }}" class="page-link bg-light border-0 rounded-pill hover:bg-danger text-dark">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach

                @if ($merks->hasMorePages())
                    <li class="page-item">
                        <a href="{{ $merks->nextPageUrl() }}" class="page-link bg-light border-0 rounded-pill hover:bg-danger text-dark"><i class="fas fa-chevron-right"></i></a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link bg-light border-0 rounded-pill"><i class="fas fa-chevron-right"></i></span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endsection
