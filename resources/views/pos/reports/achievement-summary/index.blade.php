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
  <div class="row">
    <div class="col">
      <div class="card shadow">
        <div class="card-header">
          <h4 class="card-title">Achievement Summary 2023 - 2024</h4>
        </div>
        <div class="card-body">
          <canvas id="line" width="615" height="307"
            style="display: block; box-sizing: border-box; height: 246px; width: 492px;"></canvas>
        </div>
      </div>
    </div>
  </div>
  <div class="row" style="margin-bottom: 15px;">
    <!-- Total Revenue -->
    <div class="col-6 col-md-6 col-lg-3 mb-3 mb-md-3">
      <div class="cart-item d-flex flex-column flex-sm-row align-items-center p-3 border rounded shadow">
        <div class="cart-item-image me-3 mb-sm-0">
          <!-- Font Awesome Icon for Revenue -->
          <i class="fas fa-dollar-sign text-primary" style="font-size: 20px; padding:20px;"></i>
        </div>

        <div class="cart-item-details flex-grow-1">
          <p class="header">
            Total Revenue
          </p>
          <p class="text-primary fw-bold mb-1">Rp 3.000.000</p>
        </div>
      </div>
    </div>

    <!-- Total Expenses -->
    <div class="col-6 col-md-6 col-lg-3 mb-3 mb-md-3">
      <div class="cart-item d-flex flex-column flex-sm-row align-items-center p-3 border rounded shadow">
        <div class="cart-item-image me-3 mb-sm-0">
          <!-- Font Awesome Icon for Expenses -->
          <i class="fas fa-credit-card text-primary" style="font-size: 20px; padding:20px;"></i>
        </div>

        <div class="cart-item-details flex-grow-1">
          <p class="header">
            Total Expenses
          </p>
          <p class="text-primary fw-bold mb-1">Rp 3.000.000</p>
        </div>
      </div>
    </div>

    <!-- Total Sales -->
    <div class="col-6 col-md-6 col-lg-3 mb-3 mb-md-3">
      <div class="cart-item d-flex flex-column flex-sm-row align-items-center p-3 border rounded shadow">
        <div class="cart-item-image me-3 mb-sm-0">
          <!-- Font Awesome Icon for Sales -->
          <i class="fas fa-shopping-cart text-primary" style="font-size: 20px; padding:20px;"></i>
        </div>

        <div class="cart-item-details flex-grow-1">
          <p class="header">
            Total Sales
          </p>
          <p class="text-primary fw-bold mb-1">300 Sales</p>
        </div>
      </div>
    </div>

    <!-- Total Customer -->
    <div class="col-6 col-md-6 col-lg-3 mb-3 mb-md-3">
      <div class="cart-item d-flex flex-column flex-sm-row align-items-center p-3 border rounded shadow">
        <div class="cart-item-image me-3 mb-sm-0">
          <!-- Font Awesome Icon for Customers -->
          <i class="fas fa-users text-primary" style="font-size: 20px; padding:20px;"></i>
        </div>

        <div class="cart-item-details flex-grow-1">
          <p class="header">
            Total Customer
          </p>
          <p class="text-primary fw-bold mb-1">100 Customer</p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="card shadow">
        <div class="card-header">
          <h4 class="card-title">Best Selling 2024</h4>
        </div>
        <div class="card-body">
          <div class="d-flex justify-between">
            <div class="d-flex justify-start mb-4">
              <select name="per_page" id="perPage" class="form-control w-auto mx-2">
                <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
              </select>
            </div>
            <div class="d-flex justify-center w-100 mx-2 mb-4">
              <input type="text" id="search" class="form-control w-60" placeholder="Search">
            </div>
          </div>

          <div class="table-responsive bg-white rounded shadow">
            <table class="table table-bordered table-striped text-center">
              <thead class="bg-light-grey text-white">
                <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">Name</th>
                  <th class="text-center">Type</th>
                  <th class="text-center">Stock</th>
                  <th class="text-center">Sold</th>
                  <th class="text-center">Price</th>
                  <th class="text-center">Revenue</th>
                </tr>
              </thead>
              <tbody id="achievement-summary-table-body">
                {{-- @if ($service->isEmpty()) --}}
                {{-- <tr>
                                    <td colspan="6" class="text-center">Data Not Found</td>
                                </tr> --}}
                {{-- @else
                                @foreach ($service as $index => $services) --}}
                <tr>
                  <td>1</td>
                  <td>Oli 15W-40</td>
                  <td>Product</td>
                  <td>30</td>
                  <td>20</td>
                  <td>Rp 150.000</td>
                  <td>Rp 3.000.000</td>
                </tr>
                {{-- @endforeach
                            @endif --}}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


  {{-- <div class="d-flex justify-content-end mt-4">
    <nav aria-label="Page navigation">
        <ul class="pagination">
            @if ($service->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link"><i class="fa-solid fa-chevron-left"></i></span>
                </li>
            @else
                <li class="page-item">
                    <a href="{{ $service->previousPageUrl() }}" class="page-link"><i
                            class="fa-solid fa-chevron-left"></i></a>
                </li>
            @endif

            @foreach ($service->getUrlRange(1, $service->lastPage()) as $page => $url)
                @if ($page == $service->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
                @endif
            @endforeach

            @if ($service->hasMorePages())
                <li class="page-item">
                    <a href="{{ $service->nextPageUrl() }}" class="page-link"><i
                            class="fa-solid fa-chevron-right"></i></a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link"><i class="fa-solid fa-chevron-right"></i></span>
                </li>
            @endif
        </ul>
    </nav>
</div> --}}

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    var ctx = document.getElementById('line').getContext('2d');
    var lineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: @json($chartData['labels']),
        datasets: [{
            label: '2023 Sales',
            data: @json($chartData['data']['2023']),
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderWidth: 2,
            fill: true
          },
          {
            label: '2024 Sales',
            data: @json($chartData['data']['2024']),
            borderColor: 'rgba(153, 102, 255, 1)',
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
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
