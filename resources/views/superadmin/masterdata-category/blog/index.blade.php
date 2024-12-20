@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Blog Categories
@stop

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ __('messages-superadmin.sidebar.blog.category_blog') }}</h2>
            <a href="{{ route('blog-category-create') }}" class="btn btn-custom-2 btn-sm">
                <i class="fas fa-plus"></i> {{ __('messages-superadmin.sidebar.blog.add_category_blog') }}
            </a>
        </div>

        <table class="table table-bordered">
            <thead class="field-title">
                <tr>
                    <th>No</th>
                    <th>{{ __('messages-superadmin.sidebar.info_category.category_name') }}</th>
                    <th>{{ __('messages-superadmin.sidebar.info_category.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($category as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->nama_kategori }}</td>
                        <td class="text-center">
                            <a href="{{ route('blog-category-edit', $data->id) }}" class="btn btn-custom-3 my-2"
                                title="Edit" category-bs-toggle="tooltip">
                                <i class="fas fa-edit text-primary"></i>
                            </a>

                            <form action="{{ route('blog-category-delete', $data->id) }}" method="POST"
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
    </div>
@endsection
