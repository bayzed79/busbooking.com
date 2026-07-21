@extends('layout')
@section('navbar')
<ul class="navbar-nav ms-auto">
    @auth
    <li class="nav-item">
        <a class="nav-link" href="{{ url('view_profile') }}">Profile</a>
    </li>
    <li class="nav-item">
        <a href="{{ url('edit_profile') }}" class="btn btn-primary">Edit</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('change_password') }}">Change Password</a>
    </li>
    <li class="nav-item">
        <form action="{{ route('log_out') }}" method="GET">
            <!-- Change method to POST -->
            @csrf
            <button type="submit" class="btn btn-link nav-link">Logout</button>
        </form>

    </li>
    @else
    <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">Login</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">Register</a>
    </li>
    @endauth
</ul>
@endsection
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">Change Password</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('update_password') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
