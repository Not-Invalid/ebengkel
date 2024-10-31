@extends('layouts.app')

@section('title')
    eBengkelku | Support Center
@stop

@section('content')
<section class="pt-8 pt-md-9 py-5">
    <div class="container">

      <!-- Categories -->
      <div class="row mt-6">
        <div class="col-12 mb-4">
          <span class="badge bg-pastel-primary text-primary text-uppercase-bold-sm">
            Topic categories
          </span>
        </div>

        <!-- Category -->
        <div class="col-md-3 mb-4">
          <a href="#" class="card align-items-center text-decoration-none border-1 hover-lift-light py-4 category">
            <span class="icon-circle icon-circle-lg bg-pastel-primary text-primary">
              <i class='bx bx-info-circle fs-2'></i>
            </span>
            <span class="text-dark mt-3">
              eBengkelku
            </span>
          </a>
        </div>

        <!-- Category -->
        <div class="col-md-3 mb-4">
          <a href="#" class="card align-items-center text-decoration-none border-1 hover-lift-light py-4 category">
            <span class="icon-circle icon-circle-lg bg-pastel-primary text-primary">
              <i class='bx bxs-lock fs-2'></i>
            </span>
            <span class="text-dark mt-3">
              Informasi Hukum dan Privasi
            </span>
          </a>
        </div>

        <!-- Category -->
        <div class="col-md-3 mb-4">
          <a href="#" class="card align-items-center text-decoration-none border-1 hover-lift-light py-4 category">
            <span class="icon-circle icon-circle-lg bg-pastel-primary text-primary">
              <i class='bx bxs-user-pin fs-2'></i>
            </span>
            <span class="text-dark mt-3">
              Pengaturan Akun dan Profile
            </span>
          </a>
        </div>

        <!-- Category -->
        <div class="col-md-3 mb-4">
          <a href="#" class="card align-items-center text-decoration-none border-1 hover-lift-light py-4 category">
            <span class="icon-circle icon-circle-lg bg-pastel-primary text-primary">
              <i class='bx bxs-shield fs-2'></i>
            </span>
            <span class="text-dark mt-3">
              Panduan Keamanan
            </span>
          </a>
        </div>

        <!-- Category -->
        <div class="col-md-3 mb-4">
          <a href="#" class="card align-items-center text-decoration-none border-1 hover-lift-light py-4 category">
            <span class="icon-circle icon-circle-lg bg-pastel-primary text-primary">
              <i class='bx bxs-wallet-alt fs-2'></i>
            </span>
            <span class="text-dark mt-3">
              Payment
            </span>
          </a>
        </div>

      </div>
    </div>
</section>
