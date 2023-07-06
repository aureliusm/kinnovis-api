<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $country
 * @property string|null $street
 * @property string|null $city
 * @property string|null $postal_code
 * @property string|null $phone
 * @property string|null $email
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class Location extends Model
{
    use HasFactory;

    public const TYPE_SELF_STORAGE = 'self-storage';

    public const TYPE_CO_WORKING = 'co-working';

    public const TYPE_CO_LIVING = 'co-living';

    public const TYPES = [
        self::TYPE_SELF_STORAGE,
        self::TYPE_CO_WORKING,
        self::TYPE_CO_LIVING,
    ];

    /**
     * @return HasMany<\App\Models\UnitType>
     */
    public function unitTypes(): HasMany
    {
        return $this->hasMany(UnitType::class);
    }

    /**
     * @return HasMany<\App\Models\Unit>
     */
    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }
}
