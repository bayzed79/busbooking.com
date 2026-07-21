<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\buslist;
use App\Models\User;
use App\Models\SeatRating;

class SeatRatingSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        if ($users->isEmpty()) {
            User::create([
                'name' => 'Demo Passenger',
                'email' => 'passenger@example.com',
                'password' => bcrypt('password123'),
                'mobile_no' => '01700000000',
            ]);
            $users = User::all();
        }

        $comments = [
            'Very comfortable seat & smooth ride!',
            'Air conditioning was great and departed right on time.',
            'Clean coach, polite staff, and safe driving.',
            'Spacious legroom and comfortable recline.',
            'Great experience, will definitely book again!',
            'Decent journey, clean window seats.',
            'Punctual service and smooth suspension.',
            'Extremely satisfied with the service and legroom!'
        ];

        $seats = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2', 'D1', 'D2'];
        $buslists = buslist::all();

        foreach ($buslists as $buslistItem) {
            if (SeatRating::where('bus_id', $buslistItem->id)->count() < 4) {
                $reviewCount = rand(4, 8);
                for ($i = 0; $i < $reviewCount; $i++) {
                    SeatRating::create([
                        'user_id' => $users->random()->id,
                        'bus_id' => $buslistItem->id,
                        'seat_name' => $seats[array_rand($seats)],
                        'rating' => rand(4, 5),
                        'comment' => $comments[array_rand($comments)],
                        'trip_date' => date('Y-m-d'),
                    ]);
                }
            }
        }
    }
}
