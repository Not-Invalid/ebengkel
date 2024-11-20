@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Blog
@stop

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Blog</h2>
            <a href="{{ route('blog-admin-create') }}" class="btn btn-custom-2 btn-sm">
                <i class="fas fa-plus"></i> Add New Articles
            </a>
        </div>
        <table class="table table-bordered">
            <thead class="field-title">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Kategori</th> <!-- Menambahkan kolom Kategori -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($blogs as  $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->judul }}</td> <!-- Menampilkan judul blog -->
                        <td>{{ $data->penulis }}</td> <!-- Menampilkan penulis blog -->
                        <td>{{ $data->kategori->nama_kategori }}</td> <!-- Menampilkan nama kategori -->
                        <td>
                            <a href="{{ route('blog-admin-edit', $data->id) }}" class="btn btn-custom-3 my-2" title="Edit" data-bs-toggle="tooltip">
                                <i class="fas fa-edit text-primary"></i>
                            </a>

                            <form action="{{ route('support-center-info-delete', $data->id) }}" method="POST" style="display:inline-block;">
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

        <div class="d-flex justify-content-end mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    @if ($blogs->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link bg-light border-0 rounded-pill"><i class="fas fa-chevron-left"></i></span>
                        </li>
                    @else
                        <li class="page-item">
                            <a href="{{ $blogs->previousPageUrl() }}" class="page-link bg-light border-0 rounded-pill hover:bg-danger text-dark"><i class="fas fa-chevron-left"></i></a>
                        </li>
                    @endif

                    @foreach ($blogs->getUrlRange(1, $blogs->lastPage()) as $page => $url)
                        @if ($page == $blogs->currentPage())
                            <li class="page-item active">
                                <span class="page-num page-link text-white border-0 rounded-pill">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a href="{{ $url }}" class="page-link bg-light border-0 rounded-pill hover:bg-danger text-dark">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach

                    @if ($blogs->hasMorePages())
                        <li class="page-item">
                            <a href="{{ $blogs->nextPageUrl() }}" class="page-link bg-light border-0 rounded-pill hover:bg-danger text-dark"><i class="fas fa-chevron-right"></i></a>
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
