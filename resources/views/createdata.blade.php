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
            Add Bus
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="{{ url('showdata') }}">Buslist</a></li>
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
<div class="container mt-5">
    <a href="{{ url('showdata') }}" class="btn btn-secondary mb-3">Show Data</a>

    <h2 class="mb-4">Add Bus Information</h2>

    <form action="{{ url('storedata') }}" method="POST" class="needs-validation row g-3" novalidate>
        @csrf

        <div class="col-md-6">
            <label for="bus_name" class="form-label">Bus Name:</label>
            <input type="text" class="form-control" id="bus_name" name="bus_name" required>
            <div class="invalid-feedback">Please enter the bus name.</div>
        </div>

        <div class="col-md-6">
            <label for="departing_time" class="form-label">Departing Time:</label>
            <input type="time" class="form-control" id="departing_time" name="departing_time" required>
            <div class="invalid-feedback">Please enter the departing time.</div>
        </div>

        <div class="col-md-6">
            <label for="coach_no" class="form-label">Coach Number:</label>
            <input type="text" class="form-control" id="coach_no" name="coach_no" required>
            <div class="invalid-feedback">Please enter the coach number.</div>
        </div>

        <div class="col-md-6">
            <label for="starting_point" class="form-label">Starting Point:</label>
            <input type="text" class="form-control" id="starting_point" name="starting_point" list="cityList" required>
            <div class="invalid-feedback">Please enter the starting point.</div>
        </div>

        <div class="col-md-6">
            <label for="ending_point" class="form-label">Ending Point:</label>
            <input type="text" class="form-control" id="ending_point" name="ending_point" list="cityList" required>
            <div class="invalid-feedback">Please enter the ending point.</div>
        </div>

        <div class="col-md-6">
            <label for="fare" class="form-label">Fare:</label>
            <input type="number" class="form-control" id="fare" name="fare" step="0.01" min="0" max="9999999.99"
                title="Please enter a valid fare amount" required>
            <div class="invalid-feedback">Please enter a valid fare amount.</div>
        </div>

        <div class="col-md-6">
            <label for="coach_type" class="form-label">Coach Type:</label>
            <select class="form-select" id="coach_type" name="coach_type" required>
                <option value="">Select Coach Type</option>
                <option value="AC">AC</option>
                <option value="Non-AC">Non-AC</option>
            </select>
            <div class="invalid-feedback">Please select a coach type.</div>
        </div>

        <div class="col-md-6">
            <label for="total_seats" class="form-label">Total Seats:</label>
            <input type="text" class="form-control" id="total_seats" name="total_seats" required>
            <div class="invalid-feedback">Please enter 1-100</div>
        </div>

        <!-- Datalist for starting and ending points -->
        <datalist id="cityList">
            <option value="Barishal">
            <option value="Chattogram">
            <option value="Dhaka">
            <option value="Khulna">
            <option value="Rajshahi">
            <option value="Rangpur">
            <option value="Mymensingh">
            <option value="Sylhet">
        </datalist>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

<script>
    // Bootstrap validation
    (function () {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();

    // SSLCommerz embed script
    (function (window, document) {
        var loader = function () {
            var script = document.createElement("script"),
                tag = document.getElementsByTagName("script")[0];
            script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7);
            tag.parentNode.insertBefore(script, tag);
        };
        window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
    })(window, document);
</script>
@endsection