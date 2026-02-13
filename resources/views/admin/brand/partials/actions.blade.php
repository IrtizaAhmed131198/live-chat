<div class="dropdown">
    <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
        <i class="bx bx-dots-vertical-rounded"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-end m-0">
        <a class="dropdown-item" href="{{ route('admin.brand.edit', $brand->id) }}">
            <i class="bx bx-edit me-2"></i> Edit
        </a>
        <form action="{{ route('admin.brand.destroy', $brand->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure?')">
                <i class="bx bx-trash me-2"></i> Delete
            </button>
        </form>
    </div>
</div>
