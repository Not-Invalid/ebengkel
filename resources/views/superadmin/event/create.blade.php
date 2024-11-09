@extends('superadmin.layouts.app')
@section('title')
    eBengkel | Event Data
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
            <h4>Add New Event</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('event-store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-4">
                    <div class="upload-box">
                        <label for="image_cover" class="upload-label">Cover Photo</label>
                        <input type="file" class="file-input" name="image_cover" id="image_cover"
                            onchange="previewImage('image_cover', 'coverPreview')">
                        <div class="preview-container d-flex justify-content-center">
                            <img id="coverPreview" src="" alt="Cover Photo Preview" class="image-preview"
                                style="display: none; width: 200px; margin-top: 10px;">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Nama Event -->
                    <div class="col">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="text" placeholder=" " id="nama_event" name="nama_event" />
                            <label class="did-floating-label">Nama Event</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Event Start Date -->
                    <div class="col">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="date" placeholder=" " id="event_start_date" name="event_start_date" />
                            <label class="did-floating-label">Event Start Date</label>
                        </div>
                    </div>

                    <!-- Event End Date -->
                    <div class="col">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="date" placeholder=" " id="event_end_date" name="event_end_date" />
                            <label class="did-floating-label">Event End Date</label>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="did-floating-label-content">
                    <textarea class="did-floating-input" placeholder=" " rows="4" id="deskripsi" name="deskripsi" style="height: 100px"></textarea>
                    <label class="did-floating-label">Deskripsi</label>
                </div>

                <!-- Alamat Event -->
                <div class="did-floating-label-content">
                    <textarea class="did-floating-input" placeholder=" " rows="4" id="alamat_event" name="alamat_event" style="height: 100px"></textarea>
                    <label class="did-floating-label">Alamat Event</label>
                </div>

                <div class="row">
                    <!-- Lokasi -->
                    <div class="col">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="text" placeholder=" " id="lokasi" name="lokasi" />
                            <label class="did-floating-label">Lokasi</label>
                        </div>
                    </div>

                    <!-- Tipe Harga -->
                    <div class="col">
                        <div class="did-floating-label-content">
                            <select class="did-floating-input" id="tipe_harga" name="tipe_harga" onchange="toggleHargaInput()">
                                <option value="" disabled selected>Pilih Tipe Harga</option>
                                <option value="Gratis">Gratis</option>
                                <option value="Berbayar">Berbayar</option>
                            </select>
                            <label class="did-floating-label">Tipe Harga</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Harga -->
                    <div class="col" id="hargaContainer" style="display: none;">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="text" placeholder=" " id="harga" name="harga" pattern="[0-9]*"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                            <label class="did-floating-label">Harga</label>
                        </div>
                    </div>
                </div>

                <!-- Agenda -->
                <div id="agenda-container">
                    <div class="row">
                        <div class="col">
                            <div class="did-floating-label-content">
                                <input class="did-floating-input" type="text" placeholder="" name="agenda_acara[0][judul]" />
                                <label class="did-floating-label">Judul Agenda</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="did-floating-label-content">
                                <input class="did-floating-input" type="time" placeholder="" name="agenda_acara[0][waktu]" />
                                <label class="did-floating-label">Waktu</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="additional-agenda-rows"></div>

                <!-- Add Agenda Button -->
                <div class="row my-1">
                    <div class="col text-left">
                        <button type="button" class="btn btn-custom-3" id="add-agenda">Add Agenda</button>
                    </div>
                </div>


                <!-- Bintang Tamu -->
                <div class="row mt-3"  id="bintang-tamu-container" >
                    <div class="col">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="text" placeholder="Nama Bintang Tamu" name="bintang_tamu[]" />
                            <label class="did-floating-label">Nama Bintang Tamu</label>
                        </div>
                    </div>
                </div>

                <div class="row my-1">
                    <div class="col text-left">
                        <button type="button" class="btn btn-custom-3" id="add-bintang-tamu">Add Bintang Tamu</button>
                    </div>
                </div>

                <div class="d-flex justify-content-start mt-3">
                    <button type="submit" class="btn btn-custom-icon me-2">
                        Simpan
                    </button>

                    <a href="{{ route('event-data') }}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(inputId, previewId) {
          const input = document.getElementById(inputId);
          const preview = document.getElementById(previewId);

          if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
              preview.src = e.target.result;
              preview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
          } else {
            preview.style.display = 'none';
            preview.src = '';
          }
        }
    </script>
    <script>
    function toggleHargaInput() {
        const tipeHarga = document.getElementById('tipe_harga').value;
        const hargaContainer = document.getElementById('hargaContainer');

        if (tipeHarga === 'Berbayar') {
            hargaContainer.style.display = 'block';
        } else {
            hargaContainer.style.display = 'none';
        }
    }

    const addBintangTamuButton = document.getElementById('add-bintang-tamu');
    if (addBintangTamuButton) {
        addBintangTamuButton.addEventListener('click', function () {
            const container = document.getElementById('bintang-tamu-container');
            const newRow = document.createElement('div');
            newRow.classList.add('row');
            newRow.innerHTML = `
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder="" name="bintang_tamu[]" />
                        <label class="did-floating-label">Nama Bintang Tamu</label>
                    </div>
                </div>
                <div class="col-auto">
                    <span class="remove-button" onclick="removeBintangTamu(this)"><i class="fas fa-trash mt-2"></i></span>
                </div>
            `;
            container.appendChild(newRow);
        });
    }

    const addAgendaButton = document.getElementById('add-agenda');
if (addAgendaButton) {
    addAgendaButton.addEventListener('click', function () {
        const container = document.getElementById('additional-agenda-rows');
        const newRow = document.createElement('div');
        newRow.classList.add('row');

        newRow.innerHTML = `
            <div class="col">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="text" placeholder="" name="agenda_acara[0][judul]" />
                    <label class="did-floating-label">Judul Agenda</label>
                </div>
            </div>
            <div class="col">
                <div class="did-floating-label-content">
                    <input class="did-floating-input" type="time" placeholder="" name="agenda_acara[0][waktu]"/>
                    <label class="did-floating-label">Waktu</label>
                </div>
            </div>
        `;

        container.appendChild(newRow);
    });
}

    </script>
@endsection
