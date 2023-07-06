<?php

namespace Tests\Feature\Api;

use App\Models\Location;
use App\Models\Unit;
use App\Models\UnitType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ItemFiltersTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_correct_json_structure(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        foreach (range(1, 2) as $iteration) {
            Location::factory()->create(['name' => 'Location '.$iteration])->each(function ($location, $key) use ($iteration) {
                UnitType::factory()
                    ->state(function () use ($key, $location, $iteration) {
                        return [
                            'name' => '100'.$iteration.$key.' m<sup>2</sup>',
                            'size' => '100'.$iteration.$key,
                            'location_id' => $location->id,
                        ];
                    })
                    ->has(
                        Unit::factory()
                            ->state(function () use ($location) {
                                return [
                                    'location_id' => $location->id,
                                ];
                            })
                    )->create();
            });
        }

        $response = $this->get('/api/v1/items/filters');
        $response->assertStatus(200)
            ->assertJson(
                [
                    'status' => 'OK',
                    'locale' => 'en',
                    'data' => [
                        'search' => [
                            'type' => 'fulltext-search',
                            'label' => 'Search',
                        ],
                        'location' => [
                            'type' => 'multiselect',
                            'label' => 'Location',
                            'options' => [
                                [
                                    'value' => 'Location 1',
                                    'label' => 'Location 1',
                                ],
                                [
                                    'value' => 'Location 2',
                                    'label' => 'Location 2',
                                ],
                            ],
                        ],
                        'unitType' => [
                            'type' => 'multiselect',
                            'label' => 'Unit type',
                            'options' => [
                                [
                                    'value' => 10010,
                                    'label' => '10010 m<sup>2</sup>',
                                ],
                                [
                                    'value' => 10020,
                                    'label' => '10020 m<sup>2</sup>',
                                ],
                                [
                                    'value' => 10021,
                                    'label' => '10021 m<sup>2</sup>',
                                ],
                            ],
                        ],
                        'status' => [
                            'type' => 'multiselect',
                            'label' => 'Status',
                            'options' => [
                                [
                                    'value' => 'vacant',
                                    'label' => 'Vacant',
                                ],
                                [
                                    'value' => 'maintenance',
                                    'label' => 'Maintenance',
                                ],
                                [
                                    'value' => 'blocked',
                                    'label' => 'Blocked',
                                ],
                            ],
                        ],

                    ],
                ]
            );
    }

    public function test_locations_without_units_are_not_returned(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        Location::factory(10)->create();

        $response = $this->get('/api/v1/items/filters');
        $response->assertStatus(200)
            ->assertJsonFragment([
                'location' => [
                    'type' => 'multiselect',
                    'label' => 'Location',
                    'options' => [],
                ],
            ]);
    }

    public function test_unit_types_without_units_are_not_returned(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        Location::factory()->create()->each(function ($location) {
            UnitType::factory(10)->create(['location_id' => $location->id]);
        });

        $response = $this->get('/api/v1/items/filters');
        $response->assertStatus(200)
            ->assertJsonFragment([
                'unitType' => [
                    'type' => 'multiselect',
                    'label' => 'Unit type',
                    'options' => [],
                ],
            ]);
    }

    public function test_that_allowed_locales_can_be_used(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->withHeaders([
            'Accept-Language' => 'de',
        ])->get('/api/v1/items/filters');
        $response->assertStatus(200)
            ->assertJsonFragment([
                'locale' => 'de',
            ]);

        $response = $this->withHeaders([
            'Accept-Language' => 'en',
        ])->get('/api/v1/items/filters');
        $response->assertStatus(200)
            ->assertJsonFragment([
                'locale' => 'en',
            ]);

        $response = $this->get('/api/v1/items/filters');
        $response->assertStatus(200)
            ->assertJsonFragment([
                'locale' => 'en',
            ]);
    }

    public function test_that_wrong_locale_falls_back_to_fallback_locale(): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->withHeaders([
            'Accept-Language' => 'fr',
        ])->get('/api/v1/items/filters');
        $response->assertStatus(200)
            ->assertJsonFragment([
                'locale' => 'en',
            ]);
    }
}
