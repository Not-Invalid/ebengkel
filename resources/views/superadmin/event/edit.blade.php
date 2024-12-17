@extends('superadmin.layouts.app')
@section('title')
    eBengkel | Edit Event Data
@stop

<style>
    .image-preview {
        border: 1px solid #ddd;
        border-radius: 5px;
        max-height: 200px;
    }

    .upload-box {
        border: 2px dashed var(--main-light-blue);
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        transition: background-color 0.2s;
        cursor: pointer;
    }

    .upload-box:hover {
        background-color: #f9f9f9;
    }

    .upload-label {
        font-size: 16px;
        color: #555;
        margin-bottom: 10px;
        display: block;
    }

    .file-input {
        opacity: 0;
        position: absolute;
        z-index: -1;
    }

    .remove-button {
        cursor: pointer;
        color: red;
        font-size: 18px;
        margin-left: 10px;
    }

    .remove-button i {
        font-size: 18px;
    }

    .bintang-tamu-row {
        margin-left: 0;
        margin-right: 0;
    }
</style>

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Edit {{ __('messages-superadmin.sidebar.event') }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('event-update', $event->id_event) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Cover Photo Upload -->
                <div class="form-group mb-4">
                    <div class="upload-box">
                        <label for="image_cover"
                            class="upload-label">{{ __('messages-superadmin.sidebar.info_event.photo_cover') }}</label>
                        <input type="file" class="file-input" name="image_cover" id="image_cover"
                            onchange="previewImage('image_cover', 'coverPreview')">
                        <div class="preview-container d-flex justify-content-center">
                            <img id="coverPreview" src="{{ asset($event->image_cover) }}" alt="Cover Photo Preview"
                                class="image-preview"
                                style="display: {{ $event->image_cover ? 'block' : 'none' }}; width: 200px; margin-top: 10px;">
                        </div>
                    </div>
                </div>

                <!-- Event Details -->
                <div class="row">
                    <div class="col">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="text" placeholder=" " id="nama_event"
                                name="nama_event" value="{{ old('nama_event', $event->nama_event) }}" />
                            <label
                                class="did-floating-label">{{ __('messages-superadmin.sidebar.info_event.event_name') }}</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="date" placeholder=" " id="event_start_date"
                                name="event_start_date"
                                value="{{ old('event_start_date', $event->event_start_date->format('Y-m-d')) }}" />
                            <label
                                class="did-floating-label">{{ __('messages-superadmin.sidebar.info_event.event_start') }}</label>
                        </div>
                    </div>

                    <div class="col">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="date" placeholder=" " id="event_end_date"
                                name="event_end_date"
                                value="{{ old('event_end_date', $event->event_end_date->format('Y-m-d')) }}" />
                            <label
                                class="did-floating-label">{{ __('messages-superadmin.sidebar.info_event.event_end') }}</label>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi & Alamat -->
                <div class="did-floating-label-content">
                    <textarea class="did-floating-input" placeholder=" " rows="4" id="deskripsi" name="deskripsi"
                        style="height: 100px; resize:none;">{{ old('deskripsi', $event->deskripsi) }}</textarea>
                    <label
                        class="did-floating-label">{{ __('messages-superadmin.sidebar.info_event.description') }}</label>
                </div>

                <div class="did-floating-label-content">
                    <textarea class="did-floating-input" placeholder=" " rows="4" id="alamat_event" name="alamat_event"
                        style="height: 100px; resize:none;">{{ old('alamat_event', $event->alamat_event) }}</textarea>
                    <label
                        class="did-floating-label">{{ __('messages-superadmin.sidebar.info_event.event_adress') }}</label>
                </div>

                <!-- Lokasi & Tipe Harga -->
                <div class="row">
                    <div class="col">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="text" placeholder=" " id="lokasi" name="lokasi"
                                value="{{ old('lokasi', $event->lokasi) }}" />
                            <label
                                class="did-floating-label">{{ __('messages-superadmin.sidebar.info_event.event_location') }}</label>
                        </div>
                    </div>

                    <div class="col">
                        <div class="did-floating-label-content">
                            <select class="did-floating-input" id="tipe_harga" name="tipe_harga"
                                onchange="toggleHargaInput()">
                                <option value="" disabled selected>
                                    {{ __('messages-superadmin.sidebar.info_event.event_price') }}</option>
                                <option value="Gratis"
                                    {{ old('tipe_harga', $event->tipe_harga) == 'Gratis' ? 'selected' : '' }}>
                                    {{ __('messages-superadmin.sidebar.info_event.event_free') }}
                                </option>
                                <option value="Berbayar"
                                    {{ old('tipe_harga', $event->tipe_harga) == 'Berbayar' ? 'selected' : '' }}>
                                    {{ __('messages-superadmin.sidebar.info_event.event_paid') }}
                                </option>
                            </select>
                            <label
                                class="did-floating-label">{{ __('messages-superadmin.sidebar.info_event.price_type') }}</label>
                        </div>
                    </div>
                </div>

                <!-- Harga (for paid events only) -->
                <div class="row">
                    <div class="col" id="hargaContainer"
                        style="display: {{ $event->tipe_harga == 'Berbayar' ? 'block' : 'none' }};">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="text" placeholder=" " id="harga" name="harga"
                                value="{{ old('harga', $event->harga) }}" pattern="[0-9]*"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                            <label
                                class="did-floating-label">{{ __('messages-superadmin.sidebar.info_event.price') }}</label>
                        </div>
                    </div>
                </div>

                <!-- Agenda -->
                <div id="agenda-container">
                    @if (is_array($event->agenda_acara) || is_object($event->agenda_acara))
                        @foreach ($event->agenda_acara as $index => $agenda)
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="did-floating-label-content flex-grow-1">
                                        <input class="did-floating-input" type="text" placeholder=" "
                                            name="agenda_acara[{{ $index }}][judul]"
                                            value="{{ old('agenda_acara.' . $index . '.judul', $agenda['judul']) }}" />
                                        <label
                                            class="did-floating-label">{{ __('messages-superadmin.sidebar.info_event.agenda_title') }}</label>
                                    </div>
                                </div>
                                <div class="col d-flex">
                                    <div class="did-floating-label-content flex-grow-1">
                                        <input class="did-floating-input" type="time" placeholder=" "
                                            name="agenda_acara[{{ $index }}][waktu]"
                                            value="{{ old('agenda_acara.' . $index . '.waktu', $agenda['waktu']) }}" />
                                        <label
                                            class="did-floating-label">{{ __('messages-superadmin.sidebar.info_event.time') }}</label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>{{ __('messages-superadmin.sidebar.info_event.no_agenda') }}</p>
                    @endif
                </div>

                <div id="additional-agenda-rows"></div>

                <!-- Add Agenda Button -->
                <div class="row my-1">
                    <div class="col text-left">
                        <button type="button" class="btn btn-custom-3"
                            id="add-agenda">{{ __('messages-superadmin.sidebar.info_event.add_agenda') }}</button>
                    </div>
                </div>

                <!-- Bintang Tamu -->
                <div id="bintang-tamu-container" class="mt-4">
                    @forelse ($event->bintang_tamu as $bintangTamu)
                        <div class="row align-items-center">
                            <div class="col d-flex">
                                <div class="did-floating-label-content flex-grow-1">
                                    <input class="did-floating-input" type="text" name="bintang_tamu[]"
                                        value="{{ old('bintang_tamu[]', $bintangTamu) }}" />
                                    <label
                                        class="did-floating-label">{{ __('messages-superadmin.sidebar.info_event.add_guest') }}</label>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>{{ __('messages-superadmin.sidebar.info_event.no_star') }}</p>
                    @endforelse
                </div>

                <div class="row my-1">
                    <div class="col text-left">
                        <button type="button" class="btn btn-custom-3"
                            id="add-bintang-tamu">{{ __('messages-superadmin.sidebar.info_event.add_guest') }}</button>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-start mt-3">
                    <button type="submit" class="btn btn-custom-icon me-2">
                        {{ __('messages-superadmin.sidebar.button.save') }}
                    </button>

                    <a href="{{ route('event-data') }}"
                        class="btn btn-danger">{{ __('messages-superadmin.sidebar.button.cancel') }}</a>
                </div>
            </form>

        </div>
    </div>

    <script>
        // Preview Image Function
        function previewImage(inputId, previewId) {
            const fileInput = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const file = fileInput.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        }

        // Document Ready Function
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle Harga input visibility based on Tipe Harga selection
            function toggleHargaInput() {
                const hargaContainer = document.getElementById('hargaContainer');
                const tipeHarga = document.getElementById('tipe_harga').value;
                hargaContainer.style.display = tipeHarga === 'Berbayar' ? 'block' : 'none';
            }

            // Initialize toggle function on page load
            toggleHargaInput();

            // Add Agenda functionality
            let agendaIndex = {{ count($event->agenda_acara) }};
            const addAgendaButton = document.getElementById('add-agenda');
            if (addAgendaButton) {
                addAgendaButton.addEventListener('click', function() {
                    const row = document.createElement('div');
                    row.classList.add('row');
                    row.innerHTML = `
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder="" name="agenda_acara[${agendaIndex}][judul]" />
                        <label class="did-floating-label">{{ __('messages-superadmin.sidebar.info_event.agenda_title') }}</label>
                    </div>
                </div>
                <div class="col d-flex">
                    <div class="did-floating-label-content flex-grow-1">
                        <input class="did-floating-input" type="time" placeholder="{{ __('messages-superadmin.sidebar.info_event.guest_star') }}" name="agenda_acara[${agendaIndex}][waktu]" />
                        <label class="did-floating-label">{{ __('messages-superadmin.sidebar.info_event.time') }}</label>
                    </div>
                    <button type="button" class="btn btn-danger ms-2 remove-agenda" style="height: 35px" onclick="removeAgenda(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>`;
                    document.getElementById('additional-agenda-rows').appendChild(row);
                    agendaIndex++;
                });
            }

            // Add Bintang Tamu functionality
            const addBintangTamuButton = document.getElementById('add-bintang-tamu');
            if (addBintangTamuButton) {
                addBintangTamuButton.addEventListener('click', function() {
                    const row = document.createElement('div');
                    row.classList.add('row');
                    row.innerHTML = `
                <div class="col d-flex">
                    <div class="did-floating-label-content flex-grow-1">
                        <input class="did-floating-input" type="text" name="bintang_tamu[]" />
                        <label class="did-floating-label">{{ __('messages-superadmin.sidebar.info_event.add_guest') }}</label>
                    </div>
                    <button type="button" class="btn btn-danger ms-2 remove-bintang-tamu" style="height: 35px;" onclick="removeBintangTamu(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>`;
                    document.getElementById('bintang-tamu-container').appendChild(row);
                });
            }

            // Attach event listener to tipe_harga select
            const tipeHargaSelect = document.getElementById('tipe_harga');
            if (tipeHargaSelect) {
                tipeHargaSelect.addEventListener('change', toggleHargaInput);
            }
        });
    </script>
@endsection
