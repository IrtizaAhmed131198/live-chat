@extends('admin.layout.app')

@section('title', 'Visitors')

@section('content')
    <!-- Content wrapper -->
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card p-5">
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
                        @forelse($visitors as $index => $visitorItem)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>
                                        @if ($visitorItem->website)
                                            {{ $visitorItem->website->name }}
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </strong>
                                </td>
                                <td>
                                    <strong>{{ optional($visitorItem->user)->email ?? 'N/A' }}</strong>
                                </td>
                                <td>
                                    <strong>{{ optional($visitorItem->user)->phone ?? 'N/A' }}</strong>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end m-0">
                                            <!-- Edit User Link -->
                                            @if($visitorItem->user)
                                                <a class="dropdown-item" href="{{ route('admin.visitor.edit', $visitorItem->user->id) }}">
                                                    <i class="bx bx-edit me-2"></i> Edit User
                                                </a>
                                            @endif
                                            
                                            <!-- Delete Visitor Form -->
                                            <form action="{{ route('admin.visitor.destroy', $visitorItem->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class="bx bx-trash me-2"></i> Delete Visitor
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
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
                        name: 'website.name'
                    },
                    {
                        data: 'email',
                        name: 'user.email'
                    },
                    {
                        data: 'phone',
                        name: 'user.phone'
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