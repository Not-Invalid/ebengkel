@extends('pos.layouts.app')

@section('title')
    Ebengkelku | Management Staff - Edit
@stop

@php
    $header = 'Management Staff - Edit';
@endphp

@section('content')

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                confirmButtonColor: "#3085d6",
                text: '{{ session('success') }}'
            });
        });
    </script>
@endif

<div class="section-body">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header">
                    <h4>Edit Staff for Bengkel: {{ $bengkel->nama_bengkel }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('pos.management-user.update', ['id_bengkel' => $bengkel->id_bengkel, 'id_pegawai' => $pegawai->id_pegawai]) }}" method="POST">
                        @csrf

                        <!-- Nama Pegawai -->
                        <div class="form-group">
                            <label for="nama_pegawai">Nama Pegawai</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai" required value="{{ old('nama_pegawai', $pegawai->nama_pegawai) }}">
                            </div>
                        </div>

                        <!-- Email Pegawai -->
                        <div class="form-group">
                            <label for="email_pegawai">Email Pegawai</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                </div>
                                <input type="email" class="form-control" id="email_pegawai" name="email_pegawai" required value="{{ old('email_pegawai', $pegawai->email_pegawai) }}">
                            </div>
                        </div>

                        <!-- No Telp Pegawai -->
                        <div class="form-group">
                            <label for="telp_pegawai">No Telp Pegawai</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control" id="telp_pegawai" name="telp_pegawai" required value="{{ old('telp_pegawai', $pegawai->telp_pegawai) }}">
                            </div>
                        </div>

                        <!-- Role Pegawai -->
                        <div class="form-group">
                            <label for="role">Role Pegawai</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-user-tag"></i>
                                    </div>
                                </div>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="Administrator" {{ $pegawai->role == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                                    <option value="Kasir" {{ $pegawai->role == 'Kasir' ? 'selected' : '' }}>Kasir</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{ route('pos.management-user', ['id_bengkel' => $bengkel->id_bengkel]) }}" class="btn btn-danger ml-2">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
