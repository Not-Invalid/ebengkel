@extends('pos.layouts.app')

@section('title')
    eBengkelku | POS
@stop

@php
    $header = 'Achievement Summary';
@endphp
<style>
    .cart-item {
        border-radius: 10px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        position: relative;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        width: 100%;
    }

    p.header {
        font-size: 14px;
        font-weight: 600;
        margin: 0%;
    }

    .cart-item-details {
        margin-left: 5px
    }

    .cart-item img {
        border-radius: 8px;
        height: 60px;
        width: 60px;
    }
</style>
@section('content')
    <div class="row d-flex justify-content-center my-2">

        <div class="col-6 col-md-6 col-lg-3 mb-3 mb-md-3">
            <div class="cart-item d-flex flex-column flex-sm-row align-items-center p-3 border rounded shadow">
                <div class="cart-item-image me-3 mb-sm-0">

                    <i class="fas fa-wallet text-primary" style="font-size: 20px; padding:20px;"></i>
                </div>

                <div class="cart-item-details flex-grow-1">
                    <p class="header">
                        Total Revenue
                    </p>
                    <p class="text-primary fw-bold mb-1">{{ formatRupiah($totalRevenue) }}</p>
                </div>
            </div>
        </div>


        <div class="col-6 col-md-6 col-lg-3 mb-3 mb-md-3">
            <div class="cart-item d-flex flex-column flex-sm-row align-items-center p-3 border rounded shadow">
                <div class="cart-item-image me-3 mb-sm-0">

                    <i class="fas fa-credit-card text-primary" style="font-size: 20px; padding:20px;"></i>
                </div>

                <div class="cart-item-details flex-grow-1">
                    <p class="header">
                        Total Expenses
                    </p>
                    <p class="text-primary fw-bold mb-1">{{ formatRupiah($totalExpenses) }}</p>
                </div>
            </div>
        </div>


        <div class="col-6 col-md-6 col-lg-3 mb-3 mb-md-3">
            <div class="cart-item d-flex flex-column flex-sm-row align-items-center p-3 border rounded shadow">
                <div class="cart-item-image me-3 mb-sm-0">

                    <i class="fas fa-shopping-cart text-primary" style="font-size: 20px; padding:20px;"></i>
                </div>

                <div class="cart-item-details flex-grow-1">
                    <p class="header">
                        Total Sales
                    </p>
                    <p class="text-primary fw-bold mb-1">{{ $totalQty }} Sales</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="card-title">Achievement Summary {{ $currentYear }}</h4>
                </div>
                <div class="card-body">
                    <canvas id="line" width="615" height="307"
                        style="display: block; box-sizing: border-box; height: 246px; width: 492px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('line').getContext('2d');
        var lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                        label: '{{ $currentYear }} Order Online',
                        data: @json($chartData['data']['current_year']['order_online']),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 2,
                        fill: true
                    },
                    {
                        label: '{{ $currentYear }} Order',
                        data: @json($chartData['data']['current_year']['order']),
                        borderColor: 'rgba(153, 102, 255, 1)',
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderWidth: 2,
                        fill: true
                    },
                    {
                        label: '{{ $currentYear }} Service',
                        data: @json($chartData['data']['current_year']['service']),
                        borderColor: 'rgba(255, 159, 64, 1)',
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderWidth: 2,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
