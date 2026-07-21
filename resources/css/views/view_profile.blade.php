@extends('layout')
@section('navbar')
<ul class="navbar-nav ms-auto">
    @auth
    <li class="nav-item">
        <a href="{{ url('view_profile') }}" class="btn btn-primary">Profile Info</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('purchase_history') }}">Purchase History</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('edit_profile') }}">Edit</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('change_password') }}">Change Password</a>
    </li>
    <li class="nav-item">
        <form action="{{ route('log_out') }}" method="GET">
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
                    <h2 class="mb-0">User Profile</h2>
                </div>
                <div class="card-body">
                    @auth
                    <h3>Welcome, {{ auth()->user()->name }}</h3>
                    <div class="mb-3">
                        <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
                        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                        <p><strong>Mobile No:</strong> {{ auth()->user()->mobile_no }}</p>
                    </div>
                    @endauth
                    @guest
                    <p>Please <a href="{{ url('login') }}">sign in</a> to view your profile.</p>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection