@extends('layouts.partials.sidebar')

@section('title')
    eBengkelku | Create Workshop
@stop

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
<script>
    function toggleCloseFields() {
        const openDay = document.getElementById('open_day').value;
        const closeDay = document.getElementById('close_day');

        if (openDay === 'Every Day') {
            closeDay.value = '';
            closeDay.disabled = true;
        } else {
            closeDay.disabled = false;
        }
    }
</script>
<script>
    function formatWhatsappNumber(input) {
        let number = input.value.trim();
        if (!number.startsWith('+62')) {
            if (number.startsWith('62')) {
                number = '+' + number;
            } else if (number.startsWith('0')) {
                number = '+62' + number.slice(1);
            } else {
                number = '+62' + number;
            }
        }
        input.value = number;
    }
</script>

<script>
    $(document).ready(function() {
        $('#provinsi').change(function() {
            let provinceId = $(this).val();
            if (provinceId) {
                $.get('/locations', { province_id: provinceId }, function(response) {
                    let kotaDropdown = $('#kota');
                    kotaDropdown.empty();
                    kotaDropdown.append(
                        '<option value="" selected disabled hidden>{{ __('messages.profile.address.select_city') }}</option>'
                    );

                    if (response.cities && Array.isArray(response.cities)) {
                        $.each(response.cities, function(index, city) {
                            kotaDropdown.append('<option value="' + city.city_id + '">' + city.city_name + '</option>');
                        });
                    }
                }).fail(function() {
                    console.log('Request failed for city data');
                });
            } else {
                $('#kota').empty().append(
                    '<option value="" selected disabled hidden>{{ __('messages.profile.address.select_city') }}</option>'
                );
                $('#kecamatan').empty().append(
                    '<option value="" selected disabled hidden>{{ __('messages.profile.address.select_district') }}</option>'
                );
            }
        });

        $('#kota').change(function() {
            let cityId = $(this).val();
            if (cityId) {
                $.get('/locations', { city_id: cityId }, function(response) {
                    let kecamatanDropdown = $('#kecamatan');
                    kecamatanDropdown.empty();
                    kecamatanDropdown.append(
                        '<option value="" selected disabled hidden>{{ __('messages.profile.address.select_district') }}</option>'
                    );

                    if (response.subdistricts && Array.isArray(response.subdistricts)) {
                        $.each(response.subdistricts, function(index, subdistrict) {
                            kecamatanDropdown.append('<option value="' + subdistrict.subdistrict_id + '">' + subdistrict.subdistrict_name + '</option>');
                        });
                    }
                }).fail(function() {
                    console.log('Request failed for subdistrict data');
                });
            } else {
                $('#kecamatan').empty().append(
                    '<option value="" selected disabled hidden>{{ __('messages.profile.address.select_district') }}</option>'
                );
            }
        });
        $('form').submit(function(event) {
            var provinceId = $('#provinsi option:selected').val();
            var cityId = $('#kota option:selected').val();
            var subdistrictId = $('#kecamatan option:selected').val();

            $('<input>').attr({
                type: 'hidden',
                name: 'provinsi_id',
                value: provinceId
            }).appendTo(this);

            $('<input>').attr({
                type: 'hidden',
                name: 'kota_id',
                value: city_Id
            }).appendTo(this);

            $('<input>').attr({
                type: 'hidden',
                name: 'kecamatan_id',
                value: subdistrictId
            }).appendTo(this);
        });
    });
</script>
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

    .upload-box::after {
        content: 'Click to upload';
        display: block;
        font-size: 14px;
        color: #999;
    }

    .section-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
    }

    .options-group {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .option-item {
        display: flex;
        align-items: center;
        padding: 8px 12px;
        border: 1px solid var(--main-light-blue);
        border-radius: 6px;
        background-color: var(--main-white);
        cursor: pointer;
        transition: background-color 0.2s, border-color 0.2s;
    }

    .option-item input {
        display: none;
    }

    .option-item span {
        font-size: 14px;
    }

    .option-item:hover {
        background-color: var(--main-white);
    }

    .option-item input:checked+span {
        color: var(--main-blue);
        font-weight: 500;
    }

    .option-item input:checked~.option-item {
        color: var(--main-blue);
        font-weight: 500;
    }

    .btn.btn-custom-2 {
        padding: 0.3rem 0.8rem !important;
        border-radius: 4px !important;
        font-size: 0.8rem !important;
        background-color: var(--main-blue) !important;
        color: var(--main-white) !important;
    }
</style>

@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <h4>Add Workshop</h4>
        <p class="text-danger">*indicates required fields</p>
        <form action="{{ route('profile.workshop.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-4">
                <div class="upload-box">
                    <label for="foto_cover_bengkel" class="upload-label">Cover Workshop Photo</label>
                    <input type="file" class="file-input" name="foto_cover_bengkel" id="foto_cover_bengkel"
                        onchange="previewImage('foto_cover_bengkel', 'coverPreview')">
                    <div class="preview-container d-flex justify-content-center">
                        <img id="coverPreview" src="" alt="Cover Photo Preview" class="image-preview"
                            style="display: none; width: 200px; margin-top: 10px;">
                    </div>
                </div>
            </div>

            <div class="form-group mb-4">
                <div class="upload-box">
                    <label for="foto_bengkel" class="upload-label">Workshop Photo</label>
                    <input type="file" class="file-input" name="foto_bengkel" id="foto_bengkel"
                        onchange="previewImage('foto_bengkel', 'bengkelPreview')">
                    <div class="preview-container d-flex justify-content-center">
                        <img id="bengkelPreview" src="" alt="Workshop Photo Preview" class="image-preview"
                            style="display: none; width: 200px; margin-top: 10px;">
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder=" " id="nama_bengkel" name="nama_bengkel"
                        required />
                    <label class="did-floating-label">Workshop Name<span class="text-danger">*</span></label>
                </div>
            </div>
            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder=" " id="tagline_bengkel"
                        name="tagline_bengkel" />
                    <label class="did-floating-label">Workshop Tagline</label>
                </div>
            </div>
            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <textarea class="did-floating-input form-control" name="alamat_bengkel" placeholder=" " rows="4" required
                        style="height: 100px;resize: none"></textarea>
                    <label class="did-floating-label">Workshop Address<span class="text-danger">*</span></label>
                </div>
            </div>
            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="provinsi_id" id="provinsi" class="did-floating-select">
                        <option value="" selected disabled hidden>
                            {{ __('messages.profile.address.select_province') }}
                        </option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->province_id }}">{{ $province->province_name }}</option>
                        @endforeach
                    </select>
                    <label class="did-floating-label">{{ __('messages.profile.address.province') }}</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="kota_id" id="kota" class="did-floating-select">
                        <option value="" selected disabled hidden>
                            {{ __('messages.profile.address.select_city') }}
                        </option>
                    </select>
                    <label class="did-floating-label">{{ __('messages.profile.address.city') }}</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="kecamatan_id" id="kecamatan" class="did-floating-select">
                        <option value="" selected disabled hidden>
                            {{ __('messages.profile.address.select_district') }}
                        </option>
                    </select>
                    <label class="did-floating-label">{{ __('messages.profile.address.district') }}</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder="https://" id="gmaps" name="gmaps"
                        required />
                    <label class="did-floating-label">Google Maps Link<span class="text-danger">*</span></label>
                </div>
            </div>

            <div class="form-group mb-3 text-center">
                <label for="open_day" class="w-100">Open Day<span class="text-danger">*</span></label>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 py-2">
                    <div class="did-floating-label-content">
                        <select class="did-floating-select" name="open_day" id="open_day" required
                            onchange="toggleCloseFields()">
                            <option value="" selected disabled hidden></option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                            <option value="Every Day">Every Day</option>
                        </select>
                        <label class="did-floating-label">Start</label>
                    </div>
                </div>
                <div class="col-md-6 py-2">

                    <div class="did-floating-label-content">
                        <select class="did-floating-select" name="close_day" id="close_day" required disabled>
                            <option value="" selected disabled hidden></option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                        <label class="did-floating-label">End</label>
                    </div>
                </div>
            </div>
            <div class="form-group mb-3 text-center">
                <label for="open_time" class="w-100">Open Hour<span class="text-danger">*</span></label>
            </div>
            <div class="row mb-3">
                <div class="col-md-6 py-2">
                    <div class="form-group">
                        <div class="did-floating-label-content">
                            <input type="time" class="did-floating-input" name="open_time" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 py-2">
                    <div class="form-group">
                        <div class="did-floating-label-content">
                            <input type="time" class="did-floating-input" name="close_time" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group mb-4">
                <label for="service_available" class="section-title">Service Available<span
                        class="text-danger">*</span></label>
                <div class="options-group">
                    <label class="option-item">
                        <input type="checkbox" name="service_available[]" value="Service at Workshop"
                            id="serviceOffline">
                        <span>Service at Workshop</span>
                    </label>
                    <label class="option-item">
                        <input type="checkbox" name="service_available[]" value="Service by Call" id="servicePanggilan">
                        <span>Service by Call</span>
                    </label>
                </div>
            </div>

            <!-- Bagian Payment Methods -->
            <div class="form-group mb-4">
                <label for="payment" class="section-title">Payment Methods<span class="text-danger">*</span></label>
                <div class="options-group">
                    <label class="option-item">
                        <input type="checkbox" name="payment[]" value="Manual Transfer" id="paymentManualTransfer"
                            onchange="toggleBankFields()">
                        <span>Manual Transfer</span>
                    </label>
                </div>
            </div>

            <!-- Bank Account Input -->
            <div class="form-group mb-3" id="bankAccountContainer" style="display: none;">
                <div class="row">
                    <div class="col">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="text" placeholder=" " id="rekening_number"
                                name="rekening_bank[0][no_rekening]" oninput="validateRekeningNumber(this)" />
                            <label class="did-floating-label">Bank Account Number<span
                                    class="text-danger">*</span></label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="did-floating-label-content">
                            <select class="did-floating-input" id="bank_name" name="rekening_bank[0][nama_bank]">
                                <option value="" disabled selected>Select Bank</option>
                                <option value="Bank BCA">Bank BCA</option>
                                <option value="Bank BRI">Bank BRI</option>
                                <option value="Bank BNI">Bank BNI</option>
                                <option value="Bank Mandiri">Bank Mandiri</option>
                                <option value="Bank Syariah Indonesia">Bank Syariah Indonesia</option>
                                <option value="Bank CIMB Niaga">Bank CIMB Niaga</option>
                                <option value="Panin Bank">Panin Bank</option>
                            </select>
                            <label class="did-floating-label">Bank Name<span class="text-danger">*</span></label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="text" placeholder=" " id="account_holder"
                                name="rekening_bank[0][atas_nama]" />
                            <label class="did-floating-label">Account Holder<span class="text-danger">*</span></label>
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-danger remove-button" onclick="removeBankAccount(this)">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div id="additional-bank-account-rows"></div>

            <div class="row mb-3">
                <div class="col text-left">
                    <button type="button" class="btn btn-custom-3" id="add-bank-account">Add Bank Account</button>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" name="whatsapp" placeholder="62" required
                        pattern="[\+0-9]*"
                        oninput="this.value = this.value.replace(/[^0-9]/g, ''); formatWhatsappNumber(this);" />
                    <label class="did-floating-label">WhatsApp<span class="text-danger">*</span></label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder="username" id="instagram"
                        name="instagram" />
                    <label class="did-floating-label">Instagram</label>
                </div>
            </div>
            <div class="form-group">
                <div class="d-flex justify-content-end align-items-center gap-2">
                    <a href="{{ route('profile.workshop') }}" class="btn btn-cancel">Cancel</a>
                    <button type="submit" class="btn btn-custom-icon">
                        Submit
                        <i class="bx bxs-send fs-5"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function validateRekeningNumber(input) {

            input.value = input.value.replace(/\D/g, '');
        }

        function toggleBankFields() {

            const paymentManualTransfer = document.getElementById('paymentManualTransfer');
            const bankAccountContainer = document.getElementById('bankAccountContainer');
            const addBankAccountButton = document.getElementById('add-bank-account');

            if (paymentManualTransfer.checked) {
                bankAccountContainer.style.display = 'block';
                addBankAccountButton.style.display = 'block';
            } else {
                bankAccountContainer.style.display = 'none';
                addBankAccountButton.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleBankFields();
        });

        let bankAccountIndex = 1;

        const addBankAccountButton = document.getElementById('add-bank-account');
        if (addBankAccountButton) {
            addBankAccountButton.addEventListener('click', function() {
                const container = document.getElementById('additional-bank-account-rows');
                const newRow = document.createElement('div');
                newRow.classList.add('row');

                newRow.innerHTML = `
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " name="rekening_bank[${bankAccountIndex}][no_rekening]" oninput="validateRekeningNumber(this)"/>
                        <label class="did-floating-label">Bank Account Number<span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col">
                    <div class="did-floating-label-content">
                        <select class="did-floating-input" type="text" placeholder=" " name="rekening_bank[${bankAccountIndex}][nama_bank]" />
                            <option value="" disabled selected>Select Bank</option>
                            <option value="Bank BCA">Bank BCA</option>
                            <option value="Bank BRI">Bank BRI</option>
                            <option value="Bank BNI">Bank BNI</option>
                            <option value="Bank Mandiri">Bank Mandiri</option>
                            <option value="Bank Syariah Indonesia">Bank Syariah Indonesia</option>
                            <option value="Bank CIMB Niaga">Bank CIMB Niaga</option>
                            <option value="Panin Bank">Panin Bank</option>
                        </select>
                        <label class="did-floating-label">Bank Name<span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " name="rekening_bank[${bankAccountIndex}][atas_nama]" />
                        <label class="did-floating-label">Account Holder<span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger remove-button" onclick="removeBankAccount(this)">
                        <i class="bx bx-trash"></i>
                    </button>
                </div>
            `;
                container.appendChild(newRow);
                bankAccountIndex++;
            });
        }

        function removeBankAccount(button) {
            const row = button.closest('.row');
            row.remove();
        }
    </script>
@endsection
