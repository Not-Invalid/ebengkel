@extends('layouts.partials.sidebar')

@section('title')
    eBengkelku | Create Address
@stop
@push('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endpush
@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <h4>{{ __('messages.profile.address.add_address') }}</h4>
        <p class="text-danger">{{ __('messages.profile.address.required_fields') }}</p>
        <form action="{{ route('address.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder=" " id="name" name="nama_penerima"
                        required />
                    <label class="did-floating-label">
                        {{ __('messages.profile.address.recipient_name') }}<span class="text-danger">*</span>
                    </label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder=" " id="phone" name="telp_penerima"
                        required pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                    <label class="did-floating-label">
                        {{ __('messages.profile.address.recipient_phone') }}<span class="text-danger">*</span>
                    </label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <textarea class="did-floating-input form-control" name="lokasi_alamat_pengiriman" placeholder=" " rows="4"
                        required style="height: 100px;resize: none"></textarea>
                    <label class="did-floating-label">
                        {{ __('messages.profile.address.address') }}<span class="text-danger">*</span>
                    </label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder=" " id="postcode"
                        name="kodepos_alamat_pengiriman" required pattern="[0-9]*"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                    <label class="did-floating-label">
                        {{ __('messages.profile.address.postcode') }}<span class="text-danger">*</span>
                    </label>
                </div>
            </div>

            <div class="form-group mb-3">
                <label style="color: #3a6fb0">{{ __('messages.profile.address.pinpoint') }}</label>
                <div class="map-container">
                    <div id="map" style="height: 400px; border-radius: 4px"></div>
                </div>
                <input type="hidden" name="lat_alamat_pengiriman" id="lat_alamat_pengiriman">
                <input type="hidden" name="long_alamat_pengiriman" id="long_alamat_pengiriman">
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="provinsi_id" id="provinsi" class="did-floating-select">
                        <option value="" selected disabled hidden>
                            {{ __('messages.profile.address.select_province') }}
                        </option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->province_id }}">{{ $province->province_name }}</option>
                        @endforeach
                    </select>
                    <label class="did-floating-label">{{ __('messages.profile.address.province') }}</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="kota_id" id="kota" class="did-floating-select">
                        <option value="" selected disabled hidden>
                            {{ __('messages.profile.address.select_city') }}
                        </option>
                    </select>
                    <label class="did-floating-label">{{ __('messages.profile.address.city') }}</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="kecamatan_id" id="kecamatan" class="did-floating-select">
                        <option value="" selected disabled hidden>
                            {{ __('messages.profile.address.select_district') }}
                        </option>
                    </select>
                    <label class="did-floating-label">{{ __('messages.profile.address.district') }}</label>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="did-floating-label-content">
                    <select name="status_alamat_pengiriman" id="status_alamat_pengiriman" class="did-floating-select">
                        <option value="" selected disabled hidden>
                            {{ __('messages.profile.address.select_status') }}
                        </option>
                        <option value="Office">{{ __('messages.profile.address.office') }}</option>
                        <option value="Home">{{ __('messages.profile.address.home') }}</option>
                    </select>
                    <label class="did-floating-label">{{ __('messages.profile.address.address_status') }}</label>
                </div>
            </div>

            <div class="form-group">
                <div class="d-flex justify-content-end align-items-center gap-2">
                    <a href="{{ route('profile.address') }}" class="btn btn-cancel">
                        {{ __('messages.profile.address.cancel') }}
                    </a>
                    <button type="submit" class="btn btn-custom-icon">
                        {{ __('messages.profile.address.submit') }}
                        <i class="bx bxs-send fs-5"></i>
                    </button>
                </div>
            </div>
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
            $('#provinsi').change(function() {
                let provinceId = $(this).val();
                if (provinceId) {
                    $.get('/locations', { province_id: provinceId }, function(response) {
                        let kotaDropdown = $('#kota');
                        kotaDropdown.empty();
                        kotaDropdown.append(
                            '<option value="" selected disabled hidden>{{ __('messages.profile.address.select_city') }}</option>'
                        );

                        if (response.cities && Array.isArray(response.cities)) {
                            $.each(response.cities, function(index, city) {
                                kotaDropdown.append('<option value="' + city.city_id + '">' + city.city_name + '</option>');
                            });
                        }
                    }).fail(function() {
                        console.log('Request failed for city data');
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
                let cityId = $(this).val();
                if (cityId) {
                    $.get('/locations', { city_id: cityId }, function(response) {
                        let kecamatanDropdown = $('#kecamatan');
                        kecamatanDropdown.empty();
                        kecamatanDropdown.append(
                            '<option value="" selected disabled hidden>{{ __('messages.profile.address.select_district') }}</option>'
                        );

                        if (response.subdistricts && Array.isArray(response.subdistricts)) {
                            $.each(response.subdistricts, function(index, subdistrict) {
                                kecamatanDropdown.append('<option value="' + subdistrict.subdistrict_id + '">' + subdistrict.subdistrict_name + '</option>');
                            });
                        }
                    }).fail(function() {
                        console.log('Request failed for subdistrict data');
                    });
                } else {
                    $('#kecamatan').empty().append(
                        '<option value="" selected disabled hidden>{{ __('messages.profile.address.select_district') }}</option>'
                    );
                }
            });
            $('form').submit(function(event) {
                var provinceId = $('#provinsi option:selected').val();
                var cityId = $('#kota option:selected').val();
                var subdistrictId = $('#kecamatan option:selected').val();

                $('<input>').attr({
                    type: 'hidden',
                    name: 'provinsi_id',
                    value: provinceId
                }).appendTo(this);

                $('<input>').attr({
                    type: 'hidden',
                    name: 'kota_id',
                    value: city_Id
                }).appendTo(this);

                $('<input>').attr({
                    type: 'hidden',
                    name: 'kecamatan_id',
                    value: subdistrictId
                }).appendTo(this);
            });
        });
    </script>
@endsection
