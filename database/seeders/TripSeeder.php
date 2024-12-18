<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        \DB::table('trip')->insert(['bus_id' => '1', 'line_id' => '1', 'dep_time' => '2025-04-07 02:52:04', 'arr_time' => '2025-04-07 10:52:04']);
    }
}
