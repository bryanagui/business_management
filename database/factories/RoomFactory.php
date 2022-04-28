<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => rand(1000, 3000),
            'floor' => rand(1, 30),
            'type' => 'Studio',
            'description' => 'Can handle a maximum of 2 persons.',
            'rate' => rand(250000, 1250000),
        ];
    }
}
