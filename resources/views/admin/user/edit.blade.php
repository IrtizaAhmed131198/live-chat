@extends('admin.layout.app')
@section('content')
    <!-- Content wrapper -->
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Edit User</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Name Field -->
                    <div class="mb-4">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}"
                            placeholder="Enter user name" required>
                    </div>

                    <!-- Email Field -->
                    <div class="mb-4">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                            placeholder="Enter email address" required>
                    </div>

                    <!-- Image Field -->
                    <div class="mb-4">
                        <label for="image" class="form-label">Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="image" name="image"
                            placeholder="Upload user image">
                    </div>

                    <!-- Image Field -->
                    <div class="mb-4">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select mb-6" id="acceptPaymentsVia" name="role" required>
                            <option value="2" {{ $user->role == '2' ? 'selected' : '' }}>Client</option>
                            <option value="3" {{ $user->role == '3' ? 'selected' : '' }}>Agent</option>
                        </select>
                    </div>

                    <!-- Phone Field -->
                    <div class="mb-4">
                        <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ $user->phone }}"
                            placeholder="Enter phone number" required>
                    </div>

                    <!-- Address Field -->
                    <div class="mb-4">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address"
                            value="{{ $user->address }}" placeholder="Enter address">
                    </div>

                    <!-- About Field -->
                    <div class="mb-4">
                        <label for="about" class="form-label">About</label>
                        <textarea class="form-control" id="about" name="about" rows="4"
                            placeholder="Write something about the user...">{{ $user->about }}</textarea>
                    </div>

                    <!-- Password Field -->
                    <div class="mb-4">
                        <label for="password" class="form-label">Password <span class="text-muted">(Leave blank to keep
                                current)</span></label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Enter new password">
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            placeholder="Confirm new password">
                    </div>

                    <!-- Submit Button -->
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-2"></i> Update User
                            </button>
                            <a href="{{ route('admin.users') }}" class="btn btn-secondary ms-2">Cancel</a>
                        </div>
                    </div>
                </form>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
