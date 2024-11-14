@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Staff User
@stop

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Data Staff Admin</h2>
            <a href="{{ route('data-staff-create') }}" class="btn btn-custom-2 btn-sm">
                <i class="fas fa-plus"></i> Tambah Staff Baru
            </a>
        </div>

        <table class="table table-bordered">
            <thead class="field-title">
                <tr>
                    <th>No</th>
                    <th>Nama Staff</th>
                    <th>Email</th>
                    <th>No Telepon</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($staff as $index => $data)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->email}}</td>
                        <td>{{ $data->phone_number }}</td>
                        <td>{{ $data->role}}</td>
                        <td class="text-center">
                            <a href="{{ route('data-staff-edit', $data->id) }}" class="btn btn-custom-3 my-2" title="Edit" data-bs-toggle="tooltip">
                                <i class="fas fa-edit text-primary"></i>
                            </a>

                            <form action="{{ route('data-staff-delete', $data->id) }}" method="POST" style="display:inline-block;">
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
                @if ($staff->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link bg-light border-0 rounded-pill"><i class="fas fa-chevron-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a href="{{ $staff->previousPageUrl() }}" class="page-link bg-light border-0 rounded-pill hover:bg-danger text-dark"><i class="fas fa-chevron-left"></i></a>
                    </li>
                @endif

                @foreach ($staff->getUrlRange(1, $staff->lastPage()) as $page => $url)
                    @if ($page == $staff->currentPage())
                        <li class="page-item active">
                            <span class="page-num page-link text-white border-0 rounded-pill">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a href="{{ $url }}" class="page-link bg-light border-0 rounded-pill hover:bg-danger text-dark">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach

                @if ($staff->hasMorePages())
                    <li class="page-item">
                        <a href="{{ $staff->nextPageUrl() }}" class="page-link bg-light border-0 rounded-pill hover:bg-danger text-dark"><i class="fas fa-chevron-right"></i></a>
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
