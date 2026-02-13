@extends('admin.layout.app')
@section('content')
    <!-- Content wrapper -->
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Add New User</h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Name -->
                    <div class="mb-4">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                            placeholder="Enter user name" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                            placeholder="Enter email address" required>
                    </div>

                    <!-- Image -->
                    <div class="mb-4">
                        <label class="form-label">Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="image">
                    </div>

                    <!-- Role -->
                    {{-- <div class="mb-4">
                        <label class="form-label">Role</label>
                        <select class="form-select" name="role" required>
                            <option value="2" {{ old('role') == 2 ? 'selected' : '' }}>Client</option>
                            <option value="3" {{ old('role') == 3 ? 'selected' : '' }}>Agent</option>
                        </select>
                    </div> --}}

                    <!-- Phone -->
                    <div class="mb-4">
                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" name="phone" value="{{ old('phone') }}"
                            placeholder="Enter phone number" required>
                    </div>

                    <!-- Address -->
                    <div class="mb-4">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" value="{{ old('address') }}"
                            placeholder="Enter address">
                    </div>

                    <!-- About -->
                    <div class="mb-4">
                        <label class="form-label">About</label>
                        <textarea class="form-control" name="about" rows="4" placeholder="Write something about the user...">{{ old('about') }}</textarea>
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" placeholder="Enter password" required>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password_confirmation"
                            placeholder="Confirm password" required>
                    </div>

                    <!-- Button -->
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-plus me-2"></i> Add User
                    </button>

                    <a href="{{ route('admin.users') }}" class="btn btn-secondary ms-2">Cancel</a>
                </form>


            </div>
        </div>
    </div>
@endsection
