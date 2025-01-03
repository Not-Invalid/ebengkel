@extends('layouts.partials.sidebar')

@section('title')
    eBengkelku | Setting
@stop
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/setting.css') }}">
@endpush


@section('content')
    <section class="mb-4">
        <div class="custom-tabs-container">
            <ul class="custom-tabs shadow text-center">
                <li class="custom-tab-item">
                    <a class="custom-tab-link active" data-tab="keamanan">
                        {{ __('messages.profile.settings.tabs.security_account') }}
                    </a>
                </li>
                <li class="custom-tab-item">
                    <a class="custom-tab-link" data-tab="bahasa">
                        {{ __('messages.profile.settings.tabs.language_settings') }}
                    </a>
                </li>
                <li class="custom-tab-item">
                    <a class="custom-tab-link" data-tab="log">
                        {{ __('messages.profile.settings.tabs.login_history') }}
                    </a>
                </li>
            </ul>
            <select class="custom-dropdown shadow">
                <option value="keamanan" selected> {{ __('messages.profile.settings.tabs.security_account') }}</option>
                <option value="bahasa"> {{ __('messages.profile.settings.tabs.language_settings') }}</option>
                <option value="log"> {{ __('messages.profile.settings.tabs.login_history') }}</option>
            </select>
        </div>
    </section>
    <div class="container w-100 shadow bg-white rounded p-3">
        <div class="tab-content">
            <div class="tab-pane active" id="keamanan">
                <div class="pt-3">
                    <h5> {{ __('messages.profile.settings.tabs.security_account') }}</h5>
                    <hr>
                    <!-- Ganti Password -->
                    <div class="mb-4">
                        <h6> {{ __('messages.profile.settings.security.change_password.heading') }}</h6>
                        <form method="POST" action="{{ route('profile.resetPassword') }}">
                            @csrf
                            <div class="mb-3">
                                <div class="input-box">
                                    <input type="password" class="form-control" id="currentPassword" name="currentPassword"
                                        placeholder="{{ __('messages.profile.settings.security.change_password.fields.current_password') }}"
                                        required>
                                    <span class="toggle-password" onclick="toggleCurrentPasswordVisibility()">
                                        <i class="bx bx-hide" id="toggle-current-icon"></i>
                                    </span>
                                </div>
                                @error('currentPassword')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="input-box">
                                    <input type="password" class="form-control" id="newPassword" name="newPassword"
                                        placeholder="{{ __('messages.profile.settings.security.change_password.fields.new_password') }}"
                                        required>
                                    <span class="toggle-password" onclick="toggleNewPasswordVisibility()">
                                        <i class="bx bx-hide" id="toggle-new-icon"></i>
                                    </span>
                                </div>
                                @error('newPassword')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="input-box">
                                    <input type="password" class="form-control" id="newPassword_confirmation"
                                        name="newPassword_confirmation"
                                        placeholder="{{ __('messages.profile.settings.security.change_password.fields.confirm_password') }}"
                                        required>
                                    <span class="toggle-password" onclick="toggleNewPasswordConfirmationVisibility()">
                                        <i class="bx bx-hide" id="toggle-confirm-icon"></i>
                                    </span>
                                </div>
                                @error('newPassword_confirmation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit"
                                class="btn btn-save">{{ __('messages.profile.settings.security.change_password.save_button') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="bahasa">
                <div class="pt-3">
                    <h5>{{ __('messages.profile.settings.language.title') }}</h5>
                    <hr>
                    <form id="languageForm" action="{{ route('change-language') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="languageSelect"
                                class="form-label">{{ __('messages.profile.settings.language.select_language') }}</label>
                            <select class="form-select" id="languageSelect" name="language">
                                <option value="" selected disabled hidden>
                                    {{ __('messages.profile.settings.language.select_language') }}</option>
                                <option value="id" {{ session('locale') === 'id' ? 'selected' : '' }}>ID</option>
                                <option value="en" {{ session('locale') === 'en' ? 'selected' : '' }}>EN</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary"
                            id="saveLanguage">{{ __('messages.profile.settings.language.save_button') }}</button>
                    </form>
                </div>
            </div>
            <div class="tab-pane" id="log">
                {{-- isi card --}}
                <div class="pt-3 w-75">
                    <h5>{{ __('messages.profile.settings.log.title') }}</h5>
                    <hr>
                    <canvas id="myBarChart" class="bar-log" style="width: 900px; height: 400px;"></canvas>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tabLinks = document.querySelectorAll(".custom-tab-link");
            const dropdown = document.querySelector(".custom-dropdown");

            tabLinks.forEach((link) => {
                link.addEventListener("click", function(e) {
                    e.preventDefault();
                    tabLinks.forEach((tab) => tab.classList.remove("active"));
                    document
                        .querySelectorAll(".tab-pane")
                        .forEach((pane) => pane.classList.remove("active"));
                    this.classList.add("active");
                    document
                        .getElementById(this.getAttribute("data-tab"))
                        .classList.add("active");
                });
            });

            dropdown.addEventListener("change", function() {
                const selectedTab = this.value;
                tabLinks.forEach((tab) => tab.classList.remove("active"));
                document
                    .querySelectorAll(".tab-pane")
                    .forEach((pane) => pane.classList.remove("active"));
                document
                    .querySelector(`[data-tab="${selectedTab}"]`)
                    .classList.add("active");
                document.getElementById(selectedTab).classList.add("active");
            });
        });
    </script>


    <script>
        function toggleCurrentPasswordVisibility() {
            const passwordInput = document.getElementById("currentPassword");
            const toggleIcon = document.getElementById("toggle-current-icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.replace("bx-hide", "bx-show");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.replace("bx-show", "bx-hide");
            }
        }

        function toggleNewPasswordVisibility() {
            const passwordInput = document.getElementById("newPassword");
            const toggleIcon = document.getElementById("toggle-new-icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.replace("bx-hide", "bx-show");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.replace("bx-show", "bx-hide");
            }
        }

        function toggleNewPasswordConfirmationVisibility() {
            const passwordInput = document.getElementById("newPassword_confirmation");
            const toggleIcon = document.getElementById("toggle-confirm-icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.replace("bx-hide", "bx-show");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.replace("bx-show", "bx-hide");
            }
        }
    </script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tabLinks = document.querySelectorAll(".custom-tab-link");
            const dropdown = document.querySelector(".custom-dropdown");
            let myBarChart; // Define the chart variable here for global scope

            function initializeChart() {
                const ctx = document.getElementById("myBarChart").getContext("2d");

                if (myBarChart) {
                    myBarChart.destroy(); // Destroy any existing instance of the chart to avoid duplication
                }

                myBarChart = new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels: {!! json_encode($days) !!},
                        datasets: [{
                            label: "Number of Login",
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            data: {!! json_encode(array_values($logCounts)) !!},
                            barThickness: 20, // Set the desired width here
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        aspectRatio: 2,
                        scales: {
                            y: {
                                beginAtZero: true,
                                precision: 0
                            }
                        }
                    }
                });
            }


            tabLinks.forEach((link) => {
                link.addEventListener("click", function(e) {
                    e.preventDefault();
                    tabLinks.forEach((tab) => tab.classList.remove("active"));
                    document
                        .querySelectorAll(".tab-pane")
                        .forEach((pane) => pane.classList.remove("active"));
                    this.classList.add("active");
                    const selectedTabId = this.getAttribute("data-tab");
                    document.getElementById(selectedTabId).classList.add("active");

                    if (selectedTabId === "log") {
                        initializeChart(); // Initialize the chart when the "Log" tab is clicked
                    }
                });
            });

            dropdown.addEventListener("change", function() {
                const selectedTab = this.value;
                tabLinks.forEach((tab) => tab.classList.remove("active"));
                document
                    .querySelectorAll(".tab-pane")
                    .forEach((pane) => pane.classList.remove("active"));
                document
                    .querySelector(`[data-tab="${selectedTab}"]`)
                    .classList.add("active");
                document.getElementById(selectedTab).classList.add("active");

                if (selectedTab === "log") {
                    initializeChart(); // Initialize the chart when "Log" is selected from the dropdown
                }
            });
        });
    </script>
@endsection
