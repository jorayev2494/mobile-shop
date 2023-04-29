<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Application\Commands\Delete;

use Project\Shared\Application\Command\Command;

final class DeleteCardCommand extends Command
{
    public function __construct(
        public readonly string $uuid,
    )
    {
        
    }
}
