@extends('layout.main')

@section('content')
    <div class="p-4 shadow mb-4 " style="background-color:aliceblue;">
        <h1 class="h3 mb-2 text-gray-800">{{ 'User Table' }}</h1>
        <div class="p-3"></div>
        <a href="{{ route('user.create') }}">
            <button class="btn btn-primary" type="button">Add User</button>
        </a>
        <form action="{{ route('user.destroy-bulk') }}" method="POST" onsubmit="return confirm('Are you sure?')" style="display:inline;">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit" title="Bulk Delete">
                Bulk Delete
            </button>
            <div class="p-3"></div>
            <table id="user" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th><input type="checkbox" id='checkbox-all'></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </form>
    </div>

    <script>
        $('#user').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('user.index') }}',
            },
            columns: [
                { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                { data: 'id', name: 'users.id'},
                { data: 'name', name: 'users.name'},
                { data: 'phone_number', name: 'phone_number'},
                { data: 'email', name: 'email'},
                { data: 'password', name: 'password'},
                { data: 'status_string', name: 'status_string'},
                { data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#checkbox-all').on('change', function() {
            var checked = $(this).is(':checked');
            $('#user').find('tbody input.bulk-checkbox').prop('checked', checked);
        });

        $('#user').on('change', 'tbody input.bulk-checkbox', function() {
            var $pageCheckboxes = $('#user').find('tbody input.bulk-checkbox');
            var allChecked = $pageCheckboxes.length && $pageCheckboxes.filter(':checked').length === $pageCheckboxes.length;
            $('#checkbox-all').prop('checked', !!allChecked);
        });

        $('#user').on('draw.dt', function() {
            var $pageCheckboxes = $('#user').find('tbody input.bulk-checkbox');
            var allChecked = $pageCheckboxes.length && $pageCheckboxes.filter(':checked').length === $pageCheckboxes.length;
            $('#checkbox-all').prop('checked', !!allChecked);
        });
    </script>

@endsection