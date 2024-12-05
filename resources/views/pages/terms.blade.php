@extends('layouts.app')

@section('title')
    eBengkelku | Terms & Condition
@stop

@section('content')
    <section class="mt-5 py-3">
        <div class="bg-light py-5">
            <div class="container">
                <div class="d-flex justify-content-between">
                    <h2 class="fw-bold">{{ __('messages.terms.title') }}</h2>
                    <nav class="pt-3"
                        style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                        aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="nav-link"
                                    href="{{ route('home') }}">{{ __('messages.terms.breadcrumb.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('messages.terms.breadcrumb.terms') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <p class="welcome-text">{{ __('messages.terms.intro') }}</p>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('assets/images/logo/logo.png') }}" class="img-fluid rounded w-50" alt="eBengkelku">
            </div>
        </div>

        <div class="row my-4">
            <div class="col-lg-6">
                <h5 class="fw-bold mt-4">{{ __('messages.terms.terms1') }}</h5>
                <p class="terms-detail">{{ __('messages.terms.agreement') }}</p>
            </div>

            <div class="col-lg-6">
                <h5 class="fw-bold mt-4">{{ __('messages.terms.terms2') }}</h5>
                <p class="terms-detail">{{ __('messages.terms.services') }}</p>
            </div>
        </div>

        <div class="row my-4">
            <div class="col-lg-6">
                <h5 class="fw-bold mt-4">{{ __('messages.terms.terms3') }}</h5>
                <p class="terms-detail">{{ __('messages.terms.account_security') }}</p>
            </div>

            <div class="col-lg-6">
                <h5 class="fw-bold mt-4">{{ __('messages.terms.terms4') }}</h5>
                <p class="terms-detail">{{ __('messages.terms.changes') }}</p>
            </div>
        </div>
    </div>


@endsection
