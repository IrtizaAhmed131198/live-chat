@extends('admin.layout.app')

@section('title', 'Edit Brand')

@section('content')
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
                        <label for="user_id" class="form-label">Select User</label>
                        <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id"
                            required>
                            <option value="">-- Select User --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('user_id', $brand->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

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
