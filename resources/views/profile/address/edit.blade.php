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
                    <select name="provinsi_id" id="provinsi" class="did-floating-select">
                        <option value="" selected disabled hidden>Select Province</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->province_id }}" {{ $province->province_id == $address->provinsi_id ? 'selected' : '' }}>
                                {{ $province->province_name }}
                            </option>
                        @endforeach
                    </select>
                    <label class="did-floating-label">Province</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="kota_id" id="kota" class="did-floating-select">
                        <option value="" selected disabled hidden>Select City</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->city_id }}" {{ $city->city_id == $address->kota_id ? 'selected' : '' }}>
                                {{ $city->city_name }}
                            </option>
                        @endforeach
                    </select>
                    <label class="did-floating-label">City</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="kecamatan_id" id="kecamatan" class="did-floating-select">
                        <option value="" selected disabled hidden>Select District</option>
                        @foreach($subdistricts as $subdistrict)
                            <option value="{{ $subdistrict->subdistrict_id }}" {{ $subdistrict->subdistrict_id == $address->kecamatan_id ? 'selected' : '' }}>
                                {{ $subdistrict->subdistrict_name }}
                            </option>
                        @endforeach
                    </select>
                    <label class="did-floating-label">District</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="status_alamat_pengiriman" id="status_alamat_pengiriman" class="did-floating-select">
                        <option value="{{ $address->status_alamat_pengiriman }}" selected>
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

            $('#provinsi').change(function() {
                let provinceId = $(this).val();
                if (provinceId) {
                    $.get('/locations?province_id=' + provinceId, function(response) {
                        let kotaDropdown = $('#kota');
                        kotaDropdown.empty();
                        kotaDropdown.append('<option value="" selected disabled hidden>Select City</option>');

                        if (response.cities && Array.isArray(response.cities)) {
                            $.each(response.cities, function(index, city) {
                                kotaDropdown.append('<option value="' + city.city_id + '">' + city.city_name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#kota').empty().append('<option value="" selected disabled hidden>Select City</option>');
                    $('#kecamatan').empty().append('<option value="" selected disabled hidden>Select District</option>').hide();
                }
            });

            $('#kota').change(function() {
                let cityId = $(this).val();
                if (cityId) {
                    $.get('/locations?city_id=' + cityId, function(response) {
                        let kecamatanDropdown = $('#kecamatan');
                        kecamatanDropdown.empty();
                        kecamatanDropdown.append('<option value="" selected disabled hidden>Select District</option>');

                        if (response.subdistricts && Array.isArray(response.subdistricts)) {
                            $.each(response.subdistricts, function(index, subdistrict) {
                                kecamatanDropdown.append('<option value="' + subdistrict.subdistrict_id + '">' + subdistrict.subdistrict_name + '</option>');
                            });
                        }

                        // Show district dropdown
                        kecamatanDropdown.show();
                    });
                } else {
                    $('#kecamatan').empty().append('<option value="" selected disabled hidden>Select District</option>').hide();
                }
            });
        });
    </script>

@endsection
