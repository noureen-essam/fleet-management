<?php

namespace Database\Factories;


use App\Models\Stations;
use Illuminate\Database\Eloquent\Factories\Factory;

class StationsFactory extends Factory
{
    protected $model = Stations::class;

    public function definition()
    {
        return [
            'name' => $this->faker->city, // Adjust based on your schema
        ];
    }
}

