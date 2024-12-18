<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \DB::table('buses')->insert([ 'plate_number' => '1234']);
        \DB::table('buses')->insert([ 'plate_number' => '5678']);
        \DB::table('buses')->insert([ 'plate_number' => '6789']);

    }
}
