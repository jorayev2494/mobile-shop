<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Application\Commands\Create;
use Project\Shared\Domain\Bus\Command\CommandInterface;

class Command implements CommandInterface
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $phone,
    )
    {
        
    }
}
