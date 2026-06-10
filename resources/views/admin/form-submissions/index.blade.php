@extends('admin.layout.app')

@section('title', 'Form Submissions')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card p-5">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Form Submissions</h5>
        </div>
        {{-- Filter Controls (mirroring Users page) --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <label class="form-label">Brand</label>
                <select id="filter-brand" class="form-select">
                    <option value="">All</option>
                    @foreach($brands as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Form Action</label>
                <input type="text" id="filter-action" class="form-control" placeholder="e.g. /contact">
            </div>
            <div class="col-md-2">
                <label class="form-label">From</label>
                <input type="date" id="filter-date-from" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label">To</label>
                <input type="date" id="filter-date-to" class="form-control">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" id="filter-submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table id="form-submissions-table" class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Brand</th>
                        <th>Page URL</th>
                        <th>Form Action</th>
                        <th>Form Method</th>
                        <th>Submitted At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(function() {
        var table = $('#form-submissions-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.form-submissions.data') }}",
                data: function (d) {
                    d.brand_id = $('#filter-brand').val();
                    d.form_action = $('#filter-action').val();
                    d.date_from = $('#filter-date-from').val();
                    d.date_to = $('#filter-date-to').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'brand', name: 'brand' },
                { data: 'page_url', name: 'page_url' },
                { data: 'form_action', name: 'form_action' },
                { data: 'form_method', name: 'form_method' },
                { data: 'created_at', name: 'created_at' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
        // Trigger filter reload
        $('#filter-submit').on('click', function () {
            table.ajax.reload();
        });
    });
</script>
@endsection