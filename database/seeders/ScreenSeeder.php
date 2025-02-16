<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Screen;

class ScreenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Screen::insert([
            ['name' => 'スクリーン1'],
            ['name' => 'スクリーン2'],
            ['name' => 'スクリーン3'],
        ]);
    }
}