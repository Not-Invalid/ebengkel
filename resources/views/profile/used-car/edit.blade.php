@extends('layouts.partials.sidebar')

@section('title')
    eBengkelku | Used Car Edit
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
        <h4>Edit Used Car</h4>
        <p class="text-danger">*indicates required fields</p>
        <form class="py-4" action="{{ route('used-car-update', $mobil->id_mobil) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="nama_mobil" name="nama_mobil"
                            value="{{ old('nama_mobil', $mobil->nama_mobil) }}" required />
                        <label class="did-floating-label car">Car Name<span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <select class="did-floating-input" id="merk_mobil_id" name="merk_mobil_id" required>
                            <option value="" disabled hidden>Select Merk Car</option>
                            @foreach ($carMerks as $merk)
                                <option value="{{ $merk->id }}"
                                    {{ old('merk_mobil_id', $mobil->merk_mobil_id) == $merk->id ? 'selected' : '' }}>
                                    {{ $merk->nama_merk }}
                                </option>
                            @endforeach
                        </select>
                        <label class="did-floating-label">Car Merk<span class="text-danger">*</span></label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="harga_mobil" name="harga_mobil"
                            value="{{ old('harga_mobil', number_format($mobil->harga_mobil, 0, ',', '.')) }}" required />
                        <label class="did-floating-label car">Car Price<span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="plat_nomor"
                            name="plat_nomor_mobil" value="{{ old('plat_nomor_mobil', $mobil->plat_nomor_mobil) }}"
                            required />
                        <label class="did-floating-label car">Car License Plate Number<span class="text-danger">*</span></label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="tahun_mobil" name="tahun_mobil"
                            value="{{ old('tahun_mobil', $mobil->tahun_mobil) }}" required />
                        <label class="did-floating-label car">Car Year<span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="km_mobil" name="km_mobil"
                            value="{{ old('km_mobil', $mobil->km_mobil) }}" required />
                        <label class="did-floating-label car">KM Car<span class="text-danger">*</span></label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="kapasitas_mesin_mobil"
                            name="kapasitas_mesin_mobil"
                            value="{{ old('kapasitas_mesin_mobil', $mobil->kapasitas_mesin_mobil) }}" required />
                        <label class="did-floating-label car">Car Engine Capacity<span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <select class="did-floating-input" id="bahan_bakar" name="bahan_bakar_mobil" required>
                            <option value="" disabled selected hidden>Select Fuel Type</option>
                            <option value="bensin"
                                {{ old('bahan_bakar_mobil', $mobil->bahan_bakar_mobil) == 'bensin' ? 'selected' : '' }}>
                                Gasoline</option>
                            <option value="diesel"
                                {{ old('bahan_bakar_mobil', $mobil->bahan_bakar_mobil) == 'diesel' ? 'selected' : '' }}>
                                Diesel</option>
                            <option value="listrik"
                                {{ old('bahan_bakar_mobil', $mobil->bahan_bakar_mobil) == 'listrik' ? 'selected' : '' }}>
                                Electric</option>
                        </select>
                        <label class="did-floating-label">Car Fuel Type<span class="text-danger">*</span></label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <select class="did-floating-input" id="transmisi_mobil" name="jenis_transmisi_mobil" required>
                            <option value="" disabled selected hidden>Select Transmission Type</option>
                            <option value="matic"
                                {{ old('jenis_transmisi_mobil', $mobil->jenis_transmisi_mobil) == 'matic' ? 'selected' : '' }}>
                                Automatic</option>
                            <option value="manual"
                                {{ old('jenis_transmisi_mobil', $mobil->jenis_transmisi_mobil) == 'manual' ? 'selected' : '' }}>
                                Manual</option>
                        </select>
                        <label class="did-floating-label">Car Transmission Type<span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <select class="did-floating-input" id="bulan_pajak_mobil" name="bulan_pajak_mobil" required>
                            <option value="" disabled selected>Select Tax Month</option>
                            <option value="Januari"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'Januari' ? 'selected' : '' }}>
                                January</option>
                            <option value="Februari"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'Februari' ? 'selected' : '' }}>
                                February</option>
                            <option value="Maret"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'Maret' ? 'selected' : '' }}>
                                March</option>
                            <option value="April"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'April' ? 'selected' : '' }}>
                                April</option>
                            <option value="Mei"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'Mei' ? 'selected' : '' }}>
                                May</option>
                            <option value="Juni"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'Juni' ? 'selected' : '' }}>
                                June</option>
                            <option value="Juli"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'Juli' ? 'selected' : '' }}>
                                July</option>
                            <option value="Agustus"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'Agustus' ? 'selected' : '' }}>
                                August</option>
                            <option value="September"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'September' ? 'selected' : '' }}>
                                September</option>
                            <option value="Oktober"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'Oktober' ? 'selected' : '' }}>
                                October</option>
                            <option value="November"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'November' ? 'selected' : '' }}>
                                November</option>
                            <option value="Desember"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'Desember' ? 'selected' : '' }}>
                                December</option>
                        </select>
                        <label class="did-floating-label">Car Tax Month<span class="text-danger">*</span></label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="tahun_pajak_mobil"
                            name="tahun_pajak_mobil" value="{{ old('tahun_pajak_mobil', $mobil->tahun_pajak_mobil) }}"
                            required />
                        <label class="did-floating-label car">Car Tax Year<span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="date" placeholder=" " id="terakhir_pajak_mobil"
                            name="terakhir_pajak_mobil"
                            value="{{ old('terakhir_pajak_mobil', $mobil->terakhir_pajak_mobil) }}" required />
                        <label class="did-floating-label car">Last Car Tax<span class="text-danger">*</span></label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <textarea class="did-floating-input" placeholder=" " id="keterangan_mobil" name="keterangan_mobil"
                            style="resize: none; height:100px;">{{ old('keterangan_mobil', $mobil->keterangan_mobil) }}</textarea>
                        <label class="did-floating-label car">Car Description</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <textarea class="did-floating-input" placeholder=" " id="lokasi_mobil" name="lokasi_mobil" required
                            style="resize: none; height:100px;">{{ old('lokasi_mobil', $mobil->lokasi_mobil) }}</textarea>
                        <label class="did-floating-label car">Car Location<span class="text-danger">*</span></label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <!-- Foto Mobil 1 -->
                <div class="col-md-12">
                    <label>Car Foto 1</label>
                    @if ($mobil->fotos && $mobil->fotos->file_foto_mobil_1)
                        <div class="upload-box">
                            <label for="file_foto_mobil_1" class="upload-label">Upload Foto</label>
                            <input type="file" class="file-input" name="file_foto_mobil_1" id="file_foto_mobil_1"
                                onchange="previewImage('file_foto_mobil_1', 'foto1Preview')" style="display: none;"
                                required>
                            <div class="preview-container d-flex justify-content-center"
                                onclick="triggerFileInput('file_foto_mobil_1')">
                                <img id="foto1Preview" src="{{ $mobil->fotos->file_foto_mobil_1 }}"
                                    alt="Foto Mobil 1 Preview" class="image-preview"
                                    style="display: block; width: 200px; margin-top: 10px; cursor: pointer;">
                            </div>
                        </div>
                    @else
                        <input type="file" class="form-control mt-2" name="file_foto_mobil_1" id="file_foto_mobil_1"
                            onchange="previewImage('file_foto_mobil_1', 'foto1Preview')" style="display: none;" required>
                        <div class="preview-container d-flex justify-content-center onclick="triggerFileInput('file_foto_mobil_1')">
                            <img id="foto1Preview" src="#" alt="Foto Mobil 1 Preview" class="image-preview"
                                style="display: none; width: 200px; margin-top: 10px; cursor: pointer;">
                        </div>
                    @endif
                </div>

                <!-- Foto Mobil 2 -->
                <div class="col-md-12">
                    <label class="mt-3">Car Foto 2</label>
                    @if ($mobil->fotos && $mobil->fotos->file_foto_mobil_2)
                        <div class="upload-box">
                            <label for="file_foto_mobil_2" class="upload-label">Upload Foto</label>
                            <input type="file" class="file-input" name="file_foto_mobil_2" id="file_foto_mobil_2"
                                onchange="previewImage('file_foto_mobil_2', 'foto2Preview')" style="display: none;"
                                required>
                            <div class="preview-container d-flex justify-content-center"
                                onclick="triggerFileInput('file_foto_mobil_2')">
                                <img id="foto2Preview" src="{{ $mobil->fotos->file_foto_mobil_2 }}"
                                    alt="Foto Mobil 2 Preview" class="image-preview"
                                    style="display: block; width: 200px; margin-top: 10px; cursor: pointer;">
                            </div>
                        </div>
                    @else
                        <input type="file" class="form-control mt-2" name="file_foto_mobil_2" id="file_foto_mobil_2"
                            onchange="previewImage('file_foto_mobil_2', 'foto2Preview')" style="display: none;" required>
                        <div class="preview-container d-flex justify-content-center"
                            onclick="triggerFileInput('file_foto_mobil_2')">
                            <img id="foto2Preview" src="#" alt="Foto Mobil 2 Preview" class="image-preview"
                                style="display: none; width: 200px; margin-top: 10px; cursor: pointer;">
                        </div>
                    @endif
                </div>
            </div>

            <!-- Foto Mobil 3 -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <label>Car Foto 3</label>
                    @if ($mobil->fotos && $mobil->fotos->file_foto_mobil_3)
                        <div class="upload-box">
                            <label for="file_foto_mobil_3" class="upload-label">Upload Foto</label>
                            <input type="file" class="file-input" name="file_foto_mobil_3" id="file_foto_mobil_3"
                                onchange="previewImage('file_foto_mobil_3', 'foto3Preview')" style="display: none;"
                                required>
                            <div class="preview-container d-flex justify-content-center"
                                onclick="triggerFileInput('file_foto_mobil_3')">
                                <img id="foto3Preview" src="{{ $mobil->fotos->file_foto_mobil_3 }}"
                                    alt="Foto Mobil 3 Preview" class="image-preview"
                                    style="display: block; width: 200px; margin-top: 10px; cursor: pointer;">
                            </div>
                        </div>
                    @else
                        <input type="file" class="form-control mt-2" name="file_foto_mobil_3" id="file_foto_mobil_3"
                            onchange="previewImage('file_foto_mobil_3', 'foto3Preview')" style="display: none;" required>
                        <div class="preview-container d-flex justify-content-center"
                            onclick="triggerFileInput('file_foto_mobil_3')">
                            <img id="foto3Preview" src="#" alt="Foto Mobil 3 Preview" class="image-preview"
                                style="display: none; width: 200px; margin-top: 10px; cursor: pointer;">
                        </div>
                    @endif
                </div>
            </div>

            <!-- Foto Mobil 4 -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <label>Car Foto 4</label>
                    @if ($mobil->fotos && $mobil->fotos->file_foto_mobil_4)
                        <div class="upload-box">
                            <label for="file_foto_mobil_4" class="upload-label">Upload Foto</label>
                            <input type="file" class="file-input" name="file _foto_mobil_4" id="file_foto_mobil_4"
                                onchange="previewImage('file_foto_mobil_4', 'foto4Preview')" style="display: none;"
                                required>
                            <div class="preview-container d-flex justify-content-center"
                                onclick="triggerFileInput('file_foto_mobil_4')">
                                <img id="foto4Preview" src="{{ $mobil->fotos->file_foto_mobil_4 }}"
                                    alt="Foto Mobil 4 Preview" class="image-preview"
                                    style="display: block; width: 200px; margin-top: 10px; cursor: pointer;">
                            </div>
                        </div>
                    @else
                        <input type="file" class="form-control mt-2" name="file_foto_mobil_4" id="file_foto_mobil_4"
                            onchange="previewImage('file_foto_mobil_4', 'foto4Preview')" style="display: none;" required>
                        <div class="preview-container d-flex justify-content-center"
                            onclick="triggerFileInput('file_foto_mobil_4')">
                            <img id="foto4Preview" src="#" alt="Foto Mobil 4 Preview" class="image-preview"
                                style="display: none; width: 200px; margin-top: 10px; cursor: pointer;">
                        </div>
                    @endif
                </div>
            </div>

            <!-- Foto Mobil 5 -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <label>Car Foto 5</label>
                    @if ($mobil->fotos && $mobil->fotos->file_foto_mobil_5)
                        <div class="upload-box">
                            <label for="file_foto_mobil_5" class="upload-label">Upload Foto</label>
                            <input type="file" class="file-input" name="file_foto_mobil_5" id="file_foto_mobil_5"
                                onchange="previewImage('file_foto_mobil_5', 'foto5Preview')" style="display: none;"
                                required>
                            <div class="preview-container d-flex justify-content-center"
                                onclick="triggerFileInput('file_foto_mobil_5')">
                                <img id="foto5Preview" src="{{ $mobil->fotos->file_foto_mobil_5 }}"
                                    alt="Foto Mobil 5 Preview" class="image-preview"
                                    style="display: block; width: 200px; margin-top: 10px; cursor: pointer;">
                            </div>
                        </div>
                    @else
                        <input type="file" class="form-control mt-2" name="file_foto_mobil_5" id="file_foto_mobil_5"
                            onchange="previewImage('file_foto_mobil_5', 'foto5Preview')" style="display: none;" required>
                        <div class="preview-container d-flex justify-content-center"
                            onclick="triggerFileInput('file_foto_mobil_5')">
                            <img id="foto5Preview" src="#" alt="Foto Mobil 5 Preview" class="image-preview"
                                style="display: none; width: 200px; margin-top: 10px; cursor: pointer;">
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="d-flex justify-content-end align-items-center gap-2">
                    <a href="{{ route('profile-used-car') }}" class="btn btn-cancel">Cancel</a>
                    <button type="submit" class="btn btn-custom-icon">
                        Save
                        <i class="bx bxs-save fs-5"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function triggerFileInput(fileInputId) {
            document.getElementById(fileInputId).click();
        }

        function previewImage(inputId, previewId) {
            var file = document.getElementById(inputId).files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                var preview = document.getElementById(previewId);
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
