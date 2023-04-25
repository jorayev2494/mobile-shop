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
            $command->full_name,
            $this->authManager->client()->uuid,
            $command->first_address,
            $command->second_address,
            $command->zip_code,
            $command->country_uuid,
            $command->city_uuid,
            $command->district,
            $command->is_active,
        );

        $this->repository->save($address);

        return ['uuid' => $command->uuid];
    }

}
