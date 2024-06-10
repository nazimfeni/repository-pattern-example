<!-- resources/views/users/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>User Details</h1>
        <div class="card">
            <div class="card-body">
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <!-- Add other user details here -->
            </div>
        </div>
    </div>
@endsection
