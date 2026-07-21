@extends('admin.layout')
@section('navbar')
<ul class="navbar-nav ms-auto">

    <li class="nav-item">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin_show_all_user') }}">Users</a>
    </li>
    <li class=" nav-item">
        <a class="nav-link" href="{{ route('adminOrders') }}">Orders</a>
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
@php
use App\Models\User;
use App\Models\Buslist;
use App\Models\Order;
$totalBuses = Buslist::all()->count();
$totalUsers = User::all()->count();
$order = Order::where('status', 'processing')->get();
$totalPurchasedTickets = $order->count();
$totalPendingTickets = Order::where('status', 'pending')->count();
$totalCanceledTickets = Order::all()->count()-$totalPurchasedTickets-$totalPendingTickets;
$totalRevenue = 0;
foreach ($order as $item) {

$totalRevenue += (int) $item->amount;
}
@endphp
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Buses</h5>
                    <p class="card-text">{{ $totalBuses }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Purchased Tickets</h5>
                    <p class="card-text">{{ $totalPurchasedTickets }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Pending Tickets</h5>
                    <p class="card-text">{{ $totalPendingTickets }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Canceled Tickets</h5>
                    <p class="card-text">{{ $totalCanceledTickets }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Revenue</h5>
                    <p class="card-text">${{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection