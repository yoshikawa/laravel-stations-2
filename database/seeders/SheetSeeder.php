<?php

namespace Database\Seeders;

use App\Models\Sheet;
use Illuminate\Database\Seeder;

class SheetSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $cols = 5;
        $rows = ['A', 'B', 'C'];
        $id = 1;
        for ($i = 0; $i < count($rows); $i++) {
            for ($j = 0; $j < $cols; $j++) {
                Sheet::insert([
                    'id' => $id,
                    'column' => $j + 1,
                    'row' => $rows[$i],
                ]);
                $id++;
            }
        }
    }
}