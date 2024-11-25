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
        content: 'Click to upload';
        display: block;
        font-size: 14px;
        color: #999;
    }
</style>
@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <h4>Add Used Car</h4>
        <form class="py-4" action="{{ route('used-car-store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="text" placeholder=" " id="nama_mobil"
                                name="nama_mobil" required />
                            <label class="did-floating-label">Car Name</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="did-floating-label-content">
                            <select class="did-floating-input" id="merk_mobil_id" name="merk_mobil_id" required>
                                <option value="" disabled selected hidden>Select Car Merk</option>
                                @foreach ($carMerks as $merk)
                                    <option value="{{ $merk->id }}">{{ $merk->nama_merk }}</option>
                                @endforeach
                            </select>
                            <label class="did-floating-label">Car Merk</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="harga_mobil" name="harga_mobil"
                            required />
                        <label class="did-floating-label">Car Price</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="plat_nomor"
                            name="plat_nomor_mobil" required />
                        <label class="did-floating-label">Car License Plate Number</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="tahun_mobil" name="tahun_mobil"
                            required />
                        <label class="did-floating-label">Car Year</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="km_mobil" name="km_mobil"
                            required />
                        <label class="did-floating-label">KM Car</label>
                    </div>
                </div>
            </div>

            {{-- <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="nomor_rangka_mobil"
                            name="nomor_rangka_mobil" />
                        <label class="did-floating-label">Car Chassis Number</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="nomor_mesin"
                            name="nomor_mesin_mobil" />
                        <label class="did-floating-label">Car Engine Number </label>
                    </div>
                </div>
            </div> --}}

            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="kapasitas_mesin_mobil"
                            name="kapasitas_mesin_mobil" required />
                        <label class="did-floating-label">Car Engine Capacity</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <select class="did-floating-input" id="bahan_bakar" name="bahan_bakar_mobil" required>
                            <option value="" disabled selected hidden>Select Fuel Type</option>
                            <option value="bensin">Bensin</option>
                            <option value="diesel">Diesel</option>
                            <option value="listrik">Listrik</option>
                        </select>
                        <label class="did-floating-label">Car Fuel Type </label>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <select class="did-floating-input" id="transmisi_mobil" name="jenis_transmisi_mobil" required>
                            <option value="" disabled selected hidden>Select Transmission</option>
                            <option value="matic">Matic</option>
                            <option value="manual">Manual</option>
                        </select>
                        <label class="did-floating-label">Car Transmission Type</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <select class="did-floating-input" id="bulan_pajak_mobil" name="bulan_pajak_mobil" required>
                            <option value="" disabled selected>Select Tax Month</option>
                            <option value="Januari">Januari</option>
                            <option value="Februari">Februari</option>
                            <option value="Maret">Maret</option>
                            <option value="April">April</option>
                            <option value="Mei">Mei</option>
                            <option value="Juni">Juni</option>
                            <option value="Juli">Juli</option>
                            <option value="Agustus">Agustus</option>
                            <option value="September">September</option>
                            <option value="Oktober">Oktober</option>
                            <option value="November">November</option>
                            <option value="Desember">Desember</option>
                        </select>
                        <label class="did-floating-label">Car Tax Month
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="tahun_pajak_mobil"
                            name="tahun_pajak_mobil" required />
                        <label class="did-floating-label">Car Tax Year</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="date" placeholder=" " id="terakhir_pajak_mobil"
                            name="terakhir_pajak_mobil" required />
                        <label class="did-floating-label">Last Car Tax</label>
                    </div>
                </div>
                {{-- <div class="col-md-12">
                    <div class="did-floating-label-content">
                        <select class="did-floating-input" id="pemakaian" name="pemakaian" required>
                            <option value="" disabled selected hidden>Select Car Year</option>
                            <option value="Under 1 Year">Under 1 Year</option>
                            <option value="Under 3 Years">Under 3 Years</option>
                            <option value="Under 5 Years">Under 5 Years</option>
                            <option value="Under 7 Years">Under 7 Years</option>
                            <option value="Under 10 Years">Under 10 Years</option>
                        </select>
                        <label class="did-floating-label">Car Year</label>
                    </div>
                </div> --}}
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <textarea class="did-floating-input" placeholder=" " id="keterangan_mobil" name="keterangan_mobil"
                            style="resize: none; height:100px;"></textarea>
                        <label class="did-floating-label">Car Decription</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <textarea class="did-floating-input" placeholder=" " id="lokasi_mobil" name="lokasi_mobil"
                            style="resize: none; height:100px;" required></textarea>
                        <label class="did-floating-label">Car Location</label>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="foto_mobil" class="mb-2">Car Foto 1</label>

                <!-- Foto Mobil 1 -->
                <div class="col-md-12">
                    <label for="file_foto_mobil_1" class="upload-label">
                        <div class="upload-box">
                            <div class="preview-container d-flex justify-content-center align-items-center"
                                onclick="triggerFileInput('file_foto_mobil_1')">
                                <img id="foto1Preview" src="#" alt="Foto Mobil 1 Preview" class="image-preview"
                                    style="display: none; width: 200px; margin-top: 10px; cursor: pointer;">
                                <i class="fa-solid fa-plus" style="font-size: 36px;"></i>
                                <p class="mb-2 text-sm text-gray-500">
                                </p>
                            </div>
                        </div>
                    </label>
                    <input type="file" class="file-input" name="file_foto_mobil_1" id="file_foto_mobil_1"
                        onchange="previewImage('file_foto_mobil_1', 'foto1Preview')" style="display: none;"
                        accept="image/*" required>
                </div>

                <!-- Foto Mobil 2 -->
                <div class="col-md-12">
                    <label for="file_foto_mobil_2" class="upload-label">
                        <label for="foto_mobil_2" class="mb-2 mt-3">Car Foto 2</label>

                        <div class="upload-box">
                            <div class="preview-container d-flex justify-content-center"
                                onclick="triggerFileInput('file_foto_mobil_2')">
                                <img id="foto2Preview" src="#" alt="Foto Mobil 2 Preview" class="image-preview"
                                    style="display: none; width: 200px; margin-top: 10px; cursor: pointer;">
                                <i class="fa-solid fa-plus" style="font-size: 36px;"></i>
                            </div>
                        </div>
                    </label>
                    <input type="file" class="file-input" name="file_foto_mobil_2" id="file_foto_mobil_2"
                        onchange="previewImage('file_foto_mobil_2', 'foto2Preview')" style="display: none;"
                        accept="image/*" required>
                </div>

                <!-- Foto Mobil 3 -->
                <div class="col-md-12">
                    <label for="file_foto_mobil_3" class="upload-label">
                        <label for="foto_mobil_3" class="mb-2 mt-3">Car Foto 3</label>

                        <div class="upload-box">
                            <div class="preview-container d-flex justify-content-center"
                                onclick="triggerFileInput('file_foto_mobil_3')">
                                <img id="foto3Preview" src="#" alt="Foto Mobil 3 Preview" class="image-preview"
                                    style="display: none; width: 200px; margin-top: 10px; cursor: pointer;">
                                <i class="fa-solid fa-plus" style="font-size: 36px;"></i>
                            </div>
                        </div>
                    </label>
                    <input type="file" class="file-input" name="file_foto_mobil_3" id="file_foto_mobil_3"
                        onchange="previewImage('file_foto_mobil_3', 'foto3Preview')" style="display: none;"
                        accept="image/*" required>
                </div>

                <!-- Foto Mobil 4 -->
                <div class="col-md-12">
                    <label for="file_foto_mobil_4" class="upload-label">
                        <label for="foto_mobil_4" class="mb-2 mt-3">Car Foto 4</label>
                        <div class="upload-box">
                            <div class="preview-container d-flex justify-content-center"
                                onclick="triggerFileInput('file_foto_mobil_4')">
                                <img id="foto4Preview" src="#" alt="Foto Mobil 4 Preview" class="image-preview"
                                    style="display: none; width: 200px; margin-top: 10px; cursor: pointer;">
                                <i class="fa-solid fa-plus" style="font-size: 36px;"></i>
                            </div>
                        </div>
                    </label>
                    <input type="file" class="file-input" name="file_foto_mobil_4" id="file_foto_mobil_4"
                        onchange="previewImage('file_foto_mobil_4', 'foto4Preview')" style="display: none;"
                        accept="image/*" required>
                </div>

                <!-- Foto Mobil 5 -->
                <div class="col-md-12">
                    <label for="file_foto_mobil_5" class="upload-label">
                        <label for="foto_mobil_5" class="mb-2 mt-3">Car Foto 5</label>

                        <div class="upload-box">
                            <div class="preview-container d-flex justify-content-center"
                                onclick="triggerFileInput('file_foto_mobil_5')">
                                <img id="foto5Preview" src="#" alt="Foto Mobil 5 Preview" class="image-preview"
                                    style="display: none; width: 200px; margin-top: 10px; cursor: pointer;">
                                <i class="fa-solid fa-plus" style="font-size: 36px;"></i>
                            </div>
                        </div>
                    </label>
                    <input type="file" class="file-input" name="file_foto_mobil_5" id="file_foto_mobil_5"
                        onchange="previewImage('file_foto_mobil_5', 'foto5Preview')" style="display: none;"
                        accept="image/*" required>
                </div>
            </div>

            <div class="d-flex justify-content-start mt-3">
                <button type="submit" class="btn btn-custom-icon me-2">
                    Save
                </button>

                <a href="{{ route('profile-used-car') }}" class="btn btn-cancel">Cancel</a>
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
            // Trigger file input click
            document.getElementById(fileInputId).click();
        }

        function previewImage(inputId, previewId) {
            var fileInput = document.getElementById(inputId);
            var previewImage = document.getElementById(previewId);

            // Pastikan ada file yang dipilih
            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    // Tampilkan gambar pada preview
                    previewImage.style.display = "block";
                    previewImage.src = e.target.result;
                };

                // Baca file yang dipilih
                reader.readAsDataURL(fileInput.files[0]);
            }
        }

        // Bulan
        // Fungsi untuk menampilkan nama bulan
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
