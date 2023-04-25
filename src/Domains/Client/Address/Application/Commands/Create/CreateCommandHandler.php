<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Commands\Create;

use Project\Shared\Domain\Bus\Command\CommandHandler;

final class CreateCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly CreateCommandService $service,
    )
    {
        
    }

    public function __invoke(CreateCommand $command): array
    {
        return $this->service->execute($command);
    }
}
