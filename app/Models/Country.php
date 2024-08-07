<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Country
 *
 * @property string $uuid
 * @property string $value
 * @property bool $is_active
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\CountryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereValue($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $cities
 * @property-read int|null $cities_count
 * @property string $iso
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereIso($value)
 */
class Country extends Model
{
    use HasFactory;
    use HasUuids;

    protected $connection = 'admin_pgsql';

    protected $table = 'country_countries';

    protected $fillable = [
        'uuid',
        'value',
        'iso',
        'is_active',
    ];

    protected $primaryKey = 'uuid';

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'country_uuid', 'uuid');
    }

}
