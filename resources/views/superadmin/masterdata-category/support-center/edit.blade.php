@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Support Center Categories
@stop

@push('css')
    <style>
        #icon-preview {
            display: inline-block;
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            font-size: 24px;
            color: #333;
            background-color: #f0f0f0;
            border-radius: 4px;
        }
    </style>
@endpush

@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <h4>{{ __('messages-superadmin.sidebar.info_support_center.edit_categories') }}</h4>

        <form class="py-4" action="{{ route('support-center-category-update', $category->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="nama_category"
                            name="nama_category" value="{{ old('nama_category', $category->nama_category) }}" />
                        <label
                            class="did-floating-label">{{ __('messages-superadmin.sidebar.info_support_center.categories_name') }}</label>
                    </div>
                </div>
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="icon" name="icon"
                            value="{{ old('icon', $category->icon) }}" oninput="updateIconPreview()" />
                        <label
                            class="did-floating-label">{{ __('messages-superadmin.sidebar.info_support_center.icon') }}</label>
                    </div>
                    <small class="form-text text-muted mt-1">
                        {{ __('messages-superadmin.sidebar.info_support_center.enter') }} (e.g.,
                        <strong>{{ __('messages-superadmin.sidebar.info_support_center.user') }}</strong>,
                        <strong>{{ __('messages-superadmin.sidebar.info_support_center.heart') }}</strong>).
                        {{ __('messages-superadmin.sidebar.info_support_center.option') }} <a
                            href="https://fontawesome.com/icons"
                            target="_blank">{{ __('messages-superadmin.sidebar.info_support_center.aws_web') }}</a>.
                    </small>
                    <div class="mt-2">
                        <span>{{ __('messages-superadmin.sidebar.info_support_center.icon_preview') }}:</span>
                        <i id="icon-preview" class="fas fa-{{ old('icon', $category->icon) }}"></i>
                    </div>
                </div>
            </div>

            <div class="mt-3 d-flex gap-2">
                <a href="{{ route('support-center-category') }}" class="btn btn-cancel ms-2">
                    {{ __('messages-superadmin.sidebar.button.cancel') }}
                </a>
                <button type="submit" class="btn btn-custom-icon">
                    <i class='fas fa-floppy-disk fs-6'></i> {{ __('messages-superadmin.sidebar.button.save') }}
                </button>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script>
        function updateIconPreview() {
            var iconClass = document.getElementById('icon').value;
            var iconPreview = document.getElementById('icon-preview');

            iconPreview.className = "fas fa-" + iconClass;
        }
    </script>
@endpush
