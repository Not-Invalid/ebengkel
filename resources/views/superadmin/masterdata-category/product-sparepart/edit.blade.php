@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Edit Product & Sparepart Category
@stop

@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <h4>{{ __('messages-superadmin.sidebar.info_category.edit_category') }}</h4>
        <form class="py-4" action="{{ route('product-sparepart-update', $category->id_kategori_spare_part) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="nama_kategori_spare_part"
                            name="nama_kategori_spare_part"
                            value="{{ old('nama_kategori_spare_part', $category->nama_kategori_spare_part) }}" />
                        <label
                            class="did-floating-label">{{ __('messages-superadmin.sidebar.info_category.category_name') }}</label>
                    </div>
                </div>
            </div>

            <div class="mt-3 d-flex gap-2">
                <a href="{{ route('product-sparepart-category') }}" class="btn btn-cancel ms-2">
                    {{ __('messages-superadmin.sidebar.button.cancel') }}
                </a>
                <button type="submit" class="btn btn-custom-icon">
                    <i class='fas fa-floppy-disk fs-6'></i> {{ __('messages-superadmin.sidebar.button.save') }}
                </button>
            </div>
        </form>
    </div>
@endsection
