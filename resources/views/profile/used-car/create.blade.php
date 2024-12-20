@extends('layouts.partials.sidebar')

@section('title')
    eBengkelku | Create Used Car
@stop
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
        content: '{{ __('messages.profile.usedCar.upload.clik_upload') }}';
        display: block;
        font-size: 14px;
        color: #999;
    }
</style>
@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <h4>{{ __('messages.profile.usedCar.add_newcar') }}</h4>
        <p class="text-danger">*{{ __('messages.profile.usedCar.label.info') }}</p>
        <form class="py-4" action="{{ route('used-car-store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="text" placeholder=" " id="nama_mobil"
                                name="nama_mobil" required />
                            <label class="did-floating-label">{{ __('messages.profile.usedCar.label.car_name') }}<span
                                    class="text-danger">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="did-floating-label-content">
                            <select class="did-floating-input" id="merk_mobil_id" name="merk_mobil_id" required>
                                <option value="" disabled selected hidden>
                                    {{ __('messages.profile.usedCar.label.select_car') }}</option>
                                @foreach ($carMerks as $merk)
                                    <option value="{{ $merk->id }}">{{ $merk->nama_merk }}</option>
                                @endforeach
                            </select>
                            <label class="did-floating-label">{{ __('messages.profile.usedCar.label.car_brand') }}<span
                                    class="text-danger">*</span></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="harga_mobil" name="harga_mobil"
                            required />
                        <label class="did-floating-label">{{ __('messages.profile.usedCar.label.car_price') }}<span
                                class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="plat_nomor"
                            name="plat_nomor_mobil" required />
                        <label class="did-floating-label">{{ __('messages.profile.usedCar.label.car_plate') }}<span
                                class="text-danger">*</span></label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="tahun_mobil" name="tahun_mobil"
                            required />
                        <label class="did-floating-label">{{ __('messages.profile.usedCar.label.car_year') }}<span
                                class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="km_mobil" name="km_mobil"
                            required />
                        <label class="did-floating-label">{{ __('messages.profile.usedCar.label.car_mielage') }}<span
                                class="text-danger">*</span></label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="kapasitas_mesin_mobil"
                            name="kapasitas_mesin_mobil" required />
                        <label class="did-floating-label">{{ __('messages.profile.usedCar.label.car_capacity') }}<span
                                class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <select class="did-floating-input" id="bahan_bakar" name="bahan_bakar_mobil" required>
                            <option value="" disabled selected hidden>
                                {{ __('messages.profile.usedCar.label.car_selectfuel') }}</option>
                            <option value="bensin">{{ __('messages.profile.usedCar.label.car_gasoline') }}</option>
                            <option value="diesel">{{ __('messages.profile.usedCar.label.car_diesel') }}</option>
                            <option value="listrik">{{ __('messages.profile.usedCar.label.car_electric') }}</option>
                        </select>
                        <label class="did-floating-label">{{ __('messages.profile.usedCar.label.car_fuel') }}<span
                                class="text-danger">*</span></label>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <select class="did-floating-input" id="transmisi_mobil" name="jenis_transmisi_mobil" required>
                            <option value="" disabled selected hidden>
                                {{ __('messages.profile.usedCar.label.car_select_transmission') }}</option>
                            <option value="matic">{{ __('messages.profile.usedCar.label.car_automatic') }}</option>
                            <option value="manual">{{ __('messages.profile.usedCar.label.car_manual') }}</option>
                        </select>
                        <label class="did-floating-label">{{ __('messages.profile.usedCar.label.car_transmission') }}<span
                                class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <select class="did-floating-input" id="bulan_pajak_mobil" name="bulan_pajak_mobil" required>
                            <option value="" disabled selected>
                                {{ __('messages.profile.usedCar.label_month.tax_month') }}</option>
                            <option value="Januari">{{ __('messages.profile.usedCar.label_month.january') }}</option>
                            <option value="Februari">{{ __('messages.profile.usedCar.label_month.february') }}</option>
                            <option value="Maret">{{ __('messages.profile.usedCar.label_month.march') }}</option>
                            <option value="April">{{ __('messages.profile.usedCar.label_month.april') }}</option>
                            <option value="Mei">{{ __('messages.profile.usedCar.label_month.may') }}</option>
                            <option value="Juni">{{ __('messages.profile.usedCar.label_month.june') }}</option>
                            <option value="Juli">{{ __('messages.profile.usedCar.label_month.july') }}</option>
                            <option value="Agustus">{{ __('messages.profile.usedCar.label_month.august') }}</option>
                            <option value="September">{{ __('messages.profile.usedCar.label_month.september') }}</option>
                            <option value="Oktober">{{ __('messages.profile.usedCar.label_month.october') }}</option>
                            <option value="November">{{ __('messages.profile.usedCar.label_month.november') }}</option>
                            <option value="Desember">{{ __('messages.profile.usedCar.label_month.december') }}</option>
                        </select>
                        <label
                            class="did-floating-label">{{ __('messages.profile.usedCar.label_month.car_taxmonth') }}<span
                                class="text-danger">*</span></label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="tahun_pajak_mobil"
                            name="tahun_pajak_mobil" required />
                        <label class="did-floating-label">{{ __('messages.profile.usedCar.label.car_taxyear') }}<span
                                class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="date" placeholder=" " id="terakhir_pajak_mobil"
                            name="terakhir_pajak_mobil" required />
                        <label class="did-floating-label">{{ __('messages.profile.usedCar.label.lastcar_tax') }}<span
                                class="text-danger">*</span></label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <textarea class="did-floating-input" placeholder=" " id="keterangan_mobil" name="keterangan_mobil"
                            style="resize: none; height:100px;"></textarea>
                        <label
                            class="did-floating-label">{{ __('messages.profile.usedCar.label.car_description') }}</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <textarea class="did-floating-input" placeholder=" " id="lokasi_mobil" name="lokasi_mobil"
                            style="resize: none; height:100px;" required></textarea>
                        <label class="did-floating-label">{{ __('messages.profile.usedCar.label.car_location') }}<span
                                class="text-danger">*</span></label>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="foto_mobil" class="mb-2">
                    {{ __('messages.profile.usedCar.label_photo.photo_1') }}<span class="text-danger">*</span>
                </label>
                <div class="col-md-12">
                    <label for="file_foto_mobil_1" class="upload-label">
                        <div class="upload-box">
                            <div class="preview-container d-flex justify-content-center align-items-center">
                                <img id="foto1Preview" src="#" alt="Car Photo 1 Preview" class="image-preview"
                                    style="display: none; width: 200px; margin-top: 10px; cursor: pointer;">
                            </div>
                        </div>
                    </label>
                    <input type="file" class="file-input" name="file_foto_mobil_1" id="file_foto_mobil_1"
                        onchange="previewImage('file_foto_mobil_1', 'foto1Preview')" accept="image/*" required>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="foto_mobil" class="mb-2">{{ __('messages.profile.usedCar.label_photo.photo_2') }}<span
                        class="text-danger">*</span>
                </label>
                <div class="col-md-12">
                    <label for="file_foto_mobil_2" class="upload-label">
                        <div class="upload-box">
                            <div class="preview-container d-flex justify-content-center align-items-center">
                                <img id="foto2Preview" src="#" alt="Car Photo 2 Preview" class="image-preview"
                                    style="display: none; width: 200px; margin-top: 10px; cursor: pointer;">
                            </div>
                        </div>
                    </label>
                    <input type="file" class="file-input" name="file_foto_mobil_2" id="file_foto_mobil_2"
                        onchange="previewImage('file_foto_mobil_2', 'foto2Preview')" style="display: none;"
                        accept="image/*" required>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="foto_mobil" class="mb-2">{{ __('messages.profile.usedCar.label_photo.photo_3') }}<span
                        class="text-danger">*</span>
                </label>
                <div class="col-md-12">
                    <label for="file_foto_mobil_3" class="upload-label">
                        <div class="upload-box">
                            <div class="preview-container d-flex justify-content-center align-items-center">
                                <img id="foto3Preview" src="#" alt="Car Photo 3 Preview" class="image-preview"
                                    style="display: none; width: 200px; margin-top: 10px; cursor: pointer;">
                            </div>
                        </div>
                    </label>
                    <input type="file" class="file-input" name="file_foto_mobil_3" id="file_foto_mobil_3"
                        onchange="previewImage('file_foto_mobil_3', 'foto3Preview')" style="display: none;"
                        accept="image/*" required>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="foto_mobil" class="mb-2">{{ __('messages.profile.usedCar.label_photo.photo_4') }}<span
                        class="text-danger">*</span>
                </label>
                <div class="col-md-12">
                    <label for="file_foto_mobil_4" class="upload-label">
                        <div class="upload-box">
                            <div class="preview-container d-flex justify-content-center align-items-center">
                                <img id="foto4Preview" src="#" alt="Car Photo 4 Preview" class="image-preview"
                                    style="display: none; width: 200px; margin-top: 10px; cursor: pointer;">
                            </div>
                        </div>
                    </label>
                    <input type="file" class="file-input" name="file_foto_mobil_4" id="file_foto_mobil_4"
                        onchange="previewImage('file_foto_mobil_4', 'foto4Preview')" style="display: none;"
                        accept="image/*" required>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="foto_mobil" class="mb-2">{{ __('messages.profile.usedCar.label_photo.photo_5') }}<span
                        class="text-danger">*</span>
                </label>
                <div class="col-md-12">
                    <label for="file_foto_mobil_5" class="upload-label">
                        <div class="upload-box">
                            <div class="preview-container d-flex justify-content-center align-items-center">
                                <img id="foto5Preview" src="#" alt="Car Photo 5 Preview" class="image-preview"
                                    style="display: none; width: 200px; margin-top: 10px; cursor: pointer;">
                            </div>
                        </div>
                    </label>
                    <input type="file" class="file-input" name="file_foto_mobil_5" id="file_foto_mobil_5"
                        onchange="previewImage('file_foto_mobil_5', 'foto5Preview')" style="display: none;"
                        accept="image/*" required>
                </div>
            </div>

            <div class="form-group">
                <div class="d-flex justify-content-end align-items-center gap-2">
                    <a href="{{ route('profile-used-car') }}"
                        class="btn btn-cancel">{{ __('messages.profile.usedCar.button.cancel') }}</a>
                    <button type="submit" class="btn btn-custom-icon">
                        {{ __('messages.profile.usedCar.button.submit') }}
                        <i class="bx bxs-send fs-5"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('tahun_pajak_mobil').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);
        });
    </script>
    <script>
        function triggerFileInput(fileInputId) {
            document.getElementById(fileInputId).click();
        }

        function previewImage(inputId, previewId) {
            var fileInput = document.getElementById(inputId);
            var previewImage = document.getElementById(previewId);
            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.style.display = "block";
                    previewImage.src = e.target.result;
                };
                reader.readAsDataURL(fileInput.files[0]);
            } else {
                previewImage.style.display = "none";
                previewImage.src = "#";
            }
        }
        document.querySelectorAll('.file-input').forEach(input => {
            input.addEventListener('change', function() {
                var previewId = this.getAttribute('onchange').match(/'([^']+)'/g)[1].replace(/'/g, '');
                previewImage(this.id, previewId);
            });
        });

        function showMonthName(input) {
            if (input.value) {
                const [year, month] = input.value.split('-');
                const monthNames = [
                    "January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ];
                const monthName = monthNames[parseInt(month, 10) - 1];
                input.type = 'text';
                input.value = monthName;
            }
        }
        document.getElementById('bulan_pajak_mobil').addEventListener('focus', function() {
            this.type = 'month';
        });
        document.getElementById('bulan_pajak_mobil').addEventListener('keydown', function(event) {
            if (this.type === 'text') {
                event.preventDefault();
            }
        });
        document.getElementById('bulan_pajak_mobil').addEventListener('input', function(event) {
            if (this.type === 'text' && event.inputType !== 'insertFromPaste') {
                event.preventDefault();
            }
        });
    </script>

@endsection
