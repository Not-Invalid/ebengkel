@extends('superadmin.layouts.app')
@section('title')
    Ebengkelku | Superadmin
@stop
@section('content')

    <style>
        canvas {
            width: 100% !important;
            height: auto !important;
        }
    </style>

    {{-- @if (session('success'))
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
@endif --}}
    <div class="d-flex justify-content-center flex-wrap gap-4 mt-4">
        <!-- Box 1 -->
        <div class="bg-white shadow rounded-3 p-4 d-flex align-items-center gap-3">
            <div class="bg-emphasis shadow-lg rounded-circle d-flex justify-content-center align-items-center"
                style="width: 64px; height: 64px;">
                <i class="fas fa-wrench text-primary fs-2"></i>
            </div>
            <div>
                <div class="text-secondary">Bengkel Terdaftar</div>
                <div class="fs-4 fw-semibold text-dark">1000</div>
            </div>
        </div>

        <!-- Box 2 -->
        <div class="bg-white shadow rounded-3 p-4 d-flex align-items-center gap-3">
            <div class="bg-emphasis shadow-lg rounded-circle d-flex justify-content-center align-items-center"
                style="width: 64px; height: 64px;">
                <i class="fas fa-user text-primary fs-2"></i>
            </div>
            <div>
                <div class="text-secondary">User Terdaftar</div>
                <div class="fs-4 fw-semibold text-dark">30000</div>
            </div>
        </div>
    </div>


    {{-- Chart --}}
    {{-- <div class="bg-white shadow-sm rounded mt-4 p-4">
    <canvas id="transactionsChart" class="w-100"></canvas>
</div> --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('transactionsChart').getContext('2d');
        var months = {!! json_encode($months) !!};
        var transactionData = {!! json_encode($transactionData) !!};

        var transactionsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Jumlah Transaksi per Bulan',
                    data: transactionData,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    });
</script> --}}

@endsection
