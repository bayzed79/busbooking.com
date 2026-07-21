@extends('admin.layout')
@section('navbar')
<ul class="navbar-nav ms-auto">

    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin_show_all_user') }}">Users</a>
    </li>
    <li class=" nav-item">
        <a class="nav-link" href="{{ route('adminOrders') }}">Orders</a>
    </li>

    <li class="nav-item dropdown">
        <a class="btn btn-primary dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            Seat Info
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="{{ url('showdata') }}">Buslist</a></li>
            <li><a class="dropdown-item" href="{{ url('createdata') }}">Add Bus</a></li>
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
<div class="col-md-6">
    <form action="{{ route('fetch_bus_data') }}" method="POST">
        @csrf
        <label for="bus_date" class="form-label">Bus Date:</label>
        <div class="input-group">
            <input type="date" class="form-control" id="bus_date" name="bus_date" required>
            <button id="searchButton" class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('bus_date').value = today;
    });
</script>
@endsection