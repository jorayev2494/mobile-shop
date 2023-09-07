<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Commands\Create;

use Project\Domains\Client\Address\Domain\ValueObjects\AddressCityUuid;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressAuthorUuid;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressCountryUuid;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressDistrict;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressFirstAddress;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressFullName;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressSecondAddress;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressTitle;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressUuid;
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

    public function execute(CreateCommand $command): void
    {
        $address = Address::create(
            AddressUuid::fromValue($command->uuid),
            AddressTitle::fromValue($command->title),
            AddressFullName::fromValue($command->fullName),
            AddressAuthorUuid::fromValue($this->authManager->client()->uuid),
            AddressFirstAddress::fromValue($command->firstAddress),
            AddressSecondAddress::fromValue($command->secondAddress),
            AddressZipCode::fromValue($command->zipCode),
            AddressCountryUuid::fromValue($command->countryUuid),
            AddressCityUuid::fromValue($command->cityUuid),
            AddressDistrict::fromValue($command->district),
        );

        $this->repository->save($address);
    }
}
