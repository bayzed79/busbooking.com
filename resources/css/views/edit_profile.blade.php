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
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">Edit Profile</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('update_profile') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="mobile_no" class="form-label">Mobile No</label>
                            <input type="text" class="form-control" id="mobile_no" name="mobile_no" value="{{ auth()->user()->mobile_no }}" required>
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
