@extends('layouts.partials.sidebar')

@section('title')
    eBengkelku | Used Car
@stop

@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fs-5">Your Used Car</h4>
            <a href="{{ route('used-car-create') }}" class="btn btn-custom-2">+ Add New Used Car</a>
        </div>

        @if ($mobilList->isEmpty())
            <div class="card border-1 rounded-2 mt-4">
                <div class="card-body d-flex justify-content-center">
                    <div class="text-center">
                        <img src="{{ asset('assets/images/components/empty.png') }}" height="130" width="130"
                            alt="">
                        <p>No data available.</p>
                    </div>
                </div>
            </div>
        @else
            @foreach ($mobilList as $mobil)
                @if ($mobil->delete_mobil === 'N')
                    <div class="card border-1 rounded-2 mt-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-3 d-flex align-items-center justify-content-center mb-3">
                                    <div class="d-flex align-items-center">
                                        @if ($mobil->fotos && $mobil->fotos->file_foto_mobil_1)
                                            <img src="{{ url($mobil->fotos->file_foto_mobil_1) }}" alt="Car Image"
                                                width="180" height="180" style="border-radius: 4px; object-fit: cover">
                                        @else
                                            <img src="{{ asset('assets/images/components/image.png') }}" alt="Car Image"
                                                width="180" height="180" style="border-radius: 4px">
                                        @endif
                                    </div>

                                </div>
                                <div class="col-12 col-md-9">
                                    <span class="badge">{{ $mobil->status_mobil }}</span>
                                    <h5 class="card-title mt-3">{{ $mobil->nama_mobil ?? 'No name' }}</h5>
                                    <h6 class="card-title mt-3">Rp
                                        {{ number_format($mobil->harga_mobil, 0, ',', '.') }}
                                    </h6>
                                    <p class="card-text text-secondary" style="font-size: 14px">
                                        {{ $mobil->merkMobil->nama_merk ?? 'No car name' }}
                                    </p>
                                    <a href="{{ route('used-car-edit', $mobil->id_mobil) }}"
                                        class="btn btn-custom-3">Edit</a>

                                    <!-- Form hapus mobil -->
                                    <form action="{{ route('used-car-delete', $mobil->id_mobil) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
@endsection
