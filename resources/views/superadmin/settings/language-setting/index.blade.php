@extends('superadmin.layouts.app')
@section('title')
    eBengkelku | Language
@stop
@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body">
                        <hr>

                        <form id="languageForm" action="{{ route('change-language') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="languageSelect">
                                    {{ __('messages.profile.settings.language.select_language') }}</label>
                                <select class="form-control" id="languageSelect" name="language">
                                    <option value="" selected disabled hidden>
                                        {{ __('messages.profile.settings.language.select_language') }}</option>
                                    <option value="id" {{ session('locale') === 'id' ? 'selected' : '' }}>ID</option>
                                    <option value="en" {{ session('locale') === 'en' ? 'selected' : '' }}>EN</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary"
                                id="saveLanguage">{{ __('messages.profile.settings.language.save_button') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
