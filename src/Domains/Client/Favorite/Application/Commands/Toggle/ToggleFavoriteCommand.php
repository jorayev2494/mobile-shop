<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Application\Commands\Toggle;
use Project\Shared\Application\Command\Command;

final class ToggleFavoriteCommand extends Command
{
    public function __construct(
        public readonly string $productUUID,
    )
    {
        
    }
}
