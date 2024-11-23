@extends('pos.layouts.app')
@section('title')
    Ebengkelku | POS
@stop
@php
    $header = 'Master Product';
@endphp
@section('content')
    <div class="card">
        <div class="d-flex align-items-center justify-content-between p-4">
            <h4>List Product</h4>
            <div class="d-flex justify-content-between">
                <div class="d-flex justify-content-start mx-4">
                    <input type="text" id="search" class="form-control w-100" placeholder="Search">
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('pos.product.create', ['id_bengkel' => $bengkel->id_bengkel]) }}"
                        class="btn btn-primary text-white d-flex align-items-center">Add Product</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive bg-white">
                <table class="table table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Product</th>
                            <th>Jenis Product</th>
                            <th>Merk Product</th>
                            <th>Stok Product</th>
                            <th>Foto Product</th>
                            <th>Harga Product</th>
                            <th>Kualitas Product</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="category-table-body">
                        @foreach ($products as $index => $product)
                            <tr>
                                <td>{{ $index + 1 + ($products->currentPage() - 1) * $products->perPage() }}</td>
                                <td>{{ $product->nama_produk }}</td>
                                <td>{{ $product->kategoriProduct->nama_kategori_spare_part }}</td>
                                <td>{{ $product->merk_produk }}</td>
                                <td>{{ $product->stok_produk }}</td>
                                <td>
                                    <img src="{{ asset($product->foto_produk) }}" alt="Product Image" width="50"
                                        height="50">
                                </td>
                                <td>Rp{{ number_format($product->harga_produk, 0, ',', '.') }}</td>
                                <td>{{ $product->kualitas_produk }}</td>
                                <td>
                                    <a href="{{ route('pos.product.edit', ['id_bengkel' => $bengkel->id_bengkel, 'id_produk' => $product->id_produk]) }}"
                                        class="btn btn-sm btn-warning">Edit</a>

                                    <form
                                        action="{{ route('pos.product.destroy', ['id_bengkel' => $bengkel->id_bengkel, 'id_produk' => $product->id_produk]) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this product?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <script>
        document.getElementById('search').addEventListener('input', function() {
            let searchValue = this.value.toLowerCase();
            let tableRows = document.querySelectorAll('#category-table-body tr');

            tableRows.forEach(row => {
                let productName = row.cells[1].textContent.toLowerCase();
                row.style.display = productName.includes(searchValue) ? '' : 'none';
            });
        });
    </script>
@endsection
