@extends('layouts.app')

@section('title')
    eBengkelku | Support Center
@stop

@section('content')
    <section class="mt-5 py-3">
        <div class="bg-light py-5">
            <div class="container">
                <div class="d-flex justify-content-between">
                    <nav class="pt-3"
                        style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                        aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="nav-link"
                                    href="{{ route('support-center') }}">{{ __('messages.supportcenter.breadcrumb.support_center') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('messages.supportcenter.breadcrumb.current_page') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="py-4">
        <div class="container py-2">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <h3 class="mb-4 text-center">
                        {{ __('messages.supportcenter.title', ['category_name' => $supportInfo->nama_category]) }}</h3>
                    <div class="accordion" id="Questions-accordion">
                        @foreach ($supportInfo->questions as $index => $question)
                            <div class="accordion-item mb-1">
                                <h2 class="accordion-header" id="Questions-heading{{ $index }}">
                                    <button class="accordion-button collapsed"
                                        data-bs-target="#Questions-collapse{{ $index }}" data-bs-toggle="collapse"
                                        type="button" aria-label="{{ __('messages.supportcenter.accordion.icon') }}">
                                        <i class="bx bx-chevron-down me-2 fs-4"></i>
                                        {{ $question->question }}
                                    </button>
                                </h2>
                                <div id="Questions-collapse{{ $index }}" class="accordion-collapse collapse"
                                    data-bs-parent="#Questions-accordion"
                                    aria-labelledby="Questions-heading{{ $index }}">
                                    <div class="accordion-body">
                                        {{ $question->answer }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
