<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $locations = \App\Models\Location::factory()->createMany([
            ['name' => 'Storeroom Innsbruck'],
            ['name' => 'Storeroom Wien'],
            ['name' => 'Storeroom Graz'],
        ]);

        $sizes = [2, 5, 8, 10, 30, 50, 100, 160];
        $locations->each(function ($location) use ($sizes) {
            foreach ($sizes as $size) {
                $unitType = \App\Models\UnitType::factory()->create([
                    'size' => $size,
                    'name' => $size.' m<sup>2</sup>',
                    'location_id' => $location->id,
                ]);

                \App\Models\Unit::factory(3)->create([
                    'location_id' => $location->id,
                    'unit_type_id' => $unitType->id,
                ]);
            }
        });
    }
}
