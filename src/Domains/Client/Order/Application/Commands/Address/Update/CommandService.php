<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Commands\Address\Update;

use Project\Domains\Client\Order\Domain\Address\AddressRepositoryInterface;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\CityUuid;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\CountryUuid;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\District;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\FirstAddress;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\FullName;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\SecondAddress;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\Title;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\ZipCode;
use Project\Shared\Domain\DomainException;

final class CommandService
{
    public function __construct(
        private readonly AddressRepositoryInterface $repository,
    ) {

    }

    public function execute(Command $command): void
    {
        $address = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $address ?? throw new DomainException('Address not found');

        $address->changeTitle(Title::fromValue($command->title));
        $address->changeFullName(FullName::fromValue($command->fullName));
        $address->changeFirstAddress(FirstAddress::fromValue($command->firstAddress));
        $address->changeSecondAddress(SecondAddress::fromValue($command->secondAddress));
        $address->changeZipCode(ZipCode::fromValue($command->zipCode));
        $address->changeFullName(FullName::fromValue($command->fullName));
        $address->changeCountryUuid(CountryUuid::fromValue($command->countryUuid));
        $address->changeCityUuid(CityUuid::fromValue($command->cityUuid));
        $address->changeDistrict(District::fromValue($command->district));

        $this->repository->save($address);
    }

}
