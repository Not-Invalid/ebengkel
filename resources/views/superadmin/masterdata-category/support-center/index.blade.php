@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Support Center Categories
@stop

@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fs-5"> {{ __('messages-superadmin.sidebar.info_support_center.support_categories') }}</h4>
            <a href="{{ route('support-center-category-create') }}" class="btn btn-custom-2">+
                {{ __('messages-superadmin.sidebar.info_support_center.add_new_categories') }}</a>
        </div>

        @if ($categories->isEmpty())
            <div class="card border-1 rounded-2 mt-4">
                <div class="card-body d-flex justify-content-center">
                    <div class="text-center">
                        <img src="{{ asset('assets/images/components/empty.png') }}" height="130" width="130"
                            alt="">
                        <p>{{ __('messages-superadmin.sidebar.not_found') }}</p>
                    </div>
                </div>
            </div>
        @else
            @foreach ($categories as $category)
                @if ($category)
                    <div class="card border-1 rounded-2 mt-4">
                        <div class="card-body shadow-sm border">
                            <div class="row">
                                <div class="col-12 col-md-3 d-flex align-items-center justify-content-center mb-3">
                                    <i class="fas fa-{{ $category->icon }} icon-support-center"></i>
                                </div>
                                <div class="col-12 col-md-6">
                                    <h5 class="card-title mt-3">{{ $category->nama_category }}</h5>
                                    <p class="text-muted mt-1">{{ $category->icon }}</p>
                                </div>
                                <div class="col-12 col-md-3 d-flex align-items-center justify-content-center">
                                    <a href="{{ route('support-center-category-edit', $category->id) }}"
                                        class="btn btn-custom-3 mx-2" data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit text-primary"></i>
                                    </a>

                                    <form action="{{ route('support-center-category-delete', $category->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this category?');"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete" data-bs-toggle="tooltip"
                                            title="Delete" style="border: none; background: none;">
                                            <i class="fas fa-trash-alt text-white"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>

    <div class="d-flex justify-content-end mt-4">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                @if ($categories->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link bg-light border-0 rounded-pill"><i class="fas fa-chevron-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a href="{{ $categories->previousPageUrl() }}"
                            class="page-link bg-light border-0 rounded-pill hover:bg-danger text-dark"><i
                                class="fas fa-chevron-left"></i></a>
                    </li>
                @endif

                @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                    @if ($page == $categories->currentPage())
                        <li class="page-item active">
                            <span class="page-num page-link text-white border-0 rounded-pill">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a href="{{ $url }}"
                                class="page-link bg-light border-0 rounded-pill hover:bg-danger text-dark">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach

                @if ($categories->hasMorePages())
                    <li class="page-item">
                        <a href="{{ $categories->nextPageUrl() }}"
                            class="page-link bg-light border-0 rounded-pill hover:bg-danger text-dark"><i
                                class="fas fa-chevron-right"></i></a>
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
