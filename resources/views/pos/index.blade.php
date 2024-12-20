@extends('pos.layouts.app')

@section('title')
    eBengkelku | POS
@stop

@php
     $header = 'Dashboard';
@endphp

@section('content')
    <div class="row">
        <!-- Stat cards for Total Services, Products, Spareparts -->
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
                        <h4>Total Products</h4>
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
                        <h4>Total Spareparts</h4>
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
                        <h4>Orders This Month</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalOrderOnline }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4>Online Orders</h4>
                    <div class="card-header-action">
                        <a href="{{ route('pos.order-online', ['id_bengkel' => $bengkel->id_bengkel]) }}" class="btn btn-primary">View More <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive table-invoice">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">Order ID</th>
                                    <th class="text-center">Customer</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Order Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($orders && $orders->isNotEmpty())
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="text-center">{{ $order->order_id }}</td>
                                            <td class="font-weight-600 text-center">{{ $order->atas_nama }}</td>
                                            <td class="d-flex align-items-center justify-content-center">
                                                @php
                                                    $statusNames = [
                                                        'PENDING' => 'Belum Dibayar',
                                                        'Waiting_Confirmation' => 'Menunggu Konfirmasi',
                                                        'DIKEMAS' => 'Dikemas',
                                                        'DIKIRIM' => 'Dikirim',
                                                        'SELESAI' => 'Selesai'
                                                    ];
                                                @endphp

                                                @if (array_key_exists($order->status_order, $statusNames))
                                                    <div class="badge fixed-width
                                                        @if ($order->status_order == 'PENDING') badge-secondary
                                                        @elseif ($order->status_order == 'Waiting_Confirmation') badge-warning
                                                        @elseif ($order->status_order == 'DIKEMAS') badge-primary
                                                        @elseif ($order->status_order == 'DIKIRIM') badge-info
                                                        @elseif ($order->status_order == 'SELESAI') badge-success
                                                        @else badge-secondary
                                                        @endif">
                                                        {{ $statusNames[$order->status_order] }}
                                                    </div>
                                                @else
                                                    <div class="badge badge-secondary">Unknown</div>
                                                @endif
                                            </td>

                                            <td class="text-center">{{ \Carbon\Carbon::parse($order->tanggal)->format('d-m-Y') }}</td>
                                            <td class="d-flex align-items-center justify-content-center">
                                                <a href="{{ route('pos.order-online.edit', ['id_bengkel' => $order->id_bengkel, 'order_id' => $order->order_id]) }}" class="btn btn-primary">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">No orders found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card gradient-bottom">
                <div class="card-header">
                    <h4>Top 5 Products</h4>
                    <div class="card-header-action dropdown">
                        <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">{{ ucfirst($periodeProduk) }}</a>
                        <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                            <li class="dropdown-title">Select Periode</li>
                            <li><a href="{{ route('pos.index', ['id_bengkel' => $bengkel->id_bengkel, 'periodeProduk' => 'day', 'periodeSpareParts' => $periodeSpareParts]) }}" class="dropdown-item {{ $periodeProduk == 'day' ? 'active' : '' }}">Today</a></li>
                            <li><a href="{{ route('pos.index', ['id_bengkel' => $bengkel->id_bengkel, 'periodeProduk' => 'week', 'periodeSpareParts' => $periodeSpareParts]) }}" class="dropdown-item {{ $periodeProduk == 'week' ? 'active' : '' }}">Week</a></li>
                            <li><a href="{{ route('pos.index', ['id_bengkel' => $bengkel->id_bengkel, 'periodeProduk' => 'month', 'periodeSpareParts' => $periodeSpareParts]) }}" class="dropdown-item {{ $periodeProduk == 'month' ? 'active' : '' }}">Month</a></li>
                            <li><a href="{{ route('pos.index', ['id_bengkel' => $bengkel->id_bengkel, 'periodeProduk' => 'year', 'periodeSpareParts' => $periodeSpareParts]) }}" class="dropdown-item {{ $periodeProduk == 'year' ? 'active' : '' }}">This Year</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body" id="top-5-scroll" tabindex="2" style="height: 315px; overflow: hidden; outline: none;">
                    <ul class="list-unstyled list-unstyled-border">
                        @php
                            $maxQty = $topProducts->max();
                        @endphp
                        @foreach ($topProducts as $productId => $qty)
                            @php
                                $product = \App\Models\Product::find($productId);
                                $width = $maxQty > 0 ? round(($qty / $maxQty) * 100) : 0;
                            @endphp
                            @if ($product)
                                <li class="media d-flex justify-content-center align-items-center">
                                    <img class="mr-3 rounded bg-info" width="55" src="{{ asset('assets/images/bg/car.png') }}" alt="product">
                                    <div class="media-body">
                                        <div class="float-right"><div class="font-weight-600 text-muted text-small">{{ $qty }} Sales</div></div>
                                        <div class="media-title">{{ $product->nama_produk ?? 'Unknown Product' }}</div>
                                        <div class="mt-1">
                                            <div class="budget-price">
                                                <div class="budget-price-square bg-primary" data-width="{{ $width }}%" style="width: {{ $width }}%;"></div>
                                                <div class="budget-price-label">{{ $qty }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="card-footer pt-3 d-flex justify-content-center">
                    <div class="budget-price justify-content-center">
                        <div class="budget-price-square bg-primary" data-width="20" style="width: 20px;"></div>
                        <div class="budget-price-label">Online</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card gradient-bottom">
                <div class="card-header">
                    <h4>Top 5 Spareparts</h4>
                    <div class="card-header-action dropdown">
                        <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">{{ ucfirst($periodeSpareParts) }}</a>
                        <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                            <li class="dropdown-title">Select Periode</li>
                            <li><a href="{{ route('pos.index', ['id_bengkel' => $bengkel->id_bengkel, 'periodeSpareParts' => 'day', 'periodeProduk' => $periodeProduk]) }}" class="dropdown-item {{ $periodeSpareParts == 'day' ? 'active' : '' }}">Today</a></li>
                            <li><a href="{{ route('pos.index', ['id_bengkel' => $bengkel->id_bengkel, 'periodeSpareParts' => 'week', 'periodeProduk' => $periodeProduk]) }}" class="dropdown-item {{ $periodeSpareParts == 'week' ? 'active' : '' }}">Week</a></li>
                            <li><a href="{{ route('pos.index', ['id_bengkel' => $bengkel->id_bengkel, 'periodeSpareParts' => 'month', 'periodeProduk' => $periodeProduk]) }}" class="dropdown-item {{ $periodeSpareParts == 'month' ? 'active' : '' }}">Month</a></li>
                            <li><a href="{{ route('pos.index', ['id_bengkel' => $bengkel->id_bengkel, 'periodeSpareParts' => 'year', 'periodeProduk' => $periodeProduk]) }}" class="dropdown-item {{ $periodeSpareParts == 'year' ? 'active' : '' }}">This Year</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body" id="top-5-scroll" tabindex="2" style="height: 315px; overflow: hidden; outline: none;">
                    <ul class="list-unstyled list-unstyled-border">
                        @php
                            $maxQtySpareParts = $topSpareParts->max();
                        @endphp
                        @foreach ($topSpareParts as $sparePartId => $qty)
                            @php
                                $sparePart = \App\Models\SpareParts::find($sparePartId);
                                $width = $maxQtySpareParts > 0 ? round(($qty / $maxQtySpareParts) * 100) : 0;
                            @endphp
                            @if ($sparePart)
                                <li class="media d-flex justify-content-center align-items-center">
                                    <img class="mr-3 rounded bg-info" width="55" src="{{ asset('assets/images/bg/car.png') }}" alt="sparepart">
                                    <div class="media-body">
                                        <div class="float-right"><div class="font-weight-600 text-muted text-small">{{ $qty }} Sales</div></div>
                                        <div class="media-title">{{ $sparePart->nama_spare_part ?? 'Unknown Spare Part' }}</div>
                                        <div class="mt-1">
                                            <div class="budget-price">
                                                <div class="budget-price-square bg-primary" data-width="{{ $width }}%" style="width: {{ $width }}%;"></div>
                                                <div class="budget-price-label">{{ $qty }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="card-footer pt-3 d-flex justify-content-center">
                    <div class="budget-price justify-content-center">
                        <div class="budget-price-square bg-primary" data-width="20" style="width: 20px;"></div>
                        <div class="budget-price-label">Online</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
