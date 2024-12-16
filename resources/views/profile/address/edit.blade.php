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
        <p class="text-danger">*indicates required fields</p>
        <form action="{{ route('address.update', $address->id_alamat_pengiriman) }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder=" " id="name" name="nama_penerima"
                        value="{{ $address->nama_penerima }}" />
                    <label class="did-floating-label">Recipient Name<span class="text-danger">*</span></label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder=" " id="name" name="telp_penerima"
                        pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                        value="{{ $address->telp_penerima }}" />
                    <label class="did-floating-label">Recipient Phone<span class="text-danger">*</span></label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <textarea class="did-floating-input form-control" name="lokasi_alamat_pengiriman" placeholder=" " rows="4"
                        required style="height: 100px;resize: none">{{ $address->lokasi_alamat_pengiriman }}</textarea>
                    <label class="did-floating-label">Address<span class="text-danger">*</span></label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder=" " name="kodepos_alamat_pengiriman"
                        value="{{ $address->kodepos_alamat_pengiriman }}" pattern="[0-9]*"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                    <label class="did-floating-label">Pos Code<span class="text-danger">*</span></label>
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
                        <option value="" selected disabled hidden>Select Province</option>
                        <!-- Options will be populated by JavaScript -->
                    </select>
                    <label class="did-floating-label">Province</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="kota" id="kota" class="did-floating-select">
                        <option value="" selected disabled hidden>Select City</option>
                        <!-- Options will be populated by JavaScript -->
                    </select>
                    <label class="did-floating-label">City</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="kecamatan" id="kecamatan" class="did-floating-select">
                        <option value="" selected disabled hidden>Select District</option>
                        <!-- Options will be populated by JavaScript -->
                    </select>
                    <label class="did-floating-label">District</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="status_alamat_pengiriman" id="status_alamat_pengiriman" class="did-floating-select">
                        <option value="{{ $address->status_alamat_pengiriman }}" selected disabled hidden>
                            {{ $address->status_alamat_pengiriman }}</option>
                        <option value="Office">Office</option>
                        <option value="Home">Home</option>
                    </select>
                    <label class="did-floating-label">Address Status</label>
                </div>
            </div>

            <div class="form-group">
                <div class="d-flex justify-content-end align-items-center gap-2">
                    <a href="{{ route('profile.address') }}" class="btn btn-cancel">Cancel</a>
                    <button type="submit" class="btn btn-custom-icon">
                        Save
                        <i class="bx bxs-save fs-5"></i>
                    </button>
                </div>
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

    $.get('https://api.cahyadsn.com/provinces', function(response) {
        let provinsiDropdown = $('#provinsi');
        let selectedProvinsi = "{{ $address->provinsi }}";
        provinsiDropdown.empty();
        provinsiDropdown.append(
            '<option value="" selected disabled hidden>{{ __('messages.profile.address.select_province') }}</option>'
        );

        if (response.data && Array.isArray(response.data)) {
            $.each(response.data, function(index, provinsi) {
                let selected = (provinsi.nama == selectedProvinsi) ? 'selected' : '';
                provinsiDropdown.append('<option value="' + provinsi.kode + '" ' + selected + '>' +
                    provinsi.nama + '</option>');
            });
        }

        provinsiDropdown.trigger('change');
    }).fail(function() {
        console.log('Request gagal untuk data provinsi');
    });

    $('#provinsi').change(function() {
        let provinsiNama = $(this).val();
        if (provinsiNama) {
            $.get('https://api.cahyadsn.com/regencies/' + provinsiNama, function(response) {
                let kotaDropdown = $('#kota');
                kotaDropdown.empty();
                kotaDropdown.append(
                    '<option value="" selected disabled hidden>{{ __('messages.profile.address.select_city') }}</option>'
                );

                if (response.data && Array.isArray(response.data)) {
                    $.each(response.data, function(index, kota) {
                        let selected = (kota.nama == "{{ $address->kota }}") ? 'selected' : '';
                        kotaDropdown.append('<option value="' + kota.kode + '" ' + selected + '>' + kota.nama + '</option>');
                    });
                }

                kotaDropdown.trigger('change');
            }).fail(function() {
                console.log('Request gagal untuk data kota');
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
        let kotaNama = $(this).val();
        if (kotaNama) {
            $.get('https://api.cahyadsn.com/districts/' + kotaNama, function(response) {
                let kecamatanDropdown = $('#kecamatan');
                kecamatanDropdown.empty();
                kecamatanDropdown.append(
                    '<option value="" selected disabled hidden>{{ __('messages.profile.address.select_district') }}</option>'
                );

                if (response.data && Array.isArray(response.data)) {
                    $.each(response.data, function(index, kecamatan) {
                        let selected = (kecamatan.nama == "{{ $address->kecamatan }}") ? 'selected' : '';
                        kecamatanDropdown.append('<option value="' + kecamatan.kode + '" ' + selected + '>' + kecamatan.nama + '</option>');
                    });
                }
            }).fail(function() {
                console.log('Request gagal untuk data kecamatan');
            });
        } else {
            $('#kecamatan').empty().append(
                '<option value="" selected disabled hidden>{{ __('messages.profile.address.select_district') }}</option>'
            );
        }
    });

    $('#provinsi').trigger('change');
    $('#kota').trigger('change');
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

    </script>

@endsection
