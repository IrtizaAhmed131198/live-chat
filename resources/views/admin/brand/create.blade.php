@extends('admin.layout.app')

@section('title', 'Create Brand')

@section('content')
    <style>
        /* Select box styling */
        select[multiple] {
            background-image: none !important;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            padding: 8px;
        }

        select[multiple] option {
            padding: 12px 15px !important;
            margin: 2px 0;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        select[multiple] option:hover {
            background-color: #e7f1ff !important;
        }

        select[multiple] option:checked {
            background-color: #0d6efd !important;
            color: white !important;
            font-weight: 500;
        }

        select[multiple] option:checked:hover {
            background-color: #0b5ed7 !important;
        }

        /* Selected count badge */
        #selectedCount {
            font-size: 0.9rem;
            padding: 6px 12px;
            border-radius: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
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
                    <div class="mb-3">
                        <label for="name" class="form-label">Brand Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="user_ids" class="form-label fw-bold">Select Users</label>
                        <select
                            class="form-select @error('user_ids') is-invalid @enderror @error('user_ids.*') is-invalid @enderror"
                            id="user_ids" name="user_ids[]" multiple required style="min-height: 200px;">
                            <option value="" disabled class="text-muted fst-italic">-- Select Users --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ in_array($user->id, old('user_ids', [])) ? 'selected' : '' }} style="padding: 10px;">
                                    👤 {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>

                        <!-- Selected count display - ye element missing tha -->
                        <div class="mt-2">
                            <span class="badge bg-info text-dark" id="selectedCount">
                                {{ count(old('user_ids', [])) }} user(s) selected
                            </span>
                        </div>

                        @error('user_ids')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        @error('user_ids.*')
                            <span class="invalid-feedback">Invalid user selection</span>
                        @enderror
                        <small class="form-text text-muted mt-2 d-block">
                            <i class="fas fa-info-circle"></i>
                            Hold Ctrl (Windows) or Cmd (Mac) to select multiple users
                        </small>
                    </div>

                    <script>
                        document.getElementById('user_ids')?.addEventListener('change', function() {
                            const selectedCount = this.selectedOptions.length;
                            document.getElementById('selectedCount').textContent = selectedCount + ' user(s) selected';
                        });
                    </script>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email') }}">
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                            value="{{ old('phone') }}">
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address"
                            value="{{ old('address') }}">
                    </div>

                    <div class="mb-3">
                        <label for="url" class="form-label">Brand URL</label>
                        <input type="text" class="form-control" id="url" name="url"
                            value="{{ old('url') }}">
                    </div>

                    <div class="mb-3">
                        <label for="logo" class="form-label">Brand Logo</label>
                        <input type="file" class="form-control" id="logo" name="logo">
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


                    <button type="submit" class="btn btn-primary">Create Brand</button>
                    <a href="{{ route('admin.brand') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
