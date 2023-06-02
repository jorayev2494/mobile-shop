<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Commands\Delete;

use Project\Domains\Admin\Product\Domain\ValueObjects\ProductUUID;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class DeleteProductCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly DeleteProductService $service,
    )
    {
        
    }

    public function __invoke(DeleteProductCommand $command): void
    {
        $productUUID = ProductUUID::fromValue($command->uuid);

        $this->service->execute($productUUID);
    }
}
