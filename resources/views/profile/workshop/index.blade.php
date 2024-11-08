@extends('layouts.partials.sidebar')
@push('css')
  <link rel="stylesheet" href="{{ asset('assets/css/workshop.css') }}">
@endpush
@section('title')
  eBengkelku | Workshop
@stop

@section('content')
  <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
    <div class="d-flex justify-content-between align-items-center">
      <h4 class="fs-5">Your Workshops</h4>
      <a href="{{ route('profile.workshop.create') }}" class="btn btn-custom-2">+ Add New Workshop</a>
    </div>

    @if ($bengkels->isEmpty())
      <div class="card border-1 rounded-2 mt-4">
        <div class="card-body d-flex justify-content-center">
          <div class="text-center">
            <img src="{{ asset('assets/images/components/empty.png') }}" height="130" width="130" alt="No workshops">
            <p>No data available for workshops.</p>
          </div>
        </div>
      </div>
    @else
      <div class="row">
        @foreach ($bengkels as $bengkel)
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 py-4">
            <div class="card-product p-3">
              <img
                src="{{ isset($bengkel) && $bengkel->foto_bengkel ? url($bengkel->foto_bengkel) : asset('assets/images/components/image.png') }}"
                class="card-img-top" alt="Workshop Image">
              <div class="card-body text-start">
                <div class="d-flex align-items-center location-map my-2">
                  <i class='bx bx-map-pin me-2' style="font-size: 16px; line-height: 1;"></i>
                  <p class="location m-0">{{ \Illuminate\Support\Str::limit($bengkel->alamat_bengkel, 18) }}</p>
                </div>
                <h5 class="card-title">{{ $bengkel->nama_bengkel }}</h5>
                <div class="mt-3">
                  <div class="tagline d-flex justify-content-start">
                    <span class="tagline">{{ $bengkel->tagline_bengkel }}</span>
                  </div>
                </div>
                <div class="footer-card d-flex justify-content-start gap-3 mt-3">
                  <a href="{{ route('profile.workshop.edit', ['id_bengkel' => $bengkel->id_bengkel]) }}"
                    class="btn btn-link" title="Edit">
                    <i class='bx bx-edit-alt' style="font-size: 1.3rem;"></i>
                  </a>
                  <a href="{{ route('home', ['id_bengkel' => $bengkel->id_bengkel]) }}" class="btn btn-link"
                    title="PoS">
                    <i class='bx bx-calculator' style="font-size: 1.3rem;"></i>
                  </a>
                  <form action="{{ route('profile.workshop.destroy', ['id_bengkel' => $bengkel->id_bengkel]) }}"
                    method="POST" onsubmit="return confirm('Are you sure you want to delete this workshop?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link" title="Delete">
                      <i class='bx bx-trash' style="font-size: 1.3rem;"></i>
                    </button>
                  </form>
                </div>

              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
@endsection
