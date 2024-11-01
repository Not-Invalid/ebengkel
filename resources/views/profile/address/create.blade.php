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
                <label for="nama_alamat_pengiriman">Alamat</label>
                <textarea class="form-control" name="nama_alamat_pengiriman" required></textarea>
            </div>

            <div class="form-group mb-3">
                <label for="kodepos_alamat_pengiriman">Kode Pos</label>
                <input type="text" class="form-control" name="kodepos_alamat_pengiriman" required>
            </div>

            <div class="form-group mb-3">
                <label for="lokasi_alamat_pengiriman">Lokasi Alamat</label>
                <textarea class="form-control" name="lokasi_alamat_pengiriman" required></textarea>
            </div>

            <div class="form-group mb-3">
                <label>Status Alamat</label>
                <select name="status_alamat_pengiriman" id="status_alamat_pengiriman" class="form-select">
                    <option value="Pilih Status" selected disabled hidden>Pilih Status</option>
                    <option value="Home">Home</option>
                    <option value="Office">Office</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label>Pinpoint Alamat</label>
                {{-- <div id="map" style="height: 300px;"></div> --}}
                <textarea name="" id="" cols="30" rows="10" class="form-control"></textarea>
                <input type="hidden" name="lat_alamat_pengiriman" id="latitude">
                <input type="hidden" name="long_alamat_pengiriman" id="longitude">
            </div>

            <div class="form-group">
                <label for="provinsi">Provinsi</label>
                <select class="form-control" id="provinsi" name="provinsi">
                    <option value="">Pilih Provinsi</option>
                </select>
            </div>

            <div class="form-group">
                <label for="kota">Kota</label>
                <select class="form-control" id="kota" name="kota">
                    <option value="">Pilih Kota</option>
                </select>
            </div>

            <div class="form-group">
                <label for="kecamatan">Kecamatan</label>
                <select class="form-control" id="kecamatan" name="kecamatan">
                    <option value="">Pilih Kecamatan</option>
                </select>
            </div>


            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Initialize Leaflet map
        var map = L.map('map').setView([-6.200000, 106.816666], 10); // Default to Jakarta

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker([-6.200000, 106.816666], {
            draggable: true
        }).addTo(map);

        marker.on('dragend', function(e) {
            var lat = e.target.getLatLng().lat;
            var lng = e.target.getLatLng().lng;
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        });

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;
        });
    </script>
@endsection
