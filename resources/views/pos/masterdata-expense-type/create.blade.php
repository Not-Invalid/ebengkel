@extends('pos.layouts.app')
@section('title')
    eBengkelku | POS
@stop
@php
    $header = 'Add New Expense Type';
@endphp
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="text-danger">
                * Indicated required fields
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('pos.expense-type.store', ['id_bengkel' => $bengkel->id_bengkel]) }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nama_jenis_pengeluaran">Expense Type Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama_jenis_pengeluaran" required>
                </div>
                <div class="form-group">
                    <label for="keterangan">Description</label>
                    <textarea class="form-control" style="resize:none; height:80px !important;" name="keterangan"></textarea>
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('pos.expense-type', ['id_bengkel' => $bengkel->id_bengkel]) }}" class="btn btn-cancel">Cancel</a>
                    <button type="submit" class="btn btn-custom-icon">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
