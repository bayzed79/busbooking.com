<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bus_id',
        'seat_name',
        'rating',
        'comment',
        'trip_date'
    ];

    protected $casts = [
        'trip_date' => 'date',
        'rating' => 'integer'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buslist()
    {
        return $this->belongsTo(buslist::class, 'bus_id');
    }

    // Helper methods
    public function getAverageRatingForSeat($busId, $seatName)
    {
        return $this->where('bus_id', $busId)
            ->where('seat_name', $seatName)
            ->avg('rating');
    }

    public function getReviewsForSeat($busId, $seatName)
    {
        return $this->where('bus_id', $busId)
            ->where('seat_name', $seatName)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getRecentReviewsForBus($busId, $limit = 10)
    {
        return $this->where('bus_id', $busId)
            ->with(['user', 'bus'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    // New method to calculate average bus rating
    public static function getAverageBusRating($busId)
    {
        return self::where('bus_id', $busId)->avg('rating');
    }

    // New method to get total reviews count for a bus
    public static function getBusReviewsCount($busId)
    {
        return self::where('bus_id', $busId)->count();
    }

    // New method to get bus rating summary
    public static function getBusRatingSummary($busId)
    {
        $ratings = self::where('bus_id', $busId)->get();
        
        if ($ratings->isEmpty()) {
            return [
                'average_rating' => 0,
                'total_reviews' => 0,
                'rating_distribution' => [
                    5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0
                ]
            ];
        }

        $averageRating = $ratings->avg('rating');
        $totalReviews = $ratings->count();
        
        $ratingDistribution = [
            5 => $ratings->where('rating', 5)->count(),
            4 => $ratings->where('rating', 4)->count(),
            3 => $ratings->where('rating', 3)->count(),
            2 => $ratings->where('rating', 2)->count(),
            1 => $ratings->where('rating', 1)->count(),
        ];

        return [
            'average_rating' => round($averageRating, 1),
            'total_reviews' => $totalReviews,
            'rating_distribution' => $ratingDistribution
        ];
    }
}
