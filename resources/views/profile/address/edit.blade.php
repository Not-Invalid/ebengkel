@extends('layouts.partials.sidebar')

@section('title')
    eBengkelku | Edit Address
@stop
@push('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endpush

@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <h4>Edit Address</h4>
        <form action="{{ route('address.update', $address->id_alamat_pengiriman) }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder=" " id="name" name="nama_penerima"
                        value="{{ $address->nama_penerima }}" />
                    <label class="did-floating-label">Recipient Name</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder=" " id="name" name="telp_penerima"
                        pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                        value="{{ $address->telp_penerima }}" />
                    <label class="did-floating-label">Recipient Phone</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <textarea class="did-floating-input form-control" name="lokasi_alamat_pengiriman" placeholder=" " rows="4"
                        required style="height: 100px;resize: none">{{ $address->lokasi_alamat_pengiriman }}</textarea>
                    <label class="did-floating-label">Address</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder=" " name="kodepos_alamat_pengiriman"
                        value="{{ $address->kodepos_alamat_pengiriman }}" pattern="[0-9]*"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                    <label class="did-floating-label">Pos Code</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <label>Pinpoint Alamat</label>
                <div id="map" style="height: 300px;"></div>
                <input type="hidden" name="lat_alamat_pengiriman" id="latitude"
                    value="{{ $address->lat_alamat_pengiriman }}">
                <input type="hidden" name="long_alamat_pengiriman" id="longitude"
                    value="{{ $address->long_alamat_pengiriman }}">
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="provinsi" id="provinsi" class="did-floating-select">
                        <option value="{{ $address->provinsi }}" selected>{{ $address->provinsi }}</option>
                    </select>
                    <label class="did-floating-label">Province</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="kota" id="kota" class="did-floating-select">
                        <option value="{{ $address->kota }}" selected>{{ $address->kota }}</option>
                    </select>
                    <label class="did-floating-label">City</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="kecamatan" id="kecamatan" class="did-floating-select">
                        <option value="{{ $address->kecamatan }}" selected>{{ $address->kecamatan }}</option>
                    </select>
                    <label class="did-floating-label">District</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="status_alamat_pengiriman" id="status_alamat_pengiriman" class="did-floating-select">
                        <option value="{{ $address->status_alamat_pengiriman }}" selected disabled hidden>
                            {{ $address->status_alamat_pengiriman }}</option>
                        <option value="office">Office</option>
                        <option value="home">Home</option>
                    </select>
                    <label class="did-floating-label">Address Status</label>
                </div>
            </div>

            <div>
                <button type="submit" class="btn btn-primary mt-3">Update</button>
                <a href="{{ route('profile.address') }}" class="btn btn-danger mt-3">Back</a>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var lat = {{ $address->lat_alamat_pengiriman ?? 'null' }};
            var lng = {{ $address->long_alamat_pengiriman ?? 'null' }};
            var map, marker;

            function initMap(latitude, longitude) {
                map = L.map('map').setView([latitude, longitude], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
                marker = L.marker([latitude, longitude], {
                    draggable: true
                }).addTo(map);
                marker.on('dragend', function(e) {
                    var newLatLng = e.target.getLatLng();
                    document.getElementById('latitude').value = newLatLng.lat;
                    document.getElementById('longitude').value = newLatLng.lng;
                });
            }

            if (lat && lng) {
                initMap(lat, lng);
            } else if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        initMap(position.coords.latitude, position.coords.longitude);
                    },
                    function(error) {
                        console.error("Error getting location: " + error.message);
                        initMap(-6.200000, 106.816666);
                    }
                );
            } else {
                initMap(-6.200000, 106.816666);
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            let provinsiLoaded = false;

            $('#provinsi').one('click', function() {
                if (!provinsiLoaded) {
                    $.get('https://api.cahyadsn.com/provinces', function(response) {
                        let provinsiDropdown = $('#provinsi');
                        provinsiDropdown.empty();
                        provinsiDropdown.append(
                            '<option value="" selected disabled hidden>Select Province</option>'
                            );

                        if (response.data && Array.isArray(response.data)) {
                            $.each(response.data, function(index, provinsi) {
                                provinsiDropdown.append('<option value="' + provinsi.kode +
                                    '">' + provinsi.nama + '</option>');
                            });
                            provinsiLoaded = true;
                        }
                    }).fail(function() {
                        console.log('Request gagal untuk data provinsi');
                    });
                }
            });

            $('#provinsi').change(function() {
                let provinsiId = $(this).val();
                if (provinsiId) {
                    $.get('https://api.cahyadsn.com/regencies/' + provinsiId, function(response) {
                        let kotaDropdown = $('#kota');
                        kotaDropdown.empty();
                        kotaDropdown.append(
                            '<option value="" selected disabled hidden>Select City</option>'
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
                        '<option value="" selected disabled hidden>Select City</option>');
                    $('#kecamatan').empty().append(
                        '<option value="" selected disabled hidden>Select District</option>');
                }
            });

            $('#kota').change(function() {
                let kotaId = $(this).val();
                if (kotaId) {
                    $.get('https://api.cahyadsn.com/districts/' + kotaId, function(response) {
                        let kecamatanDropdown = $('#kecamatan');
                        kecamatanDropdown.empty();
                        kecamatanDropdown.append(
                            '<option value="" selected disabled hidden>Select District</option>'
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
                        '<option value="" selected disabled hidden>Select District</option>');
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
