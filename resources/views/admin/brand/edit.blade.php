@extends('admin.layout.app')

@section('title', 'Edit Brand')

@section('content')
    <style>
        select[multiple] {
            background-image: none !important;
        }

        select[multiple] option {
            padding: 10px 15px;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s;
        }

        select[multiple] option:hover {
            background-color: #e9ecef !important;
        }

        select[multiple] option:checked {
            background-color: #0d6efd !important;
            color: white !important;
        }

        select[multiple] option:checked:hover {
            background-color: #0b5ed7 !important;
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h5>Edit Brand</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.brand.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Brand Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $brand->name) }}" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="user_ids" class="form-label fw-bold">Select Users</label>
                        <select
                            class="form-select @error('user_ids') is-invalid @enderror @error('user_ids.*') is-invalid @enderror"
                            id="user_ids" name="user_ids[]" multiple="multiple" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ in_array($user->id, old('user_ids', $selectedUserIds ?? [])) ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_ids')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <script>
                        $(document).ready(function() {
                            $('#user_ids').select2({
                                placeholder: "Select users...",
                                allowClear: true,
                                width: '100%'
                            });
                        });
                    </script>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email', $brand->email) }}">
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                            value="{{ old('phone', $brand->phone) }}">
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address"
                            value="{{ old('address', $brand->address) }}">
                    </div>

                    <div class="mb-3">
                        <label for="url" class="form-label">Brand URL</label>
                        <input type="text" class="form-control" id="url" name="url"
                            value="{{ old('url', $brand->url) }}">
                    </div>

                    <div class="mb-3">
                        <label for="logo" class="form-label">Brand Logo</label>
                        <input type="file" class="form-control" id="logo" name="logo">
                        @if ($brand->logo)
                            <img src="{{ asset($brand->logo) }}" alt="Logo" class="mt-2" width="100">
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="1" {{ old('status', $brand->status ?? '') == 1 ? 'selected' : '' }}>Active
                            </option>
                            <option value="0" {{ old('status', $brand->status ?? '') == 0 ? 'selected' : '' }}>
                                Inactive</option>
                        </select>
                    </div>


                    <button type="submit" class="btn btn-primary">Update Brand</button>
                    <a href="{{ route('admin.brand') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
