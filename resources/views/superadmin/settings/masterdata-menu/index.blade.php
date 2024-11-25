@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Master Menu
@stop

@section('content')
    <section class="section">
        <div class="d-flex justify-content-end mb-4">
            <a href="" class="btn btn-primary">Tambah Menu</a>
        </div>
        <table class="table table-bordered">
            <thead class="field-title">
                <tr>
                    <th>No</th>
                    <th>Nama Menu</th>
                    <th>Route</th>
                    <th>Icon</th>
                    <th>Action</th>
                </tr>
            <tbody>

            </tbody>
            </thead>
        </table>
    </section>
@endsection
