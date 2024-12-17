@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Data Pelanggan
@stop

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2> {{ __('messages-superadmin.sidebar.info_data_pelanggan.list_pelanggan') }}</h2>
        </div>
        <table class="table table-bordered">
            <thead class="field-title">
                <tr>
                    <th>No</th>
                    <th>{{ __('messages-superadmin.sidebar.info_data_pelanggan.name_pelanggan') }}</th>
                    <th>{{ __('messages-superadmin.sidebar.info_data_pelanggan.phone_pelanggan') }}</th>
                    <th>{{ __('messages-superadmin.sidebar.info_data_pelanggan.email_pelanggan') }}</th>
                    <th>{{ __('messages-superadmin.sidebar.info_data_pelanggan.role') }}</th>
                    <th>{{ __('messages-superadmin.sidebar.info_data_pelanggan.delete_pelanggan') }}</th>
                    <th>{{ __('messages-superadmin.sidebar.info_data_pelanggan.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pelanggan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_pelanggan }}</td>
                        <td>{{ $item->telp_pelanggan }}</td>
                        <td>{{ $item->email_pelanggan }}</td>
                        <td>{{ $item->role_pelanggan }}</td>
                        <td><span class="badge bg-success">{{ $item->delete_pelanggan }}</span></td>
                        <td class="text-center">
                            <a href="{{-- route('bengkel.show', $data->id_bengkel) --}}" class="btn btn-delete my-2" title="Detail" data-bs-toggle="tooltip">
                                <i class="fas fa-trash-alt text-white"></i>
                            </a>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-end mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    @if ($pelanggan->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link bg-light border-0 rounded-pill"><i
                                    class="fas fa-chevron-left"></i></span>
                        </li>
                    @else
                        <li class="page-item">
                            <a href="{{ $pelanggan->previousPageUrl() }}"
                                class="page-link bg-light border-0 rounded-pill hover:bg-danger text-dark"><i
                                    class="fas fa-chevron-left"></i></a>
                        </li>
                    @endif

                    @foreach ($pelanggan->getUrlRange(1, $pelanggan->lastPage()) as $page => $url)
                        @if ($page == $pelanggan->currentPage())
                            <li class="page-item active">
                                <span
                                    class="page-num page-link text-white border-0 rounded-pill">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a href="{{ $url }}"
                                    class="page-link bg-light border-0 rounded-pill hover:bg-danger text-dark">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach

                    @if ($pelanggan->hasMorePages())
                        <li class="page-item">
                            <a href="{{ $pelanggan->nextPageUrl() }}"
                                class="page-link bg-light border-0 rounded-pill hover:bg-danger text-dark"><i
                                    class="fas fa-chevron-right"></i></a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link bg-light border-0 rounded-pill"><i
                                    class="fas fa-chevron-right"></i></span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
@endsection
