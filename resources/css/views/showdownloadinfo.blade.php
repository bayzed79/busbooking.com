{{-- bus and order --}}
@extends('mainlayout')

@section('content')
<div class="container mt-4">
    <div class="card bg-info text-white border-info mb-3">
        <div class="card-header">User Information</div>
        @php
        $ticketlist = json_decode($order->ticketlist);
        @endphp
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">Name:</div>
                <div class="col-md-9">{{$order->name }}</div>
            </div>
            <div class="row">
                <div class="col-md-3">Email:</div>
                <div class="col-md-9">{{ $order->email }}</div>
            </div>
            <div class="row">
                <div class="col-md-3">Mobile No:</div>
                <div class="col-md-9">{{ $order->phone }}</div>
            </div>

            <div class="row">
                <div class="col-md-3">Ticket List:</div>
                <div class="col-md-9">
                    <ul class="list-unstyled">
                        @php
                        $totalFare = 0;
                        $fare = floatval($bus->fare);
                        @endphp
                        @foreach ($ticketlist as $ticket)
                        @php
                        $totalFare += $fare;
                        @endphp
                        <li>{{ $ticket }} - {{ $bus->fare }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">Total Fare:</div>
                <div class="col-md-9">{{ $totalFare }}</div>
            </div>
            <hr> <!-- Add a horizontal line to separate user information and bus information -->
            <div class="row">
                <div class="col-md-3">Date:</div>
                <div class="col-md-9">{{ $bus->date }}</div>
            </div>
            <div class="row">
                <div class="col-md-3">Bus Name:</div>
                <div class="col-md-9">{{ $bus->bus_name }}</div>
            </div>
            <div class="row">
                <div class="col-md-3">Departing Time:</div>
                <div class="col-md-9">{{ $bus->departing_time }}</div>
            </div>
            <div class="row">
                <div class="col-md-3">Coach No:</div>
                <div class="col-md-9">{{ $bus->coach_no }}</div>
            </div>
            <div class="row">
                <div class="col-md-3">Starting Point:</div>
                <div class="col-md-9">{{ $bus->starting_point }}</div>
            </div>
            <div class="row">
                <div class="col-md-3">Ending Point:</div>
                <div class="col-md-9">{{ $bus->ending_point }}</div>
            </div>
            <div class="row">
                <div class="col-md-3">Coach Type:</div>
                <div class="col-md-9">{{ $bus->coach_type }}</div>
            </div>
            <div class="row">
                <div class="col-md-3"> Transaction Id:</div>
                <div class="col-md-9">{{ $order->transaction_id }}</div>
            </div>
            <div class="row">
                <div class="col-md-3"> Card Issuer:</div>
                <div class="col-md-9">{{ $card_issuer }}</div>
            </div>
        </div>
    </div>
    <form action="{{ route('downloadTicket') }}" method="get">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->id }}">
        <button type="submit" class="btn btn-primary">Download Ticket</button>
    </form>
</div>


@guest
<div class="container mt-4">
    <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">Please Login and then Buy a ticket</h4>
        <p>You need to be logged in to view your ticket information.</p>
    </div>
</div>
@endguest
@endsection