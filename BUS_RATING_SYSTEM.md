# Bus Rating System

## Overview
The bus rating system calculates average ratings for buses based on individual seat ratings. This provides users with an overall rating for each bus when searching for trips.

## How it Works

### 1. Rating Calculation
- Bus ratings are calculated from all seat ratings for that bus
- The system finds the corresponding `buslist` record using the `coach_no`
- Average rating is calculated from all seat ratings for that bus
- Rating distribution (how many 1-star, 2-star, etc.) is also tracked

### 2. Database Structure
- **SeatRating Model**: Stores individual seat ratings with `bus_id` pointing to `buslist.id`
- **Bus Model**: Contains trip-specific bus data with `coach_no` to link to `buslist`
- **buslist Model**: Contains the master bus information

### 3. Key Methods

#### SeatRating Model
- `getAverageBusRating($busId)`: Returns average rating for a bus
- `getBusReviewsCount($busId)`: Returns total number of reviews
- `getBusRatingSummary($busId)`: Returns complete rating summary with distribution

#### Bus Model
- `getRatingSummary()`: Returns rating summary for the current bus
- `getAverageRating()`: Returns average rating
- `getReviewsCount()`: Returns total reviews count

### 4. Display in Bus Table
The bus table now shows:
- **Compact Layout**: Two rows per bus for better organization
- **Star Ratings**: Visual star display with average rating
- **Review Count**: Number of total reviews
- **Rating Distribution**: Breakdown of ratings (5★, 4★, etc.)
- **Enhanced Styling**: Better visual appearance with Bootstrap and Font Awesome

### 5. Features
- **Responsive Design**: Table adapts to different screen sizes
- **Visual Indicators**: Color-coded seats availability (green for available, red for full)
- **Star Ratings**: Font Awesome stars for visual rating display
- **Rating Breakdown**: Shows distribution of ratings in the second row

## Usage

### In Controllers
```php
// Get bus rating summary
$bus = Bus::find($id);
$ratingSummary = $bus->getRatingSummary();

// Access rating data
$averageRating = $ratingSummary['average_rating'];
$totalReviews = $ratingSummary['total_reviews'];
$ratingDistribution = $ratingSummary['rating_distribution'];
```

### In Views
```blade
@include('components.bus-rating', ['rating_data' => $bus->rating_data])
```

## Testing
Use the test route to verify bus ratings:
```
GET /test-bus-rating/{id}
```

This returns JSON with bus information and rating summary for testing purposes.

## Future Enhancements
- Add sorting by rating
- Add filtering by rating range
- Add detailed bus review pages
- Add rating trends over time 