<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Commands\Update;

use Project\Shared\Domain\Bus\Command\CommandInterface;

final class Command implements CommandInterface
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $title,
        public readonly string $fullName,
        public readonly string $firstAddress,
        public readonly ?string $secondAddress,
        public readonly int $zipCode,
        public readonly string $countryUuid,
        public readonly string $cityUuid,
        public readonly string $district,
    )
    {
        
    }
}
