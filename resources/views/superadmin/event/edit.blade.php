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
</style>

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Edit Event</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('event-update', $event->id_event) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group mb-4">
                    <div class="upload-box">
                        <label for="image_cover" class="upload-label">Cover Photo</label>
                        <input type="file" class="file-input" name="image_cover" id="image_cover"
                            onchange="previewImage('image_cover', 'coverPreview')">
                        <div class="preview-container d-flex justify-content-center">
                            <img id="coverPreview" src="{{ asset($event->image_cover) }}" alt="Cover Photo Preview" class="image-preview" style="display: {{ $event->image_cover ? 'block' : 'none' }}; width: 200px; margin-top: 10px;">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Nama Event -->
                    <div class="col">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="text" placeholder=" " id="nama_event" name="nama_event" value="{{ old('nama_event', $event->nama_event) }}" />
                            <label class="did-floating-label">Nama Event</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Event Start Date -->
                    <div class="col">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="date" placeholder=" " id="event_start_date" name="event_start_date" value="{{ old('event_start_date', \Carbon\Carbon::parse($event->event_start_date)->format('Y-m-d')) }}" />
                            <label class="did-floating-label">Event Start Date</label>
                        </div>
                    </div>

                    <!-- Event End Date -->
                    <div class="col">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="date" placeholder=" " id="event_end_date" name="event_end_date" value="{{ old('event_end_date', \Carbon\Carbon::parse($event->event_end_date)->format('Y-m-d')) }}" />
                            <label class="did-floating-label">Event End Date</label>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="did-floating-label-content">
                    <textarea class="did-floating-input" placeholder=" " rows="4" id="deskripsi" name="deskripsi" style="height: 100px">{{ old('deskripsi', $event->deskripsi) }}</textarea>
                    <label class="did-floating-label">Deskripsi</label>
                </div>

                <!-- Alamat Event -->
                <div class="did-floating-label-content">
                    <textarea class="did-floating-input" placeholder=" " rows="4" id="alamat_event" name="alamat_event" style="height: 100px">{{ old('alamat_event', $event->alamat_event) }}</textarea>
                    <label class="did-floating-label">Alamat Event</label>
                </div>

                <div class="row">
                    <!-- Lokasi -->
                    <div class="col">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="text" placeholder=" " id="lokasi" name="lokasi" value="{{ old('lokasi', $event->lokasi) }}" />
                            <label class="did-floating-label">Lokasi</label>
                        </div>
                    </div>

                    <!-- Tipe Harga -->
                    <div class="col">
                        <div class="did-floating-label-content">
                            <select class="did-floating-input" id="tipe_harga" name="tipe_harga" onchange="toggleHargaInput()">
                                <option value="" disabled selected>Pilih Tipe Harga</option>
                                <option value="Gratis" {{ old('tipe_harga', $event->tipe_harga) == 'Gratis' ? 'selected' : '' }}>Gratis</option>
                                <option value="Berbayar" {{ old('tipe_harga', $event->tipe_harga) == 'Berbayar' ? 'selected' : '' }}>Berbayar</option>
                            </select>
                            <label class="did-floating-label">Tipe Harga</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Harga -->
                    <div class="col" id="hargaContainer" style="display: {{ $event->tipe_harga == 'Berbayar' ? 'block' : 'none' }};">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="text" placeholder=" " id="harga" name="harga" value="{{ old('harga', $event->harga) }}" pattern="[0-9]*"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                            <label class="did-floating-label">Harga</label>
                        </div>
                    </div>
                </div>

                <!-- Agenda -->
                <div id="agenda-container">
                    @forelse ($event->agenda_acara as $index => $agenda)
                        <div class="row">
                            <div class="col">
                                <div class="did-floating-label-content">
                                    <input class="did-floating-input" type="text" placeholder=" " name="agenda_acara[{{ $index }}][judul]" value="{{ old('agenda_acara.' . $index . '.judul', $agenda['judul']) }}" />
                                    <label class="did-floating-label">Judul Agenda</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="did-floating-label-content">
                                    <input class="did-floating-input" type="time" placeholder=" " name="agenda_acara[{{ $index }}][waktu]" value="{{ old('agenda_acara.' . $index . '.waktu', $agenda['waktu']) }}" />
                                    <label class="did-floating-label">Waktu</label>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>No agenda available.</p>
                    @endforelse
                </div>


                <div id="additional-agenda-rows"></div>

                <!-- Add Agenda Button -->
                <div class="row my-1">
                    <div class="col text-left">
                        <button type="button" class="btn btn-outline-secondary" id="add-agenda">Add Agenda</button>
                    </div>
                </div>

                <!-- Bintang Tamu -->
                <div id="bintang-tamu-container">
                    @forelse ($event->bintang_tamu as $bintangTamu)
                        <div class="col">
                            <div class="did-floating-label-content">
                                <input class="did-floating-input" type="text" placeholder="Nama Bintang Tamu" name="bintang_tamu[]" value="{{ old('bintang_tamu[]', $bintangTamu) }}" />
                                <label class="did-floating-label">Nama Bintang Tamu</label>
                            </div>
                        </div>
                    @empty
                        <p>No guest stars available.</p>
                    @endforelse
                </div>

                <div class="row mt-3">
                    <div class="col text-left">
                        <button type="button" class="btn btn-outline-secondary" id="add-bintang-tamu">Add Bintang Tamu</button>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="row mt-4">
                    <div class="col text-right">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        // Show or hide price input based on 'tipe_harga'
        function toggleHargaInput() {
            const hargaContainer = document.getElementById('hargaContainer');
            const tipeHarga = document.getElementById('tipe_harga').value;
            if (tipeHarga === 'Berbayar') {
                hargaContainer.style.display = 'block';
            } else {
                hargaContainer.style.display = 'none';
            }
        }

        // Add Agenda Functionality
        let agendaIndex = {{ count($event->agenda_acara) }};
        document.getElementById('add-agenda').addEventListener('click', function() {
            const row = document.createElement('div');
            row.classList.add('row');
            row.innerHTML = `
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " name="agenda_acara[${agendaIndex}][judul]" />
                        <label class="did-floating-label">Judul Agenda</label>
                    </div>
                </div>
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="time" placeholder=" " name="agenda_acara[${agendaIndex}][waktu]" />
                        <label class="did-floating-label">Waktu</label>
                    </div>
                </div>`;
            document.getElementById('additional-agenda-rows').appendChild(row);
            agendaIndex++;
        });

        // Add Bintang Tamu Functionality
        document.getElementById('add-bintang-tamu').addEventListener('click', function() {
            const row = document.createElement('div');
            row.classList.add('col');
            row.innerHTML = `
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder="Nama Bintang Tamu" name="bintang_tamu[]" />
                    <label class="did-floating-label">Nama Bintang Tamu</label>
                </div>`;
            document.getElementById('bintang-tamu-container').appendChild(row);
        });
    </script>
@endsection
