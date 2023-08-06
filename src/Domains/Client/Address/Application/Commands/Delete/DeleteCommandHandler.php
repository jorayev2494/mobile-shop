<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Commands\Delete;

use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class DeleteCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly DeleteService $service,
    )
    {
        
    }

    public function __invoke(DeleteCommand $command): void
    {
        $this->service->execute($command);
    }
}
