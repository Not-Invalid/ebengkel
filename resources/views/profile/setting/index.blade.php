@extends('layouts.partials.sidebar')

@section('title')
    eBengkelku | Setting
@stop
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/setting.css') }}">
@endpush


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

@section('content')
    <section class="mb-4">
        <div class="custom-tabs-container">
            <ul class="custom-tabs shadow text-center">
                <li class="custom-tab-item">
                    <a class="custom-tab-link active" data-tab="keamanan">
                        Security & Account
                    </a>
                </li>
                <li class="custom-tab-item">
                    <a class="custom-tab-link" data-tab="bahasa">
                        Language Settings
                    </a>
                </li>
                <li class="custom-tab-item">
                    <a class="custom-tab-link" data-tab="log">
                        Login History
                    </a>
                </li>
            </ul>
            <select class="custom-dropdown shadow">
                <option value="keamanan" selected>Security & Account</option>
                <option value="bahasa">Languange Settings</option>
                <option value="log">Login History</option>
            </select>
        </div>
    </section>
    <div class="container w-100 shadow bg-white rounded p-3">
        <div class="tab-content">
            <div class="tab-pane active" id="keamanan">
                <div class="pt-3">
                    <h5>Security & Account</h5>
                    <hr>
                    <!-- Ganti Password -->
                    <div class="mb-4">
                        <h6>Change Password</h6>
                        <form method="POST" action="{{ route('profile.resetPassword') }}">
                            @csrf
                            <div class="mb-3">
                                <div class="input-box">
                                    <input type="password" class="form-control" id="currentPassword" name="currentPassword"
                                        placeholder="Enter Old Password" required>
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
                                        placeholder="Enter New Password" required>
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
                                        name="newPassword_confirmation" placeholder="Confirm New Password" required>
                                    <span class="toggle-password" onclick="toggleNewPasswordConfirmationVisibility()">
                                        <i class="bx bx-hide" id="toggle-confirm-icon"></i>
                                    </span>
                                </div>
                                @error('newPassword_confirmation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-save">Save</button>
                        </form>
                    </div>
                </div>
            </div>



            <div class="tab-pane" id="bahasa">
                <div class="pt-3">
                    <h5>Language Settings</h5>
                    <hr>
                    <form id="languageForm">
                        <div class="mb-3">
                            <label for="languageSelect" class="form-label">Select Language</label>
                            <select class="form-select" id="languageSelect"></select>
                        </div>
                        <button type="button" class="btn btn-primary" id="saveLanguage">Save</button>
                    </form>
                </div>
            </div>
            <div class="tab-pane" id="log">
                {{-- isi card --}}
                <div class="pt-3 w-75">
                    <h5>Login History</h5>
                    <hr>
                    <canvas id="myBarChart" class="bar-log" style="width: 900px; height: 400px;"></canvas>

                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const languageSelect = document.getElementById("languageSelect");
            const saveButton = document.getElementById("saveLanguage");

            // Ambil daftar bahasa dari API LibreTranslate
            fetch("https://libretranslate.com/languages")
                .then(response => response.json())
                .then(data => {
                    data.forEach(language => {
                        const option = document.createElement("option");
                        option.value = language.code; // Kode bahasa, contoh: 'en'
                        option.textContent = language.name; // Nama bahasa, contoh: 'English'
                        languageSelect.appendChild(option);
                    });
                })
                .catch(error => console.error("Error fetching languages:", error));

            // Event listener untuk tombol Save
            saveButton.addEventListener("click", () => {
                const selectedLanguage = languageSelect.value;

                // Ambil semua elemen teks (kecuali input, textarea, dll.)
                const elements = document.body.querySelectorAll("*:not(script):not(style)");

                elements.forEach(element => {
                    // Pastikan elemen memiliki teks
                    if (element.childNodes.length === 1 && element.childNodes[0].nodeType === Node
                        .TEXT_NODE) {
                        const originalText = element.textContent.trim();
                        if (originalText) {
                            // Kirim teks ke LibreTranslate untuk diterjemahkan
                            fetch("https://libretranslate.com/translate", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json"
                                    },
                                    body: JSON.stringify({
                                        q: originalText,
                                        source: "en", // Ganti ke bahasa sumber default
                                        target: selectedLanguage,
                                    }),
                                })
                                .then(response => response.json())
                                .then(data => {
                                    element.textContent = data
                                        .translatedText; // Ganti teks dengan hasil terjemahan
                                })
                                .catch(error => console.error("Error translating text:", error));
                        }
                    }
                });
            });
        });
    </script>
@endsection
