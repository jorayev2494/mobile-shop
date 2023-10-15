<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\Device
 *
 * @property int $id
 * @property int $device_able_id
 * @property string $device_able_type
 * @property string $refresh_token
 * @property string $device_id
 * @property string $device_name
 * @property string|null $user_agent
 * @property string|null $os
 * @property string|null $os_version
 * @property string|null $app_version
 * @property string|null $ip_address
 * @property string|null $location
 * @property string $expired_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Device newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device query()
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereAppVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereDeviceAbleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereDeviceAbleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereDeviceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereOs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereOsVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUserAgent($value)
 * @mixin \Eloquent
 * @property-read Model|\Eloquent $deviceAble
 * @property string $device_able_uuid
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereDeviceAbleUuid($value)
 */
class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_able_uuid',
        'device_able_type',
        'refresh_token',
        'device_id',
        'device_name',
        'user_agent',
        'os',
        'os_version',
        'app_version',
        'ip_address',
        'location',
        'expired_at',
    ];

    /**
     * @return MorphTo
     */
    public function deviceAble(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'device_able_type', 'device_able_uuid');
    }
}
