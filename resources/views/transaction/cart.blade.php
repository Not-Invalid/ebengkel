@extends('layouts.app')

@push('css')
  <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">
@endpush

@section('title')
  eBengkelku | Cart
@stop

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
  <div class="container mt-5">
    <div class="row">
      <div class="col-lg-12">
        @foreach ($cartItems as $item)
          <div class="cart-item d-flex align-items-center mb-3 p-3" data-id="{{ $item->id }}"
            data-stock="{{ optional($item->produk)->stok_produk ?? optional($item->sparepart)->stok_spare_part }}"
            data-price="{{ optional($item->produk)->harga_produk ?? optional($item->sparepart)->harga_spare_part }}">
            <input type="checkbox" class="form-check-input me-3 item-select">
            <div class="cart-item-image me-3">
              @if ($item->produk)
                <img
                  src="{{ optional($item->produk)->foto_produk ? url($item->produk->foto_produk) : asset('assets/images/components/image.png') }}"
                  alt="Product Image" style="width: 100px; height: 100px; object-fit: cover;" />
              @elseif ($item->sparepart)
                <img
                  src="{{ optional($item->sparepart)->foto_spare_part ? url($item->sparepart->foto_spare_part) : asset('assets/images/components/image.png') }}"
                  alt="Spare Part Image" style="width: 100px; height: 100px; object-fit: cover;" />
              @endif
            </div>
            <div class="cart-item-details flex-grow-1">
              <h6>
                {{ optional($item->produk)->nama_produk ?? (optional($item->sparepart)->nama_spare_part ?? 'Item Tidak Ditemukan') }}
              </h6>
              <p class="text-muted mb-1">
                {{ optional($item->produk)->bengkel->nama_bengkel ?? 'Nama Bengkel Tidak Tersedia' }}</p>
              <p class="text-primary fw-bold mb-1">
                {{ formatRupiah(optional($item->produk)->harga_produk ?? (optional($item->sparepart)->harga_spare_part ?? 0)) }}
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
    </div>
    <div class="row">
      <div class="col-lg-8">
        <div class="cart-summary p-3">
          <h5>Shipping Info</h5>
          <p class="text-muted">Select Address</p>
          <!-- Dropdown for Shipping Address -->
          <div class="dropdown mb-3">
            <button
              class="btn btn-outline-border dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center"
              type="button" id="addressDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <div>
                <p class="mb-0 fw-bold" id="selectedAddressName">Select Address</p>
                <p class="mb-0 text-muted" id="selectedAddressDetails" style="font-size: 14px;">Please choose your address
                </p>
              </div>
            </button>
            <ul class="dropdown-menu w-100" aria-labelledby="addressDropdown" style="z-index: 1050;">
              <li>
                <a class="dropdown-item"
                  data-address="Address 1|Bradley McMillian|109 Clarksburg Park Road|Show Low, AZ 85901|Mo. 012-345-6789"
                  onclick="updateAddress('Address 1', 'Bradley McMillian', '109 Clarksburg Park Road', 'Show Low, AZ 85901', 'Mo. 012-345-6789')">
                  Address 1
                </a>
              </li>
              <li>
                <a class="dropdown-item"
                  data-address="Address 2|Bradley McMillian|109 Clarksburg Park Road|Show Low, AZ 85901|Mo. 012-345-6789"
                  onclick="updateAddress('Address 2', 'Bradley McMillian', '109 Clarksburg Park Road', 'Show Low, AZ 85901', 'Mo. 012-345-6789')">
                  Address 2
                </a>
              </li>
            </ul>
          </div>
          <h5 class="mb-3">Opsi Pengiriman</h5>
          <div class="dropdown">
            <button
              class="btn btn-outline-border dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center"
              type="button" id="shippingOptionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <div>
                <p class="mb-0 fw-bold" id="selectedShippingName">Reguler</p>
                <p class="mb-0 text-muted" id="selectedShippingCourier" style="font-size: 14px;">J&T Express</p>
                <p class="mb-0 text-muted" style="font-size: 12px;" id="deliveryDate">Akan diterima pada tanggal
                  23 Ags - 24 Ags</p>
              </div>
              <div class="text-end">
                <p class="mb-0 fw-bold" id="selectedShippingPrice">Rp 11.000</p>
              </div>
            </button>
            <ul class="dropdown-menu w-100" aria-labelledby="shippingOptionsDropdown" style="z-index: 1050;">
              <li>
                <a class="dropdown-item" data-shipping="Reguler" data-price="Rp 11.000" data-courier="J&T Express"
                  data-time="2-4 Hari" onclick="updateShipping('Reguler', 11000, 'J&T Express', '2-4 Hari')">
                  Reguler (Rp 11.000) - J&T Express
                </a>
              </li>
              <li>
                <a class="dropdown-item" data-shipping="Ekspres" data-price="Rp 25.000" data-courier="Gojek Xpress"
                  data-time="1-2 Hari" onclick="updateShipping('Ekspres', 25000, 'Gojek Xpress', '1-2 Hari')">
                  Ekspres (Rp 25.000) - Gojek Xpress
                </a>
              </li>
              <li>
                <a class="dropdown-item" data-shipping="Same Day" data-price="Rp 50.000" data-courier="JNE Super Speed"
                  data-time="Hari yang sama"
                  onclick="updateShipping('Same Day', 50000, 'JNE Super Speed', 'Hari yang sama')">
                  Same Day (Rp 50.000) - JNE Super Speed
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-5">
        <div class="cart-summary p-3">
          <h5>Price Details</h5>
          <div class="selected-items-list">
            <h6 class="fw-semibold my-2">Selected Items</h6>
            <ul id="selected-items-list" class="list-unstyled mb-3">
              <!-- Daftar item yang dipilih akan ditampilkan disini -->
            </ul>
          </div>
          <ul class="list-unstyled">
            <hr>
            <li class="d-flex justify-content-between my-3">
              <span>Total Price of Selected Items</span>
              <span id="total-selected-price">Rp 0</span>
            </li>
          </ul>
          <form action="{{ route('cart.place-order') }}" method="POST">
            @csrf
            <button class="btn btn-success w-100">Place order</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    function formatRupiahJS(angka) {
      return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }


    const selectedItemsList = document.getElementById('selected-items-list');
    const totalPriceElement = document.getElementById('total-selected-price');

    function updatePriceDetails() {
      let totalPrice = 0;
      let selectedItemsCount = 0;
      let selectedItems = [];

      document.querySelectorAll('.cart-item').forEach(item => {
        let checkbox = item.querySelector('.item-select');
        if (checkbox.checked) {
          let price = parseFloat(item.getAttribute('data-price'));
          let quantity = parseInt(item.querySelector('.quantity-input').value);
          let name = item.querySelector('h6').innerText;

          selectedItems.push({
            name,
            price,
            quantity
          });
          totalPrice += price * quantity;
          selectedItemsCount++;
        }
      });

      // Clear the list and add selected items to the summary
      selectedItemsList.innerHTML = '';
      selectedItems.forEach(item => {
        const li = document.createElement('li');
        li.classList.add('d-flex', 'justify-content-between');
        li.innerHTML = `${item.quantity}x ${item.name} <span>${formatRupiahJS(item.price * item.quantity)}</span>`;
        selectedItemsList.appendChild(li);
      });

      totalPriceElement.innerText = formatRupiahJS(totalPrice);
      document.querySelector('.fw-semibold').innerText =
        `${selectedItemsCount} Selected Item${selectedItemsCount > 1 ? 's' : ''}`;
    }
    // Tambahkan event listener ke input quantity untuk memanggil updatePriceDetails
    document.querySelectorAll('.quantity-input').forEach(input => {
      input.addEventListener('input', updatePriceDetails);
    });


    // Menambahkan event listener untuk setiap checkbox
    document.querySelectorAll('.item-select').forEach(checkbox => {
      checkbox.addEventListener('change', updatePriceDetails);
    });

    // Memperbarui Price Details ketika halaman dimuat pertama kali
    updatePriceDetails();
  </script>
  <script>
    // Remove item from the cart when the trash icon is clicked
    document.querySelectorAll('.remove-item').forEach(button => {
      button.addEventListener('click', function() {
        const itemId = this.getAttribute('data-id');

        // Make an AJAX request to remove the item from the cart
        fetch('{{ route('cart.remove') }}', {
            method: 'DELETE',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
              id: itemId
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.status === 'success') {
              // Remove the item from the DOM
              const itemElement = this.closest('.cart-item');
              itemElement.remove();

              // Optionally, update the price details after removal
              updatePriceDetails();
            } else {
              alert(data.message || 'Failed to remove item');
            }
          })
          .catch(error => console.error('Error:', error));
      });
    });

    document.querySelectorAll('.increment-quantity, .decrement-quantity').forEach(button => {
      button.addEventListener('click', function() {
        const cartItem = this.closest('.cart-item');
        const itemId = cartItem.getAttribute('data-id');
        const stock = parseInt(cartItem.getAttribute('data-stock'));
        const pricePerUnit = parseFloat(cartItem.getAttribute('data-price'));
        const quantityInput = cartItem.querySelector('.quantity-input');
        let quantity = parseInt(quantityInput.value);

        if (this.classList.contains('increment-quantity')) {
          if (quantity < stock) {
            quantity++;
          } else {
            alert('Cannot exceed stock quantity');
            return;
          }
        } else if (this.classList.contains('decrement-quantity')) {
          if (quantity > 1) {
            quantity--;
          }
        }

        quantityInput.value = quantity;

        // Kirim pembaruan quantity ke server
        fetch('{{ route('cart.updateQuantity') }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
              id: itemId,
              quantity: quantity
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.status === 'success') {
              updatePriceDetails(); // Panggil fungsi setelah perubahan kuantitas
            } else {
              alert(data.message || 'Failed to update quantity');
            }
          })
          .catch(error => console.error('Error:', error));
      });
    });
    // // JavaScript to display selected address details
    // document.querySelectorAll('.dropdown-item').forEach(function(item) {
    //   item.addEventListener('click', function(e) {
    //     e.preventDefault();
    //     var addressDetails = item.getAttribute('data-address');
    //     var addressArray = addressDetails.split('|');
    //     var addressText = `
  //     <h6>${addressArray[0]}</h6>
  //     <p>${addressArray[1]}<br>${addressArray[2]}<br>${addressArray[3]}<br>${addressArray[4]}</p>
  //   `;
    //     var addressDiv = document.getElementById('selected-address');
    //     addressDiv.innerHTML = addressText;
    //     addressDiv.style.display = 'block';
    //     // Change button text to selected address name
    //     document.getElementById('address-dropdown-btn').textContent = `${addressArray[0]}: ${addressArray[1]}`;
    //   });
    // });
    function updateAddress(addressName, recipient, street, city, phone) {
      document.getElementById('selectedAddressName').textContent = addressName;
      document.getElementById('selectedAddressDetails').textContent = recipient + "\n" + street + "\n" + city + "\n" +
        "Mo. " + phone;
      document.getElementById('selectedAddress').textContent = "Selected: " + addressName;
      document.getElementById('selected-address').style.display = 'block';
      document.getElementById('selected-address').innerHTML =
        `<h6>${addressName}</h6><p>${recipient}<br>${street}<br>${city}<br>Mo. ${phone}</p>`;
    }

    function updateShipping(shippingName, shippingPrice, courierName, deliveryTime) {
      // Mengupdate tampilan teks berdasarkan pilihan
      document.getElementById('selectedShippingName').textContent = shippingName;
      document.getElementById('selectedShippingCourier').textContent = courierName;
      document.getElementById('deliveryDate').textContent = `Akan diterima dalam ${deliveryTime}`;
      document.getElementById('selectedShippingPrice').textContent = `Rp ${shippingPrice.toLocaleString()}`;
    }
  </script>

@endsection
