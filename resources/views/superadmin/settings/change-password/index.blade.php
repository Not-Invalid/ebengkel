@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Change Password
@stop

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('messages-superadmin.sidebar.password.change') }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('reset-password') }}" method="POST">
                            @csrf
                            <div class="form-group my-2">
                                <label for="currentPassword"
                                    class="form-label">{{ __('messages-superadmin.sidebar.password.current') }}</label>
                                <input type="password" name="currentPassword" id="currentPassword" class="form-control"
                                    placeholder="{{ __('messages-superadmin.sidebar.password.placeholder.current') }}">
                            </div>
                            <div class="form-group my-2">
                                <label for="newPassword"
                                    class="form-label">{{ __('messages-superadmin.sidebar.password.new') }}</label>
                                <input type="password" name="newPassword" id="newPassword" class="form-control"
                                    placeholder="{{ __('messages-superadmin.sidebar.password.placeholder.new') }}">
                            </div>
                            <div class="form-group my-2">
                                <label for="confirmPassword"
                                    class="form-label">{{ __('messages-superadmin.sidebar.password.confirm') }}</label>
                                <input type="password" name="newPassword_confirmation" id="confirmPassword"
                                    class="form-control"
                                    placeholder="{{ __('messages-superadmin.sidebar.password.placeholder.new') }}">
                            </div>
                            <div class="form-group my-2 d-flex justify-content-end">
                                <button type="submit"
                                    class="btn btn-primary">{{ __('messages-superadmin.sidebar.password.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
