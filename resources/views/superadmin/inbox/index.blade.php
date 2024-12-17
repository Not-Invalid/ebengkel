@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Inbox Message
@stop

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ __('messages-superadmin.sidebar.message.message_list') }}</h2>
        </div>

        <table class="table table-bordered">
            <thead class="field-title">
                <tr>
                    <th>No</th>
                    <th>{{ __('messages-superadmin.sidebar.message.sender_name') }}</th>
                    <th>Email</th>
                    <th>{{ __('messages-superadmin.sidebar.message.phone_number') }}</th>
                    <th>{{ __('messages-superadmin.sidebar.message.message') }}</th>
                    <th>{{ __('messages-superadmin.sidebar.message.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($messages as $index => $data)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $data->nama }}</td>
                        <td>{{ $data->email }}</td>
                        <td>{{ $data->telepon }}</td>
                        <td>{{ Str::limit($data->pesan, 20) }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#messageModal{{ $data->id }}">
                                {{ __('messages-superadmin.sidebar.message.view') }}
                            </button>

                            <div class="modal fade" id="messageModal{{ $data->id }}" tabindex="-1"
                                aria-labelledby="messageModalLabel{{ $data->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="messageModalLabel{{ $data->id }}">
                                                {{ __('messages-superadmin.sidebar.message.full_message') }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="did-floating-label-content">
                                                        <input class="did-floating-input" type="text" placeholder=" "
                                                            value="{{ $data->nama }}" readonly />
                                                        <label
                                                            class="did-floating-label">{{ __('messages-superadmin.sidebar.message.sender_name') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="did-floating-label-content">
                                                        <input class="did-floating-input" type="email" placeholder=" "
                                                            value="{{ $data->email }}" readonly />
                                                        <label class="did-floating-label">Email</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="did-floating-label-content">
                                                        <input class="did-floating-input" type="text" placeholder=" "
                                                            value="{{ $data->telepon }}" readonly />
                                                        <label
                                                            class="did-floating-label">{{ __('messages-superadmin.sidebar.message.phone_number') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="did-floating-label-content">
                                                        <textarea class="did-floating-input" style="height: 120px; resize:none;" placeholder=" " rows="3" readonly>{{ $data->pesan }}</textarea>
                                                        <label
                                                            class="did-floating-label">{{ __('messages-superadmin.sidebar.message.message') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-4">
        <nav aria-label="Page navigation">
            <ul class="pagination gap-2">
                @if ($messages->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link bg-light border-0 rounded-pill"><i class="fas fa-chevron-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a href="{{ $messages->previousPageUrl() }}"
                            class="page-link bg-light border-0 rounded-pill hover:bg-danger text-dark"><i
                                class="fas fa-chevron-left"></i></a>
                    </li>
                @endif

                @foreach ($messages->getUrlRange(1, $messages->lastPage()) as $page => $url)
                    @if ($page == $messages->currentPage())
                        <li class="page-item active">
                            <span class="page-num page-link text-white border-0 rounded-pill">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a href="{{ $url }}"
                                class="page-link bg-light border-0 rounded-pill hover:bg-danger text-dark">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach

                @if ($messages->hasMorePages())
                    <li class="page-item">
                        <a href="{{ $messages->nextPageUrl() }}"
                            class="page-link bg-light border-0 rounded-pill hover:bg-danger text-dark"><i
                                class="fas fa-chevron-right"></i></a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link bg-light border-0 rounded-pill"><i class="fas fa-chevron-right"></i></span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endsection
