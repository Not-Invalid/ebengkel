@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Categories
@stop

@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fs-5">Support Center Categories</h4>
            <a href="" class="btn btn-custom-2">+ Add New Categories</a>
        </div>

        @if ($categories->isEmpty())
            <div class="card border-1 rounded-2 mt-4">
                <div class="card-body d-flex justify-content-center">
                    <div class="text-center">
                        <img src="{{ asset('assets/images/components/empty.png') }}" height="130" width="130"
                            alt="">
                        <p>No data support data categories.</p>
                    </div>
                </div>
            </div>
        @else
            @foreach ($categories as $categories)
                @if ($categories)
                    <div class="card border-1 rounded-2 mt-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-3 d-flex align-items-center justify-content-center mb-3">
                                    <div class="d-flex align-items-center">
                                        <iframe
                                           >
                                        </iframe>
                                    </div>
                                </div>
                                <div class="col-12 col-md-9">
                                    <h5 class="card-title mt-3">Nama Kategori</h5>
                                    <h6 class="card-title mt-3"></h6>
                                    <a href="#" class="btn btn-custom-3">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
@endsection
