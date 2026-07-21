@extends('layout')
@section('navbar')
<ul class="navbar-nav ms-auto">
    @auth
    <li class="nav-item">
        <a class="nav-link" href="{{ url('view_profile') }}">Profile Info</a>
    </li>
    <li class="nav-item">
        <a href="{{ url('purchase_history') }}" class="btn btn-primary">Purchase History</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('edit_profile') }}">Edit</a>
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
<style>
    table tbody tr:nth-child(n) {
        background-color: orange;
    }
</style>
@section('content')
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th scope="col">Transaction ID</th>
            <th scope="col">Staring Point</th>
            <th scope="col">Ending Point</th>
            <th scope="col">Deperting Time</th>
            <th scope="col">Updated At</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order as $key => $item)
        @php
        $bus = App\Models\Bus::find($item->bus_id);
        @endphp
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $item->transaction_id }}</td>
            <td>{{ optional($bus)->starting_point }}</td>
            <td>{{ optional($bus)->ending_point }}</td>
            <td>{{ $bus->departing_time }}</td>
            <td>{{ $item->updated_at }}</td>
            @if ($item->status == 'Processing')
            <td class="text-success">Success</td>
            <form action="{{ route('showdownloadinfo') }}" method="GET">
                @csrf
                <input type="hidden" name="bus_id" value="{{ $bus->id }}">
                <input type="hidden" name="order_id" value="{{ $item->id}}">
                <td> <button type="submit" class="btn btn-success">Download</button></td>
            </form>
            @else
            <td class="text-danger">Failed</td>
            <td> <button class="btn btn-danger">Unavailable</button></td>
            @endif



        </tr>
        @endforeach
        {{ $order->links() }}

    </tbody>
</table>
@endsection