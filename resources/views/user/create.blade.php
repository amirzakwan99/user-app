@extends('layout.main')

@section('content')
    <div class="p-4 card shadow mb-4" style="background-color:aliceblue;">
        <h1 class="h3 mb-2 text-gray-800">{{ 'Add User' }}</h1>
        <p class="mb-4">Add New User</p>
        
        @include('user.form', ['type' => 'ADD', 'route' => route('user.store') ])
    </div>
@endsection
