<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bus;
use App\Models\buslist;

class BulkBusSeeder extends Seeder
{
    public function run()
    {
        $startDate = new \DateTime(date('Y-m-d'));
        $endDate = new \DateTime(date('Y-m-d', strtotime('+30 days')));
        $interval = new \DateInterval('P1D');
        $dateRange = new \DatePeriod($startDate, $interval, $endDate->modify('+1 day'));

        $masterBuses = buslist::all();
        $count = 0;

        foreach ($dateRange as $dateObj) {
            $dateStr = $dateObj->format('Y-m-d');
            foreach ($masterBuses as $template) {
                $exists = Bus::where('coach_no', $template->coach_no)
                    ->where('date', $dateStr)
                    ->first();

                if (!$exists) {
                    Bus::create([
                        'date' => $dateStr,
                        'bus_name' => $template->bus_name,
                        'departing_time' => $template->departing_time,
                        'coach_no' => $template->coach_no,
                        'starting_point' => $template->starting_point,
                        'ending_point' => $template->ending_point,
                        'fare' => $template->fare,
                        'coach_type' => $template->coach_type,
                        'seats_available' => 40,
                        'view' => str_repeat('0', 40),
                        'total_seats' => 40,
                    ]);
                    $count++;
                }
            }
        }
    }
}
