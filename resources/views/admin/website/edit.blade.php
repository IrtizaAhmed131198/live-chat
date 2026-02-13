@extends('admin.layout.app')

@section('title', 'Edit Brand')

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
                <h5>Edit Website</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.website.update', $website->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Website Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $website->name) }}" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="domain" class="form-label">Domain</label>
                        <input type="domain" class="form-control" id="domain" name="domain"
                            value="{{ old('domain', $website->domain) }}">
                    </div>


                    <button type="submit" class="btn btn-primary">Update Website</button>
                    <a href="{{ route('admin.website') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $("#user_ids").select2({
            placeholder: "Select a User",
            allowClear: true
        });
    </script>
@endsection
