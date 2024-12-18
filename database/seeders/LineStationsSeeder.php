<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LineStationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \DB::table('line_stations')->insert(['line_id' => '1', 'station_id' => '1', 'stop_order' => '1']);
        \DB::table('line_stations')->insert(['line_id' => '1', 'station_id' => '2', 'stop_order' => '2']);
        \DB::table('line_stations')->insert(['line_id' => '1', 'station_id' => '3', 'stop_order' => '3']);
        \DB::table('line_stations')->insert(['line_id' => '1', 'station_id' => '4', 'stop_order' => '4']);
        \DB::table('line_stations')->insert(['line_id' => '1', 'station_id' => '5', 'stop_order' => '5']);

    }
}
