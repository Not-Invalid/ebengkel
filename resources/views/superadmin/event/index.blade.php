@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Event Data
@stop

@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fs-5"> {{ __('messages-superadmin.sidebar.info_event.list_event') }}</h4>
            <a href="{{ route('event-create') }}" class="btn btn-custom-2">+
                {{ __('messages-superadmin.sidebar.info_event.add_event') }}</a>
        </div>

        @if ($events->isEmpty())
            <div class="card border-1 rounded-2 mt-4">
                <div class="card-body d-flex justify-content-center">
                    <div class="text-center">
                        <img src="{{ asset('assets/images/components/empty.png') }}" height="130" width="130"
                            alt="">
                        <p>{{ __('messages-superadmin.sidebar.not_found') }}</p>
                    </div>
                </div>
            </div>
        @else
            @foreach ($events as $event)
                <div class="card border-1 rounded-2 mt-4">
                    <div class="card-body shadow-sm border">
                        <div class="row">
                            <div class="col-12 col-md-3 d-flex align-items-center justify-content-center mb-3">
                                <img src="{{ asset($event->image_cover) }}" class="img-fluid" alt="{{ $event->nama_event }}"
                                    style="max-height: 150px;">
                            </div>
                            <div class="col-12 col-md-6">
                                <h5 class="card-title mt-2">{{ $event->nama_event }}</h5>
                                <p class="text-muted mt-1">
                                    <i class="fas fa-calendar fs-6"></i>
                                    {{ \Carbon\Carbon::parse($event->event_start_date)->format('M d, Y') }} -
                                    {{ \Carbon\Carbon::parse($event->event_end_date)->format('M d, Y') }}
                                </p>
                                <p class="text-muted">
                                    <i class="fas fa-map-marker-alt fs-6"></i>
                                    {{ $event->lokasi }}
                                </p>
                            </div>
                            <div class="col-12 col-md-3 d-flex align-items-center justify-content-center">
                                <a href="{{ route('event-edit', $event->id_event) }}" class="btn btn-custom-3 mx-2"
                                    data-bs-toggle="tooltip" title="Edit">
                                    <i class="fas fa-edit text-primary"></i>
                                </a>

                                <a href="{{ route('event-peserta', $event->id_event) }}" class="btn btn-custom-3 mx-2"
                                    data-bs-toggle="tooltip" title="Daftar Peserta">
                                    <i class="fas fa-users text-warning"></i>
                                </a>

                                <form action="{{ route('event-delete', $event->id_event) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this event?');"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete" data-bs-toggle="tooltip" title="Delete"
                                        style="border: none; background: none;">
                                        <i class="fas fa-trash-alt text-white"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
