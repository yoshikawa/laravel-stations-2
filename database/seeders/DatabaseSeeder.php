<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use App\Practice;
use Illuminate\Database\Seeder;
use Database\Seeders\SheetSeeder;
use Database\Seeders\ScreenSeeder;
use Database\Seeders\ScheduleSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Practice::factory(10)->create();
        Movie::factory(10)->create();
        Genre::factory(10)->create();
        $this->call(SheetSeeder::class);
        $this->call(ScreenSeeder::class);
        $this->call(ScheduleSeeder::class);
    }
}
