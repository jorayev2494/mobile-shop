<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Domain\Device;

use App\Repositories\Contracts\BaseEntityRepositoryInterface;

interface DeviceRepositoryInterface extends BaseEntityRepositoryInterface
{
    public function findByRefreshToken(string $refreshToken): ?Device;

    public function findByAuthorUuidAndDeviceId(string $authorUuid, string $deviceId): ?Device;

    public function delete(Device $device): void;
}
