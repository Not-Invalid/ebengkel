@extends('layouts.app')

@push('css')
  <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">
@endpush

@section('title')
  eBengkelku | Cart
@stop

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.item-select');
    const totalSelectedPriceEl = document.getElementById('total-selected-price');
    // const totalAmountEl = document.getElementById('total-amount');
    const selectedItemsListEl = document.getElementById('selected-items-list');

    // Function to update the total price of selected items and selected items list
    function updateTotalPrice() {
      let selectedItemIds = [];
      let totalPrice = 0;
      selectedItemsListEl.innerHTML = ''; // Clear the previous list

      checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
          const cartItem = checkbox.closest('.cart-item');
          const itemId = cartItem.getAttribute('data-id');
          selectedItemIds.push(itemId);

          const itemName = cartItem.querySelector('.cart-item-details h6').textContent;
          const itemPrice = parseFloat(cartItem.querySelector('.item-price').textContent.replace(/\./g, '')
            .replace('Rp', '').trim());
          const quantity = parseInt(cartItem.querySelector('.quantity-input').value);
          totalPrice += itemPrice * quantity;

          // Add selected item and quantity to the list
          const listItem = document.createElement('li');
          listItem.classList.add('d-flex', 'justify-content-between');
          listItem.innerHTML =
            `<span>${itemName} x ${quantity}</span><span>Rp ${itemPrice.toLocaleString('id-ID')}</span>`;
          selectedItemsListEl.appendChild(listItem);
        }
      });

      totalSelectedPriceEl.textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');

      // Send request to update the total amount
      // fetch('/cart/total-amount', {
      //     method: 'POST',
      //     headers: {
      //       'Content-Type': 'application/json',
      //       'X-CSRF-TOKEN': '{{ csrf_token() }}'
      //     },
      //     body: JSON.stringify({
      //       selectedItemIds
      //     })
      //   })
      //   .then(response => response.json())
      //   .then(data => {
      //     totalAmountEl.textContent = 'Rp ' + data.totalAmount.toLocaleString('id-ID');
      //   });
    }

    checkboxes.forEach(checkbox => {
      checkbox.addEventListener('change', updateTotalPrice);
    });

    // Handle increment and decrement of quantity
    document.querySelectorAll('.increment-quantity, .decrement-quantity').forEach(button => {
      button.addEventListener('click', function() {
        const cartItem = button.closest('.cart-item');
        const itemId = cartItem.getAttribute('data-id');
        const quantityInput = cartItem.querySelector('.quantity-input');
        let newQuantity = parseInt(quantityInput.value);
        const stock = parseInt(cartItem.getAttribute('data-stock')); // Get the stock value here

        // Handle Increment
        if (button.classList.contains('increment-quantity')) {
          // Check if the quantity exceeds the available stock
          if (newQuantity < stock) {
            newQuantity++;
          } else {
            // Show warning if quantity exceeds stock
            toastr.warning(`Maximum quantity for this product is ${stock}`);
            return; // Prevent increment if stock is exceeded
          }
        }

        // Handle Decrement
        if (button.classList.contains('decrement-quantity') && newQuantity > 1) {
          newQuantity--;
        }

        // Update the quantity input and send updated quantity to the server
        quantityInput.value = newQuantity;

        // Send the updated quantity to the server
        fetch(`/cart/update-quantity-ajax/${itemId}`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
              quantity: newQuantity
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              updateTotalPrice(); // Update the total price after quantity is updated
            } else {
              alert('Error updating quantity.');
            }
          });
      });
    });

    // Handle removing an item from the cart when the trash button is clicked
    document.querySelectorAll('.remove-item').forEach(button => {
      button.addEventListener('click', function() {
        const cartItem = button.closest('.cart-item');
        const itemId = cartItem.getAttribute('data-id');

        // Send AJAX request to remove item from the cart
        fetch(`/cart/remove/${itemId}`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              // Remove the item from the UI
              cartItem.remove();
              updateTotalPrice(); // Update the total price after removal

              // Display a success toast message
              toastr.success(data.message || 'Product removed from cart.');
            } else {
              toastr.error(data.message || 'Error removing product.');
            }
          });
      });
    });
  });
</script>

@section('content')
  <section class="section section-white"
    style="position: relative; overflow: hidden; padding-top: 100px; padding-bottom: 20px;">
    <div
      style="background-image: url('{{ asset('assets/images/bg/wallpaper.png') }}'); background-size: cover; background-position: center; background-attachment: fixed; background-repeat: no-repeat; position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0;">
    </div>
    <div class="bg-white" style="position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0; opacity: 0.7;">
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <h4 class="title-header">What's In The Cart</h4>
        </div>
      </div>
    </div>
  </section>

                                        <!-- Loop through Cart Items -->
                                        @foreach ($cartItems as $item)
                                            <div class="row mb-4 d-flex justify-content-between align-items-center">
                                                <div class="col-md-2 col-lg-2 col-xl-2">
                                                    <img src="{{ isset($item->produk->foto_produk) ? url($item->produk->foto_produk) : (isset($item->produk->foto_spare_part) ? url($item->produk->foto_spare_part) : asset('assets/images/components/image.png')) }}"
                                                        class="img-fluid rounded-3 border" alt="{{ $item->produk->nama_produk }}">
                                                </div>
                                                <div class="col-md-3 col-lg-3 col-xl-3">
                                                    <h6 class="text-muted">
                                                        @if($item->produk && $item->produk->kategoriProduct)
                                                            {{ $item->produk->kategoriProduct->nama_kategori_spare_part }}
                                                        @else
                                                            No category
                                                        @endif
                                                    </h6>
                                                    <h6 class="mb-0">{{ $item->produk ? $item->produk->nama_produk : 'No product' }}</h6>
                                                </div>
                                                <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                                    <button class="btn btn-link px-2" onclick="decreaseQuantity({{ $item->id }})">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input id="quantity-{{ $item->id }}" name="quantity" type="text" value="{{ $item->quantity }}" class="form-control form-control-sm quantity-input" onchange="updateCartItemQuantity({{ $item->id }}, this.value)" pattern="\d*" data-stock="{{ $item->produk->stok_produk }}" />
                                                    <button class="btn btn-link px-2" onclick="increaseQuantity({{ $item->id }})">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                                <div class="col-md-3 col-lg-2 col-xl-2">
                                                    <p class="mb-0 fw-semibold price">Rp {{ number_format($item->produk->harga_produk * $item->quantity, 0, ',', '.') }}</p> <!-- Display in Rupiah -->
                                                </div>
                                                <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-muted" style="background: none; border: none; padding: 0;">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            <hr class="my-4">
                                        @endforeach


                                        <div class="pt-5">
                                            <h6 class="mb-0"><a href="" class="text-body text-decoration-none"><i class="fas fa-long-arrow-alt-left me-2"></i>Back to shop</a></h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 bg-body-tertiary">
                                    <div class="p-5">
                                        <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
                                        <hr class="my-4">
                                        <div class="d-flex justify-content-between mb-4">
                                            <h5 class="text-uppercase">items {{ count($cartItems) }}</h5>
                                            {{-- <h5>Rp {{ number_format($totalPrice, 0, ',', '.') }}</h5> <!-- Example: € to IDR conversion rate 1€ = 16,000 IDR --> --}}
                                        </div>

                                        <h5 class="text-uppercase mb-3">Shipping</h5>
                                        <div class="mb-4 pb-2">
                                            <select data-mdb-select-init>
                                                <option value="1">Standard-Delivery - Rp 10,000</option> <!-- Adjusted to Rupiah -->
                                                <option value="2">Express Delivery - Rp 20,000</option> <!-- Adjusted to Rupiah -->
                                            </select>
                                        </div>

                                        <h5 class="text-uppercase mb-3">Code Voucher</h5>
                                        <div class="mb-5">
                                            <div data-mdb-input-init class="form-outline">
                                                <input type="text" id="form3Examplea2" class="form-control form-control-lg" placeholder="Enter your code" />
                                            </div>
                                        </div>

                                        <hr class="my-4">

                                        <div class="d-flex justify-content-between mb-5">
                                            <h5 class="text-uppercase">Total price</h5>
                                            {{-- <h5>Rp {{ number_format($totalPrice, 0, ',', '.') }}</h5> <!-- Assuming fixed shipping fee and conversion rate --> --}}
                                        </div>

                                        <button type="button" onclick="window.location.href='{{ route('payment') }}'" 
                                            class="btn btn-dark btn-block btn-lg">
                                            Checkout
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
  <div class="container mt-5">
    <div class="row">
      <div class="col-lg-8">
        @foreach ($cartItems as $item)
          <div class="cart-item d-flex align-items-center mb-3 p-3" data-id="{{ $item->id }}"
            data-stock="{{ $item->produk->stok_produk }}">
            <input type="checkbox" class="form-check-input me-3 item-select">
            <div class="cart-item-image me-3">
              <img
                src="{{ optional($item->produk)->foto_produk ? url($item->produk->foto_produk) : asset('assets/images/components/image.png') }}"
                alt="Product Image" style="width: 100px; height: 100px; object-fit: cover;" />
            </div>
            <div class="cart-item-details flex-grow-1">
              <h6>{{ optional($item->produk)->nama_produk ?? 'Produk Tidak Ditemukan' }}</h6>
              <p class="text-muted mb-1">
                {{ optional($item->produk)->bengkel->nama_bengkel ?? 'Nama Bengkel Tidak Tersedia' }}</p>
              <p class="text-primary fw-bold mb-1">Rp <span
                  class="item-price">{{ number_format(optional($item->produk)->harga_produk ?? 0, 0, ',', '.') }}</span>
              </p>
            </div>
            <div class="cart-item-quantity d-flex align-items-center me-3">
              <button class="btn btn-outline-dark btn-sm decrement-quantity">−</button>
              <input type="text" value="{{ $item->quantity }}"
                class="form-control form-control-sm text-center mx-1 quantity-input" style="width: 50px;">
              <button class="btn btn-outline-dark btn-sm increment-quantity">+</button>
            </div>
            <button class="btn btn-sm btn-outline-danger remove-item p-1" data-id="{{ $item->id }}"><i
                class='bx bx-trash'></i></button>
          </div>
        @endforeach
      </div>

      <div class="col-lg-4 mb-5">
        <div class="cart-summary p-3">
          <h5>Price Details</h5>
          <div class="selected-items-list">
            <ul id="selected-items-list" class="list-unstyled mb-3">
              <!-- Selected items and quantities will be dynamically added here -->
            </ul>
          </div>
          <ul class="list-unstyled">
            <hr>
            <li class="d-flex justify-content-between my-3">
              <span>Total Price of Selected Items</span>
              <span id="total-selected-price">Rp 0</span>
            </li>
          </ul>
          <button class="btn btn-success w-100">Place order</button>
        </div>
      </div>
    </div>
  </div>
@endsection
