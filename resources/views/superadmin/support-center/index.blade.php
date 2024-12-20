@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Info Support Center
@stop

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2> {{ __('messages-superadmin.sidebar.info_support_center.info') }}</h2>
            <a href="{{ route('support-center-info-create') }}" class="btn btn-custom-2 btn-sm">
                <i class="fas fa-plus"></i> {{ __('messages-superadmin.sidebar.info_support_center.add_info') }}
            </a>
        </div>
        <table class="table table-bordered">
            <thead class="field-title">
                <tr>
                    <th>No</th>
                    <th>{{ __('messages-superadmin.sidebar.category') }}</th>
                    <th>{{ __('messages-superadmin.sidebar.info_support_center.question') }}</th>
                    <th>{{ __('messages-superadmin.sidebar.info_support_center.answer') }}</th>
                    <th>{{ __('messages-superadmin.sidebar.info_support_center.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($supportInfo as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->category->nama_category }}</td>
                        <td>{{ $data->question }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($data->answer, 30) }}</td>
                        <td>
                            <a href="{{ route('support-center-info-edit', $data->id) }}" class="btn btn-custom-3 my-2"
                                title="Edit" data-bs-toggle="tooltip">
                                <i class="fas fa-edit text-primary"></i>
                            </a>

                            <form action="{{ route('support-center-info-delete', $data->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete" title="Delete" data-bs-toggle="tooltip"
                                    style="border: none; background: none;">
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
                    @if ($supportInfo->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link bg-light border-0 rounded-pill"><i
                                    class="fas fa-chevron-left"></i></span>
                        </li>
                    @else
                        <li class="page-item">
                            <a href="{{ $supportInfo->previousPageUrl() }}"
                                class="page-link bg-light border-0 rounded-pill hover:bg-danger text-dark"><i
                                    class="fas fa-chevron-left"></i></a>
                        </li>
                    @endif

                    @foreach ($supportInfo->getUrlRange(1, $supportInfo->lastPage()) as $page => $url)
                        @if ($page == $supportInfo->currentPage())
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

                    @if ($supportInfo->hasMorePages())
                        <li class="page-item">
                            <a href="{{ $supportInfo->nextPageUrl() }}"
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
