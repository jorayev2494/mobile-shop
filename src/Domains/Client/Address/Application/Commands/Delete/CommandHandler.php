<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Commands\Delete;

use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CommandService $service,
    )
    {
        
    }

    public function __invoke(Command $command): void
    {
        $this->service->execute($command);
    }
}
