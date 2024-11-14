@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/detail-ProductSparePart.css') }}">
@endpush

@section('title')
    eBengkelku - Detail Product & SparePart
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
                    <h4 class="title-header">Product & SparePart</h4>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-5 p-3 rounded">
                    <img src="{{ isset($data->foto_produk) ? url($data->foto_produk) : (isset($data->foto_spare_part) ? url($data->foto_spare_part) : asset('assets/images/components/image.png')) }}"
                        alt="" style="width: 90%; height: auto;">
                </div>
                <div class="col-md-7">
                    <h2 class=" fw-bolder mb-3">{{ $data->nama_produk ?? $data->nama_spare_part }}</h2>
                    <div class="fs-5 mb-3">
                        <span class="fw-bold">Rp.
                            {{ number_format($data->harga_produk ?? $data->harga_spare_part, 0, ',', '.') }}</span>
                    </div>
                    <p>{{ $data->keterangan_produk ?? $data->keterangan_spare_part }}</p>
                    <div class="d-flex align-items-center mb-3 mt-3">
                        <label for="inputQuantity" style="margin-right: 10px;">Kuantitas: </label>
                        <input class="form-control text-center quantity-input me-3" id="inputQuantity" type="text"
                            value="1" style="max-width: 5rem" />
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <button class="btn btn-outline-dark flex-shrink-0 add-to-cart-btn me-3" type="button"
                            style="border-radius: 5px;">
                            <i class="bx bx-cart"></i>
                            Add to Chart
                        </button>
                        <button class="btn btn-primary flex-shrink-0 " type="button" style="border-radius: 5px;">
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
