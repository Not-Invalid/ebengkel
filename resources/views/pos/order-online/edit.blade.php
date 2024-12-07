@extends('pos.layouts.app')

@section('title')
    eBengkelku | POS
@stop

@php
    $header = 'Edit Order Online';
@endphp
@section('content')
    <div class="container">
        <h3>Edit Order and Invoice</h3>

        <form
            action="{{ route('pos.order-online.update', ['id_bengkel' => $bengkel->id_bengkel, 'id_order' => $order->id]) }}"
            method="POST">
            @csrf
            <div class="form-group">
                <label for="status_order">Status Order</label>
                <select name="status_order" id="status_order" class="form-control" required>
                    <option value="PENDING" {{ $order->status_order == 'PENDING' ? 'selected' : '' }}>Pending</option>
                    <option value="COMPLETED" {{ $order->status_order == 'COMPLETED' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status_invoice">Status Invoice</label>
                <select name="status_invoice" id="status_invoice" class="form-control" required>
                    <option value="PENDING" {{ $order->invoice->status_invoice == 'PENDING' ? 'selected' : '' }}>Pending
                    </option>
                    <option value="RECEIVED" {{ $order->invoice->status_invoice == 'RECEIVED' ? 'selected' : '' }}>Received
                    </option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
