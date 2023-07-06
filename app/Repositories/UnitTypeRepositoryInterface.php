<?php

namespace App\Repositories;

use App\Models\UnitType;
use Illuminate\Database\Eloquent\Collection;

interface UnitTypeRepositoryInterface
{
    /**
     * @return Collection<int, UnitType>
     */
    public function getUnitTypesWithUnits(): Collection;
}
