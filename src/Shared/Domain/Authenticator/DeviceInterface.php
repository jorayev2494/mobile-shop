<?php

declare(strict_types=1);

namespace Project\Shared\Domain\Authenticator;

use Illuminate\Contracts\Support\Arrayable;

interface DeviceInterface extends Arrayable
{
    public function getRefreshToken(): string;
}
