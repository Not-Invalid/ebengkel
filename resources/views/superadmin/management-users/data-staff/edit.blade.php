@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Edit Staff
@stop

@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <h4>{{ __('messages-superadmin.sidebar.staff_admin.edit_admin') }}</h4>
        <form class="py-4" action="{{ route('data-staff-update', $staff->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="name" name="name"
                            value="{{ $staff->name }}" />
                        <label class="did-floating-label">{{ __('messages-superadmin.sidebar.staff_admin.name') }}</label>
                    </div>
                </div>
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="email" placeholder=" " id="email" name="email"
                            value="{{ $staff->email }}" />
                        <label class="did-floating-label">Email</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="phone_number"
                            name="phone_number" value="{{ $staff->phone_number }}"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                        <label class="did-floating-label">{{ __('messages-superadmin.sidebar.staff_admin.phone') }}</label>
                    </div>
                </div>
                <div class="col">
                    <div class="did-floating-label-content">
                        <select class="did-floating-input" id="role" name="role">
                            <option value="Administrator" {{ $staff->role == 'Administrator' ? 'selected' : '' }}>
                                Administrator</option>
                            <option value="User" {{ $staff->role == 'User' ? 'selected' : '' }}>
                                {{ __('messages-superadmin.sidebar.staff_admin.user') }}</option>
                        </select>
                        <label class="did-floating-label">{{ __('messages-superadmin.sidebar.staff_admin.role') }}</label>
                    </div>
                </div>
            </div>

            <div class="mt-3 d-flex gap-2">
                <a href="{{ route('data-staff-admin') }}" class="btn btn-cancel ms-2">
                    {{ __('messages-superadmin.sidebar.button.cancel') }}
                </a>
                <button type="submit" class="btn btn-custom-icon">
                    <i class='fas fa-floppy-disk fs-6'></i> {{ __('messages-superadmin.sidebar.button.save') }}
                </button>
            </div>
        </form>
    </div>
@endsection
