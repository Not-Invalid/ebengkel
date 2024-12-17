@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Blog
@stop

<style>
    .image-preview {
        border: 1px solid #ddd;
        border-radius: 5px;
        max-height: 200px;
    }

    .upload-box {
        border: 2px dashed var(--main-light-blue);
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        transition: background-color 0.2s;
        cursor: pointer;
    }

    .upload-box:hover {
        background-color: #f9f9f9;
    }

    .upload-label {
        font-size: 16px;
        color: #555;
        margin-bottom: 10px;
        display: block;
    }

    .file-input {
        opacity: 0;
        position: absolute;
        z-index: -1;
    }
</style>

@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <h4>{{ __('messages-superadmin.sidebar.blog.add_blog') }}</h4>
        <form class="py-4" action="{{ route('blog-admin-store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-4">
                <div class="upload-box">
                    <label for="foto_cover"
                        class="upload-label">{{ __('messages-superadmin.sidebar.blog.cover_photo') }}</label>
                    <input type="file" class="file-input" name="foto_cover" id="foto_cover"
                        onchange="previewImage('foto_cover', 'coverPreview')">
                    <div class="preview-container d-flex justify-content-center">
                        <img id="coverPreview" src="" alt="Cover Photo Preview" class="image-preview"
                            style="display: none; width: 200px; margin-top: 10px;">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="did-floating-label-content">
                        <select class="did-floating-input" id="id_kategori" name="id_kategori" required>
                            <option value="" disabled selected>
                                {{ __('messages-superadmin.sidebar.blog.select_category') }}
                            </option>
                            @foreach ($kategoriBlogs as $kategori)
                                <option value="{{ $kategori->id }}"
                                    {{ old('id_kategori') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        <label class="did-floating-label">{{ __('messages-superadmin.sidebar.category') }}</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="judul" name="judul"
                            value="{{ old('judul') }}" required />
                        <label class="did-floating-label">{{ __('messages-superadmin.sidebar.blog.title_blog') }}</label>
                    </div>
                </div>
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="penulis" name="penulis"
                            value="{{ old('penulis') }}" required />
                        <label class="did-floating-label">{{ __('messages-superadmin.sidebar.blog.author') }}</label>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <label for="konten">{{ __('messages-superadmin.sidebar.blog.content_blog') }}</label>
                <textarea id="konten" name="konten" class="form-control">{{ old('konten') }}</textarea>
            </div>

            <div class="mt-3 d-flex gap-2">
                <a href="{{ route('blog-admin') }}" class="btn btn-cancel ms-2">
                    {{ __('messages-superadmin.sidebar.button.cancel') }}
                </a>
                <button type="submit" class="btn btn-custom-icon">
                    <i class='fas fa-floppy-disk fs-6'></i> {{ __('messages-superadmin.sidebar.button.save') }}
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(inputId, previewId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
                preview.src = '';
            }
        }
    </script>



@endsection
