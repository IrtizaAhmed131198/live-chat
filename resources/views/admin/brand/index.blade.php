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
                            <th>Logo</th>
                            <th>Brand Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse($brand as $index => $brand)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    {{-- @dd($brand->logo) --}}
                                    <img height="50px" src="{{ asset($brand->logo) }}" alt="">
                                </td>
                                <td>
                                    <strong>{{ $brand->name }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $brand->email }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $brand->phone }}</strong>
                                </td>

                                <td>
                                    <div class="dropdown">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end m-0">
                                            <a class="dropdown-item" href="{{ route('admin.brand.edit', $brand->id) }}">
                                                <i class="bx bx-edit me-2"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.brand.destroy', $brand->id) }}" method="POST"
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
                                    <p class="text-muted mb-0">No Brand found</p>
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
                ajax: "{{ route('admin.brand.getdata') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'logo', // Added comma here
                        name: 'logo',
                        render: function(data) {
                            return '<img height="100px" src="{{ asset('') }}' + data + '" alt="">';
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
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
