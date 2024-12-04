@extends('layouts.partials.sidebar')

@section('title')
  eBengkelku | Order Detail
@stop

@section('content')
  <div class="container mt-4">
    <div class="card shadow-lg rounded p-4">
      <h4 class="mb-4 text-center">Order Details</h4>

      <div class="order-details">
        <div class="row mb-3">
          <div class="col-md-6">
            <h5><strong>Order ID:</strong> 12345</h5>
            <p><strong>Status:</strong> <span class="badge bg-warning text-dark">Dikemas</span></p>
          </div>
          <div class="col-md-6 text-md-end">
            <h5><strong>Total Price:</strong> <span class="text-primary fw-bold">Rp 50,000</span></h5>
          </div>
        </div>

        <h6 class="mt-4">Product Details:</h6>
        <div class="order-items">
          <!-- Product 1 -->
          <div class="cart-item d-flex align-items-center mb-3 p-3 border rounded shadow-sm">
            <div class="cart-item-image me-3">
              <img src="{{ asset('assets/images/components/image.png') }}" alt="Product Image" class="img-fluid rounded"
                style="width: 100px; height: 100px; object-fit: cover;" />
            </div>
            <div class="cart-item-details flex-grow-1">
              <h6 class="mb-1">Product Name 1</h6>
              <p class="text-muted mb-1">Workshop Name 1</p>
              <p class="text-primary fw-bold mb-1"><span class="text-muted fw-light">Total 2 Pesanan: </span>Rp 50,000</p>
            </div>
          </div>

          <!-- Product 2 -->
          <div class="cart-item d-flex align-items-center mb-3 p-3 border rounded shadow-sm">
            <div class="cart-item-image me-3">
              <img src="{{ asset('assets/images/components/image.png') }}" alt="Product Image" class="img-fluid rounded"
                style="width: 100px; height: 100px; object-fit: cover;" />
            </div>
            <div class="cart-item-details flex-grow-1">
              <h6 class="mb-1">Product Name 2</h6>
              <p class="text-muted mb-1">Workshop Name 2</p>
              <p class="text-primary fw-bold mb-1"><span class="text-muted fw-light">Total 1 Pesanan: </span>Rp 25,000</p>
            </div>
          </div>
        </div>

        <div class="mt-4">
          <h6><strong>Shipping Address:</strong></h6>
          <div class="p-3 border rounded bg-light">
            <p>Jl. Merdeka No. 123, Jakarta, Indonesia</p>
          </div>
        </div>

        <div class="mt-4">
          <h6><strong>Order Notes:</strong></h6>
          <p>No additional notes for this order.</p>
        </div>

        <div class="mt-4 d-flex justify-content-between">
          <a href="{{ url('my/orders') }}" class="btn btn-outline-secondary btn-lg px-4">Back to Orders</a>
          <a href="{{ url('order/print') }}" class="btn btn-primary btn-lg px-4">Print Order</a>
        </div>
      </div>
    </div>
  </div>
@endsection
