@extends('pos.layouts.app')

@section('title')
    eBengkelku | POS
@stop

@php
    $header = 'Edit Expense Record';
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="text-danger">
                * Indicated required fields
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('pos.expense-record.update', ['id_bengkel' => $bengkel->id_bengkel, 'id_pengeluaran' => $expenseRecord->id_pengeluaran]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="id_jenis_pengeluaran">Jenis Pengeluaran<span class="text-danger">*</span></label>
                    <select class="form-control select2" id="id_jenis_pengeluaran" name="id_jenis_pengeluaran" required>
                        @foreach($expenseTypes as $type)
                            <option value="{{ $type->id_jenis_pengeluaran }}"
                                @if($type->id_jenis_pengeluaran == $expenseRecord->id_jenis_pengeluaran) selected @endif>
                                {{ $type->nama_jenis_pengeluaran }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="tanggal">Date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="tanggal" value="{{ $expenseRecord->tanggal }}" required>
                </div>

                <div class="form-group">
                    <label for="keterangan">Description</label>
                    <textarea class="form-control" name="keterangan" style="resize:none; height:80px !important;">{{ $expenseRecord->keterangan }}</textarea>
                </div>

                <div class="form-group">
                    <label for="nominal">Amount (Nominal)<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="nominal" value="{{ $expenseRecord->nominal }}" required>
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('pos.expense-record', ['id_bengkel' => $bengkel->id_bengkel]) }}" class="btn btn-cancel">Cancel</a>
                    <button type="submit" class="btn btn-custom-icon">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
