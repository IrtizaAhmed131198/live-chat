@extends('admin.layout.app')

@section('title', 'Edit Visitor')

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
            border-color: color-mix(in srgb, #e6e6f1 22%, #393a5a);
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
                <h5>Edit Visitor</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.visitor.update', $visitor->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- User Selection (jisse email aur phone aayega) -->
                    {{-- <div class="mb-3">
                        <label for="user_id" class="form-label">Select User</label>
                        <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id"
                            required>
                            <option value="">-- Select User --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" data-email="{{ $user->email }}"
                                    data-phone="{{ $user->phone }}"
                                    {{ old('user_id', $visitor->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div> --}}

                    <!-- Website Selection (jisse website name aayega) -->
                    <div class="mb-3">
                        <label for="website_id" class="form-label">Select Website</label>
                        <select class="form-control @error('website_id') is-invalid @enderror" id="website_id"
                            name="website_id" required>
                            <option value="">-- Select Website --</option>
                            @foreach ($websites as $website)
                                <option value="{{ $website->id }}" data-name="{{ $website->name }}"
                                    {{ old('website_id', $visitor->website_id) == $website->id ? 'selected' : '' }}>
                                    {{ $website->name }} ({{ $website->domain }})
                                </option>
                            @endforeach
                        </select>
                        @error('website_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Display User Details (Read Only) -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">User Email</label>
                                <input type="text" class="form-control" id="display_email"
                                    value="{{ $visitor->user->email ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">User Phone</label>
                                <input type="text" class="form-control" id="display_phone"
                                    value="{{ $visitor->user->phone ?? '' }}">
                            </div>
                        </div>
                    </div>

                    <!-- Display Website Details (Read Only) -->
                    <div class="mb-3">
                        <label class="form-label">Website Name</label>
                        <input type="text" class="form-control" id="display_website_name"
                            value="{{ $visitor->website->name ?? '' }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Update Visitor</button>
                    <a href="{{ route('admin.visitor') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    
@endsection
@section('js')
<script>
        // Page load pe bhi data set karo
        document.addEventListener('DOMContentLoaded', function() {
            // Initial values set karo (yeh already set hain but ensure kar lo)
            var userSelect = document.getElementById('user_id');
            var websiteSelect = document.getElementById('website_id');

            if (userSelect.value) {
                var selectedUser = userSelect.options[userSelect.selectedIndex];
                document.getElementById('display_email').value = selectedUser.dataset.email || '';
                document.getElementById('display_phone').value = selectedUser.dataset.phone || '';
            }

            if (websiteSelect.value) {
                var selectedWebsite = websiteSelect.options[websiteSelect.selectedIndex];
                document.getElementById('display_website_name').value = selectedWebsite.dataset.name || '';
            }
        });

        // Update display fields when user changes
        document.getElementById('user_id').addEventListener('change', function() {
            var selected = this.options[this.selectedIndex];
            document.getElementById('display_email').value = selected.dataset.email || '';
            document.getElementById('display_phone').value = selected.dataset.phone || '';
        });

        // Update display fields when website changes
        document.getElementById('website_id').addEventListener('change', function() {
            var selected = this.options[this.selectedIndex];
            document.getElementById('display_website_name').value = selected.dataset.name || '';
        });
    </script>
@endsection