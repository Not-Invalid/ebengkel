@extends('layouts.partials.sidebar')

@section('title')
    eBengkelku | Profile
@stop

@section('content')
    <div class="w-100 shadow bg-white rounded" style="padding: 1rem">
        <h4>Profile Information</h4>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="d-flex justify-content-center mb-4">
                <label for="upload-photo" style="cursor: pointer;">
                    <img src="{{ isset($data_pelanggan) && $data_pelanggan->foto_pelanggan ? url($data_pelanggan->foto_pelanggan) : asset('assets/images/components/avatar.png') }}"
                        alt="Profile Picture" alt="Foto Pelanggan" style="width: 150px; height: 150px; object-fit: cover;"
                        class="rounded-circle profile-pic" id="profilePic">
                </label>
                <input type="file" id="upload-photo" name="foto" style="display: none;" onchange="previewImage(event)"
                    disabled>
            </div>

            <div class="row">
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="text" placeholder=" " id="name" name="nama"
                            value="{{ $data_pelanggan->nama_pelanggan }}" readonly />
                        <label class="did-floating-label">Full Name</label>
                    </div>
                </div>
                <div class="col">
                    <div class="did-floating-label-content">
                        <input class="did-floating-input" type="email" placeholder=" " id="email" name="email"
                            value="{{ $data_pelanggan->email_pelanggan }}" readonly />
                        <label class="did-floating-label">Email</label>
                    </div>
                </div>
            </div>

            <div class="did-floating-label-content">
                <input class="did-floating-input" type="text" placeholder=" " id="phone" name="telp"
                    value="{{ $data_pelanggan->telp_pelanggan }}" readonly required pattern="[0-9]*"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                <label class="did-floating-label">No. Telp</label>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-outline-secondary" id="editBtn" onclick="toggleEdit()">Edit</button>
                <button type="submit" id="saveBtn" class="btn btn-primary" style="display: none;">Save</button>
                <button type="button" id="cancelBtn" class="btn btn-danger mx-2" onclick="cancelEdit()"
                    style="display: none;">Cancel</button>
            </div>
        </form>
    </div>

    <div class="w-100 shadow bg-white rounded mt-5" style="padding: 1rem">
        <h4>History Access</h4>
        <canvas id="myBarChart" height="160" width="500">
        </canvas>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        function toggleEdit() {
            const isReadOnly = document.getElementById("name").readOnly;
            document.querySelectorAll(".did-floating-input").forEach(input => {
                input.readOnly = !isReadOnly;
            });
            document.getElementById("upload-photo").disabled = !isReadOnly;
            document.getElementById("editBtn").style.display = isReadOnly ? "none" : "inline-block";
            document.getElementById("saveBtn").style.display = isReadOnly ? "inline-block" : "none";
            document.getElementById("cancelBtn").style.display = isReadOnly ? "inline-block" : "none";
        }

        function cancelEdit() {
            document.getElementById("name").value = "{{ $data_pelanggan->nama_pelanggan }}";
            document.getElementById("email").value = "{{ $data_pelanggan->email_pelanggan }}";
            document.getElementById("phone").value = "{{ $data_pelanggan->telp_pelanggan }}";
            document.getElementById("profilePic").src = "{{ url($data_pelanggan->foto_pelanggan) }}";
            document.querySelectorAll(".did-floating-input").forEach(input => {
                input.readOnly = true;
            });
            document.getElementById("upload-photo").disabled = true;
            document.getElementById("editBtn").style.display = "inline-block";
            document.getElementById("saveBtn").style.display = "none";
            document.getElementById("cancelBtn").style.display = "none";
        }

        function previewImage(event) {
            const output = document.getElementById("profilePic");
            output.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
    <script type="text/javascript">
        var xValues = {!! json_encode($days) !!};
        var yValues = {!! json_encode(array_values($logCounts)) !!};

        new Chart("myBarChart", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                    label: "Jumlah Log",
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    data: yValues,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 2,
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    </script>

@endsection
