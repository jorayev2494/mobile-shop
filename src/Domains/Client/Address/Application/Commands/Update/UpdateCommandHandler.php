<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Commands\Update;

use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class UpdateCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UpdateService $service,
    )
    {
        
    }

    public function __invoke(UpdateCommand $command): array
    {
        return $this->service->execute($command);
    }
}
