@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Info Support Center
@stop

@section('content')
<div class="w-100 shadow bg-white rounded" style="padding: 1rem">
    <h4>Edit Support Center Info</h4>
    <form class="py-4" action="{{ route('support-center-info-update', $supportInfo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col">
                <div class="did-floating-label-content">
                    <select class="did-floating-input" id="support_category_id" name="support_category_id" required>
                        <option value="" disabled>Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                @if ($category->id == $supportInfo->support_category_id) selected @endif>
                                {{ $category->nama_category }}
                            </option>
                        @endforeach
                    </select>
                    <label class="did-floating-label">Category</label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="did-floating-label-content">
                    <textarea class="did-floating-input" placeholder=" " id="question" name="question" style="resize: none; height:100px;">{{ old('question', $supportInfo->question) }}</textarea>
                    <label class="did-floating-label custom">Question</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="did-floating-label-content">
                    <textarea class="did-floating-input" placeholder=" " id="answer" name="answer" style="resize: none; height:100px;">{{ old('answer', $supportInfo->answer) }}</textarea>
                    <label class="did-floating-label custom">Answer</label>
                </div>
            </div>
        </div>

        <div class="mt-3 d-flex gap-2">
            <a href="{{ route('support-center-info') }}" class="btn btn-cancel ms-2">
                Cancel
            </a>
            <button type="submit" class="btn btn-custom-icon">
                <i class='fas fa-floppy-disk fs-6'></i> Save
            </button>
        </div>
    </form>
</div>
@endsection
