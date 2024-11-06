@extends('layouts.partials.sidebar')

@section('title')
    eBengkelku | Edit Address
@stop

@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <h4>Edit Address</h4>
        <form action="{{ route('address.update', $address->id_alamat_pengiriman) }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label for="nama_penerima">Nama Penerima</label>
                <input type="text" class="form-control" name="nama_penerima" value="{{ $address->nama_penerima }}">
            </div>

            <div class="form-group mb-3">
                <label for="telp_penerima">No Telp Penerima</label>
                <input type="text" class="form-control" name="telp_penerima" required pattern="[0-9]*"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="{{ $address->telp_penerima }}">
            </div>

            <div class="form-group mb-3">
                <label for="lokasi_alamat_pengiriman">Alamat</label>
                <textarea class="form-control" name="lokasi_alamat_pengiriman">{{ $address->lokasi_alamat_pengiriman }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label for="kodepos_alamat_pengiriman">Kode Pos</label>
                <input type="text" class="form-control" name="kodepos_alamat_pengiriman"
                    value="{{ $address->kodepos_alamat_pengiriman }}">
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
                <label for="provinsi">Provinsi</label>
                <select class="form-control" id="provinsi" name="provinsi">
                    <option value="{{ $address->provinsi }}" selected>{{ $address->provinsi }}</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="kota">Kota</label>
                <select class="form-control" id="kota" name="kota">
                    <option value="{{ $address->kota }}" selected>{{ $address->kota }}</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="kecamatan">Kecamatan</label>
                <select class="form-control" id="kecamatan" name="kecamatan">
                    <option value="{{ $address->kecamatan }}" selected>{{ $address->kecamatan }}</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label>Status Alamat</label>
                <select name="status_alamat_pengiriman" id="status_alamat_pengiriman" class="form-select">
                    <option value="{{ $address->status_alamat_pengiriman }}" selected disabled hidden>
                        {{ $address->status_alamat_pengiriman }}</option>
                    <option value="Home">Home</option>
                    <option value="Office">Office</option>
                </select>
            </div>

            <div>
                <button type="submit" class="btn btn-primary mt-3">Update</button>
                <a href="{{ route('profile.address') }}" class="btn btn-danger mt-3">Back</a>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var lat = {{ $address->lat_alamat_pengiriman }};
            var lng = {{ $address->long_alamat_pengiriman }};
            var map = L.map('map').setView([lat, lng], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            var marker = L.marker([lat, lng]).addTo(map);
            marker.on('dragend', function(e) {
                var newLatLng = e.target.getLatLng();
                document.getElementById('latitude').value = newLatLng.lat;
                document.getElementById('longitude').value = newLatLng.lng;
            });
            marker.dragging.enable();
        });
    </script>
@endsection
