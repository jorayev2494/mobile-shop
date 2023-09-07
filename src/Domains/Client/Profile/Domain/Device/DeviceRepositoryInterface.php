<?php

declare(strict_types=1);

namespace Project\Domains\Client\Profile\Domain\Device;
use App\Repositories\Contracts\BaseEntityRepositoryInterface;

interface DeviceRepositoryInterface extends BaseEntityRepositoryInterface
{
    public function save(Device $device): void;
}
