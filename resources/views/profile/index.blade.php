@extends('layouts.partials.sidebar')

@section('title')
    eBengkelku | Profile
@stop

@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <h4>{{ __('messages.profile.profile_info') }}</h4>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="d-flex justify-content-center mb-4">
                <label for="upload-photo" style="cursor: pointer;">
                    <img src="{{ isset($data_pelanggan) && $data_pelanggan->foto_pelanggan ? url($data_pelanggan->foto_pelanggan) : asset('assets/images/components/avatar.png') }}"
                        alt="Profile Picture" style="width: 150px; height: 150px; object-fit: cover;"
                        class="rounded-circle profile-pic" id="profilePic">
                </label>
                <input type="file" id="upload-photo" name="foto" style="display: none;" onchange="previewImage(event)"
                    disabled>
            </div>

            <div class="row">
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="name" name="nama"
                            value="{{ $data_pelanggan->nama_pelanggan }}" readonly />
                        <label class="did-floating-label">{{ __('messages.profile.full_name') }}</label>
                    </div>
                </div>
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="email" placeholder=" " id="email" name="email"
                            value="{{ $data_pelanggan->email_pelanggan }}" readonly />
                        <label class="did-floating-label">{{ __('messages.profile.email') }}</label>
                    </div>
                </div>
            </div>

            <div class="did-floating-label-content">
                <input class="did-floating-input" type="text" placeholder=" " id="phone" name="telp"
                    value="{{ $data_pelanggan->telp_pelanggan }}" readonly required pattern="[0-9]*"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                <label class="did-floating-label">{{ __('messages.profile.phone') }}</label>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-outline-secondary" id="editBtn"
                    onclick="toggleEdit()">{{ __('messages.profile.edit') }}</button>
                <button type="submit" id="saveBtn" class="btn btn-primary"
                    style="display: none;">{{ __('messages.profile.save') }}</button>
                <button type="button" id="cancelBtn" class="btn btn-danger mx-2" onclick="cancelEdit()"
                    style="display: none;">{{ __('messages.profile.cancel') }}</button>
            </div>
        </form>
    </div>

    <script>
        function toggleEdit() {
            const isReadOnly = document.getElementById("name").readOnly;
            document.querySelectorAll(".did-floating-input").forEach(input => {
                input.readOnly = !isReadOnly;
            });
            document.getElementById("upload-photo").disabled = !isReadOnly;
            document.getElementById("editBtn").style.display = isReadOnly ? "none" : "inline-block";
            document.getElementById("saveBtn").style.display = isReadOnly ? "inline-block" : "none";
            document.getElementById("cancelBtn").style.display = isReadOnly ? "inline-block" : "none";
        }

        function cancelEdit() {
            document.getElementById("name").value = "{{ $data_pelanggan->nama_pelanggan }}";
            document.getElementById("email").value = "{{ $data_pelanggan->email_pelanggan }}";
            document.getElementById("phone").value = "{{ $data_pelanggan->telp_pelanggan }}";
            document.getElementById("profilePic").src = "{{ url($data_pelanggan->foto_pelanggan) }}";
            document.querySelectorAll(".did-floating-input").forEach(input => {
                input.readOnly = true;
            });
            document.getElementById("upload-photo").disabled = true;
            document.getElementById("editBtn").style.display = "inline-block";
            document.getElementById("saveBtn").style.display = "none";
            document.getElementById("cancelBtn").style.display = "none";
        }

        function previewImage(event) {
            const output = document.getElementById("profilePic");
            output.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>

@endsection
