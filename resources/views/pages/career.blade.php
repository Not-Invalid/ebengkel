@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/career.css') }}">
@endpush
@section('title')
    eBengkelku | Career
@stop

@section('content')
    <div class="container">
        <!-- Hero Section -->
        <section class="hero-section ">
            <div class="container">
                <nav class="pt-3"
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="nav-link"
                                href="{{ route('home') }}">{{ __('messages.career.breadcrumb_home') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('messages.career.breadcrumb_career') }}
                        </li>
                    </ol>
                </nav>
                <div class="row align-items-center">
                    <div class="col-lg-6" data-aos="fade-right">
                        <h1 class="hero-title">{{ __('messages.career.hero_title') }} <span
                                class="company-name">eBengkelku</span>
                        </h1>
                        <p class="hero-subtitle">{{ __('messages.career.hero_subtitle') }}.</p>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left">
                        <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Ilustrasi" class="illustration floating">
                    </div>
                </div>
            </div>
        </section>

        <section class="life-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <!-- Feature Card 1 -->
                            <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                                <div class="feature-card">
                                    <svg class="icon-custom" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        style="color: var(--main-blue)">
                                        <path d="M21 12a9 9 0 1 0-18 0 9 9 0 0 0 18 0z" />
                                        <path d="M12 7v5l3 3" />
                                    </svg>
                                    <h3 class="feature-title">{{ __('messages.career.life_section_features.0.title') }}</h3>
                                    <p class="feature-text">{{ __('messages.career.life_section_features.0.text') }}.</p>
                                </div>
                            </div>

                            <!-- Feature Card 2 -->
                            <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                                <div class="feature-card">
                                    <svg class="icon-custom" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        style="color: var(--main-blue)">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    </svg>
                                    <h3 class="feature-title">{{ __('messages.career.life_section_features.1.title') }}.
                                    </h3>
                                    <p class="feature-text">{{ __('messages.career.life_section_features.1.text') }}.
                                    </p>
                                </div>
                            </div>

                            <!-- Feature Card 3 -->
                            <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                                <div class="feature-card">
                                    <svg class="icon-custom" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        style="color: var(--main-blue)">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                    <h3 class="feature-title">{{ __('messages.career.life_section_features.2.title') }}.
                                    </h3>
                                    <p class="feature-text">{{ __('messages.career.life_section_features.2.text') }}.</p>
                                </div>
                            </div>

                            <!-- Feature Card 4 -->
                            <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
                                <div class="feature-card">
                                    <svg class="icon-custom" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        style="color: var(--main-blue)">
                                        <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                                        <path d="M6 12v5c3 3 9 3 12 0v-5" />
                                    </svg>
                                    <h3 class="feature-title">{{ __('messages.career.life_section_features.3.title') }}.
                                    </h3>
                                    <p class="feature-text">{{ __('messages.career.life_section_features.3.text') }}.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-8 mx-auto mt-5" data-aos="fade-left">
                        <h2 class="section-title">{{ __('messages.career.positive') }}<span
                                class="company-name">eBengkelku</span></h2>
                        <p class="description-text">{{ __('messages.career.positive_desc') }}.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Our vision --}}
        <section class="our-vision-section text-center my-5">
            <!-- Title -->
            <h2 class="vision-title" data-aos="zoom-in">{{ __('messages.career.vision_title') }}</h2>

            <!-- Content -->
            <p class="vision-text mt-5" data-aos="fade-up">
                {{ __('messages.career.vision_text') }}.
            </p>
        </section>

        <!-- Stats Section -->
        <div class="container-fluid fact bg-dark my-5 py-5">
            <div class="container">
                <div class="row g-4 justify-content-center">
                    <div class="col-6 col-md-3 text-center">
                        <i class="bx bx-wrench fa-2x text-white mb-3"></i>
                        <h2 class="text-white mb-2 counter" data-target="1000">10</h2>
                        <p class="text-white mb-0">{{ __('messages.career.stats.workshops') }}</p>
                    </div>
                    <div class="col-6 col-md-3 text-center">
                        <i class="bx bx-box fa-2x text-white mb-3"></i>
                        <h2 class="text-white mb-2 counter" data-target="750">10</h2>
                        <p class="text-white mb-0">{{ __('messages.career.stats.products') }}</p>
                    </div>
                    <div class="col-6 col-md-3 text-center">
                        <i class="bx bx-cog fa-2x text-white mb-3"></i>
                        <h2 class="text-white mb-2 counter" data-target="500">10</h2>
                        <p class="text-white mb-0">{{ __('messages.career.stats.services') }}</p>
                    </div>
                    <div class="col-6 col-md-3 text-center">
                        <i class="bx bx-user fa-2x text-white mb-3"></i>
                        <h2 class="text-white mb-2 counter" data-target="250">10</h2>
                        <p class="text-white mb-0">{{ __('messages.career.stats.users') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Process Section -->
        <section class="process-section">
            <div class="container">
                <h2 class="section-title">{{ __('messages.career.mission_title') }}</h2>

                <div class="row g-4">
                    <div class="col-md-3 col-lg-3">
                        <div class="process-card">
                            <div class="process-number">1</div>
                            <div class="process-content">
                                <div class="process-icon">
                                    <i class="bx bx-time-five"></i>
                                </div>
                                <h4>{{ __('messages.career.mission_steps.0.title') }}</h4>
                                <p>{{ __('messages.career.mission_steps.0.text') }}.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3">
                        <div class="process-card">
                            <div class="process-number">2</div>
                            <div class="process-content">
                                <div class="process-icon">
                                    <i class="bx bx-check-shield"></i>
                                </div>
                                <h4>{{ __('messages.career.mission_steps.1.title') }}</h4>
                                <p>{{ __('messages.career.mission_steps.1.text') }}.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3">
                        <div class="process-card">
                            <div class="process-number">3</div>
                            <div class="process-content">
                                <div class="process-icon">
                                    <i class="bx bx-wrench"></i>
                                </div>
                                <h4>{{ __('messages.career.mission_steps.2.title') }}</h4>
                                <p>{{ __('messages.career.mission_steps.2.text') }}.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3">
                        <div class="process-card">
                            <div class="process-number">4</div>
                            <div class="process-content">
                                <div class="process-icon">
                                    <i class="bx bx-rocket"></i>
                                </div>
                                <h4>{{ __('messages.career.mission_steps.3.title') }}</h4>
                                <p>{{ __('messages.career.mission_steps.3.text') }}.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
