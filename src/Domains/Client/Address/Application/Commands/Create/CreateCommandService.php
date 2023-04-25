<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Commands\Create;

use Project\Domains\Client\Address\Domain\ValueObjects\AddressCityUUID;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressClientUUID;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressCountryUUID;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressDistrict;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressFirstAddress;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressFullName;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressSecondAddress;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressTitle;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressUUID;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressZipCode;
use Project\Domains\Client\Address\Domain\AddressRepositoryInterface;
use Project\Domains\Client\Address\Domain\Address;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class CreateCommandService
{
    public function __construct(
        private readonly AddressRepositoryInterface $repository,
        private readonly AuthManagerInterface $authManager,
    )
    {
        
    }

    public function execute(CreateCommand $command): array
    {
        $addressUUID = AddressUUID::generate();
        $clientUUID = AddressClientUUID::fromValue($this->authManager->client()->uuid);

        $address = Address::create(
            $addressUUID,
            AddressTitle::fromValue($command->title),
            AddressFullName::fromValue($command->full_name),
            $clientUUID,
            AddressFirstAddress::fromValue($command->first_address),
            AddressSecondAddress::fromValue($command->second_address),
            AddressZipCode::fromValue($command->zip_code),
            AddressCountryUUID::fromValue($command->country_uuid),
            AddressCityUUID::fromValue($command->city_uuid),
            AddressDistrict::fromValue($command->district),
            $command->is_active
        );

        $this->repository->save($address);

        return ['uuid' => $addressUUID->value];
    }
}
