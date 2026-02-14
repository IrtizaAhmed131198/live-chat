@extends('admin.layout.app')

@section('title', 'Edit Visitor')

@section('content')
    <style>
        .image-upload-container {
            position: relative;
            display: inline-block;
        }

        .image-upload-container img {
            transition: opacity 0.3s;
        }

        .image-upload-container img:hover {
            opacity: 0.8;
        }

        .form-control {
            background-color: #2b2c40 !important;
            border: 1px solid #4a4b68 !important;
            color: white !important;
        }

        .form-control:focus {
            background-color: #2b2c40 !important;
            border-color: #7367f0 !important;
            color: white !important;
        }

        .form-label.text-white {
            color: #e6e6f1 !important;
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h5>Edit Visitor</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.visitor.update', $visitor->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @if ($visitor->user)
                        <div class="user-info" style="background-color: #393a5a; padding: 20px; border-radius: 8px;">
                            <!-- Image Upload Field -->
                            <div class="mb-4 text-center">
                                <label class="form-label text-white small mb-2">Profile Image</label>
                                <div class="image-upload-container" style="position: relative; display: inline-block;">
                                    <!-- Current Image Preview -->
                                    <div id="image_preview">
                                        @if ($visitor->user->image)
                                            <img src="{{ asset($visitor->user->image) }}" class="rounded-circle"
                                                style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #7367f0; cursor: pointer;"
                                                id="profileImage" onclick="document.getElementById('image').click();">
                                        @else
                                            <img src="{{ asset('assets/images/default.png') }}" class="rounded-circle"
                                                style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #7367f0; cursor: pointer;"
                                                id="profileImage" onclick="document.getElementById('image').click();">
                                        @endif
                                    </div>

                                    <!-- Hidden File Input -->
                                    <input type="file" name="image" id="image" accept="image/*"
                                        style="display: none;" onchange="previewImage(this);">

                                    <!-- Upload Button -->
                                    <button type="button" class="btn btn-sm btn-primary mt-2"
                                        onclick="document.getElementById('image').click();">
                                        <i class="bx bx-upload me-1"></i> Change Image
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-2">Click on image or button to change (Max: 2MB)</small>
                                @error('image')
                                    <span class="text-danger small d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label text-white small mb-1">Email <span
                                                class="text-danger">*</span></label>
                                        <input name="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $visitor->user->email ?? '') }}" required>
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-white small mb-1">Phone</label>
                                        <input name="phone" type="text"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone', $visitor->user->phone ?? '') }}">
                                        @error('phone')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-white small mb-1">Address</label>
                                        <input name="address" type="text"
                                            class="form-control @error('address') is-invalid @enderror"
                                            value="{{ old('address', $visitor->user->address ?? '') }}">
                                        @error('address')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label text-white small mb-1">About</label>
                                        <textarea name="about" class="form-control @error('about') is-invalid @enderror" rows="3">{{ old('about', $visitor->user->about ?? '') }}</textarea>
                                        @error('about')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save me-2"></i> Update User
                        </button>
                        <a href="{{ route('admin.visitor') }}" class="btn btn-secondary">
                            <i class="bx bx-arrow-back me-2"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {{-- <script>
        $(document).ready(function() {
            $('#website_id').select2({
                placeholder: "Select a Website",
                allowClear: true,
                width: '100%'
            });
        });
    </script> --}}
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profileImage').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
