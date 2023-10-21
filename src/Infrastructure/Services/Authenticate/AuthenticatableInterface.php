<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Authenticate;

use Illuminate\Contracts\Support\Arrayable;

interface AuthenticatableInterface extends Arrayable
{
    public function getUuid(): string;

    public function getClaims(): array;
}
