<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Address
 *
 * @property string $uuid
 * @property string $client_uuid
 * @property string $title
 * @property string $full_name
 * @property string $first_address
 * @property string|null $second_address
 * @property int $zip_code
 * @property string $country_uuid
 * @property string $city
 * @property string|null $district
 * @property bool $is_active
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property-read \App\Models\Country $country
 * @method static \Database\Factories\AddressFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereClientUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCountryUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereFirstAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereSecondAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereZipCode($value)
 * @mixin \Eloquent
 * @property string $city_uuid
 * @property-read \App\Models\Client $client
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCityUuid($value)
 */
class Address extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'title',
        'full_name',
        'client_uuid',
        'first_address',
        'second_address',
        'zip_code',
        'country_uuid',
        'city_uuid',
        'district',
        'is_active',
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_uuid', 'uuid');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_uuid', 'uuid');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_uuid', 'uuid');
    }
}
