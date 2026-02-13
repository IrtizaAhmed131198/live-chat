@extends('admin.layout.app')

@section('title', 'Brand')

@section('content')
    <!-- Content wrapper -->
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card p-5">
            {{-- <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Visitor</h5>
                <a href="{{ route('admin.visitor.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus me-2"></i> Add Visitor
                </a>
            </div> --}}

            <div class="table-responsive text-nowrap">
                <table id="users-table" class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Website</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse($visitor as $index => $visitor)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>
                                        @if ($visitor->website)
                                            {{ $visitor->website->name }}
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </strong>
                                </td>
                                <td>
                                    <strong>{{ optional($visitor->user)->email ?? 'N/A' }}</strong>
                                </td>
                                <td>
                                    <strong>{{ optional($visitor->user)->phone ?? 'N/A' }}</strong>
                                </td>

                                <td>
                                    <div class="dropdown">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end m-0">
                                            <a class="dropdown-item" href="{{ route('admin.visitor.edit', $visitor->id) }}">
                                                <i class="bx bx-edit me-2"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.visitor.destroy', $visitor->id) }}" method="POST"
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
                                    <p class="text-muted mb-0">No Visitor found</p>
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
                ajax: "{{ route('admin.visitor.getdata') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'website_name',
                        name: 'website.name' // Website table se name
                    },
                    {
                        data: 'email',
                        name: 'user.email' // User table se email
                    },
                    {
                        data: 'phone',
                        name: 'user.phone' // User table se phone
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
