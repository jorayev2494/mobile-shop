<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Commands\Update;

use Project\Shared\Domain\Bus\Command\CommandHandler;

final class UpdateCommandHandler implements CommandHandler
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
