@extends('admin.layout.app')

@section('title', 'Brand')

@section('content')
    <!-- Content wrapper -->
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card p-5">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Webstie</h5>
                <a href="{{ route('admin.website.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus me-2"></i> Add Website
                </a>
            </div>

            <div class="table-responsive text-nowrap">
                <table id="users-table" class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Website</th>
                            <th>Domain</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse($website as $index => $website)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $website->name }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $website->domain }}</strong>
                                </td>

                                <td>
                                    <div class="dropdown">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end m-0">
                                            <a class="dropdown-item" href="{{ route('admin.website.edit', $website->id) }}">
                                                <i class="bx bx-edit me-2"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.website.destroy', $website->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class="bx bx-trash me-2"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <p class="text-muted mb-0">No Website found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.website.getdata') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'domain',
                        name: 'domain'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endsection
