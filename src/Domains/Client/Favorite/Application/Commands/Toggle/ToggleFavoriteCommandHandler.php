<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Application\Commands\Toggle;

use Project\Shared\Domain\Bus\Command\CommandHandler;

final class ToggleFavoriteCommandHandler implements CommandHandler
{
    public function __construct(
        public readonly ToggleFavoriteCommandService $service,
    )
    {
        
    }

    public function __invoke(ToggleFavoriteCommand $command): void
    {
        $this->service->execute($command);
    }
}
