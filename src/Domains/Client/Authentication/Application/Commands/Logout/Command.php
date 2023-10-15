<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Commands\Logout;

use Project\Shared\Domain\Bus\Command\CommandInterface;

final class Command implements CommandInterface
{
    public function __construct(
        public readonly string $deviceId,
    ) {

    }
}
