<?php

namespace App\Repositories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Collection;

interface LocationRepositoryInterface
{
    /**
     * @return Collection<int, Location>
     */
    public function getLocationsWithUnits(): Collection;
}
