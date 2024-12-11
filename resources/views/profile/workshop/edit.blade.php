@extends('layouts.partials.sidebar')

@section('title')
    eBengkelku | Edit bengkel
@stop

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        $.get('https://api.cahyadsn.com/provinces', function(response) {
            console.log('Provinces Response:', response);
            let provinsiDropdown = $('#provinsi');
            provinsiDropdown.empty();
            provinsiDropdown.append(
                '<option value="" selected disabled hidden>Select Province</option>');

            if (response.data && Array.isArray(response.data)) {
                $.each(response.data, function(index, provinsi) {
                    let selected = (provinsi.kode == "{{ $bengkel->provinsi }}") ? 'selected' :
                        '';
                    provinsiDropdown.append('<option value="' + provinsi.kode + '" ' +
                        selected + '>' + provinsi.nama + '</option>');
                });
            }

            provinsiDropdown.trigger('change');
        }).fail(function() {
            console.log('Failed to load provinces');
        });

        $('#provinsi').change(function() {
            let provinsiId = $(this).val();
            let kotaDropdown = $('#kota');
            kotaDropdown.empty();
            kotaDropdown.append('<option value="" selected disabled hidden>Select City</option>');

            $.get('https://api.cahyadsn.com/regencies/' + provinsiId, function(response) {
                console.log('Cities Response:', response);
                if (response.data && Array.isArray(response.data)) {
                    $.each(response.data, function(index, kota) {
                        let selected = (kota.kode == "{{ $bengkel->kota }}") ?
                            'selected' : '';
                        kotaDropdown.append('<option value="' + kota.kode + '" ' +
                            selected + '>' + kota.nama + '</option>');
                    });
                }

                kotaDropdown.trigger('change');
            }).fail(function() {
                console.log('Failed to load cities');
            });
        });

        $('#kota').change(function() {
            let kotaId = $(this).val();
            let kecamatanDropdown = $('#kecamatan');
            kecamatanDropdown.empty();
            kecamatanDropdown.append(
                '<option value="" selected disabled hidden>Select District</option>');

            $.get('https://api.cahyadsn.com/districts/' + kotaId, function(response) {
                console.log('Districts Response:', response);
                if (response.data && Array.isArray(response.data)) {
                    $.each(response.data, function(index, kecamatan) {
                        let selected = (kecamatan.kode == "{{ $bengkel->kecamatan }}") ?
                            'selected' : '';
                        kecamatanDropdown.append('<option value="' + kecamatan.kode +
                            '" ' + selected + '>' + kecamatan.nama + '</option>');
                    });
                }
            }).fail(function() {
                console.log('Failed to load districts');
            });
        });

        $('#provinsi').trigger('change');
    });
</script>
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
            closeDay.disabled = true; < span class = "text-danger" > * < /span>
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

    document.addEventListener('DOMContentLoaded', function() {
        const whatsappInput = document.querySelector('[name="whatsapp"]');
        if (whatsappInput && whatsappInput.value) {
            formatWhatsappNumber(whatsappInput);
        }
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
</style>

@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <h4>Edit bengkel</h4>
        <p class="text-danger">*indicates required fields</p>
        <form action="{{ route('profile.workshop.update', $bengkel->id_bengkel) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Cover Image -->
            <div class="form-group mb-4">
                <div class="upload-box">
                    <label for="foto_cover_bengkel" class="upload-label">Cover Workshop Photo</label>
                    <input type="file" class="file-input" name="foto_cover_bengkel" id="foto_cover_bengkel"
                        onchange="previewImage('foto_cover_bengkel', 'coverPreview')">
                    <div class="preview-container d-flex justify-content-center">
                        <img id="coverPreview"
                            src="{{ $bengkel->foto_cover_bengkel ? asset($bengkel->foto_cover_bengkel) : asset('assets/images/components/image.ppg') }}"
                            alt="Cover Photo Preview" class="image-preview"
                            style="display: block; width: 200px; margin-top: 10px;">

                    </div>
                </div>
            </div>

            <!-- Workshop Image -->
            <div class="form-group mb-4">
                <div class="upload-box">
                    <label for="foto_bengkel" class="upload-label">Workshop Photo</label>
                    <input type="file" class="file-input" name="foto_bengkel" id="foto_bengkel"
                        onchange="previewImage('foto_bengkel', 'bengkelPreview')">
                    <div class="preview-container d-flex justify-content-center">
                        <img id="bengkelPreview"
                            src="{{ $bengkel->foto_bengkel ? asset($bengkel->foto_bengkel) : asset('assets/images/components/image.png') }}"
                            alt="Workshop Photo Preview" class="image-preview"
                            style="display: block; width: 200px; margin-top: 10px;">

                    </div>
                </div>
            </div>

            <!-- Workshop Name -->
            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder=" " id="nama_bengkel" name="nama_bengkel"
                        value="{{ old('nama_bengkel', $bengkel->nama_bengkel) }}" required />
                    <label class="did-floating-label">Workshop Name<span class="text-danger">*</span></label>
                </div>
            </div>

            <!-- Tagline -->
            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder=" " id="tagline_bengkel"
                        name="tagline_bengkel" value="{{ old('tagline_bengkel', $bengkel->tagline_bengkel) }}" />
                    <label class="did-floating-label">Workshop Tagline</label>
                </div>
            </div>

            <!-- Address -->
            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <textarea class="did-floating-input form-control" name="alamat_bengkel" placeholder=" " rows="4" required
                        style="height: 100px;resize: none">{{ old('alamat_bengkel', $bengkel->alamat_bengkel) }}</textarea>
                    <label class="did-floating-label">Workshop Address<span class="text-danger">*</span></label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="provinsi" id="provinsi" class="did-floating-select">
                        <option value="" selected disabled hidden>Select Province</option>
                        <!-- Options will be populated by JavaScript -->
                    </select>
                    <label class="did-floating-label">Province<span class="text-danger">*</span></label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="kota" id="kota" class="did-floating-select">
                        <option value="" selected disabled hidden>Select City</option>
                        <!-- Options will be populated by JavaScript -->
                    </select>
                    <label class="did-floating-label">City<span class="text-danger">*</span></label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="kecamatan" id="kecamatan" class="did-floating-select">
                        <option value="" selected disabled hidden>Select District</option>
                        <!-- Options will be populated by JavaScript -->
                    </select>
                    <label class="did-floating-label">District<span class="text-danger">*</span></label>
                </div>
            </div>

            <!-- Google Maps Link -->
            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder="https://" id="gmaps" name="gmaps"
                        required value="{{ old('gmaps', $bengkel->gmaps) }}" />
                    <label class="did-floating-label">Google Maps Link<span class="text-danger">*</span></label>
                </div>
            </div>

            <!-- Schedule -->
            <div class="form-group mb-3 text-center">
                <label for="open_day" class="w-100">Open Day<span class="text-danger">*</span></label>
            </div>
            <div class="row mb-3">
                <div class="col-md-6 py-2">
                    <div class="did-floating-label-content">
                        <select class="did-floating-select" name="open_day" id="open_day" required
                            onchange="toggleCloseFields()">
                            <option value="" selected disabled hidden></option>
                            <option value="Monday"
                                {{ old('open_day', $bengkel->open_day) == 'Monday' ? 'selected' : '' }}>Monday
                            </option>
                            <option value="Tuesday"
                                {{ old('open_day', $bengkel->open_day) == 'Tuesday' ? 'selected' : '' }}>Tuesday
                            </option>
                            <option value="Wednesday"
                                {{ old('open_day', $bengkel->open_day) == 'Wednesday' ? 'selected' : '' }}>
                                Wednesday</option>
                            <option value="Thursday"
                                {{ old('open_day', $bengkel->open_day) == 'Thursday' ? 'selected' : '' }}>
                                Thursday
                            </option>
                            <option value="Friday"
                                {{ old('open_day', $bengkel->open_day) == 'Friday' ? 'selected' : '' }}>Friday
                            </option>
                            <option value="Saturday"
                                {{ old('open_day', $bengkel->open_day) == 'Saturday' ? 'selected' : '' }}>
                                Saturday
                            </option>
                            <option value="Sunday"
                                {{ old('open_day', $bengkel->open_day) == 'Sunday' ? 'selected' : '' }}>Sunday
                            </option>
                            <option value="Every Day"
                                {{ old('open_day', $bengkel->open_day) == 'Every Day' ? 'selected' : '' }}>
                                Every
                                Day</option>
                        </select>
                        <label class="did-floating-label">Start</label>
                    </div>
                </div>
                <div class="col-md-6 py-2">
                    <div class="did-floating-label-content">
                        <select class="did-floating-select" name="close_day" id="close_day" required
                            {{ $bengkel->open_day == 'Every Day' ? 'disabled' : '' }}>
                            <option value="" selected disabled hidden></option>
                            <option value="Monday"
                                {{ old('close_day', $bengkel->close_day) == 'Monday' ? 'selected' : '' }}>Monday
                            </option>
                            <option value="Tuesday"
                                {{ old('close_day', $bengkel->close_day) == 'Tuesday' ? 'selected' : '' }}>
                                Tuesday
                            </option>
                            <option value="Wednesday"
                                {{ old('close_day', $bengkel->close_day) == 'Wednesday' ? 'selected' : '' }}>
                                Wednesday</option>
                            <option value="Thursday"
                                {{ old('close_day', $bengkel->close_day) == 'Thursday' ? 'selected' : '' }}>
                                Thursday</option>
                            <option value="Friday"
                                {{ old('close_day', $bengkel->close_day) == 'Friday' ? 'selected' : '' }}>Friday
                            </option>
                            <option value="Saturday"
                                {{ old('close_day', $bengkel->close_day) == 'Saturday' ? 'selected' : '' }}>
                                Saturday</option>
                            <option value="Sunday"
                                {{ old('close_day', $bengkel->close_day) == 'Sunday' ? 'selected' : '' }}>Sunday
                            </option>
                        </select>
                        <label class="did-floating-label">End</label>
                    </div>
                </div>
            </div>

            <!-- Clock -->
            <div class="form-group mb-3 text-center">
                <label for="open_time" class="w-100">Open Hour<span class="text-danger">*</span></label>
            </div>
            <div class="row mb-3">
                <div class="col-md-6 py-2">
                    <div class="did-floating-label-content">
                        <input type="time" class="did-floating-input" name="open_time"
                            value="{{ old('open_time', $bengkel->open_time) }}" required>
                        <label class="did-floating-label">Open Time</label>
                    </div>
                </div>
                <div class="col-md-6 py-2">
                    <div class="did-floating-label-content">
                        <input type="time" class="did-floating-input" name="close_time"
                            value="{{ $bengkel->close_time }}" required>
                        <label class="did-floating-label">Close Time</label>
                    </div>
                </div>
            </div>

            <!-- Service Available -->
            <div class="form-group mb-4">
                <label for="service_available" class="section-title">Service Available<span
                        class="text-danger">*</span></label>
                <div class="options-group">
                    <label class="option-item">
                        <input type="checkbox" name="service_available[]" value="Service at Workshop"
                            id="serviceOffline"
                            {{ in_array('Service at Workshop', old('service_available', $serviceAvailable)) ? 'checked' : '' }}>
                        <span>Service at Workshop</span>
                    </label>
                    <label class="option-item">
                        <input type="checkbox" name="service_available[]" value="Service by Call" id="servicePanggilan"
                            {{ in_array('Service by Call', old('service_available', $serviceAvailable)) ? 'checked' : '' }}>
                        <span>Service by Call</span>
                    </label>
                </div>
            </div>

            <!-- Bagian Payment Methods -->
            <div class="form-group mb-4">
                <label for="payment" class="section-title">Payment Methods<span class="text-danger">*</span></label>
                <div class="options-group">
                    <label class="option-item">
                        <input type="checkbox" name="payment[]" value="Cash" id="paymentCash"
                            {{ in_array('Cash', old('payment', $paymentMethods)) ? 'checked' : '' }}>
                        <span>Cash</span>
                    </label>
                    <label class="option-item">
                        <input type="checkbox" name="payment[]" value="Manual Transfer" id="paymentManualTransfer"
                            {{ in_array('Manual Transfer', old('payment', $paymentMethods)) ? 'checked' : '' }}
                            onchange="toggleBankFields()">
                        <span>Manual Transfer</span>
                    </label>
                    <label class="option-item">
                        <input type="checkbox" name="payment[]" value="QRIS" id="paymentQRIS"
                            {{ in_array('QRIS', old('payment', $paymentMethods)) ? 'checked' : '' }}
                            onchange="toggleBankFields()">
                        <span>QRIS</span>
                    </label>
                </div>
            </div>

            <!-- Bank Account Input (styled like the event form) -->
            <div class="form-group mb-3" id="bankAccountContainer"
                style="display: {{ in_array('Manual Transfer', old('payment', $paymentMethods)) ? 'block' : 'none' }};">
                @foreach ($bankAccounts as $index => $bankAccount)
                    <div class="row mb-3">
                        <div class="col">
                            <div class="did-floating-label-content">
                                <input class="did-floating-input" type="text" placeholder=" "
                                    name="rekening_bank[{{ $index }}][no_rekening]"
                                    value="{{ old('rekening_bank.' . $index . '.no_rekening', $bankAccount['no_rekening']) }}"
                                    oninput="validateRekeningNumber(this)" />
                                <label class="did-floating-label">Bank Account Number<span
                                        class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="did-floating-label-content">
                                <select class="did-floating-input" name="rekening_bank[{{ $index }}][nama_bank]">
                                    <option value="" disabled selected>Select Bank</option>
                                    <option value="Bank BCA"
                                        {{ old('rekening_bank.' . $index . '.nama_bank', $bankAccount['nama_bank']) == 'Bank BCA' ? 'selected' : '' }}>
                                        Bank BCA</option>
                                    <option value="Bank BRI"
                                        {{ old('rekening_bank.' . $index . '.nama_bank', $bankAccount['nama_bank']) == 'Bank BRI' ? 'selected' : '' }}>
                                        Bank BRI</option>
                                    <option value="Bank BNI"
                                        {{ old('rekening_bank.' . $index . '.nama_bank', $bankAccount['nama_bank']) == 'Bank BNI' ? 'selected' : '' }}>
                                        Bank BNI</option>
                                    <option value="Bank Mandiri"
                                        {{ old('rekening_bank.' . $index . '.nama_bank', $bankAccount['nama_bank']) == 'Bank Mandiri' ? 'selected' : '' }}>
                                        Bank Mandiri</option>
                                    <option value="Bank Syariah Indonesia"
                                        {{ old('rekening_bank.' . $index . '.nama_bank', $bankAccount['nama_bank']) == 'Bank Syariah Indonesia' ? 'selected' : '' }}>
                                        Bank Syariah Indonesia</option>
                                    <option value="Bank CIMB Niaga"
                                        {{ old('rekening_bank.' . $index . '.nama_bank', $bankAccount['nama_bank']) == 'Bank CIMB Niaga' ? 'selected' : '' }}>
                                        Bank CIMB Niaga</option>
                                    <option value="Panin Bank"
                                        {{ old('rekening_bank.' . $index . '.nama_bank', $bankAccount['nama_bank']) == 'Panin Bank' ? 'selected' : '' }}>
                                        Panin Bank</option>
                                </select>
                                <label class="did-floating-label">Bank Name<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="did-floating-label-content">
                                <input class="did-floating-input" type="text" placeholder=" "
                                    name="rekening_bank[{{ $index }}][atas_nama]"
                                    value="{{ old('rekening_bank.' . $index . '.atas_nama', $bankAccount['atas_nama']) }}" />
                                <label class="did-floating-label">Account Holder<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger remove-button"
                                onclick="removeBankAccount(this)">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="additional-bank-account-rows"></div>

            <!-- Add Bank Account Button -->
            <div class="row mb-3">
                <div class="col text-left">
                    <button type="button" class="btn btn-custom-3" id="add-bank-account"
                        style="display: {{ in_array('Manual Transfer', old('payment', $paymentMethods)) ? 'block' : 'none' }};">Add
                        Bank Account</button>
                </div>
            </div>

            <!-- QRIS QR Code Input (will be shown if "QRIS" is selected) -->
            <div class="form-group mb-4" id="qrisContainer"
                style="display: {{ in_array('QRIS', old('payment', $paymentMethods)) ? 'block' : 'none' }};">
                <div class="upload-box">
                    <label for="qris_qrcode" class="upload-label">QRIS QR Code</label>
                    <input type="file" class="file-input" name="qris_qrcode" id="qris_qrcode"
                        onchange="previewImage('qris_qrcode', 'qrisPreview')">
                    <div class="preview-container d-flex justify-content-center">
                        <img id="qrisPreview" src="{{ old('qris_qrcode', $bengkel->qris_qrcode) }}"
                            alt="QRIS QR Code Preview" class="image-preview"
                            style="display: {{ old('qris_qrcode', $bengkel->qris_qrcode) ? 'block' : 'none' }}; width: 200px; margin-top: 10px;">
                    </div>
                </div>
            </div>

            <!-- WhatsApp -->
            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" name="whatsapp" placeholder="62"
                        value="{{ old('whatsapp', $bengkel->whatsapp) }}" required pattern="[\+0-9]*"
                        oninput="this.value = this.value.replace(/[^0-9]/g, ''); formatWhatsappNumber(this);" />
                    <label class="did-floating-label">WhatsApp<span class="text-danger">*</span></label>
                </div>
            </div>

            <!-- Instagram -->
            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder="username" id="instagram"
                        name="instagram" value="{{ old('instagram', $bengkel->instagram) }}" />
                    <label class="did-floating-label">Instagram</label>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <div class="d-flex justify-content-end align-items-center gap-2">
                    <a href="{{ route('profile.workshop') }}" class="btn btn-cancel">Cancel</a>
                    <button type="submit" class="btn btn-custom-icon">
                        Save
                        <i class="bx bxs-save fs-5"></i>
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
            const paymentQRIS = document.getElementById('paymentQRIS');

            if (paymentManualTransfer && paymentQRIS) {

                const bankAccountContainer = document.getElementById('bankAccountContainer');
                const qrisContainer = document.getElementById('qrisContainer');
                const addBankAccountButton = document.getElementById('add-bank-account');

                if (paymentManualTransfer.checked) {
                    bankAccountContainer.style.display = 'block';
                    addBankAccountButton.style.display = 'block';
                } else {
                    bankAccountContainer.style.display = 'none';
                    addBankAccountButton.style.display = 'none';
                }

                if (paymentQRIS.checked) {
                    qrisContainer.style.display = 'block';
                } else {
                    qrisContainer.style.display = 'none';
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleBankFields();
        });

        let bankAccountIndex = {{ count($bankAccounts) }};
        const addBankAccountButton = document.getElementById('add-bank-account');
        const bankAccountContainer = document.getElementById('additional-bank-account-rows');

        if (addBankAccountButton) {
            addBankAccountButton.addEventListener('click', function() {

                const newRow = document.createElement('div');
                newRow.classList.add('row', 'mb-3');

                newRow.innerHTML = `
            <div class="col">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder=" " name="rekening_bank[${bankAccountIndex}][no_rekening]" oninput="validateRekeningNumber(this)" />
                    <label class="did-floating-label">Bank Account Number<span class="text-danger">*</span></label>
                </div>
            </div>
            <div class="col">
                <div class="did-floating-label-content">
                    <select class="did-floating-input" name="rekening_bank[${bankAccountIndex}][nama_bank]">
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
                    <label class="did-floating-label">Account Holder<span class="text-danger">*</label>
                </div>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-danger remove-button" onclick="removeBankAccount(this)">
                    <i class="bx bx-trash"></i>
                </button>
            </div>
        `;

                bankAccountContainer.appendChild(newRow);
                bankAccountIndex++;
            });
        }

        function removeBankAccount(button) {
            const row = button.closest('.row');
            row.remove();
        }
    </script>

@endsection
