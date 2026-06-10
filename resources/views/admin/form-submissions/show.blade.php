@extends('admin.layout.app')

@section('title', 'Form Submission Details')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card p-5">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Form Submission #{{ $submission->id }}</h5>
            <a href="{{ route('admin.form-submissions') }}" class="btn btn-secondary btn-sm">
                <i class="bx bx-arrow-back me-1"></i> Back
            </a>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <p><strong>Brand:</strong> {{ optional($submission->brand)->name ?? '-' }}</p>
                <p><strong>Page URL:</strong> {{ $submission->page_url ?? '-' }}</p>
                <p><strong>Form Action:</strong> {{ $submission->form_action ?? '-' }}</p>
                <p><strong>Form Method:</strong> {{ $submission->form_method ?? '-' }}</p>
                <p><strong>Submitted At:</strong> {{ $submission->created_at->format('Y-m-d H:i') }}</p>
            </div>
            <div class="col-md-6">
                <h6>Form Data</h6>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Field</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($submission->form_data as $field => $value)
                                <tr>
                                    <td>{{ $field }}</td>
                                    <td>
                                        @if(is_array($value) || is_object($value))
                                            {{ json_encode($value, JSON_UNESCAPED_SLASHES) }}
                                        @else
                                            {{ $value }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection