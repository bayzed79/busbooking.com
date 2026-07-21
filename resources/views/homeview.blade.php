@extends('layout')

@section('title', 'JatraPoth - Book Bus Tickets Online')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        <!-- Hero Section Header -->
        <div class="text-center text-white mb-4">
            <h1 class="display-6 fw-bold text-white mb-2">Book Bus Tickets Online</h1>
            <p class="lead opacity-90 text-white-50">Fast, secure, and hassle-free travel across Bangladesh</p>
        </div>

        <!-- Main Search Form Card -->
        <div class="glass-card">
            <form action="{{ route('search_bus') }}" method="GET" id="busSearchForm">
                <div class="row g-3">
                    <!-- Origin City Input -->
                    <div class="col-md-6">
                        <label for="starting_point" class="form-label fw-semibold">
                            <i class="fas fa-map-marker-alt text-danger me-1"></i> Starting From
                        </label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="starting_point" name="starting_point"
                                list="cityList" placeholder="e.g. Dhaka" required autocomplete="off"
                                value="{{ request('starting_point', 'Dhaka') }}">
                        </div>
                    </div>

                    <!-- Destination City Input -->
                    <div class="col-md-6">
                        <label for="ending_point" class="form-label fw-semibold">
                            <i class="fas fa-location-arrow text-primary me-1"></i> Going To
                        </label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="ending_point" name="ending_point"
                                list="cityList" placeholder="e.g. Chattogram" required autocomplete="off"
                                value="{{ request('ending_point') }}">
                        </div>
                    </div>

                    <!-- Shared City Datalist -->
                    <datalist id="cityList">
                        <option value="Dhaka">
                        <option value="Chattogram">
                        <option value="Sylhet">
                        <option value="Rajshahi">
                        <option value="Khulna">
                        <option value="Barishal">
                        <option value="Rangpur">
                        <option value="Mymensingh">
                        <option value="Cox's Bazar">
                    </datalist>

                    <!-- Departure Date Input -->
                    <div class="col-md-6">
                        <label for="depart-date" class="form-label fw-semibold">
                            <i class="fas fa-calendar-alt text-success me-1"></i> Journey Date
                        </label>
                        <input type="date" class="form-control" id="depart-date" name="date"
                            value="{{ request('date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                    </div>

                    <!-- Return Date Input (Optional) -->
                    <div class="col-md-6">
                        <label for="return-date" class="form-label fw-semibold">
                            <i class="fas fa-calendar-check text-muted me-1"></i> Return Date (Optional)
                        </label>
                        <input type="date" class="form-control" id="return-date" name="return-date"
                            min="{{ date('Y-m-d') }}">
                    </div>

                    <!-- Popular Route Quick Chips (One-Tap Selection) -->
                    <div class="col-12 mt-3">
                        <small class="text-muted d-block mb-2 fw-semibold">Popular Routes (Tap to select):</small>
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="route-chip" onclick="selectRoute('Dhaka', 'Chattogram')">
                                Dhaka <i class="fas fa-arrow-right mx-1 text-muted"></i> Chattogram
                            </button>
                            <button type="button" class="route-chip" onclick="selectRoute('Dhaka', 'Sylhet')">
                                Dhaka <i class="fas fa-arrow-right mx-1 text-muted"></i> Sylhet
                            </button>
                            <button type="button" class="route-chip" onclick="selectRoute('Dhaka', 'Cox\'s Bazar')">
                                Dhaka <i class="fas fa-arrow-right mx-1 text-muted"></i> Cox's Bazar
                            </button>
                            <button type="button" class="route-chip" onclick="selectRoute('Dhaka', 'Rajshahi')">
                                Dhaka <i class="fas fa-arrow-right mx-1 text-muted"></i> Rajshahi
                            </button>
                        </div>
                    </div>

                    <!-- Primary CTA Button (Thumb Zone Priority) -->
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary-touch w-100 py-3 text-uppercase tracking-wider fw-bold">
                            <i class="fas fa-search me-2"></i> Search Available Buses
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Features Grid -->
        <div class="row g-3 text-white mt-2">
            <div class="col-md-4">
                <div class="p-3 glass-card bg-dark bg-opacity-50 border-secondary border-opacity-25 h-100 text-center">
                    <div class="fs-2 text-warning mb-2"><i class="fas fa-shield-alt"></i></div>
                    <h3 class="h6 fw-bold text-white">Instant E-Ticket</h3>
                    <p class="small text-white-50 mb-0">Get your ticket confirmed immediately with QR verification.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 glass-card bg-dark bg-opacity-50 border-secondary border-opacity-25 h-100 text-center">
                    <div class="fs-2 text-success mb-2"><i class="fas fa-star"></i></div>
                    <h3 class="h6 fw-bold text-white">Verified Seat Reviews</h3>
                    <p class="small text-white-50 mb-0">Read passenger feedback for every coach before booking.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 glass-card bg-dark bg-opacity-50 border-secondary border-opacity-25 h-100 text-center">
                    <div class="fs-2 text-info mb-2"><i class="fas fa-credit-card"></i></div>
                    <h3 class="h6 fw-bold text-white">Secure Payments</h3>
                    <p class="small text-white-50 mb-0">Pay with bKash, Nagad, cards or net banking safely.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function selectRoute(start, end) {
        document.getElementById('starting_point').value = start;
        document.getElementById('ending_point').value = end;
        document.getElementById('depart-date').focus();
    }
</script>
@endsection