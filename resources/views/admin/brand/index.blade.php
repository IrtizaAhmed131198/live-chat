@extends('admin.layout.app')

@section('title', 'Brand')

@section('content')
    <!-- Content wrapper -->
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card p-5">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Brand</h5>
                <a href="{{ route('admin.brand.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus me-2"></i> Add Brand
                </a>
            </div>

            <div class="table-responsive text-nowrap">
                <table id="users-table" class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Domain</th>
                            <th>URL</th>
                            <th>Active</th>
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
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.brand.getdata') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'domain',
                    name: 'domain'
                },
                {
                    data: 'url',
                    name: 'url'
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    </script>
    <script>
        $(document).on('change', '.toggle-status', function() {

            let id = $(this).data('id');
            let status = $(this).prop('checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('admin.brand.status.update') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    status: status
                },
                success: function(response) {
                    toastr.success('Status updated successfully!', 'Success!', {
                        "timeOut": "3000",
                        "positionClass": "toast-top-center"
                    });
                },
                error: function(xhr) {
                    toastr.error('Failed to update status!', 'Error!', {
                        "timeOut": "3000",
                        "positionClass": "toast-top-center"
                    });
                }
            });

        });
    </script>
@endsection
