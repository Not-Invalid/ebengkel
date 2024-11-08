@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Merk Mobil
@stop

@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <h4>Add New Merk</h4>
        <form class="py-4" action="{{ route('merk-mobil-send') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="nama_merk" name="nama_merk" />
                        <label class="did-floating-label">Nama Merk</label>
                    </div>
                </div>
            </div>

            <div class="mt-3 d-flex gap-2">
                <a href="{{ route('merk-mobil') }}" class="btn btn-cancel ms-2">
                    Cancel
                </a>
                <button type="submit" class="btn btn-custom-icon">
                    <i class='fas fa-floppy-disk fs-6'></i> Save
                </button>
            </div>
        </form>
    </div>
@endsection
