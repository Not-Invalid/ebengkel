@extends('layouts.app')

@push('css')
  <link rel="stylesheet" href="{{ asset('assets/css/event.css') }}">
@endpush

@section('title')
  eBengkelku | Event
@stop

@section('content')
  <section class="section section-white" style="position: relative; overflow: hidden; padding-top: 100px; padding-bottom: 20px;">
    <div style="background-image: url('{{ asset('assets/images/bg/wallpaper.png') }}'); background-size: cover; background-position: center; background-attachment: fixed; background-repeat: no-repeat; position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0;">
    </div>
    <div class="bg-white" style="position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0; opacity: 0.7;">
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <h4 class="title-header">See Our Event</h4>
        </div>
      </div>
    </div>
  </section>

  <section class="section bg-white py-5">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="d-flex justify-content-center align-items-center" style="min-height: 50px;">
            <form method="GET" action="{{ route('event.show') }}" style="width: 60%;">
                <div class="input-group">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci..." class="form-control" style="border-radius: 20px 0 0 20px;">
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

  {{-- Section for displaying events --}}
  <section class="section bg-white" style="padding-bottom: 50px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="row">

            @if ($events->isEmpty())
                <div class="d-flex justify-content-center pb-5">
                    <div class="text-center">
                        <img src="{{ asset('assets/images/components/empty.png') }}" height="200" width="200" alt="Empty">
                        @if (request('search'))
                            <p>No events found for "{{ request('search') }}".</p>
                        @else
                            <p>No data available for events.</p>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Loop untuk menampilkan event --}}
            @if ($events->isNotEmpty())
              @foreach ($events as $event)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                  <a href="{{ route('event.detail', $event->id_event) }}" class="card-event p-3">
                    <img src="{{ asset($event->image_cover) }}" class="card-img-top" alt="{{ $event->nama_event }}">
                    <div class="card-body text-start">
                      <p class="card-title mt-4">{{ $event->nama_event }}</p>
                      <div class="d-flex align-items-center mt-1 event-date">
                        <i class='bx bx-calendar'></i>
                        <span class="date ms-2">
                          {{ \Carbon\Carbon::parse($event->event_start_date)->format('M d, Y') }} -
                          {{ \Carbon\Carbon::parse($event->event_end_date)->format('M d, Y') }}
                        </span>
                      </div>
                      <div class="d-flex align-items-center mt-1 event-date">
                        <i class='bx bx-map-pin'></i>
                        <span class="date ms-2">
                          {{ $event->lokasi }}
                        </span>
                      </div>
                      <div class="footer-card">
                        <div class="price d-flex justify-content-start">
                          <span class="price">{{ $event->tipe_harga === 'Gratis' ? 'Free' : 'Rp' . number_format($event->harga, 0, ',', '.') }}</span>
                        </div>
                      </div>
                    </div>
                  </a>
                </div>
              @endforeach
            @endif
          </div>

            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($events->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link">Previous</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a href="{{ $events->previousPageUrl() }}" class="page-link">Previous</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($events->getUrlRange(1, $events->lastPage()) as $page => $url)
                            @if ($page == $events->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <a class="page-link" href="{{ $url }}">{{ $page }} <span class="visually-hidden">(current)</span></a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($events->hasMorePages())
                            <li class="page-item">
                                <a href="{{ $events->nextPageUrl() }}" class="page-link">Next</a>
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
