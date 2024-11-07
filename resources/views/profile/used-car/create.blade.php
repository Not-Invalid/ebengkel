@extends('layouts.partials.sidebar')

@section('title')
    eBengkelku | Create Used Car
@stop

@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <h4>Add Used Car</h4>
        <form class="py-4" action="{{ route('used-car-store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="nama_mobil" name="nama_mobil" />
                        <label class="did-floating-label custom">Nama Mobil</label>
                    </div>
                </div>
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="merk_mobil"
                            name="merk_mobil" />
                        <label class="did-floating-label custom">Merk Mobil</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="harga_mobil"
                            name="harga_mobil" />
                        <label class="did-floating-label custom">Harga Mobil</label>
                    </div>
                </div>
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="plat_nomor"
                            name="plat_nomor_mobil" />
                        <label class="did-floating-label custom">Plat Nomor Mobil</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="tahun_mobil"
                            name="tahun_mobil" />
                        <label class="did-floating-label custom">Tahun Mobil</label>
                    </div>
                </div>
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="km_mobil" name="km_mobil" />
                        <label class="did-floating-label custom">KM Mobil</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="nomor_rangka_mobil"
                            name="nomor_rangka_mobil" />
                        <label class="did-floating-label custom">Nomor Rangka Mobil</label>
                    </div>
                </div>
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="nomor_mesin"
                            name="nomor_mesin_mobil" />
                        <label class="did-floating-label custom">Nomor Mesin Mobil</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="kapasitas_mesin_mobil"
                            name="kapasitas_mesin_mobil" />
                        <label class="did-floating-label custom">Kapasitas Mesin Mobil</label>
                    </div>
                </div>
                <div class="col">
                    <div class="did-floating-label-content">
                        <select class="did-floating-input" id="bahan_bakar" name="bahan_bakar_mobil" required>
                            <option value="" disabled selected hidden></option>
                            <option value="bensin">Bensin</option>
                            <option value="diesel">Diesel</option>
                            <option value="listrik">Listrik</option>
                        </select>
                        <label class="did-floating-label">Bahan Bakar Mobil</label>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="jenis_transmisi_mobil"
                            name="jenis_transmisi_mobil" />
                        <label class="did-floating-label custom">Jenis Transmisi Mobil</label>
                    </div>
                </div>
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="month" placeholder=" " id="bulan_pajak_mobil"
                            name="bulan_pajak_mobil" />
                        <label class="did-floating-label custom">Bulan Pajak Mobil</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="tahun_pajak_mobil"
                            name="tahun_pajak_mobil" />
                        <label class="did-floating-label custom">Tahun Pajak Mobil</label>
                    </div>
                </div>
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="date" placeholder=" " id="terakhir_pajak_mobil"
                            name="terakhir_pajak_mobil" />
                        <label class="did-floating-label custom">Terakhir Pajak Mobil</label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <textarea class="did-floating-input" placeholder=" " id="keterangan_mobil" name="keterangan_mobil"
                            style="resize: none; height:100px;"></textarea>
                        <label class="did-floating-label custom">Keterangan Mobil</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="did-floating-label-content">
                        <textarea class="did-floating-input" placeholder=" " id="lokasi_mobil" name="lokasi_mobil"
                            style="resize: none; height:100px;"></textarea>
                        <label class="did-floating-label custom">Lokasi Mobil</label>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="foto_mobil">Upload Foto Mobil</label>
                <input type="file" class="form-control" name="file_foto_mobil" required>
                <input type="file" class="form-control mt-2" name="file_foto_mobil_2">
                <input type="file" class="form-control mt-2" name="file_foto_mobil_3">
                <input type="file" class="form-control mt-2" name="file_foto_mobil_4">
                <input type="file" class="form-control mt-2" name="file_foto_mobil_5">
            </div>
            <button type="submit" class="btn btn-custom-icon mt-3">
                <i class='bx bxs-save fs-5'></i> Simpan
            </button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('tahun_pajak_mobil').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);
        });
    </script>
@endsection
