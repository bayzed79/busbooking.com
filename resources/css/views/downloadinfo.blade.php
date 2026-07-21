<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Info</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    @auth
    <div class="container mt-4">
        <div class="card bg-info text-white border-info mb-3">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-6">Name: {{ auth()->user()->name }}</div>
                    <div class="col-md-6">Email: {{ auth()->user()->email }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">Mobile No: {{ auth()->user()->mobile_no }}</div>
                    <div class="col-md-6">Ticket Issue Time: {{ $order->updated_at }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">Ticket Issuer: {{ $order->card_issuer }}</div>
                    <div class="col-md-6">Transaction ID: {{ $order->transaction_id }}</div>
                </div>
                <div class="row mb-2">
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
                    <div class="col-md-6">Total Fare: {{ $totalFare }} {{ $order->currency }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="card bg-warning text-dark border-warning mb-3">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-4">Date: {{ $bus->date }}</div>
                    <div class="col-md-4">Departing Time: {{ $bus->departing_time }}</div>
                    <div class="col-md-4">Starting Point: {{ $bus->starting_point }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">Ending Point: {{ $bus->ending_point }}</div>
                    <div class="col-md-4">Bus Name: {{ $bus->bus_name }}</div>
                    <div class="col-md-4">Coach No: {{ $bus->coach_no }}</div>
                </div>
                <div class="row">
                    <div class="col-md-4">Coach Type: {{ $bus->coach_type }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="card bg-info text-white border-info mb-3">
            <div class="card-header">QR Code</div>
            <div class="card-body text-center">
                <img src="data:image/png;base64, {!! base64_encode(QrCode::size(200)->generate($order)) !!} ">
            </div>
        </div>
    </div>
    @endauth

    @guest
    <div class="container mt-4">
        <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">Please Login and then Buy a ticket</h4>
            <p>You need to be logged in to view your ticket information.</p>
        </div>
    </div>
    @endguest

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>