<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $stations = ['Cairo', 'Giza', 'AlFayyum', 'AlMinya', 'Asyut'];
        foreach ($stations as $station) {
            \DB::table('stations')->insert(['name' => $station]);
        }
    }
}
