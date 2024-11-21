@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Edit Blog Category
@stop

@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <h4>Edit Blog Category</h4>
        <form class="py-4" action="{{ route('blog-category-update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori', $category->nama_kategori) }}" />
                        <label class="did-floating-label">Nama Kategori</label>
                    </div>
                </div>
            </div>

            <div class="mt-3 d-flex gap-2">
                <a href="{{ route('blog-category') }}" class="btn btn-cancel ms-2">
                    Cancel
                </a>
                <button type="submit" class="btn btn-custom-icon">
                    <i class='fas fa-floppy-disk fs-6'></i> Save
                </button>
            </div>
        </form>
    </div>
@endsection
