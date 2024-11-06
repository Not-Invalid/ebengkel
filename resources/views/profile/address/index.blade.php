@extends('layouts.partials.sidebar')

@section('title')
    eBengkelku | Address
@stop

@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fs-5">Your Address</h4>
            <a href="{{ route('profile.address.create') }}" class="btn btn-custom-2">+ Add New Address</a>
        </div>

        @if ($address->isEmpty())
            <div class="card border-1 rounded-2 mt-4">
                <div class="card-body d-flex justify-content-center">
                    <div class="text-center">
                        <img src="{{ asset('assets/images/components/empty.png') }}" height="130" width="130"
                            alt="">
                        <p>No data address delivery.</p>
                    </div>
                </div>
            </div>
        @else
            @foreach ($address as $addr)
                @if ($addr->delete_alamat_pengiriman === 'N')
                    <div class="card border-1 rounded-2 mt-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-3 d-flex align-items-center justify-content-center mb-3">
                                    <div class="d-flex align-items-center">
                                        <!-- Map container with unique id per address -->
                                        <div id="map_{{ $addr->id_alamat_pengiriman }}"
                                            style="height: 180px; width: 180px; border-radius: 4px;"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-9">
                                    <span class="badge">{{ $addr->status_alamat_pengiriman }}</span>
                                    <h5 class="card-title mt-3">{{ $addr->nama_penerima }}</h5>
                                    <h6 class="card-title mt-3">
                                        {{ $addr->telp_penerima }}
                                    </h6>
                                    <p class="card-text text-secondary" style="font-size: 14px">
                                        {{ $addr->lokasi_alamat_pengiriman }}</p>
                                    <div class="d-flex justify-content-start">
                                        <a href="{{ route('address.edit', $addr->id_alamat_pengiriman) }}"
                                            class="btn btn-custom-3 me-2">
                                            Edit
                                        </a>
                                        <form action="{{ route('address.delete', $addr->id_alamat_pengiriman) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-custom-3" type="submit">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Loop through all address entries and initialize the map for each
            @foreach ($address as $addr)
                @if ($addr->delete_alamat_pengiriman === 'N')
                    var latitude = {{ $addr->lat_alamat_pengiriman }};
                    var longitude = {{ $addr->long_alamat_pengiriman }};
                    var mapId = 'map_{{ $addr->id_alamat_pengiriman }}';

                    // Create the map for each address
                    var map = L.map(mapId).setView([latitude, longitude], 13);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);
                    var marker = L.marker([latitude, longitude]).addTo(map);
                @endif
            @endforeach
        });
    </script>
@endsection
