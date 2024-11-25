@extends('pos.layouts.app')

@section('title')
    Ebengkelku | Account Profile
@stop

@php
    $header = 'Account Profile';
@endphp

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">

@section('content')
<div class="page-heading">
    <section class="section mt-2">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="d-flex justify-content-center mb-4">
                                <img
                                    src="{{ isset($pegawai->foto_pegawai) ? url($pegawai->foto_pegawai) : asset('assets/images/components/avatar.png') }}"
                                    alt="Profile Picture" style="width: 150px; height: 150px; object-fit: cover;"
                                    class="rounded-circle profile-pic" id="profilePhoto" onclick="openModal()">
                            </div>
                            <h3 class="mt-3">{{ $pegawai->nama_pegawai }}</h3>
                            <p class="text-small">{{ $pegawai->role }}</p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12 col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('profile-pegawai.update', ['id_bengkel' => $bengkel->id_bengkel, 'id_pegawai' => $pegawai->id_pegawai]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="nama_pegawai" class="form-label">Name</label>
                                <input type="text" name="nama_pegawai" id="nama_pegawai" class="form-control" placeholder="Your Name" value="{{ $pegawai->nama_pegawai }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="email_pegawai" class="form-label">Email</label>
                                <input type="email" name="email_pegawai" id="email_pegawai" class="form-control" placeholder="Your Email" value="{{ $pegawai->email_pegawai }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="telp_pegawai" class="form-label">Phone</label>
                                <input type="text" name="telp_pegawai" id="telp_pegawai" class="form-control" placeholder="Your Phone" value="{{ $pegawai->telp_pegawai ?? 'Not Provided' }}" disabled oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                            <div class="form-group foto" id="fotoGroup" style="display: none;">
                                <label for="upload-photo" class="form-label">Profile Photo</label>
                                <input type="file" id="upload-photo" name="foto_pegawai" class="form-control" accept="image/*" onchange="previewImage(event)" disabled>
                            </div>

                            <div class="form-group">
                                <button type="button" id="editButton" class="btn btn-primary" onclick="enableEditing()">Edit Profile</button>
                                <button type="submit" id="saveButton" class="btn btn-primary d-none">Save</button>
                                <button type="button" id="cancelButton" class="btn btn-danger d-none" onclick="cancelEditing()">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<script>
    function enableEditing() {
        document.getElementById('nama_pegawai').disabled = false;
        document.getElementById('email_pegawai').disabled = false;
        document.getElementById('telp_pegawai').disabled = false;
        document.getElementById('upload-photo').disabled = false;

        document.getElementById('fotoGroup').style.display = "block";
        document.getElementById('saveButton').classList.remove('d-none');
        document.getElementById('cancelButton').classList.remove('d-none');
        document.getElementById('editButton').classList.add('d-none');
    }

    function cancelEditing() {
        document.getElementById('nama_pegawai').disabled = true;
        document.getElementById('email_pegawai').disabled = true;
        document.getElementById('telp_pegawai').disabled = true;
        document.getElementById('upload-photo').disabled = true;

        document.getElementById('fotoGroup').style.display = "none";
        document.getElementById('saveButton').classList.add('d-none');
        document.getElementById('cancelButton').classList.add('d-none');
        document.getElementById('editButton').classList.remove('d-none');

        document.getElementById('nama_pegawai').value = "{{ $pegawai->nama_pegawai }}";
        document.getElementById('email_pegawai').value = "{{ $pegawai->email_pegawai }}";
        document.getElementById('telp_pegawai').value = "{{ $pegawai->telp_pegawai ?? 'Not Provided' }}";
        document.getElementById('profilePhoto').src = "{{ $pegawai->foto_pegawai ?? asset('assets/images/components/avatar.png') }}";
    }

    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            document.getElementById('profilePhoto').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

</script>
@endsection
