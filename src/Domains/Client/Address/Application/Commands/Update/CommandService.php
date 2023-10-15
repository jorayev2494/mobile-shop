<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Address\Domain\Address;
use Project\Domains\Client\Address\Domain\AddressRepositoryInterface;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressCityUuid;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressCountryUuid;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressDistrict;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressFirstAddress;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressFullName;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressSecondAddress;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressTitle;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressUuid;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressZipCode;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class CommandService
{
    public function __construct(
        private readonly AddressRepositoryInterface $repository,
        private readonly AuthManagerInterface $authManager,
    ) {

    }

    public function execute(Command $command): void
    {
        $address = $this->repository->findByUuid(AddressUuid::fromValue($command->uuid));

        $address ?? throw new ModelNotFoundException();

        $address->changeTitle(AddressTitle::fromValue($command->title));
        $address->changeFullName(AddressFullName::fromValue($command->fullName));
        $address->changeFirstAddress(AddressFirstAddress::fromValue($command->firstAddress));
        $address->changeSecondAddress(AddressSecondAddress::fromValue($command->secondAddress));
        $address->changeZipCode(AddressZipCode::fromValue($command->zipCode));
        $address->changeFullName(AddressFullName::fromValue($command->fullName));
        $address->changeCountryUuid(AddressCountryUuid::fromValue($command->countryUuid));
        $address->changeCityUuid(AddressCityUuid::fromValue($command->cityUuid));
        $address->changeDistrict(AddressDistrict::fromValue($command->district));

        $this->repository->save($address);
    }

}
