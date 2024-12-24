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

    <div class="container my-5">
        <div class="row">

            @if ($cartItems->isEmpty())
                <div class="d-flex justify-content-center pb-5">
                    <div class="empty-cart-message text-center" style="display: block;">
                        <img src="{{ asset('assets/images/components/empty.png') }}" height="200" width="200"
                            alt="No items in cart">
                        <p>{{ __('messages.home.no_data_cart') }}.</p>
                        <a href="{{ route('ProductSparePart') }}" class="btn btn-primary my-2"><i
                                class="fas fa-cart-shopping"></i> Shop Now</a>
                    </div>
                </div>
            @else
                <div class="col-lg-8 col-md-12">
                    @foreach ($cartItems as $item)
                        <div class="cart-item d-flex align-items-center mb-3 p-3" data-id="{{ $item->id }}"
                            data-stock="{{ optional($item->produk)->stok_produk ?? optional($item->sparepart)->stok_spare_part }}"
                            data-price="{{ optional($item->produk)->harga_produk ?? optional($item->sparepart)->harga_spare_part }}">
                            <input type="checkbox" class="form-check-input me-3 item-select"
                                @if (request()->get('buy_now') && $item->id == session('last_added_item_id')) checked @endif>

                            <div class="cart-item-image me-3">
                                @if ($item->produk)
                                    <img src="{{ optional($item->produk)->foto_produk ? url($item->produk->foto_produk) : asset('assets/images/components/image.png') }}"
                                        alt="Product Image" style="width: 100px; height: 100px; object-fit: cover;" />
                                @elseif ($item->sparepart)
                                    <img src="{{ optional($item->sparepart)->foto_spare_part ? url($item->sparepart->foto_spare_part) : asset('assets/images/components/image.png') }}"
                                        alt="Spare Part Image" style="width: 100px; height: 100px; object-fit: cover;" />
                                @endif
                            </div>
                            <div class="cart-item-details flex-grow-1">
                                <h6>
                                    {{ optional($item->produk)->nama_produk ?? (optional($item->sparepart)->nama_spare_part ?? 'Item Tidak Ditemukan') }}
                                </h6>
                                <p class="text-muted mb-1">
                                    {{ optional($item->produk)->bengkel ? optional($item->produk->bengkel)->nama_bengkel : (optional($item->sparepart)->bengkel ? optional($item->sparepart->bengkel)->nama_bengkel : 'Nama Bengkel Tidak Tersedia') }}
                                </p>

                                <p class="text-primary fw-bold mb-1">
                                    {{ formatRupiah(optional($item->produk)->harga_produk ?? (optional($item->sparepart)->harga_spare_part ?? 0)) }}
                                </p>
                            </div>
                            <div class="cart-item-quantity d-flex align-items-center me-3">
                                <button class="btn btn-outline-dark btn-sm decrement-quantity">−</button>
                                <input type="text" value="{{ $item->quantity }}"
                                    class="form-control form-control-sm text-center mx-1 quantity-input"
                                    style="width: 50px;">
                                <button class="btn btn-outline-dark btn-sm increment-quantity">+</button>
                            </div>
                            <button class="btn btn-sm btn-outline-danger remove-item p-1" data-id="{{ $item->id }}"><i
                                    class='bx bx-trash'></i></button>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-start my-3">
                        <a href="{{ route('ProductSparePart') }}" class="shop-more btn btn-primary text-decoration-none"><i
                                class="fas fa-circle-left"></i> See Other Products & Spareparts</a>
                    </div>
                </div>
                <div class="col-lg-4 mb-5">
                    <div class="cart-summary p-3">
                        <h5>Price Details</h5>
                        <div class="selected-items-list">
                            <h6 class="fw-semibold my-2">Selected Items</h6>
                            <ul id="selected-items-list" class="list-unstyled mb-3">

                            </ul>
                        </div>
                        <ul class="list-unstyled">
                            <hr>
                            <li class="d-flex justify-content-between my-3">
                                <span>Total Price of Selected Items</span>
                                <span id="total-selected-price-items">Rp 0</span>
                            </li>
                        </ul>
                        <button type="button" class="btn btn-success w-100" data-bs-toggle="modal"
                            data-bs-target="#placeOrderModal">Place order</button>
                    </div>
                </div>
        </div>
    </div>
    @endif
    </div>

    <div class="modal fade" id="placeOrderModal" tabindex="-1" aria-labelledby="placeOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="placeOrderModalLabel">Confirm Your Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="dropdown dropdown-shipping border mb-3">
                        <button
                            class="btn btn-outline-border dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center"
                            type="button" id="addressDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div id="selected-address">
                                <p class="mb-0 fw-bold" id="selectedAddressName">Select Address</p>
                                <p class="mb-0 text-muted" id="selectedAddressDetails" style="font-size: 14px;">Please
                                    choose your address</p>
                            </div>
                        </button>
                        <ul class="dropdown-menu w-100" aria-labelledby="addressDropdown" style="z-index: 1050;">
                            @foreach ($shippingAddress as $address)
                                <li>
                                    <a class="dropdown-item shipping"
                                        onclick="updateAddress('{{ $address->nama_penerima }}', '{{ $address->lokasi_alamat_pengiriman }}', '{{ $address->telp_penerima }}', '{{ $address->provinsi_id }}', '{{ $address->kecamatan_id }}', '{{ $address->kota_id }}', '{{ $address->kodepos_alamat_pengiriman }}')">
                                        <span
                                            class="badge badge-custom {{ $address->status_alamat_pengiriman == 'Active' ? 'bg-primary' : 'bg-secondary' }}">
                                            {{ $address->status_alamat_pengiriman }}
                                        </span> | {{ $address->nama_penerima }} | {{ $address->telp_penerima }}<br>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
                <div class="modal-footer">
                    <form id="modalOrderForm" action="{{ route('cart.place-order') }}" method="POST">
                        @csrf
                        <input type="hidden" name="recipient" id="hiddenAddressRecipient">
                        <input type="hidden" name="location" id="hiddenAddressLocation">
                        <input type="hidden" name="phone" id="hiddenAddressPhone">
                        <input type="hidden" name="province" id="hiddenAddressProvince">
                        <input type="hidden" name="district" id="hiddenAddressDistrict">
                        <input type="hidden" name="city" id="hiddenAddressCity">
                        <input type="hidden" name="postal_code" id="hiddenAddressPostalCode">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Confirm Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateAddress(recipient, location, phone, province, district, city, postalCode) {
            console.log('City:', city);
            console.log('Postal Code:', postalCode);

            const locationWords = location.split(' ');
            let formattedLocation = '';
            for (let i = 0; i < locationWords.length; i += 11) {
                formattedLocation += locationWords.slice(i, i + 11).join(' ') + '<br>';
            }

            document.getElementById('selectedAddressName').textContent = recipient + ' | ' + phone;
            document.getElementById('selectedAddressDetails').innerHTML = formattedLocation;

            document.getElementById('hiddenAddressRecipient').value = recipient;
            document.getElementById('hiddenAddressLocation').value = location;
            document.getElementById('hiddenAddressPhone').value = phone;
            document.getElementById('hiddenAddressProvince').value = province;
            document.getElementById('hiddenAddressDistrict').value = district;
            document.getElementById('hiddenAddressCity').value = city;
            document.getElementById('hiddenAddressPostalCode').value = postalCode;
        }

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

            selectedItemsList.innerHTML = '';
            selectedItems.forEach(item => {
                const li = document.createElement('li');
                li.classList.add('d-flex', 'justify-content-between');
                li.innerHTML =
                    `${item.quantity}x ${item.name} <span>${formatRupiahJS(item.price * item.quantity)}</span>`;
                selectedItemsList.appendChild(li);
            });

            document.getElementById('total-selected-price-items').innerText = formatRupiahJS(totalPrice);

            const shippingPrice = parseFloat(document.getElementById('shipping_cost').value) || 0;

            const grandTotal = totalPrice;
            document.getElementById('grand-total').innerText = formatRupiahJS(grandTotal);

            document.querySelector('.fw-semibold').innerText =
                `${selectedItemsCount} Selected Item${selectedItemsCount > 1 ? 's' : ''}`;
        }

        document.querySelectorAll('.item-select').forEach(checkbox => {
            checkbox.addEventListener('change', updatePriceDetails);
        });

        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('input', updatePriceDetails);
        });

        updatePriceDetails();
    </script>
    <script>
        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');

                fetch('{{ route('cart.remove') }}', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            id: itemId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {

                            const itemElement = this.closest('.cart-item');
                            itemElement.remove();
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

                fetch('{{ route('cart.updateQuantity') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            id: itemId,
                            quantity: quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            updatePriceDetails();
                        } else {
                            alert(data.message || 'Failed to update quantity');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>

@endsection
