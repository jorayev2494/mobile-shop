<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Commands\Delete;

use Project\Domains\Client\Order\Domain\ValueObjects\OrderUUID;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class DeleteOrderCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly DeleteOrderService $service,
    )
    {
        
    }

    public function __invoke(DeleteOrderCommand $command): void
    {
        $this->service->execute(OrderUUID::fromValue($command->uuid));
    }
}
