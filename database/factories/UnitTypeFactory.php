<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UnitType>
 */
class UnitTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $number = fake()->randomNumber(5);

        return [
            'name' => $number.' m<sup>2</sup>',
            'size' => $number,
            'short_description' => fake()->text(),
            'description' => fake()->text(),
            'is_archived' => false,
        ];
    }
}
