@extends('pos.layouts.app')
@section('title')
    eBengkelku | Language Settings
@stop
@php
    $header = 'Language Settings';
@endphp
@section('content')
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <form action="" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="languageSelect">Select Language</label>
                            <select class="form-control select2" id="languageSelect" name="language">
                                <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
                                <option value="id" {{ app()->getLocale() == 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Change Language</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
