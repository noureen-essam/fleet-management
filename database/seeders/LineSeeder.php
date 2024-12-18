<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \DB::table('line')->insert(['name' => 'Line1']);
        \DB::table('line')->insert(['name' => 'Line2']);
        \DB::table('line')->insert(['name' => 'Line3']);
    }
}
