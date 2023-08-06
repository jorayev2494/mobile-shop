<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Commands\Create;

use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class CreateCommandHandler implements CommandHandlerInterface
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
