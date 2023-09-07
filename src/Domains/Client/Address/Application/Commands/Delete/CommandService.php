<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Commands\Delete;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Address\Domain\AddressRepositoryInterface;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressUuid;

final class CommandService
{
    public function __construct(
        private readonly AddressRepositoryInterface $repository,
    )
    {
        
    }

    public function execute(Command $command): void
    {
        $address = $this->repository->findByUuid(AddressUuid::fromValue($command->uuid));

        $address ?? throw new ModelNotFoundException();

        $this->repository->delete($address);
    }
}
