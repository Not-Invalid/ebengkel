@extends('pos.layouts.app')
@section('title')
    eBengkelku | POS
@stop
@php
    $header = 'Dashboard';
@endphp
@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1 shadow-sm">
                <div class="card-icon bg-primary">
                    <i class="fas fa-wrench"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Services</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalServices }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1 shadow-sm">
                <div class="card-icon bg-danger">
                    <i class="fas fa-box"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Product</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalProducts }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1 shadow-sm">
                <div class="card-icon bg-warning">
                    <i class="fas fa-cogs"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total SpareParts</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalSpareParts }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1 shadow-sm">
                <div class="card-icon bg-success">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Orders</h4>
                    </div>
                    <div class="card-body">
                        800
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
