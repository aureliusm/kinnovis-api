<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $location_id
 * @property int $unit_type_id
 * @property string $name
 * @property string $status
 * @property int|null $floor
 * @property float|null $area
 * @property float|null $width
 * @property float|null $depth
 * @property float|null $volume
 * @property float|null $ceiling_height
 * @property float|null $door_height
 * @property float|null $door_width
 * @property string|null $door_type
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Location $location
 * @property UnitType $unitType
 */
class Unit extends Model
{
    use HasFactory;

    public const STATUS_VACANT = 'vacant';

    public const STATUS_MAINTENANCE = 'maintenance';

    public const STATUS_BLOCKED = 'blocked';

    public const DOOR_TYPE_ROLLER = 'roller_door';

    public const DOOR_TYPE_SINGLE_SWING = 'single_swing_door';

    public const DOOR_TYPE_DOUBLE_SWING = 'double_swing_door';

    public const STATUS = [
        self::STATUS_VACANT,
        self::STATUS_MAINTENANCE,
        self::STATUS_BLOCKED,
    ];

    public const DOOR_TYPE = [
        self::DOOR_TYPE_ROLLER,
        self::DOOR_TYPE_SINGLE_SWING,
        self::DOOR_TYPE_DOUBLE_SWING,
    ];

    /**
     * @return BelongsTo<Location, Unit>
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    /**
     * @return BelongsTo<UnitType, Unit>
     */
    public function unitType(): BelongsTo
    {
        return $this->belongsTo(UnitType::class, 'unit_type_id', 'id');
    }
}
