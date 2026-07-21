@extends('admin.layout')
@section('navbar')
<ul class="navbar-nav ms-auto">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>

    </li>
    <li class="nav-item">
        <a href="{{ route('admin_show_all_user') }}" class="btn btn-primary">Users</a>

    </li>
    <li class=" nav-item">
        <a class="nav-link" href="{{ route('adminOrders') }}">Orders</a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Manage Bus
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="{{ url('showdata') }}">Buslist</a></li>
            <li><a class="dropdown-item" href="{{ url('createdata') }}">Add Bus</a></li>
            <li><a class="dropdown-item" href="{{ route('admin_seat_info_button') }}">Seat Info</a></li>
        </ul>
    </li>
    <li class="nav-item">
        <form action="{{ route('admin.dashboard') }}" method="GET">
            @csrf
            <button type="submit" class="btn btn-link nav-link">Logout</button>
        </form>

    </li>
</ul>

@endsection

@section('content')
@php
use App\Models\User;
$users = User::all();
$totalUsers = $users->count();
@endphp

<div class="container">
    <h2 class="my-4">User Information</h2>
    <form action="{{ route('admin_search') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="query" placeholder="Search by name, email, or phone number"
                value="{{ isset($query) ? $query : '' }}">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>
    <p>Total Number of Users: {{ $totalUsers }}</p>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->mobile_no }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection