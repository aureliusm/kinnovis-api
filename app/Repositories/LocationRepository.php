<?php

namespace App\Repositories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Collection;

class LocationRepository implements LocationRepositoryInterface
{
    /**
     * @return Collection<int, Location>
     */
    public function getLocationsWithUnits(): Collection
    {
        return Location::has('units')->get();
    }
}
