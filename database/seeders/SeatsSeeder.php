<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for ($i=0; $i<=12; $i++) {
            \DB::table('seats')->insert(['bus_id' => '1', 'seat_number' => $i+1]);
        }
    }
}
