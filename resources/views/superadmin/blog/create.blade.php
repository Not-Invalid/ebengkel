@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Blog
@stop

@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <h4>Add New Blog</h4>
        <form class="py-4" action="{{ route('blog-admin-store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="judul" name="judul" value="{{ old('judul') }}" required />
                        <label class="did-floating-label">Judul Blog</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="penulis" name="penulis" value="{{ old('penulis') }}" required />
                        <label class="did-floating-label">Penulis</label>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <label for="konten">Konten Blog</label>
                <textarea id="konten" name="konten" class="form-control">{{ old('konten') }}</textarea>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <select class="did-floating-input" id="id_kategori" name="id_kategori" required>
                            <option value="" disabled selected>Select Kategori</option>
                            @foreach ($kategoriBlogs as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('id_kategori') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        <label class="did-floating-label">Pilih Kategori</label>
                    </div>
                </div>
            </div>

            <div class="mt-3 d-flex gap-2">
                <a href="{{ route('blog-admin') }}" class="btn btn-cancel ms-2">
                    Cancel
                </a>
                <button type="submit" class="btn btn-custom-icon">
                    <i class='fas fa-floppy-disk fs-6'></i> Save
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <!-- Include TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea#konten',  // Tentukan elemen textarea yang ingin diubah
            height: 300,
            menubar: false,
            plugins: 'advlist autolink lists link image charmap print preview anchor textcolor',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright | bullist numlist outdent indent | removeformat | help',
            content_css: '//www.tiny.cloud/css/codepen.min.css'
        });
    </script>
@endsection
