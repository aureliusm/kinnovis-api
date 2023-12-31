<?php

namespace App\Http\Controllers\Api\v1\Items;

use App\Enums\FilterType;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Http\Transformers\FilterOptionsTransformer;
use App\Models\Unit;
use App\Repositories\LocationRepositoryInterface;
use App\Repositories\UnitTypeRepositoryInterface;
use Illuminate\Http\Request;

class ItemFiltersController extends Controller
{
    public function __construct(
        private LocationRepositoryInterface $locationRepository,
        private UnitTypeRepositoryInterface $unitTypeRepository,
        private FilterOptionsTransformer $filterOptionsTransformer
    ) {
    }

    public function __invoke(Request $request): ApiResponse
    {
        // This could be extracted to a separate Filter service that would take care of generating these fields, but for current scope it would be a premature optimization
        $filters = [
            'search' => [
                'type' => FilterType::FULLTEXT_SEARCH,
                'label' => __('Search'),
            ],
            'location' => [
                'type' => FilterType::MULTISELECT,
                'label' => __('Location'),
                'options' => $this->filterOptionsTransformer->transformCollection(
                    // We make sure to get only locations that have at least one unit so we show
                    collection: $this->locationRepository->getLocationsWithUnits(),
                    valueField: 'name',
                    labelField: 'name'
                ),
            ],
            'unitTypeSize' => [
                'type' => FilterType::MULTISELECT,
                'label' => __('Unit type size'),
                'options' => $this->filterOptionsTransformer->transformCollection(
                    // We make sure to get only unit types that have at least one unit so we show
                    collection: $this->unitTypeRepository->getUnitTypesWithUnits(),
                    valueField: 'size',
                    labelField: 'name'
                ),
            ],
            'status' => [
                'type' => FilterType::MULTISELECT,
                'label' => __('Status'),
                'options' => $this->filterOptionsTransformer->transformEnumArray(Unit::STATUS),
            ],
        ];

        return new ApiResponse($filters);
    }
}
