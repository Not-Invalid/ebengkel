@extends('pos.layouts.app')

@section('title')
    eBengkelku | POS
@stop

@php
    $header = 'Edit Service';
@endphp
<style>
    .image-preview {
        border: 1px solid #ddd;
        border-radius: 5px;
        max-height: 200px;
    }

    .upload-box {
        border: 2px dashed var(--main-light-blue);
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        transition: background-color 0.2s;
        cursor: pointer;
    }

    .upload-box:hover {
        background-color: #f9f9f9;
    }

    .upload-label {
        font-size: 16px;
        color: #555;
        margin-bottom: 10px;
        display: block;
    }

    .file-input {
        opacity: 0;
        position: absolute;
        z-index: -1;
    }

    .upload-box::after {
        content: 'Click to upload';
        display: block;
        font-size: 14px;
        color: #999;
    }

    .hidden {
        display: none !important;
    }
</style>
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="text-danger">
                * Indicated required fields
            </h4>
        </div>
        <div class="card-body">
            <form
                action="{{ route('pos.service.update', ['id_bengkel' => $bengkel->id_bengkel, 'id_services' => $service->id_services]) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_bengkel" value="{{ $bengkel->id_bengkel }}">

                <div class="form-group">
                    <label for="nama_services">Service Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama_services"
                        value="{{ old('nama_services', $service->nama_services) }}" required>
                </div>

                <div class="form-group">
                    <label for="harga_services">Service Price <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="harga_services"
                        value="{{ old('harga_services', $service->harga_services) }}" required>
                </div>

                <div class="form-group">
                    <label for="keterangan_services">Description </label>
                    <textarea class="form-control" style="resize: none; height: 100px !important;" name="keterangan_services">{{ old('keterangan_services', $service->keterangan_services) }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <div class="upload-box">
                        <label for="foto_services" class="upload-label">Service Photo <span
                                class="text-danger">*</span></label>
                        <input type="file" class="file-input" name="foto_services" id="foto_services"
                            onchange="previewImage('foto_services', 'product')">
                        <div class="preview-container d-flex justify-content-center">
                            <img id="product" src="{{ url($service->foto_services) }}" alt="product Photo Preview"
                                class="image-preview" style="display: block; width: 200px; margin-top: 10px;">
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('pos.service.index', ['id_bengkel' => $bengkel->id_bengkel]) }}" id="backButton" class="btn btn-danger">Back</a>
                    <button id="editButton" type="button" class="btn btn-primary">Edit</button>
                    <button id="cancelButton" type="button" class="btn btn-danger hidden">Cancel</button>
                    <button id="saveButton" type="submit" class="btn btn-primary hidden">Save</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function previewImage(inputId, previewId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
                preview.src = '';
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const backButton = document.getElementById('backButton');
            const editButton = document.getElementById('editButton');
            const cancelButton = document.getElementById('cancelButton');
            const saveButton = document.getElementById('saveButton');

            const formElements = document.querySelectorAll('form input, form select, form textarea');

            formElements.forEach(element => {
                element.disabled = true;
            });

            editButton.addEventListener('click', () => {
                formElements.forEach(element => {
                    element.disabled = false;
                });

                backButton.classList.add('hidden');
                editButton.classList.add('hidden');
                saveButton.classList.remove('hidden');
                cancelButton.classList.remove('hidden');
            });

            cancelButton.addEventListener('click', () => {
                formElements.forEach(element => {
                    element.disabled = true;
                });
                backButton.classList.remove('hidden');
                editButton.classList.remove('hidden');
                saveButton.classList.add('hidden');
                cancelButton.classList.add('hidden');
            });
        });
    </script>
@endsection
