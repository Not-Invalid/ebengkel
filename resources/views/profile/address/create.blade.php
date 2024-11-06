@extends('layouts.partials.sidebar')

@section('title')
    eBengkelku | Create Address
@stop
@push('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endpush
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
                <label style="color: #3a6fb0">Pinpoint Alamat</label>
                <div class="map-container">
                    <div id="map" style="height: 400px;"></div>
                </div>
                <input type="hidden" name="lat_alamat_pengiriman" id="lat_alamat_pengiriman">
                <input type="hidden" name="long_alamat_pengiriman" id="long_alamat_pengiriman">
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="provinsi" id="provinsi" class="did-floating-select">
                        <option value="" selected disabled hidden>Pilih Provinsi</option>
                    </select>
                    <label class="did-floating-label">Provinsi</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="kota" id="kota" class="did-floating-select">
                        <option value="" selected disabled hidden>Pilih Kota</option>
                    </select>
                    <label class="did-floating-label">Kota</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="kecamatan" id="kecamatan" class="did-floating-select">
                        <option value="" selected disabled hidden>Pilih Kecamatan</option>
                    </select>
                    <label class="did-floating-label">Kecamatan</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="status_alamat_pengiriman" id="status_alamat_pengiriman" class="did-floating-select">
                        <option value="" selected disabled hidden>Pilih Status</option>
                        <option value="office">Office</option>
                        <option value="home">Home</option>
                    </select>
                    <label class="did-floating-label">Status Alamat</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            <a href="{{ route('profile.address') }}" class="btn btn-danger mt-3">Back</a>
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
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
                let provinsiDropdown = $('#provinsi');
                provinsiDropdown.empty();
                provinsiDropdown.append(
                    '<option value="" selected disabled hidden>Pilih Provinsi</option>');

                if (response.data && Array.isArray(response.data)) {
                    $.each(response.data, function(index, provinsi) {
                        provinsiDropdown.append('<option value="' + provinsi.kode + '">' +
                            provinsi.nama + '</option>');
                    });
                }
            }).fail(function() {
                console.log('Request gagal untuk data provinsi');
            });

            // Ketika provinsi dipilih
            $('#provinsi').change(function() {
                let provinsiId = $(this).val();
                if (provinsiId) {
                    $.get('https://api.cahyadsn.com/regencies/' + provinsiId, function(response) {
                        let kotaDropdown = $('#kota');
                        kotaDropdown.empty();
                        kotaDropdown.append(
                            '<option value="" selected disabled hidden>Pilih Kota/Kabupaten</option>'
                        );

                        if (response.data && Array.isArray(response.data)) {
                            $.each(response.data, function(index, kota) {
                                kotaDropdown.append('<option value="' + kota.kode + '">' +
                                    kota.nama + '</option>');
                            });
                        }
                    }).fail(function() {
                        console.log('Request gagal untuk data kota');
                    });
                } else {
                    $('#kota').empty().append(
                        '<option value="" selected disabled hidden>Pilih Kota/Kabupaten</option>');
                    $('#kecamatan').empty().append(
                        '<option value="" selected disabled hidden>Pilih Kecamatan</option>');
                }
            });

            // Ketika kota dipilih
            $('#kota').change(function() {
                let kotaId = $(this).val();
                if (kotaId) {
                    $.get('https://api.cahyadsn.com/districts/' + kotaId, function(response) {
                        let kecamatanDropdown = $('#kecamatan');
                        kecamatanDropdown.empty();
                        kecamatanDropdown.append(
                            '<option value="" selected disabled hidden>Pilih Kecamatan</option>'
                        );

                        if (response.data && Array.isArray(response.data)) {
                            $.each(response.data, function(index, kecamatan) {
                                kecamatanDropdown.append('<option value="' + kecamatan
                                    .kode + '">' + kecamatan.nama + '</option>');
                            });
                        }
                    }).fail(function() {
                        console.log('Request gagal untuk data kecamatan');
                    });
                } else {
                    $('#kecamatan').empty().append(
                        '<option value="" selected disabled hidden>Pilih Kecamatan</option>');
                }
            });
            $('form').submit(function(event) {
                var provinsiNama = $('#provinsi option:selected').text();
                var kotaNama = $('#kota option:selected').text();
                var kecamatanNama = $('#kecamatan option:selected').text();

                $('<input>').attr({
                    type: 'hidden',
                    name: 'provinsi',
                    value: provinsiNama
                }).appendTo(this);

                $('<input>').attr({
                    type: 'hidden',
                    name: 'kota',
                    value: kotaNama
                }).appendTo(this);

                $('<input>').attr({
                    type: 'hidden',
                    name: 'kecamatan',
                    value: kecamatanNama
                }).appendTo(this);

            });
        });
    </script>
@endsection
