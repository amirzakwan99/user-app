<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            @php
                switch ($user->status) {
                    case \App\Models\User::STATUS_ACTIVE:
                        $status = 'Active';
                        break;
                    case \App\Models\User::STATUS_INACTIVE:
                        $status = 'Inactive';
                        break;
                    case \App\Models\User::STATUS_DELETED:
                        $status = 'Deleted';
                        break;
                    default:
                        $status = 'Undefined';
                        break;
                }
            @endphp
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>="{{ $user->phone_number }}"</td>
                <td>{{ $user->email }}</td>
                <td>{{ $status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
