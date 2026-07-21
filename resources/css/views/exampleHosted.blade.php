<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="SSLCommerz">
    <title>Example - Hosted Checkout | SSLCommerz</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>

<body class="bg-light">
    <div class="container">
        <div class="py-5 text-center">
            <h2>Hosted Payment - SSLCommerz</h2>
            <p class="lead">Below is an example form built entirely with Bootstrap’s form controls. We have provided
                this sample form for understanding Hosted Checkout Payment with SSLCommerz.</p>
        </div>

        <div class="row">


            {{-- payment details will be added here --}}
            @auth
            <div class="container mt-4">
                <div class="card bg-info text-white border-info mb-3">
                    <div class="card-header">User Information</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">Name:</div>
                            <div class="col-md-9">{{ auth()->user()->name }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">Email:</div>
                            <div class="col-md-9">{{ auth()->user()->email }}</div>
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
                    </div>
                </div>
                {{-- <form
                    action="{{ route('downloadTicket', ['busId' => $bus->id, 'ticketlist' => json_encode($ticketlist)]) }}"
                    method="post">
                    @csrf
                    <button type="submit" class="btn btn-primary">Download Ticket</button>
                </form> --}}
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
            @auth

            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">Billing address</h4>
                <form action="{{ url('/pay') }}" method="POST" class="needs-validation">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token" />
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="firstName">Full name</label>
                            <input type="text" name="customer_name" class="form-control" id="customer_name"
                                placeholder="" value="{{ auth()->user()->name }}" required>
                            <div class="invalid-feedback">
                                Valid customer name is required.
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="mobile">Mobile</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">+88</span>
                            </div>
                            <input type="text" name="customer_mobile" class="form-control" id="mobile"
                                placeholder="Mobile" value="{{ auth()->user()->mobile_no }}" required>
                            <div class="invalid-feedback" style="width: 100%;">
                                Your Mobile number is required.
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email">Email <span class="text-muted">(Optional)</span></label>
                        <input type="email" name="customer_email" class="form-control" id="email"
                            placeholder="you@example.com" value="{{ auth()->user()->email }}" required>
                        <div class=" invalid-feedback">
                            Please enter a valid email address for shipping updates.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St"
                            value="kuet, khulna" required>
                        <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                        <input type="text" class="form-control" id="address2" name="address2"
                            placeholder="Apartment or suite">
                    </div>

                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="country">Country</label>
                            <select class="custom-select d-block w-100" id="country" required>
                                <option value="">Choose...</option>
                                <option value="Bangladesh">Bangladesh</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid country.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="state">State</label>
                            <select class="custom-select d-block w-100" id="state" required>
                                <option value="">Choose...</option>
                                @php
                                $divisions = ["Barisal", "Chittagong", "Dhaka", "Khulna", "Mymensingh", "Rajshahi",
                                "Rangpur",
                                "Sylhet"];
                                @endphp
                                @foreach ($divisions as $division)
                                <option value="{{ $division }}">{{ $division }}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback">
                                Please provide a valid state.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="zip">Zip</label>
                            <input type="text" class="form-control" id="zip" placeholder="" required>
                            <div class="invalid-feedback">
                                Zip code required.
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="same-address">
                        <input type="hidden" value="{{ $totalFare }}" name="amount" id="total_amount" required />
                        <input type="hidden" value="{{ $bus->id }}" name="bus_id" required />
                        @foreach($ticketlist as $index => $ticket)
                        <input type="hidden" value="{{ $ticket }}" name="ticketlist[{{ $index }}]" required />
                        @endforeach
                        <label class="custom-control-label" for="same-address">Shipping address is the same as my
                            billing
                            address</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="save-info">
                        <label class="custom-control-label" for="save-info">Save this information for next time</label>
                    </div>
                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout
                        (Hosted)</button>
                </form>
            </div>
        </div>
        @endauth


        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">&copy; 2019 Company Name</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Privacy</a></li>
                <li class="list-inline-item"><a href="#">Terms</a></li>
                <li class="list-inline-item"><a href="#">Support</a></li>
            </ul>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

</html>