@if($rating_data['average_rating'] > 0)
    <div class="d-flex align-items-center">
        <div class="me-2">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= $rating_data['average_rating'])
                    <i class="fas fa-star text-warning"></i>
                @else
                    <i class="far fa-star text-warning"></i>
                @endif
            @endfor
        </div>
        <small class="text-muted">({{ $rating_data['total_reviews'] }})</small>
    </div>
    <small class="text-muted">{{ $rating_data['average_rating'] }}/5</small>
@else
    <small class="text-muted">No ratings yet</small>
@endif 