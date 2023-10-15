<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Application\Commands\Toggle;

use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class ToggleFavoriteCommandHandler implements CommandHandlerInterface
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
