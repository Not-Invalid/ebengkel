@extends('layouts.partials.sidebar')

@section('title')
  eBengkelku | My Order
@stop

@section('content')
<div class="container mt-3">
  <!-- Navigation Tabs -->
  <div class="d-flex justify-content-start border-bottom">
    <!-- Untuk tampilan Mobile -->
    <ul class="nav nav-tabs w-100 flex-nowrap overflow-auto d-md-none" role="tablist" style="white-space: nowrap;">
      <li class="nav-item">
        <a class="nav-link active" href="#semua" data-bs-toggle="tab">Semua</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#dikirim" data-bs-toggle="tab">Dikirim</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#selesai" data-bs-toggle="tab">Selesai</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#dibatalkan" data-bs-toggle="tab" style="white-space: nowrap;">Dibatalkan</a>
      </li>
    </ul>

    <!-- Untuk tampilan Desktop -->
    <ul class="nav nav-tabs w-100 flex-nowrap d-none d-md-flex" role="tablist" style="white-space: nowrap;">
      <li class="nav-item">
        <a class="nav-link active" href="#semua" data-bs-toggle="tab">Semua</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#dikirim" data-bs-toggle="tab">Dikirim</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#selesai" data-bs-toggle="tab">Selesai</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#dibatalkan" data-bs-toggle="tab">Dibatalkan</a>
      </li>
    </ul>
  </div>

  <!-- Tab Content -->
  <div class="tab-content mt-3">
      <!-- Semua -->
      <div class="tab-pane fade show active" id="semua">
      </div> 

      <!-- Dikirim -->
      <div class="tab-pane fade" id="dikirim" role="tabpanel">
          <div class="container mt-3">
              <div class="mb-3">
                  <div class="card-body">
                      <!-- Header Toko dan Status -->
                      <div class="row align-items-center mb-3">
                        <div class="col-8 col-md-10 d-flex align-items-center">
                          <div class="bg-warning text-white px-2 py-0 rounded">
                            Dikirim
                          </div>
                        </div>
                      </div>                    
                      <!-- Detail Produk -->
                      <div class="row align-items-center">
                          <div class="col-auto">
                              <img src="{{ asset('assets/images/components/image.png') }}" alt="Produk" 
                                  class="img-fluid rounded" style="width: 80px; height: 80px;">
                          </div>
                          <div class="col">
                              <p class="mb-1 fw-bold">Olinol</p>
                              <span class="text-muted">Thans Racing</span>
                          </div>
                          <div class="col text-end">
                              <p class="mb-0 fw-bold">Rp100.750.000</p>
                              <p class="mb-0"><small>Rp2.750</small><span> per unit</span></p>
                          </div>
                      </div>
                      <!-- Tombol Aksi -->
                      <div class="row mt-1">
                          <div class="col text-end">
                              <button class="btn btn-outline-danger btn-sm">Beli lagi</button>
                          </div>
                      </div>
                  </div>
              </div>
              <hr> <!-- Pembatas -->
          </div>
      </div>

      <!-- Selesai -->
      <div class="tab-pane fade" id="selesai" role="tabpanel">
          <div class="container mt-3">
              <div class="mb-3">
                  <div class="card-body">
                      <!-- Header Toko dan Status -->
                      <div class="row align-items-center mb-3">
                        <div class="col-8 col-md-10 d-flex align-items-center">
                          <div class="bg-success text-white px-2 py-0 rounded">
                            Selesai
                          </div>
                        </div>
                      </div>                    
                      <!-- Detail Produk -->
                      <div class="row align-items-center">
                          <div class="col-auto">
                              <img src="{{ asset('assets/images/components/image.png') }}" alt="Produk" 
                                  class="img-fluid rounded" style="width: 80px; height: 80px;">
                          </div>
                          <div class="col">
                              <p class="mb-1 fw-bold">Olinol</p>
                              <span class="text-muted">Thans Racing</span>
                          </div>
                          <div class="col text-end">
                              <p class="mb-0 fw-bold">Rp3.750</p>
                              <p class="mb-0"><small>Rp2.750</small><span> per unit</span></p>
                          </div>
                      </div>
                      <!-- Tombol Aksi -->
                      <div class="row mt-1">
                          <div class="col text-end">
                              <button class="btn btn-outline-danger btn-sm">Beli lagi</button>
                          </div>
                      </div>
                  </div>
              </div>
              <hr> <!-- Pembatas -->
          </div>
      </div>

      <!-- Dibatalkan -->
      <div class="tab-pane fade" id="dibatalkan" role="tabpanel">
          <div class="container mt-3">
              <div class="mb-3">
                  <div class="card-body">
                      <!-- Header Toko dan Status -->
                      <div class="row align-items-center mb-3">
                        <div class="col-8 col-md-10 d-flex align-items-center">
                          <div class="bg-danger text-white px-2 py-0 rounded">
                            Dibatalkan
                          </div>
                        </div>
                      </div>
                      <!-- Detail Produk -->
                      <div class="row align-items-center">
                          <div class="col-auto">
                              <img src="{{ asset('assets/images/components/image.png') }}" alt="Produk" 
                                  class="img-fluid rounded" style="width: 80px; height: 80px;">
                          </div>
                          <div class="col">
                              <p class="mb-1 fw-bold">Olinol</p>
                              <span class="text-muted">Thans Racing</span>
                          </div>
                          <div class="col text-end">
                              <p class="mb-0 fw-bold">Rp3.750</p>
                              <p class="mb-0"><small>Rp2.750</small><span> per unit</span></p>
                          </div>
                      </div>
                      <!-- Tombol Aksi -->
                      <div class="row mt-1">
                          <div class="col text-end">
                              <button class="btn btn-outline-danger btn-sm">Beli lagi</button>
                          </div>
                      </div>
                  </div>
              </div>
              <hr> <!-- Pembatas -->
          </div>
      </div>
  </div>


</div>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Ambil elemen kontainer dari masing-masing tab
    const semuaContainer = document.querySelector("#semua");
    const dikirimContainer = document.querySelector("#dikirim .container");
    const selesaiContainer = document.querySelector("#selesai .container");
    const dibatalkanContainer = document.querySelector("#dibatalkan .container");

    // Gabungkan isi dari tab yang memiliki konten
    let combinedContent = "";

    if (dikirimContainer && dikirimContainer.innerHTML.trim() !== "") {
      combinedContent += `<div>${dikirimContainer.innerHTML}</div>`;
    }

    if (selesaiContainer && selesaiContainer.innerHTML.trim() !== "") {
      combinedContent += `<div>${selesaiContainer.innerHTML}</div>`;
    }

    if (dibatalkanContainer && dibatalkanContainer.innerHTML.trim() !== "") {
      combinedContent += `<div>${dibatalkanContainer.innerHTML}</div>`;
    }

    // Tampilkan konten di tab semua
    semuaContainer.innerHTML = combinedContent || "<p>Tidak ada data yang tersedia</p>";
  });
  
</script>


@endsection
