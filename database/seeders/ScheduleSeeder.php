<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schedule::create([
            'movie_id' => 1,
            'screen_id' => 1,
            'start_time' => '2025-02-16 10:00:00',
            'end_time' => '2025-02-16 12:00:00',
        ]);

        Schedule::create([
            'movie_id' => 2,
            'screen_id' => 2,
            'start_time' => '2025-02-16 13:00:00',
            'end_time' => '2025-02-16 15:00:00',
        ]);

        Schedule::create([
            'movie_id' => 3,
            'screen_id' => 3,
            'start_time' => '2025-02-16 16:00:00',
            'end_time' => '2025-02-16 18:00:00',
        ]);
    }
}