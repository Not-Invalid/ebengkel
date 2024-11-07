@extends('superadmin.layouts.app')
@section('title')
    eBengkel | Create Event Admin
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Add New Event</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('event-store.admin') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Nama Event -->
                    <div class="col">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="text" placeholder=" " id="nama_event"
                                name="nama_event" />
                            <label class="did-floating-label">Nama Event</label>
                        </div>
                    </div>

                    <!-- Event Start Date -->
                    <div class="col">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input flatpickr-no-config" type="date" placeholder=" "
                                id="event_start" name="event_start" />
                            <label class="did-floating-label">Event Start</label>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="did-floating-label-content">
                    <textarea class="did-floating-input" placeholder=" " rows="4" id="deskripsi" name="deskripsi"
                        style="height: 100px"></textarea>
                    <label class="did-floating-label">Deskripsi</label>
                </div>


                <!-- Alamat Event -->
                <div class="did-floating-label-content">
                    <textarea class="did-floating-input" placeholder=" " rows="4" id="alamat_event" name="alamat_event"
                        style="height: 100px"></textarea>
                    <label class="did-floating-label">Alamat Event</label>
                </div>


                <div class="row">
                    <!-- Image Cover -->
                    <div class="col">
                        <input class="form-control" type="file" id="image_cover" name="image_cover"
                            style="border: 1px solid #3a6fb0" data-bs-toggle="tooltip" title="Input your event image!"
                            data-bs-placement="top" />
                    </div>

                    <!-- Harga -->
                    <div class="col">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input" type="text" placeholder=" " id="harga" pattern="[0-9]*"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');" name="harga" />
                            <label class="did-floating-label">Harga</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Event End Date -->
                    <div class="col">
                        <div class="did-floating-label-content">
                            <input class="did-floating-input flatpickr-no-config" type="date" placeholder=" "
                                id="event_end" name="event_end" />
                            <label class="did-floating-label">Event End</label>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="row mt-4">
                    <div class="col text-right">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
