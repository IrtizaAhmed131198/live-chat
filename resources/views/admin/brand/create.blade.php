`@extends('admin.layout.app')

@section('title', 'Create Brand')

@section('content')

    <style>
        span.select2-selection.select2-selection--multiple {
            background: transparent;
            display: block;
            width: 100%;
            padding: .543rem .9375rem;
            font-size: .9375rem;
            font-weight: 400;
            line-height: 1.375;
            color: var(--bs-heading-color);
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-color: transparent;
            background-clip: padding-box;
            border-radius: var(--bs-border-radius);
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            border-color:
                color-mix(in srgb, #e6e6f1 22%, #393a5a);
        }

        li.select2-selection__choice {
            color: black;
            padding-left: 20px !important;
        }

        span.select2-dropdown {
            background: #2b2c40 !important;
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h5>Create Brand</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.brand.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Brand Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="user_ids" class="form-label fw-bold">Select Users</label>
                            <select
                                class="form-select @error('user_ids') is-invalid @enderror @error('user_ids.*') is-invalid @enderror"
                                id="user_ids" name="user_ids[]" multiple required >
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ in_array($user->id, old('user_ids', [])) ? 'selected' : '' }} style="padding: 10px;">
                                        👤 {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>

                            @error('user_ids')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            @error('user_ids.*')
                                <span class="invalid-feedback">Invalid user selection</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ old('phone') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ old('address') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="url" class="form-label">Brand URL</label>
                            <input type="text" class="form-control" id="url" name="url"
                                value="{{ old('url') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="website" class="form-label">Brand Website</label>
                            <input type="text" class="form-control" id="website" name="website"
                                value="{{ old('website') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="domain" class="form-label">Brand Domain</label>
                            <input type="text" class="form-control" id="domain" name="domain"
                                value="{{ old('domain') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="logo" class="form-label">Brand Logo</label>
                            <input type="file" class="form-control" id="logo" name="logo" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="1" {{ old('status', $brand->status ?? '') == 1 ? 'selected' : '' }}>Active
                                </option>
                                <option value="0" {{ old('status', $brand->status ?? '') == 0 ? 'selected' : '' }}>
                                    Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Create Brand</button>
                            <a href="{{ route('admin.brand') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $("#user_ids").select2({
            // placeholder: "Select a User",
            allowClear: true,
        });

        document.getElementById('user_ids')?.addEventListener('change', function() {
            const selectedCount = this.selectedOptions.length;
            document.getElementById('selectedCount').textContent = selectedCount + ' user(s) selected';
        });
    </script>
@endsection
