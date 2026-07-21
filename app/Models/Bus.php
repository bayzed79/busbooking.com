<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SeatRating;
use App\Models\buslist;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'bus_name',
        'departing_time',
        'coach_no',
        'starting_point',
        'ending_point',
        'fare',
        'coach_type',
        'seats_available',
        'view',
        'total_seats'
    ];

    // Relationship to buslist
    public function buslist()
    {
        return $this->belongsTo(buslist::class, 'coach_no', 'coach_no');
    }

    // Get bus rating summary
    public function getRatingSummary()
    {
        $buslist_bus = buslist::where('coach_no', $this->coach_no)->first();
        if ($buslist_bus) {
            return SeatRating::getBusRatingSummary($buslist_bus->id);
        }
        
        return [
            'average_rating' => 0,
            'total_reviews' => 0,
            'rating_distribution' => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0]
        ];
    }

    // Get average rating
    public function getAverageRating()
    {
        $buslist_bus = buslist::where('coach_no', $this->coach_no)->first();
        if ($buslist_bus) {
            return SeatRating::getAverageBusRating($buslist_bus->id);
        }
        return 0;
    }

    // Get total reviews count
    public function getReviewsCount()
    {
        $buslist_bus = buslist::where('coach_no', $this->coach_no)->first();
        if ($buslist_bus) {
            return SeatRating::getBusReviewsCount($buslist_bus->id);
        }
        return 0;
    }
}
