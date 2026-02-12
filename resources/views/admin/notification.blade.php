@extends('admin.layout.app')

@section('title', 'Notifications')

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card p-5" bis_skin_checked="1">
            <h5 class="card-header">Notifications</h5>
            <div class="table-responsive text-nowrap" bis_skin_checked="1">
                <table class="table" id="notificationTable">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Date</th>
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
$(function () {
    $('#notificationTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.notification.data') }}",
        columns: [
            { data: 'title', name: 'title' },
            { data: 'message', name: 'message' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'date', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    $(document).on('click', '.mark-read', function () {
        let id = $(this).data('id');

        $.ajax({
            url: "{{ route('admin.notifications.markAsRead') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function (res) {
                if (res.success) {
                    $('#notificationTable').DataTable().ajax.reload(null, false);
                }
            }
        });
    });
});
</script>
@endsection
