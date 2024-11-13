@extends('superadmin.layouts.app')

@section('title')
    eBengkelku | Profile
@stop

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Account Profile</h3>
            </div>
        </div>
    </div>
    <section class="section mt-2">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="avatar avatar-2xl">
                                <img src="{{ Auth::user()->profile_photo_url ?? asset('assets/images/components/avatar-admin.png') }}" alt="Avatar">
                            </div>
                            <h3 class="mt-3">{{ $superadmin->name }}</h3>
                            <p class="text-small">{{ $superadmin->role }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Your Name" value="{{ $superadmin->name }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Your Email" value="{{ $superadmin->email }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="Your Phone" value="{{ $superadmin->phone_number ?? 'Not Provided' }}" disabled>
                            </div>

                            <div class="form-group">
                                <button type="button" id="editButton" class="btn btn-primary" onclick="enableEditing()">Edit Profile</button>
                                <button type="submit" id="saveButton" class="btn btn-primary d-none">Save</button>
                                <button type="button" id="cancelButton" class="btn btn-cancel d-none" onclick="cancelEditing()">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function enableEditing() {
        document.getElementById('name').disabled = false;
        document.getElementById('email').disabled = false;
        document.getElementById('phone_number').disabled = false;

        document.getElementById('saveButton').classList.remove('d-none');
        document.getElementById('cancelButton').classList.remove('d-none');
        document.getElementById('editButton').classList.add('d-none');
    }

    function cancelEditing() {
        document.getElementById('name').disabled = true;
        document.getElementById('email').disabled = true;
        document.getElementById('phone_number').disabled = true;

        document.getElementById('saveButton').classList.add('d-none');
        document.getElementById('cancelButton').classList.add('d-none');
        document.getElementById('editButton').classList.remove('d-none');

        document.getElementById('name').value = "{{ $superadmin->name }}";
        document.getElementById('email').value = "{{ $superadmin->email }}";
        document.getElementById('phone_number').value = "{{ $superadmin->phone_number ?? 'Not Provided' }}";
    }
</script>
@endsection
