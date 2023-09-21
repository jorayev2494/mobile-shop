<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Authenticate;

use Illuminate\Contracts\Support\Arrayable;

interface DeviceInterface extends Arrayable
{
    public function getRefreshToken(): string;
}
