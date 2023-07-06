<?php

namespace App\Repositories;

use App\Models\UnitType;
use App\Repositories\UnitTypeRepositoryInterface as RepositoriesUnitTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UnitTypeRepository implements RepositoriesUnitTypeRepositoryInterface
{
    /**
     * @return Collection<int, UnitType>
     */
    public function getUnitTypesWithUnits(): Collection
    {
        return UnitType::select('size', 'name')->distinct()->has('units')->get();
    }
}
