<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Commands\Register;

use Project\Shared\Domain\Bus\Command\CommandInterface;

class Command implements CommandInterface
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {

    }
}
