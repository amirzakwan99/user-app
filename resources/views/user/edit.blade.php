@extends('layout.main')

@section('content')
    <div class="p-4 card shadow mb-4" style="background-color:aliceblue;">
        <h1 class="h3 mb-2 text-gray-800">{{ __('Edit User') }}</h1>
        <p class="mb-4">Edit User</p>
        
        @include('user.form', ['type' => 'EDIT', 'route' => route('user.update', $user->id) ])
    </div>
@endsection
