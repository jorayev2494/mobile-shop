<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Commands\Login;

use Project\Shared\Domain\Bus\Command\CommandInterface;

final class Command implements CommandInterface
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly string $deviceId,
    ) {

    }
}
