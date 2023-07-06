<?php

namespace Tests\Unit;

use App\Http\Transformers\FilterOptionsTransformer;
use App\Models\Location;
use App\Models\Unit;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FilterOptionsTransformerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_transforming_a_collection(): void
    {
        $locations = Location::factory(2)->create();

        $transformer = new FilterOptionsTransformer();
        $transformed = $transformer->transformCollection(
            collection: $locations,
            valueField: 'name',
            labelField: 'name'
        );

        $this->assertEquals([
            [
                'value' => $locations[0]->name,
                'label' => __($locations[0]->name),
            ],
            [
                'value' => $locations[1]->name,
                'label' => __($locations[1]->name),
            ],
        ], $transformed);
    }

    public function test_transforming_an_enum_array(): void
    {
        $transformer = new FilterOptionsTransformer();
        $transformed = $transformer->transformEnumArray(Unit::STATUS);

        $this->assertEquals([
            [
                'value' => Unit::STATUS[0],
                'label' => __(Unit::STATUS[0]),
            ],
            [
                'value' => Unit::STATUS[1],
                'label' => __(Unit::STATUS[1]),
            ],
            [
                'value' => Unit::STATUS[2],
                'label' => __(Unit::STATUS[2]),
            ],
        ], $transformed);
    }
}
