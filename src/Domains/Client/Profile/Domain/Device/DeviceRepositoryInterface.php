<?php

declare(strict_types=1);

namespace Project\Domains\Client\Profile\Domain\Device;

interface DeviceRepositoryInterface
{
    public function save(Device $device): void;
}
