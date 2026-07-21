<?php

namespace App\Http\Controllers;

use App\Models\SeatRating;
use App\Models\Bus;
use App\Models\buslist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SeatRatingController extends Controller
{
    /**
     * Show rating form page
     */
    public function showRatingForm($busId, Request $request)
    {
        // Get the bus details directly
        $bus = Bus::findOrFail($busId);
        $busfrombuslist = buslist::where('coach_no', $bus->coach_no)->first();
        $buslist_id = $busfrombuslist ? $busfrombuslist->id : $busId;

        // Get trip date from request
        $tripDate = $request->input('trip_date');
        $seats = $request->input('seats');

        // Check if user has already rated this trip
        $userRating = SeatRating::where([
            'user_id' => Auth::id(),
            'bus_id' => $buslist_id,
            'trip_date' => $tripDate
        ])->first();

        return view('rate_trip', compact('bus', 'tripDate', 'seats', 'userRating'));
    }

    /**
     * Show seat rating modal with reviews
     */
    public function showSeatReviews(Request $request)
    {
        $busId = $request->input('bus_id');
        $seatName = $request->input('seat_name');

        // Get the bus directly
        $bus = Bus::findOrFail($busId);
        $buslist_bus = buslist::where('coach_no', $bus->coach_no)->first();
        $buslist_id = $buslist_bus ? $buslist_bus->id : $busId;

        // Get reviews using bus ID or buslist ID
        $reviews = SeatRating::whereIn('bus_id', [$buslist_id, $busId])
            ->where('seat_name', $seatName)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $averageRating = $reviews->count() > 0 ? $reviews->avg('rating') : 0;

        return response()->json([
            'success' => true,
            'data' => [
                'reviews' => $reviews,
                'average_rating' => round($averageRating, 1),
                'total_reviews' => $reviews->count(),
                'seat_name' => $seatName,
                'bus_name' => $bus->bus_name
            ]
        ]);
    }

    /**
     * Show seat ratings table for a specific seat
     */
    public function showSeatRatingsTable(Request $request)
    {
        $coachNo = $request->input('coach_no');
        $seatName = $request->input('seat_name');

        $bus = Bus::where('coach_no', $coachNo)->first();

        if (!$bus) {
            return response()->json([
                'success' => false,
                'message' => 'Bus not found in buses table'
            ], 404);
        }

        $buslist = buslist::where('coach_no', $coachNo)->first();
        $buslistId = $buslist ? $buslist->id : $bus->id;

        $ratings = SeatRating::whereIn('bus_id', [$buslistId, $bus->id])
            ->where('seat_name', $seatName)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $averageRating = $ratings->count() > 0 ? $ratings->avg('rating') : 0;

        return response()->json([
            'success' => true,
            'data' => [
                'ratings' => $ratings,
                'average_rating' => round($averageRating, 1),
                'total_reviews' => $ratings->count(),
                'seat_name' => $seatName,
                'bus_name' => $bus->bus_name,
                'coach_no' => $coachNo
            ]
        ]);
    }

    /**
     * Store a new seat rating
     */
    public function storeTest(Request $request)
    {
        $validatedData = $request->validate([
            'bus_id'    => 'required|integer|exists:buses,id',
            'trip_date' => 'required|date',
            'seat_name' => 'required|string|max:10',
            'rating'    => 'required|integer|min:1|max:5',
            'comment'   => 'required|string|max:500',
        ]);

        $bus = Bus::findOrFail($validatedData['bus_id']);
        $buslist_bus = buslist::where('coach_no', $bus->coach_no)->first();
        $buslist_id = $buslist_bus ? $buslist_bus->id : $bus->id;

        $seatRating = SeatRating::updateOrCreate(
            [
                'bus_id'    => $buslist_id,
                'user_id'   => Auth::id(),
                'trip_date' => $validatedData['trip_date'],
                'seat_name' => $validatedData['seat_name'],
            ],
            [
                'rating'    => $validatedData['rating'],
                'comment'   => $validatedData['comment'],
            ]
        );

        return redirect()->route('purchase_history')->with('success', 'Review submitted successfully!');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'bus_id' => 'required|exists:buslists,id',
                'seat_name' => 'required|string|max:10',
                'rating' => 'required|integer|between:1,5',
                'comment' => 'nullable|string|max:500',
                'trip_date' => 'required|date'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $existingRating = SeatRating::where([
                'user_id' => Auth::id(),
                'bus_id' => $request->bus_id,
                'seat_name' => $request->seat_name,
                'trip_date' => $request->trip_date
            ])->first();

            if ($existingRating) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already rated this seat for this trip.'
                ], 409);
            }

            $rating = SeatRating::create([
                'user_id' => Auth::id(),
                'bus_id' => $request->bus_id,
                'seat_name' => $request->seat_name,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'trip_date' => $request->trip_date
            ]);

            return redirect()->route('purchase_history')->with('success', 'Review submitted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while saving your review. Please try again.');
        }
    }

    /**
     * Update an existing rating
     */
    public function update(Request $request, $id)
    {
        $rating = SeatRating::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $rating->update([
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        $reviews = SeatRating::where('bus_id', $rating->bus_id)
            ->where('seat_name', $rating->seat_name)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $averageRating = $reviews->count() > 0 ? $reviews->avg('rating') : 0;

        return response()->json([
            'success' => true,
            'message' => 'Rating updated successfully!',
            'data' => [
                'rating' => $rating->load('user'),
                'reviews' => $reviews,
                'average_rating' => round($averageRating, 1),
                'total_reviews' => $reviews->count()
            ]
        ]);
    }

    /**
     * Delete a rating
     */
    public function destroy($id)
    {
        $rating = SeatRating::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $buslistId = $rating->bus_id;
        $seatName = $rating->seat_name;

        $rating->delete();

        $reviews = SeatRating::where('bus_id', $buslistId)
            ->where('seat_name', $seatName)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $averageRating = $reviews->count() > 0 ? $reviews->avg('rating') : 0;

        return response()->json([
            'success' => true,
            'message' => 'Rating deleted successfully!',
            'data' => [
                'reviews' => $reviews,
                'average_rating' => round($averageRating, 1),
                'total_reviews' => $reviews->count()
            ]
        ]);
    }

    /**
     * Get recent reviews for a bus
     */
    public function getBusReviews(Request $request)
    {
        $busId = $request->input('bus_id');
        $limit = $request->input('limit', 10);

        $bus = Bus::find($busId);
        $buslistId = $busId;
        if ($bus) {
            $buslist = buslist::where('coach_no', $bus->coach_no)->first();
            if ($buslist) {
                $buslistId = $buslist->id;
            }
        }

        $reviews = SeatRating::whereIn('bus_id', [$buslistId, $busId])
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        $totalReviews = SeatRating::whereIn('bus_id', [$buslistId, $busId])->count();

        return response()->json([
            'success' => true,
            'reviews' => $reviews,
            'total_reviews' => $totalReviews,
            'data' => [
                'reviews' => $reviews,
                'total_reviews' => $totalReviews
            ]
        ]);
    }

    /**
     * Check if user has rated a specific seat
     */
    public function checkUserRating(Request $request)
    {
        $busId = $request->input('bus_id');
        $seatName = $request->input('seat_name');
        $tripDate = $request->input('trip_date');

        $rating = SeatRating::where([
            'user_id' => Auth::id(),
            'bus_id' => $busId,
            'seat_name' => $seatName,
            'trip_date' => $tripDate
        ])->first();

        return response()->json([
            'success' => true,
            'data' => [
                'has_rated' => !is_null($rating),
                'rating' => $rating
            ]
        ]);
    }
}
