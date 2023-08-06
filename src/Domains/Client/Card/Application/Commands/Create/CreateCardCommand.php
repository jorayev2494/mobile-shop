<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Application\Commands\Create;

use Project\Shared\Application\Command\Command;
use Project\Shared\Domain\Bus\Command\CommandInterface;

final class CreateCardCommand extends Command implements CommandInterface
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $type,
        public readonly string $holderName,
        public readonly string $number,
        public readonly string $cvv,
        public readonly string $expiration_date,
    )
    {
        
    }
}
