<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Commands\Delete;

use Project\Domains\Client\Address\Domain\AddressRepositoryInterface;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressUUID;

final class DeleteService
{
    public function __construct(
        private readonly AddressRepositoryInterface $repository,
    )
    {
        
    }

    public function execute(DeleteCommand $command): void
    {
        $this->repository->delete(AddressUUID::fromValue($command->uuid));
    }
}
