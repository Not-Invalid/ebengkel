@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Support Center Categories
@stop

@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fs-5">Support Center Categories</h4>
            <a href="{{ route('support-center-category-create') }}" class="btn btn-custom-2">+ Add New Categories</a>
        </div>

        @if ($categories->isEmpty())
            <div class="card border-1 rounded-2 mt-4">
                <div class="card-body d-flex justify-content-center">
                    <div class="text-center">
                        <img src="{{ asset('assets/images/components/empty.png') }}" height="130" width="130" alt="">
                        <p>Data not found.</p>
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
                                    <a href="{{ route('support-center-category-edit', $category->id) }}" class="btn btn-custom-3">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
@endsection
