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
            Categories
          </span>
        </div>

        @forelse ($categories as $category)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <a href="{{ route('support-center.detail', ['category' => $category->id]) }}" class="card justify-content-center align-items-center shadow text-decoration-none border-1 hover-lift-light py-4 category">
                    <span class="icon-circle icon-circle-lg bg-pastel-primary">
                        <i class="fas fa-{{ $category->icon }} fs-2"></i>
                    </span>
                    <span class="text-dark text-center mt-3">
                        {{ $category->nama_category }}
                    </span>
                </a>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center">No categories available.</p>
            </div>
        @endforelse

      </div>
    </div>
</section>
@stop
