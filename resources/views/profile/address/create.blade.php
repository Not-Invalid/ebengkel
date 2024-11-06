@extends('layouts.partials.sidebar')

@section('title')
    eBengkelku | Create Address
@stop

@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <h4>Add Address</h4>
        <form action="{{ route('address.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder=" " id="name" name="nama_penerima"
                        required />
                    <label class="did-floating-label">Nama Penerima</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder=" " id="name" name="telp_penerima"
                        required pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                    <label class="did-floating-label">Nama
                        Telp Penerima</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <textarea class="did-floating-input form-control" name="lokasi_alamat_pengiriman" placeholder=" " rows="4"
                        required style="height: 100px;resize: none"></textarea>
                    <label class="did-floating-label">Alamat</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder=" " id="name"
                        name="kodepos_alamat_pengiriman" required pattern="[0-9]*"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                    <label class="did-floating-label">Kodepos </label>
                </div>
            </div>

            <div class="form-group mb-3">
                <label>Pinpoint Alamat</label>
                <div class="map-container">
                    <div id="map" style="height: 400px;"></div>
                </div>
                <input type="hidden" name="lat_alamat_pengiriman" id="lat_alamat_pengiriman">
                <input type="hidden" name="long_alamat_pengiriman" id="long_alamat_pengiriman">
            </div>

            <div class="form-group mb-3">
                <label for="provinsi">Provinsi</label>
                <select class="form-control" id="provinsi" name="provinsi">
                    <option value="">Pilih Provinsi</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="kota">Kota</label>
                <select class="form-control" id="kota" name="kota">
                    <option value="">Pilih Kota</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="kecamatan">Kecamatan</label>
                <select class="form-control" id="kecamatan" name="kecamatan">
                    <option value="">Pilih Kecamatan</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label>Status Alamat</label>
                <select name="status_alamat_pengiriman" id="status_alamat_pengiriman" class="form-select">
                    <option value="Pilih Status" selected disabled hidden>Pilih Status</option>
                    <option value="Home">Home</option>
                    <option value="Office">Office</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            <a href="{{ route('profile.address') }}" class="btn btn-danger mt-3">Back</a>
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    var map = L.map('map').setView([lat, lng], 13);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);
                    var marker = L.marker([lat, lng]).addTo(map);
                    marker.on('dragend', function(e) {
                        var lat = e.target.getLatLng().lat;
                        var lng = e.target.getLatLng().lng;
                        document.getElementById('lat_alamat_pengiriman').value = lat;
                        document.getElementById('long_alamat_pengiriman').value = lng;
                    });
                    marker.dragging.enable();
                    map.on('click', function(e) {
                        var lat = e.latlng.lat;
                        var lng = e.latlng.lng;
                        marker.setLatLng([lat, lng]);
                        document.getElementById('lat_alamat_pengiriman').value = lat;
                        document.getElementById('long_alamat_pengiriman').value = lng;
                    });
                }, function(error) {
                    console.error("Error in geolocation: " + error.message);
                    var map = L.map('map').setView([-5.7771974, 106.01848], 13);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);
                    var marker = L.marker([-5.7771974, 106.01848]).addTo(map);
                    marker.on('dragend', function(e) {
                        var lat = e.target.getLatLng().lat;
                        var lng = e.target.getLatLng().lng;
                        document.getElementById('lat_alamat_pengiriman').value = lat;
                        document.getElementById('long_alamat_pengiriman').value = lng;
                    });
                    marker.dragging.enable();
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Mengambil data provinsi
            $.get('https://api.cahyadsn.com/provinces', function(response) {
                console.log('Data Provinsi:', response);

                let provinsiDropdown = $('#provinsi');
                provinsiDropdown.empty();
                provinsiDropdown.append('<option value="">Pilih Provinsi</option>');

                if (response.data && Array.isArray(response.data)) {
                    $.each(response.data, function(index, provinsi) {
                        console.log('Provinsi:', provinsi);
                        console.log('ID Provinsi:', provinsi.kode);
                        console.log('Nama Provinsi:', provinsi.nama);

                        // Menambahkan opsi untuk dropdown provinsi
                        if (provinsi.kode && provinsi.nama) {
                            provinsiDropdown.append('<option value="' + provinsi.kode + '">' +
                                provinsi.nama + '</option>');
                        } else {
                            console.log('Data provinsi tidak lengkap:', provinsi);
                        }
                    });
                } else {
                    console.log('Data provinsi tidak ditemukan atau tidak valid');
                }
            }).fail(function() {
                console.log('Request gagal untuk data provinsi');
            });

            // Ketika provinsi dipilih
            $('#provinsi').change(function() {
                let provinsiId = $(this).val();
                console.log('ID Provinsi yang dipilih:', provinsiId);

                if (provinsiId) {
                    $.get('https://api.cahyadsn.com/regencies/' + provinsiId, function(response) {
                        console.log('Response API Kota:',
                            response);

                        let kotaDropdown = $('#kota');
                        kotaDropdown.empty();
                        kotaDropdown.append('<option value="">Pilih Kota/Kabupaten</option>');
                        if (response.data && Array.isArray(response.data)) {
                            $.each(response.data, function(index, kota) {

                                console.log('Data Kota ke-' + (index + 1) + ':', kota);
                                if (kota.kode && kota.nama) {
                                    kotaDropdown.append('<option value="' + kota.kode +
                                        '">' + kota.nama + '</option>');
                                } else {
                                    console.log('Data kota tidak lengkap:', kota);
                                }
                            });
                        } else {
                            console.log('Tidak ada data kota ditemukan');
                            kotaDropdown.append(
                                '<option value="">Tidak ada kota ditemukan</option>');
                        }
                    }).fail(function() {
                        console.log('Request gagal untuk kota');
                    });

                } else {
                    $('#kota').empty().append('<option value="">Pilih Kota/Kabupaten</option>');
                    $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
                }
            });

            // Ketika kota dipilih
            $('#kota').change(function() {
                let kotaId = $(this).val();
                console.log('ID Kota yang dipilih:', kotaId);

                if (kotaId && kotaId !== "") {
                    $.get('https://api.cahyadsn.com/districts/' + kotaId, function(response) {
                        console.log('Response API Kecamatan:',
                            response);

                        let kecamatanDropdown = $('#kecamatan');
                        kecamatanDropdown.empty();
                        kecamatanDropdown.append('<option value="">Pilih Kecamatan</option>');
                        if (response.data && Array.isArray(response.data)) {
                            $.each(response.data, function(index, kecamatan) {
                                console.log('Data Kecamatan ke-' + (index + 1) + ':',
                                    kecamatan);
                                if (kecamatan.kode && kecamatan.nama) {
                                    kecamatanDropdown.append('<option value="' + kecamatan
                                        .kode + '">' + kecamatan.nama + '</option>');
                                } else {
                                    console.log('Data kecamatan tidak lengkap:', kecamatan);
                                }
                            });
                        } else {
                            console.log('Tidak ada data kecamatan ditemukan');
                            kecamatanDropdown.append(
                                '<option value="">Tidak ada kecamatan ditemukan</option>');
                        }
                    }).fail(function() {
                        console.log('Request gagal untuk kecamatan');
                    });
                } else {
                    $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
                }
            });
        });
    </script>

@endsection
