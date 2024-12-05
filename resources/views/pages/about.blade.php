@extends('layouts.app')


@section('title')
    eBengkelku | About us
@stop

@section('content')
    <section class="mt-5 py-3">
        <div class="bg-light py-5">
            <div class="container">
                <div class="d-flex justify-content-between">
                    <h2 class="fw-bold">{{ __('messages.about.title') }}</h2>
                    <nav class="pt-3" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="nav-link"
                                    href="{{ route('home') }}">{{ __('messages.about.breadcrumb.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('messages.about.breadcrumb.about') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <div class="container-fluid fact bg-dark my-5 py-5">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-6 col-md-3 text-center">
                    <i class="bx bx-wrench fa-2x text-white mb-3"></i>
                    <h2 class="text-white mb-2 counter" data-target="1000">10</h2>
                    <p class="text-white mb-0">{{ __('messages.about.stats.workshops') }}</p>
                </div>
                <div class="col-6 col-md-3 text-center">
                    <i class="bx bx-box fa-2x text-white mb-3"></i>
                    <h2 class="text-white mb-2 counter" data-target="750">10</h2>
                    <p class="text-white mb-0">{{ __('messages.about.stats.products') }}</p>
                </div>
                <div class="col-6 col-md-3 text-center">
                    <i class="bx bx-cog fa-2x text-white mb-3"></i>
                    <h2 class="text-white mb-2 counter" data-target="500">10</h2>
                    <p class="text-white mb-0">{{ __('messages.about.stats.services') }}</p>
                </div>
                <div class="col-6 col-md-3 text-center">
                    <i class="bx bx-user fa-2x text-white mb-3"></i>
                    <h2 class="text-white mb-2 counter" data-target="250">10</h2>
                    <p class="text-white mb-0">{{ __('messages.about.stats.users') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 justify-content-center">
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <img class="img-fluid rounded shadow-sm" src="{{ asset('assets/images/logo/logo.png') }}"
                        style="width:100%; max-width:300px;" alt="Logo eBengkelku">
                </div>
                <div class="col-lg-6">
                    <h6 class="text-title">{{ __('messages.about.section_title') }}</h6>
                    <h2 class="mb-2"><span class="text-p">eBengkelku</span> {{ __('messages.about.subtitle') }}</h2>
                    <p class="mb-2">
                        {{ __('messages.about.description_1') }}
                    </p>
                    <p class="mb-2">
                        {{ __('messages.about.description_2') }}
                    </p>
                </div>
            </div>
        </div>
    </div>


    <script>
        const counters = document.querySelectorAll('.counter');
        const speed = 200;

        counters.forEach(counter => {
            const animate = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;

                const increment = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(animate, 10);
                } else {
                    counter.innerText = target;
                }
            };

            animate();
        });
    </script>
@endsection
