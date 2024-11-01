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
            @foreach ($address as $address)
                @if ($address->delete_alamat_pengiriman === 'N')
                    <div class="card border-1 rounded-2 mt-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-3 d-flex align-items-center justify-content-center mb-3">
                                    <div class="d-flex align-items-center">
                                        <iframe src="https://www.google.com/maps/embed?pb=-6.2766717,106.570193"
                                            width="180" height="180" style="border:0; border-radius: 4px"
                                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                        </iframe>
                                    </div>
                                </div>
                                <div class="col-12 col-md-9">
                                    <span class="badge">{{ $address->status_alamat_pengiriman }}</span>
                                    <h5 class="card-title mt-3">{{ $address->pelanggan->nama_pelanggan ?? 'No name' }}</h5>
                                    <h6 class="card-title mt-3">
                                        {{ $address->pelanggan->telp_pelanggan ?? 'No phone number' }}
                                    </h6>
                                    <p class="card-text text-secondary" style="font-size: 14px">
                                        {{ $address->nama_alamat_pengiriman }}</p>
                                    <a href="#" class="btn btn-custom-3">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
@endsection
