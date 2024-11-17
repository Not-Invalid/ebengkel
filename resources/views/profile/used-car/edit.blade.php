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
        <form class="py-4" action="{{ route('used-car-update', $mobil->id_mobil) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="nama_mobil" name="nama_mobil"
                            value="{{ old('nama_mobil', $mobil->nama_mobil) }}" />
                        <label class="did-floating-label car">Nama Mobil</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <select class="did-floating-input" id="merk_mobil_id" name="merk_mobil_id" required>
                            <option value="" disabled hidden>Pilih Merk Mobil</option>
                            @foreach ($carMerks as $merk)
                                <option value="{{ $merk->id }}"
                                    {{ old('merk_mobil_id', $mobil->merk_mobil_id) == $merk->id ? 'selected' : '' }}>
                                    {{ $merk->nama_merk }}
                                </option>
                            @endforeach
                        </select>
                        <label class="did-floating-label">Merk Mobil</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="harga_mobil" name="harga_mobil"
                            value="{{ old('harga_mobil', number_format($mobil->harga_mobil, 0, ',', '.')) }}" />
                        <label class="did-floating-label car">Harga Mobil</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="plat_nomor"
                            name="plat_nomor_mobil" value="{{ old('plat_nomor_mobil', $mobil->plat_nomor_mobil) }}" />
                        <label class="did-floating-label car">Plat Nomor Mobil</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="tahun_mobil" name="tahun_mobil"
                            value="{{ old('tahun_mobil', $mobil->tahun_mobil) }}" />
                        <label class="did-floating-label car">Tahun Mobil</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="km_mobil" name="km_mobil"
                            value="{{ old('km_mobil', $mobil->km_mobil) }}" />
                        <label class="did-floating-label car">KM Mobil</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="nomor_rangka_mobil"
                            name="nomor_rangka_mobil" value="{{ old('nomor_rangka_mobil', $mobil->nomor_rangka_mobil) }}" />
                        <label class="did-floating-label car">Nomor Rangka Mobil</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="nomor_mesin"
                            name="nomor_mesin_mobil" value="{{ old('nomor_mesin_mobil', $mobil->nomor_mesin_mobil) }}" />
                        <label class="did-floating-label car">Nomor Mesin Mobil</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="kapasitas_mesin_mobil"
                            name="kapasitas_mesin_mobil"
                            value="{{ old('kapasitas_mesin_mobil', $mobil->kapasitas_mesin_mobil) }}" />
                        <label class="did-floating-label car">Kapasitas Mesin Mobil</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <select class="did-floating-input" id="bahan_bakar" name="bahan_bakar_mobil" required>
                            <option value="" disabled selected hidden>Pilih bahan bakar</option>
                            <option value="bensin"
                                {{ old('bahan_bakar_mobil', $mobil->bahan_bakar_mobil) == 'bensin' ? 'selected' : '' }}>
                                Bensin</option>
                            <option value="diesel"
                                {{ old('bahan_bakar_mobil', $mobil->bahan_bakar_mobil) == 'diesel' ? 'selected' : '' }}>
                                Diesel</option>
                            <option value="listrik"
                                {{ old('bahan_bakar_mobil', $mobil->bahan_bakar_mobil) == 'listrik' ? 'selected' : '' }}>
                                Listrik</option>
                        </select>
                        <label class="did-floating-label">Bahan Bakar Mobil</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <select class="did-floating-input" id="transmisi_mobil" name="jenis_transmisi_mobil" required>
                            <option value="" disabled selected hidden>Pilih transmisi</option>
                            <option value="matic"
                                {{ old('jenis_transmisi_mobil', $mobil->jenis_transmisi_mobil) == 'matic' ? 'selected' : '' }}>
                                Matic</option>
                            <option value="manual"
                                {{ old('jenis_transmisi_mobil', $mobil->jenis_transmisi_mobil) == 'manual' ? 'selected' : '' }}>
                                Manual</option>
                        </select>
                        <label class="did-floating-label">Jenis Transmisi Mobil</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <select class="did-floating-input" id="bulan_pajak_mobil" name="bulan_pajak_mobil">
                            <option value="" disabled selected>Pilih Bulan Pajak</option>
                            <option value="Januari"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'Januari' ? 'selected' : '' }}>
                                Januari</option>
                            <option value="Februari"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'Februari' ? 'selected' : '' }}>
                                Februari</option>
                            <option value="Maret"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'Maret' ? 'selected' : '' }}>
                                Maret</option>
                            <option value="April"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'April' ? 'selected' : '' }}>
                                April</option>
                            <option value="Mei"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'Mei' ? 'selected' : '' }}>Mei
                            </option>
                            <option value="Juni"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'Juni' ? 'selected' : '' }}>Juni
                            </option>
                            <option value="Juli"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'Juli' ? 'selected' : '' }}>Juli
                            </option>
                            <option value="Agustus"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'Agustus' ? 'selected' : '' }}>
                                Agustus</option>
                            <option value="September"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'September' ? 'selected' : '' }}>
                                September</option>
                            <option value="Oktober"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'Oktober' ? 'selected' : '' }}>
                                Oktober</option>
                            <option value="November"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'November' ? 'selected' : '' }}>
                                November</option>
                            <option value="Desember"
                                {{ old('bulan_pajak_mobil', $mobil->bulan_pajak_mobil) == 'Desember' ? 'selected' : '' }}>
                                Desember</option>
                        </select>
                        <label class="did-floating-label">Bulan Pajak Mobil</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="tahun_pajak_mobil"
                            name="tahun_pajak_mobil" value="{{ old('tahun_pajak_mobil', $mobil->tahun_pajak_mobil) }}" />
                        <label class="did-floating-label car">Tahun Pajak Mobil</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="date" placeholder=" " id="terakhir_pajak_mobil"
                            name="terakhir_pajak_mobil"
                            value="{{ old('terakhir_pajak_mobil', $mobil->terakhir_pajak_mobil) }}" />
                        <label class="did-floating-label car">Terakhir Pajak Mobil</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="did-floating-label-content">
                        <select class="did-floating-input" id="pemakaian" name="pemakaian" required>
                            <option value="{{ old('pemakaian', $mobil->pemakaian) }}" disabled selected hidden>
                                {{ $mobil->pemakaian }}</option>
                            <option value="Dibawah 1 Tahun">Di Bawah 1 Tahun</option>
                            <option value="Dibawah 3 Tahun">Di Bawah 3 Tahun</option>
                            <option value="Dibawah 5 Tahun">Di Bawah 5 Tahun</option>
                            <option value="Dibawah 7 Tahun">Di Bawah 7 Tahun</option>
                            <option value="Dibawah 10 Tahun">Di Bawah 10 Tahun</option>
                        </select>
                        <label class="did-floating-label">Tahun Pemakaian</label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <textarea class="did-floating-input" placeholder=" " id="keterangan_mobil" name="keterangan_mobil"
                            style="resize: none; height:100px;">{{ old('keterangan_mobil', $mobil->keterangan_mobil) }}</textarea>
                        <label class="did-floating-label car">Keterangan Mobil</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <textarea class="did-floating-input" placeholder=" " id="lokasi_mobil" name="lokasi_mobil"
                            style="resize: none; height:100px;">{{ old('lokasi_mobil', $mobil->lokasi_mobil) }}</textarea>
                        <label class="did-floating-label car">Lokasi Mobil</label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <!-- Foto Mobil 1 -->
                <div class="col-md-12">
                    <label>Foto Mobil 1</label>
                    @if ($mobil->fotos && $mobil->fotos->file_foto_mobil_1)
                        <div class="upload-box">
                            <label for="file_foto_mobil_1" class="upload-label">Upload Foto</label>
                            <input type="file" class="file-input" name="file_foto_mobil_1" id="file_foto_mobil_1"
                                onchange="previewImage('file_foto_mobil_1', 'foto1Preview')" style="display: none;">
                            <div class="preview-container d-flex justify-content-center"
                                onclick="triggerFileInput('file_foto_mobil_1')">
                                <img id="foto1Preview" src="{{ $mobil->fotos->file_foto_mobil_1 }}"
                                    alt="Foto Mobil 1 Preview" class="image-preview"
                                    style="display: block; width: 200px; margin-top: 10px; cursor: pointer;">
                            </div>
                        </div>
                    @else
                        <input type="file" class="form-control mt-2" name="file_foto_mobil_1" id="file_foto_mobil_1"
                            onchange="previewImage('file_foto_mobil_1', 'foto1Preview')" style="display: none;">
                        <div class="preview-container d-flex justify-content-center"
                            onclick="triggerFileInput('file_foto_mobil_1')">
                            <img id="foto1Preview" src="#" alt="Foto Mobil 1 Preview" class="image-preview"
                                style="display: none; width: 200px; margin-top: 10px; cursor: pointer;">
                        </div>
                    @endif
                </div>

                <!-- Foto Mobil 2 -->
                <div class="col-md-12">
                    <label class="mt-3">Foto Mobil 2</label>
                    @if ($mobil->fotos && $mobil->fotos->file_foto_mobil_2)
                        <div class="upload-box">
                            <label for="file_foto_mobil_2" class="upload-label">Upload Foto</label>
                            <input type="file" class="file-input" name="file_foto_mobil_2" id="file_foto_mobil_2"
                                onchange="previewImage('file_foto_mobil_2', 'foto2Preview')" style="display: none;">
                            <div class="preview-container d-flex justify-content-center"
                                onclick="triggerFileInput('file_foto_mobil_2')">
                                <img id="foto2Preview" src="{{ $mobil->fotos->file_foto_mobil_2 }}"
                                    alt="Foto Mobil 2 Preview" class="image-preview"
                                    style="display: block; width: 200px; margin-top: 10px; cursor: pointer;">
                            </div>
                        </div>
                    @else
                        <input type="file" class="form-control mt-2" name="file_foto_mobil_2" id="file_foto_mobil_2"
                            onchange="previewImage('file_foto_mobil_2', 'foto2Preview')" style="display: none;">
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
                    <label>Foto Mobil 3</label>
                    @if ($mobil->fotos && $mobil->fotos->file_foto_mobil_3)
                        <div class="upload-box">
                            <label for="file_foto_mobil_3" class="upload-label">Upload Foto</label>
                            <input type="file" class="file-input" name="file_foto_mobil_3" id="file_foto_mobil_3"
                                onchange="previewImage('file_foto_mobil_3', 'foto3Preview')" style="display: none;">
                            <div class="preview-container d-flex justify-content-center"
                                onclick="triggerFileInput('file_foto_mobil_3')">
                                <img id="foto3Preview" src="{{ $mobil->fotos->file_foto_mobil_3 }}"
                                    alt="Foto Mobil 3 Preview" class="image-preview"
                                    style="display: block; width: 200px; margin-top: 10px; cursor: pointer;">
                            </div>
                        </div>
                    @else
                        <input type="file" class="form-control mt-2" name="file_foto_mobil_3" id="file_foto_mobil_3"
                            onchange="previewImage('file_foto_mobil_3', 'foto3Preview')" style="display: none;">
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
                    <label>Foto Mobil 4</label>
                    @if ($mobil->fotos && $mobil->fotos->file_foto_mobil_4)
                        <div class="upload-box">
                            <label for="file_foto_mobil_4" class="upload-label">Upload Foto</label>
                            <input type="file" class="file-input" name="file_foto_mobil_4" id="file_foto_mobil_4"
                                onchange="previewImage('file_foto_mobil_4', 'foto4Preview')" style="display: none;">
                            <div class="preview-container d-flex justify-content-center"
                                onclick="triggerFileInput('file_foto_mobil_4')">
                                <img id="foto4Preview" src="{{ $mobil->fotos->file_foto_mobil_4 }}"
                                    alt="Foto Mobil 4 Preview" class="image-preview"
                                    style="display: block; width: 200px; margin-top: 10px; cursor: pointer;">
                            </div>
                        </div>
                    @else
                        <input type="file" class="form-control mt-2" name="file_foto_mobil_4" id="file_foto_mobil_4"
                            onchange="previewImage('file_foto_mobil_4', 'foto4Preview')" style="display: none;">
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
                    <label>Foto Mobil 5</label>
                    @if ($mobil->fotos && $mobil->fotos->file_foto_mobil_5)
                        <div class="upload-box">
                            <label for="file_foto_mobil_5" class="upload-label">Upload Foto</label>
                            <input type="file" class="file-input" name="file_foto_mobil_5" id="file_foto_mobil_5"
                                onchange="previewImage('file_foto_mobil_5', 'foto5Preview')" style="display: none;">
                            <div class="preview-container d-flex justify-content-center"
                                onclick="triggerFileInput('file_foto_mobil_5')">
                                <img id="foto5Preview" src="{{ $mobil->fotos->file_foto_mobil_5 }}"
                                    alt="Foto Mobil 5 Preview" class="image-preview"
                                    style="display: block; width: 200px; margin-top: 10px; cursor: pointer;">
                            </div>
                        </div>
                    @else
                        <input type="file" class="form-control mt-2" name="file_foto_mobil_5" id="file_foto_mobil_5"
                            onchange="previewImage('file_foto_mobil_5', 'foto5Preview')" style="display: none;">
                        <div class="preview-container d-flex justify-content-center"
                            onclick="triggerFileInput('file_foto_mobil_5')">
                            <img id="foto5Preview" src="#" alt="Foto Mobil 5 Preview" class="image-preview"
                                style="display: none; width: 200px; margin-top: 10px; cursor: pointer;">
                        </div>
                    @endif
                </div>
            </div>
            <div class="d-flex justify-content-start mt-3">
                <button type="submit" class="btn btn-custom-icon me-2">
                    Simpan
                </button>

                <a href="{{ route('profile-used-car') }}" class="btn btn-danger">Back</a>
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
