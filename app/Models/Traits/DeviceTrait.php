<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Models\Device;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait DeviceTrait
{
    public function devices(): MorphMany
    {
        return $this->morphMany(Device::class, 'device_able', 'device_able_type', 'device_able_uuid');
    }

    public function addDevice(string $deviceId): Device
    {
        return $this->devices()->updateOrCreate(
            [
                'device_id' => $deviceId,
            ],
            [
                'refresh_token' => md5((string) microtime()),
                'device_id' => $deviceId,
                'device_name' => '',
                'user_agent' => '',
                'os' => '',
                'os_version' => '',
                'app_version' => '',
                'ip_address' => '',
                'location' => '',
                'expired_at' => now()->addDays(30),
            ]
        );
    }

    public function removeDevice(string $deviceId): bool
    {
        return (bool) $this->devices()->where('device_id', $deviceId)?->delete();
    }

    public function resetDevices(): void
    {
        $this->devices()->delete();
    }
}
