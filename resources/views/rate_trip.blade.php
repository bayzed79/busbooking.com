@extends('layout')

@section('title', 'Rate Your Trip')

@section('content')
<div class="page-header">
    <h1 class="page-title">Rate Your Trip</h1>
    <p class="page-subtitle">Share your experience and help other travelers</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-star me-2"></i>Trip Details</h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted">Bus Information</h6>
                        <p class="mb-1"><strong>{{ $bus->bus_name }}</strong></p>
                        <p class="mb-1">Coach: {{ $bus->coach_no }}</p>
                        <p class="mb-1">Type: {{ $bus->coach_type }}</p>
                        {{-- <p class="mb-1">Bus ID: {{ $buslist->id }}</p> --}}
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Journey Details</h6>
                        <p class="mb-1"><strong>{{ $bus->starting_point }} → {{ $bus->ending_point }}</strong></p>
                        <p class="mb-1">Date: {{ \Carbon\Carbon::parse($tripDate)->format('M d, Y') }}</p>
                        <p class="mb-1">Time: {{ $bus->departing_time }}</p>
                    </div>
                </div>

                @if($userRating)
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    You have already rated this trip. You can update your rating below.
                </div>
                @endif

                <form action="{{ route('seat.rating.store') }}" method="POST" id="ratingForm">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Coach Number</label>
                            <input type="text" class="form-control" value="{{ $bus->coach_no }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Trip Date</label>
                            <input type="text" class="form-control"
                                value="{{ \Carbon\Carbon::parse($tripDate)->format('M d, Y') }}" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select Your Seat <span class="text-danger">*</span></label>
                        <select class="form-select" name="seat_name" required>
                            <option value="">Choose your seat...</option>
                            @if($seats)
                            @php
                            $seatsArray = is_string($seats) ? json_decode($seats, true) : $seats;
                            @endphp
                            @foreach($seatsArray as $seat)
                            <option value="{{ $seat }}" {{ $userRating && $userRating->seat_name == $seat ? 'selected' :
                                '' }}>
                                {{ $seat }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rating <span class="text-danger">*</span></label>
                        <div class="rating-stars">
                            <input type="radio" name="rating" value="5" id="star5" class="rating-input" {{ $userRating
                                && $userRating->rating == 5 ? 'checked' : '' }}>
                            <label for="star5" class="rating-star">★</label>
                            <input type="radio" name="rating" value="4" id="star4" class="rating-input" {{ $userRating
                                && $userRating->rating == 4 ? 'checked' : '' }}>
                            <label for="star4" class="rating-star">★</label>
                            <input type="radio" name="rating" value="3" id="star3" class="rating-input" {{ $userRating
                                && $userRating->rating == 3 ? 'checked' : '' }}>
                            <label for="star3" class="rating-star">★</label>
                            <input type="radio" name="rating" value="2" id="star2" class="rating-input" {{ $userRating
                                && $userRating->rating == 2 ? 'checked' : '' }}>
                            <label for="star2" class="rating-star">★</label>
                            <input type="radio" name="rating" value="1" id="star1" class="rating-input" {{ $userRating
                                && $userRating->rating == 1 ? 'checked' : '' }}>
                            <label for="star1" class="rating-star">★</label>
                        </div>
                        <div class="rating-text mt-2">
                            <small class="text-muted">Click on the stars to rate your experience</small>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="comment" class="form-label">Your Review <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="comment" name="comment" rows="4"
                            placeholder="Share your experience with this trip..."
                            required>{{ $userRating ? $userRating->comment : '' }}</textarea>
                        <div class="form-text">Tell us about your journey, comfort, service, and overall experience.
                        </div>
                    </div>

                    <input type="hidden" name="bus_id" value="{{$bus->id }}">

                    <input type="hidden" name="trip_date" value="{{ $tripDate }}">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('purchase_history') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Purchase History
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>
                            {{ $userRating ? 'Update Review' : 'Submit Review' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .rating-stars {
        display: flex;
        flex-direction: row-reverse;
        gap: 5px;
    }

    .rating-input {
        display: none;
    }

    .rating-star {
        font-size: 2rem;
        color: #ddd;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .rating-star:hover,
    .rating-star:hover~.rating-star,
    .rating-input:checked~.rating-star {
        color: #ffc107;
    }

    .card {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: none;
        border-radius: 1rem;
    }

    .card-header {
        border-radius: 1rem 1rem 0 0 !important;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)) !important;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
    }

    .btn {
        border-radius: 0.5rem;
        font-weight: 500;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('ratingForm');
    const ratingStars = document.querySelectorAll('.rating-input');
    const ratingText = document.querySelector('.rating-text small');

    // Update rating text when stars are clicked
    ratingStars.forEach(star => {
        star.addEventListener('change', function() {
            const rating = this.value;
            const ratingLabels = {
                1: 'Poor',
                2: 'Fair',
                3: 'Good',
                4: 'Very Good',
                5: 'Excellent'
            };
            ratingText.textContent = `You rated: ${ratingLabels[rating]} (${rating}/5 stars)`;
        });
    });

    // Form validation
    form.addEventListener('submit', function(e) {
        const seatName = document.querySelector('select[name="seat_name"]').value;
        const rating = document.querySelector('input[name="rating"]:checked');
        const comment = document.querySelector('textarea[name="comment"]').value.trim();

        if (!seatName) {
            e.preventDefault();
            alert('Please select your seat.');
            return;
        }

        if (!rating) {
            e.preventDefault();
            alert('Please provide a rating.');
            return;
        }

        if (!comment) {
            e.preventDefault();
            alert('Please write a review comment.');
            return;
        }

        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="loading-spinner"></span> Submitting...';
        submitBtn.disabled = true;
    });
});
</script>
@endsection
