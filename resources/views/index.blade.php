@extends('layout.main')

@section('content')
    <div class="p-5">
        <table id="user" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Salary</th>
                </tr>
            </thead>
        </table>
    </div>

    <script>
        ${'#user'}.DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('user.index') }}',
            },
            columns: [
                { data: '', name: ''},
                { data: '', name: ''},
                { data: '', name: ''},
                { data: '', name: ''},
                { data: '', name: ''},
                { data: '', name: ''},
            ]
        })
    </script>


@endsection