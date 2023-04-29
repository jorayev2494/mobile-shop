<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Application\Commands\Update;

use Project\Shared\Application\Command\Command;

final class UpdateCardCommand extends Command
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $type,
        public readonly string $holder_name,
        public readonly string $number,
        public readonly string $cvv,
        public readonly string $expiration_date,
        public readonly bool $is_active = true,
    )
    {
        
    }
}
