<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Test\Unit\Application;

use Project\Domains\Client\Authentication\Domain\Device\Device;
use Project\Domains\Client\Authentication\Domain\Member;

class DeviceFactory
{
    public const UUID = '279993ed-b794-4832-839c-e1d5131b2fc0';

    public const REFRESH_TOKEN = '4832839ce1d5131b2fc0';

    public const DEVICE_ID = '4832-839c-e1d5131b2fc0';

    public static function make(string $uuid = null, string $refreshToken = null, string $deviceId = null): Device
    {
        return Device::fromPrimitives(
            $uuid ?? self::UUID,
            $refreshToken ?? self::REFRESH_TOKEN,
            $deviceId ?? self::DEVICE_ID,
        );
    }
}
