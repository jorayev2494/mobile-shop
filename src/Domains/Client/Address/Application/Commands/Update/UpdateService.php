<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Commands\Update;

use Project\Domains\Client\Address\Domain\Address;
use Project\Domains\Client\Address\Domain\AddressRepositoryInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class UpdateService
{
    public function __construct(
        private readonly AddressRepositoryInterface $repository,
        private readonly AuthManagerInterface $authManager,
    )
    {
        
    }

    public function execute(UpdateCommand $command): array
    {
        $address = Address::fromPrimitives(
            $command->uuid,
            $command->title,
            $command->fullName,
            $this->authManager->client()->uuid,
            $command->firstAddress,
            $command->secondAddress,
            $command->zipCode,
            $command->countryUuid,
            $command->cityUuid,
            $command->district,
        );

        $this->repository->save($address);

        return ['uuid' => $command->uuid];
    }

}
