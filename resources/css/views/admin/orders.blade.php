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
        <a href="{{ route('adminOrders') }}" class="btn btn-primary">Orders</a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">Add Bus</a>
    </li> --}}
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
        <form action="{{ route('adminLogOut') }}" method="GET">
            @csrf
            <button type="submit" class="btn btn-link nav-link">Logout</button>
        </form>
    </li>
</ul>
@endsection

@section('content')
<div class="container mt-5">
    <h2>Orders</h2>

    {{-- Search Form --}}
    <h2 class="my-4">Search Order by Column Name</h2>
    <form action="{{ route('adminOrderSearch') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="query" value="{{ isset($query) ? $query : '' }}">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    {{-- Orders Table --}}
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Transaction ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Amount</th>
                <th scope="col">Status</th>
                <th scope="col">Card Issuer</th>
                <th scope="col">Currency</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order as $item)
            <tr>
                <td>{{ $item->transaction_id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->amount }}</td>
                <td
                    class="@if($item->status == 'Processing') table-success @elseif($item->status == 'Pending') table-warning @else table-danger @endif">
                    {{ $item->status }}
                </td>
                <td>{{ $item->card_issuer }}</td>
                <td>{{ $item->currency }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination Links --}}

</div>
@endsection