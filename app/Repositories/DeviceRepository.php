<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Device;
use App\Repositories\Base\BaseModelRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\DB;

final class DeviceRepository extends BaseModelRepository
{
    public function getModel(): string
    {
        return Device::class;
    }

    public function refreshToken(string $deviceId, string $refreshToken): Device
    {
        return DB::transaction(function () use ($deviceId, $refreshToken): Device {
            /** @var Device $device */
            $device = $this->getModelClone()->where([
                'device_id' => $deviceId,
                'refresh_token' => $refreshToken,
            ])->firstOrFail();

            if (now()->timestamp > $device->expired_at) {
                throw new AuthenticationException('Refresh token is expired');
            }

            $device->update([
                'refresh_token' => md5((string) microtime()),
                'expired_at' => now()->addDays(30),
            ]);

            return $device;
        });
    }
}
