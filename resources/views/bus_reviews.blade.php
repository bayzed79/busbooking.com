@extends('mainlayout')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-8">
            <!-- Bus Information Header -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-bus me-2"></i>
                        {{ $bus->bus_name }} - Reviews & Ratings
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Route:</strong> {{ $bus->starting_point }} → {{ $bus->ending_point }}</p>
                            <p><strong>Departure Time:</strong> {{ $bus->departing_time }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Date:</strong> {{ $bus->date }}</p>
                            <p><strong>Fare:</strong> ৳{{ $bus->fare }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Overall Statistics -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Overall Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <div class="stat-item">
                                <h3 class="text-primary">{{ $totalReviews }}</h3>
                                <p class="text-muted">Total Reviews</p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="stat-item">
                                <h3 class="text-success">{{ number_format($averageRating, 1) }}</h3>
                                <p class="text-muted">Average Rating</p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="stat-item">
                                <h3 class="text-info">{{ $ratedSeats }}</h3>
                                <p class="text-muted">Rated Seats</p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="stat-item">
                                <h3 class="text-warning">{{ $bus->total_seats }}</h3>
                                <p class="text-muted">Total Seats</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seat Rating Statistics -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-star me-2"></i>Seat Ratings</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($seatStats as $stat)
                        <div class="col-md-4 mb-3">
                            <div class="seat-stat-card p-3 border rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Seat {{ $stat->seat_name }}</h6>
                                        <div class="stars-display mb-1">
                                            @for($i = 1; $i <= 5; $i++) @if($i <=$stat->avg_rating)
                                                <i class="fas fa-star text-warning"></i>
                                                @elseif($i - 0.5 <= $stat->avg_rating)
                                                    <i class="fas fa-star-half-alt text-warning"></i>
                                                    @else
                                                    <i class="far fa-star text-warning"></i>
                                                    @endif
                                                    @endfor
                                        </div>
                                        <small class="text-muted">{{ number_format($stat->avg_rating, 1) }} ({{
                                            $stat->total_reviews }} reviews)</small>
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary"
                                        onclick="showSeatReviews('{{ $stat->seat_name }}', {{ $bus->id }})">
                                        View Reviews
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Reviews -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-comments me-2"></i>Recent Reviews</h5>
                </div>
                <div class="card-body">
                    @if($recentReviews->count() > 0)
                    @foreach($recentReviews as $review)
                    <div class="review-item border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="stars-display mb-1">
                                    @for($i = 1; $i <= 5; $i++) @if($i <=$review->rating)
                                        <i class="fas fa-star text-warning"></i>
                                        @else
                                        <i class="far fa-star text-warning"></i>
                                        @endif
                                        @endfor
                                </div>
                                <strong>{{ $review->user->name }}</strong>
                                <small class="text-muted d-block">Seat {{ $review->seat_name }} | Trip Date: {{
                                    $review->trip_date }}</small>
                                <small class="text-muted">Reviewed on {{ $review->created_at->format('M d, Y')
                                    }}</small>
                            </div>
                            @if(Auth::id() == $review->user_id)
                            <div class="review-actions">
                                <button class="btn btn-sm btn-outline-primary"
                                    onclick="editRating({{ $review->id }}, {{ $review->rating }}, '{{ $review->comment }}')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteRating({{ $review->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            @endif
                        </div>
                        @if($review->comment)
                        <p class="mt-2 mb-0">{{ $review->comment }}</p>
                        @endif
                    </div>
                    @endforeach
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No reviews yet</h5>
                        <p class="text-muted">Be the first to rate this bus!</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-tools me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary"
                            onclick="showRatingForm('', {{ $bus->id }}, '{{ $bus->date }}')">
                            <i class="fas fa-star me-2"></i>Rate a Seat
                        </button>
                        <a href="{{ route('seat_view', $bus->id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-chair me-2"></i>View Seat Layout
                        </a>
                        <a href="{{ route('search_bus') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-search me-2"></i>Search Other Buses
                        </a>
                    </div>
                </div>
            </div>

            <!-- Rating Distribution -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Rating Distribution</h5>
                </div>
                <div class="card-body">
                    @php
                    $ratingDistribution = $recentReviews->groupBy('rating')->map->count();
                    @endphp

                    @for($i = 5; $i >= 1; $i--)
                    @php
                    $count = $ratingDistribution->get($i, 0);
                    $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                    @endphp
                    <div class="rating-bar mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="stars-display">
                                @for($j = 1; $j <= 5; $j++) @if($j <=$i) <i class="fas fa-star text-warning"></i>
                                    @else
                                    <i class="far fa-star text-warning"></i>
                                    @endif
                                    @endfor
                            </div>
                            <small class="text-muted">{{ $count }}</small>
                        </div>
                        <div class="progress mt-1" style="height: 8px;">
                            <div class="progress-bar bg-warning" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Seat Reviews Modal -->
<div class="modal fade" id="seatReviewsModal" tabindex="-1" aria-labelledby="seatReviewsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="seatReviewsModalLabel">Seat Reviews</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="seatReviewsModalBody">
                <!-- Reviews will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Rating Form Modal -->
<div class="modal fade" id="ratingFormModal" tabindex="-1" aria-labelledby="ratingFormModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ratingFormModalLabel">Rate This Seat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ratingForm" method="POST" action="/seat-rating">
                    @csrf
                    <input type="hidden" id="rating_bus_id" name="bus_id" value="{{ $bus->id }}">
                    <input type="hidden" id="rating_seat_name" name="seat_name">
                    <input type="hidden" id="rating_trip_date" name="trip_date" value="{{ $bus->date }}">
                    <input type="hidden" id="rating_rating" name="rating" value="5">

                    <div class="mb-3">
                        <label for="rating_seat_name_input" class="form-label">Seat Number</label>
                        <input type="text" class="form-control" id="rating_seat_name_input" placeholder="e.g., A1, B2"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <div class="star-rating">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="rating_comment" class="form-label">Comment (Optional)</label>
                        <textarea class="form-control" id="rating_comment" name="comment" rows="3" maxlength="500"
                            placeholder="Share your experience with this seat..."></textarea>
                        <div class="form-text">Maximum 500 characters</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="submitRating()">Submit Rating</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Include the same JavaScript functions from seat_view.blade.php
// (Copy the rating system functions here)

function showSeatReviews(seatName, busId) {
    const tripDate = '{{ $bus->date }}';

    const modal = document.getElementById('seatReviewsModal');
    const modalTitle = document.getElementById('seatReviewsModalLabel');
    const modalBody = document.getElementById('seatReviewsModalBody');

    modalTitle.textContent = `Reviews for Seat ${seatName}`;
    modalBody.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading reviews...</div>';

    const bootstrapModal = new bootstrap.Modal(modal);
    bootstrapModal.show();

    fetch(`/seat-reviews?bus_id=${busId}&seat_name=${seatName}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displaySeatReviews(data.data, seatName, busId, tripDate);
            } else {
                modalBody.innerHTML = '<div class="alert alert-danger">Error loading reviews</div>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            modalBody.innerHTML = '<div class="alert alert-danger">Error loading reviews</div>';
        });
}

function showRatingForm(seatName, busId, tripDate) {
    const modal = document.getElementById('ratingFormModal');
    const modalTitle = document.getElementById('ratingFormModalLabel');
    const seatNameInput = document.getElementById('rating_seat_name');
    const seatNameInputField = document.getElementById('rating_seat_name_input');
    const busIdInput = document.getElementById('rating_bus_id');
    const tripDateInput = document.getElementById('rating_trip_date');

    modalTitle.textContent = seatName ? `Rate Seat ${seatName}` : 'Rate a Seat';
    seatNameInput.value = seatName;
    seatNameInputField.value = seatName;
    busIdInput.value = busId;
    tripDateInput.value = tripDate;

    document.getElementById('ratingForm').reset();
    document.querySelectorAll('.star-rating i').forEach(star => {
        star.className = 'far fa-star';
    });

    const bootstrapModal = new bootstrap.Modal(modal);
    bootstrapModal.show();
}

// Add event listener for seat name input
document.addEventListener('DOMContentLoaded', function() {
    const seatNameInput = document.getElementById('rating_seat_name_input');
    if (seatNameInput) {
        seatNameInput.addEventListener('input', function() {
            document.getElementById('rating_seat_name').value = this.value;
        });
    }

    // Star rating interaction
    const starContainer = document.querySelector('.star-rating');
    if (starContainer) {
        const stars = starContainer.querySelectorAll('i');

        stars.forEach((star, index) => {
            star.addEventListener('mouseenter', () => {
                stars.forEach((s, i) => {
                    s.className = i <= index ? 'fas fa-star text-warning' : 'far fa-star text-warning';
                });
            });

            star.addEventListener('click', () => {
                document.getElementById('rating_rating').value = index + 1;
                updateStarDisplay(index + 1);
            });
        });

        starContainer.addEventListener('mouseleave', () => {
            const currentRating = document.getElementById('rating_rating').value;
            updateStarDisplay(currentRating);
        });
    }
});

function updateStarDisplay(rating) {
    document.querySelectorAll('.star-rating i').forEach((star, index) => {
        if (index < rating) {
            star.className = 'fas fa-star text-warning';
        } else {
            star.className = 'far fa-star text-warning';
        }
    });
}

function submitRating() {
    const form = document.getElementById('ratingForm');
    const formData = new FormData(form);

    fetch('/seat-rating', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(Object.fromEntries(formData))
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Rating submitted successfully!');
            const modal = bootstrap.Modal.getInstance(document.getElementById('ratingFormModal'));
            modal.hide();
            location.reload(); // Refresh page to show new rating
        } else {
            alert(data.message || 'Error submitting rating');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error submitting rating');
    });
}

function editRating(ratingId, currentRating, currentComment) {
    const modal = document.getElementById('ratingFormModal');
    const modalTitle = document.getElementById('ratingFormModalLabel');
    const ratingInput = document.getElementById('rating_rating');
    const commentInput = document.getElementById('rating_comment');
    const form = document.getElementById('ratingForm');

    modalTitle.textContent = 'Edit Rating';
    ratingInput.value = currentRating;
    commentInput.value = currentComment;

    updateStarDisplay(currentRating);

    form.action = `/seat-rating/${ratingId}`;
    form.method = 'PUT';

    const bootstrapModal = new bootstrap.Modal(modal);
    bootstrapModal.show();
}

function deleteRating(ratingId) {
    if (confirm('Are you sure you want to delete this rating?')) {
        fetch(`/seat-rating/${ratingId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Rating deleted successfully!');
                location.reload(); // Refresh page
            } else {
                alert(data.message || 'Error deleting rating');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting rating');
        });
    }
}
</script>

<style>
    .seat-stat-card {
        background: #f8f9fa;
        transition: all 0.3s ease;
    }

    .seat-stat-card:hover {
        background: #e9ecef;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .rating-bar .progress {
        background-color: #e9ecef;
    }

    .stat-item h3 {
        font-size: 2rem;
        font-weight: bold;
    }

    .stars-display i {
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .seat-stat-card {
            margin-bottom: 15px;
        }

        .stat-item h3 {
            font-size: 1.5rem;
        }
    }
</style>
@endsection
