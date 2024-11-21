@extends('layouts.app')
@push('css')
  <link rel="stylesheet" href="{{ asset('assets/css/workshop.css') }}">
@endpush
@section('title')
  eBengkelku | Workshop
@stop
@section('content')
  <section class="section section-white"
    style="position: relative; overflow: hidden; padding-top: 100px; padding-bottom: 20px;">
    <div
      style="background-image: url('{{ asset('assets/images/bg/wallpaper.png') }}'); background-size: cover; background-position: center; background-attachment: fixed; background-repeat: no-repeat; position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0;">
    </div>
    <div class="bg-white" style="position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0; opacity: 0.7;">
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <h4 class="title-header">See Our Workshop</h4>
        </div>
      </div>
    </div>
  </section>

  <section class="section bg-white py-5">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="d-flex justify-content-center align-items-center" style="min-height: 50px;">
            <form method="GET" action="" style="width: 60%;">
              <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}" required maxlength="255"
                  placeholder="Ketik kata kunci..." class="form-control" style="border-radius: 20px 0 0 20px;">
                <div class="input-group-append">
                  <button type="submit" class="btn btn-search" style="border-radius: 0 20px 20px 0;">
                    <i class='bx bx-search-alt align-icon'></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section bg-white" style="padding-bottom: 50px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          @if ($bengkels->isEmpty())
            <div class="d-flex justify-content-center pb-5">
              <div class="text-center">
                <img src="{{ asset('assets/images/components/empty.png') }}" height="200" width="200"
                  alt="No workshops">
                <p>No data available for workshops.</p>
              </div>
            </div>
          @else
            <div class="row">
              @foreach ($bengkels as $bengkel)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                  <a href="{{ route('workshop.detail', $bengkel->id_bengkel) }}" class="card-product p-3">
                    <img
                      src="{{ isset($bengkel) && $bengkel->foto_bengkel ? url($bengkel->foto_bengkel) : asset('assets/images/components/image.png') }}"
                      class="card-img-top" alt="Workshop Image">
                    <div class="card-body text-start">
                      <div class="d-flex align-items-center location-map">
                        <i class='bx bx-map-pin'></i>
                        <p class="location ms-2 py-2">{{ \Illuminate\Support\Str::limit($bengkel->alamat_bengkel, 22) }}
                        </p>
                      </div>
                      <h5 class="card-title">{{ \Illuminate\Support\Str::limit($bengkel->nama_bengkel, 20) }}</h5>
                      <div class="mt-3">
                        <div class="tagline d-flex justify-content-start">
                          <span class="tagline">{{ \Illuminate\Support\Str::limit($bengkel->tagline_bengkel, 20) }}</span>
                        </div>
                      </div>
                    </div>
                  </a>
                </div>
              @endforeach
            </div>
          @endif
          <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation">
              <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($bengkels->onFirstPage())
                  <li class="page-item disabled">
                    <a class="page-link">Previous</a>
                  </li>
                @else
                  <li class="page-item">
                    <a href="{{ $bengkels->previousPageUrl() }}" class="page-link">Previous</a>
                  </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($bengkels->getUrlRange(1, $bengkels->lastPage()) as $page => $url)
                  @if ($page == $bengkels->currentPage())
                    <li class="page-item active" aria-current="page">
                      <a class="page-link" href="{{ $url }}">{{ $page }} <span
                          class="visually-hidden">(current)</span></a>
                    </li>
                  @else
                    <li class="page-item">
                      <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                  @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($bengkels->hasMorePages())
                  <li class="page-item">
                    <a href="{{ $bengkels->nextPageUrl() }}" class="page-link">Next</a>
                  </li>
                @else
                  <li class="page-item disabled">
                    <a class="page-link">Next</a>
                  </li>
                @endif
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
