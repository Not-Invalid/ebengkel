@extends('layouts.partials.sidebar')

@section('title')
  eBengkelku | Order Detail
@stop
<style>
  .cart-item-details h6 {
    font-size: 1rem;
    /* Adjust the product name font size for mobile */
  }

  .cart-item-details p {
    font-size: 0.9rem;
    /* Adjust the price and total price font size */
  }

  .cart-item-image img {
    width: 80px;
    /* Make image smaller on mobile */
    height: 80px;
  }

  /* Adding spacing to separate total price and individual price on mobile */
  .cart-item-details .d-flex.flex-column {
    gap: 10px;
    /* Adds space between the price and total price */
  }

  /* Adjust spacing for quantity (x1) on mobile */
  .product-quantity {
    font-size: 0.9rem;
    /* Adjust font size */
    padding-left: 10px;
    /* Add padding left to separate it */
  }

  .info-p {
    margin-bottom: 0;
    font-size: 14px;
    color: gray;
  }
</style>
<!-- JavaScript to dynamically change button text -->

@section('content')
  <section class="mt-5">
    <div class="py-3">
      <div class="container">
        <div class="d-flex justify-content-between">
          <nav class="pt-3"
            style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
            aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a class="nav-link d-inline-flex align-items-center"
                  href="{{ route('my-order.index') }}">My Order</a></li>
              <li class="breadcrumb-item active d-inline-flex align-items-center" aria-current="page">
                Order Detail</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section>
  <div class="container mt-4">
    <div class="card shadow-lg rounded p-4">
      <h4 class="mb-4 text-center">Order Details</h4>

      <div class="order-details">
        <div class="row mb-3">
          <div class="col-md-6">
            <p><strong>Status:</strong> <span class="badge bg-warning text-dark">Dikemas</span></p>
          </div>
          <div class="col-md-6 text-md-end">
            <p><strong>Total Price:</strong> <span class="text-primary fw-bold">Rp 75.000</span></p>
          </div>
        </div>

        <h6 class="mt-4"><strong>Product Details:</strong></h6>
        <div class="order-items">
          <!-- Product 1 -->
          <div class="cart-item d-flex flex-column flex-md-row align-items-center mb-3 p-3 border rounded shadow-sm">
            <div class="cart-item-image me-3 mb-3 mb-md-0">
              <img src="{{ asset('assets/images/components/image.png') }}" alt="Product Image" class="img-fluid rounded"
                style="width: 100px; height: 100px; object-fit: cover;" />
            </div>
            <div class="cart-item-details flex-grow-1">
              <h6 class="mb-1">Product Name 1</h6>
              <div class="d-flex justify-content-between align-items-center">
                <p class="text-muted mb-1">Workshop Name 1</p>
                <span class="product-quantity ms-3">x1</span> <!-- Added margin to separate quantity -->
              </div>
              <div class="d-flex flex-column flex-md-row justify-content-between">
                <p class="text-primary fw-bold mb-1">Rp 50.000</p>
                <p class="fw-bold mb-1">Total: Rp 50.000</p> <!-- Total price -->
              </div>
            </div>
          </div>

          <!-- Product 2 -->
          <div class="cart-item d-flex flex-column flex-md-row align-items-center mb-3 p-3 border rounded shadow-sm">
            <div class="cart-item-image me-3 mb-3 mb-md-0">
              <img src="{{ asset('assets/images/components/image.png') }}" alt="Product Image" class="img-fluid rounded"
                style="width: 100px; height: 100px; object-fit: cover;" />
            </div>
            <div class="cart-item-details flex-grow-1">
              <h6 class="mb-1">Product Name 2</h6>
              <div class="d-flex justify-content-between align-items-center">
                <p class="text-muted mb-1">Workshop Name 1</p>
                <span class="product-quantity ms-3">x1</span> <!-- Quantity with added margin -->
              </div>
              <div class="d-flex flex-column flex-md-row justify-content-between">
                <p class="text-primary fw-bold mb-1">Rp 25.000</p>
                <p class="fw-bold mb-1">Total: Rp 25.000</p> <!-- Total price for Product 2 -->
              </div>
            </div>
          </div>
        </div>
        <div class="mt-4">
          <h6><strong>Order Notes:</strong></h6>
          <p>No additional notes for this order.</p>
        </div>
        <div class="mt-4">
          <h6><strong>Shipping info:</strong></h6>
          <div class="p-3 border rounded bg-light mb-3">
            <p class="mb-0 fw-bold" id="selectedShippingName">Reguler</p>
            <p class="mb-0 text-muted" id="selectedShippingCourier" style="font-size: 14px;">J&T Express</p>
          </div>
          <div class="p-3 border rounded bg-light mb-3">
            <p class="mb-0 fw-bold" id="selectedShippingName">Penerima <span class="text-muted fw-light"
                style="font-size: 14px;">08123456789</span></p>
            <p class="mb-0 text-muted" id="selectedShippingCourier" style="font-size: 14px;">Rumah</p>
            <p class="mb-0 text-muted" style="font-size: 12px;" id="deliveryDate">Jl. Lorem ipsum dolor sit amet
              consectetur adipisicing elit.</p>
          </div>
        </div>
        <div class="p-3 border rounded bg-light">
          <!-- First Three Rows (Initially Visible) -->
          <div class="row">
            <div class="col-6">
              <p><strong>ID Order</strong></p>
            </div>
            <div class="col-6 text-end">
              <p>12345
                <span>
                  <a href="" target="_blank" class="btn btn-custom-2"
                    style="padding: 1px 5px !important; background-color:white !important; border-color:grey !important; color:black !important;">
                    Salin
                  </a>
                </span>
              </p>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <p class="info-p">Payment Method</p>
            </div>
            <div class="col-6 text-end">
              <p class="info-p">Bank BRI</p>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <p class="info-p">Proof of Payment</p>
            </div>
            <div class="col-6 text-end">
              <!-- Proof of Payment Section -->
              <p class="info-p d-flex align-items-center justify-content-end">
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#paymentProofModal"
                  style="text-decoration: none; display: flex; align-items: center;">
                  Lihat <span class="fs-5 ms-2">></span>
                </a>
              </p>

            </div>
          </div>

          <!-- Additional Info (Initially Hidden) -->
          <div class="collapse" id="additionalInfo">
            <hr>
            <div class="row">
              <div class="col-6">
                <p class="info-p">Order Time</p>
              </div>
              <div class="col-6 text-end">
                <p class="info-p">2024-12-05 10:00</p>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <p class="info-p">Payment Time</p>
              </div>
              <div class="col-6 text-end">
                <p class="info-p">2024-12-05 11:00</p>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <p class="info-p">Shipping Time</p>
              </div>
              <div class="col-6 text-end">
                <p class="info-p">2024-12-06 08:00</p>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <p class="info-p">Completed Order Time</p>
              </div>
              <div class="col-6 text-end">
                <p class="info-p">2024-12-06 12:00</p>
              </div>
            </div>
          </div>

          <!-- Toggle Button for Collapse (Centered with Dynamic Text) -->
          <div class="text-center mt-2">
            <hr>
            <button class="btn btn-link" style="text-decoration: none;" type="button" data-bs-toggle="collapse"
              data-bs-target="#additionalInfo" aria-expanded="false" aria-controls="additionalInfo" id="toggleButton">
              Lihat Semua
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal for Proof of Payment -->
  <div class="modal fade" id="paymentProofModal" tabindex="-1" aria-labelledby="paymentProofModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="paymentProofModalLabel">Proof of Payment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="d-flex justify-content-center">
            <!-- Image inside the modal, with a max width and height set to ensure zooming functionality -->
            <img src="{{ asset('assets/images/components/image.png') }}" alt="Bukti Pembayaran" class="img-fluid"
              id="paymentImage" style="max-width: 100%; max-height: 400px; cursor: zoom-in;">
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const collapseElement = document.getElementById('additionalInfo');
    const toggleButton = document.getElementById('toggleButton');

    collapseElement.addEventListener('show.bs.collapse', function() {
      toggleButton.innerHTML = 'Lihat Lebih Sedikit';
    });

    collapseElement.addEventListener('hide.bs.collapse', function() {
      toggleButton.innerHTML = 'Lihat Semua';
    });
  </script>
  <script>
    // Handle zoom in/out on image click
    const paymentImage = document.getElementById('paymentImage');

    paymentImage.addEventListener('click', function() {
      const currentZoom = parseFloat(window.getComputedStyle(paymentImage).getPropertyValue('transform').split(',')[
        3]) || 1;
      const newZoom = currentZoom === 1 ? 2 : 1; // Toggle between zoom in (2x) and normal (1x)
      paymentImage.style.transform = `scale(${newZoom})`;
      paymentImage.style.transition = 'transform 0.3s ease';
    });
  </script>

@endsection
