<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Domain;

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
use Project\Shared\Domain\Aggregate\AggregateRoot;

final class Address extends AggregateRoot
{
    private function __construct(
        public readonly AddressUUID $uuid,
        public readonly AddressTitle $title,
        public readonly AddressFullName $fullName,
        public readonly AddressClientUUID $clientUUID,
        public readonly AddressFirstAddress $firstAddress,
        public readonly AddressSecondAddress $secondAddress,
        public readonly AddressZipCode $zipCode,
        public readonly AddressCountryUUID $countryUUID,
        public readonly AddressCityUUID $cityUUID,
        public readonly AddressDistrict $district,
        public readonly bool $isActive = true,
    )
    {
        
    }

    public static function create(
        AddressUUID $uuid,
        AddressTitle $title,
        AddressFullName $fullName,
        AddressClientUUID $clientUUID,
        AddressFirstAddress $firstAddress,
        AddressSecondAddress $secondAddress,
        AddressZipCode $zipCode,
        AddressCountryUUID $countryUUID,
        AddressCityUUID $cityUUID,
        AddressDistrict $district,
        bool $isActive = true,
    ): self
    {
        return new self($uuid, $title, $fullName, $clientUUID, $firstAddress, $secondAddress, $zipCode, $countryUUID, $cityUUID, $district, $isActive);
    }

    public static function fromPrimitives(
        string $uuid,
        string $title,
        string $fullName,
        string $clientUUID,
        string $firstAddress,
        string $secondAddress,
        string $zipCode,
        string $countryUUID,
        string $cityUUID,
        string $district,
        bool $isActive = true,
    ): self
    {
        return new self(
            AddressUUID::fromValue($uuid),
            AddressTitle::fromValue($title),
            AddressFullName::fromValue($fullName),
            AddressClientUUID::fromValue($clientUUID),
            AddressFirstAddress::fromValue($firstAddress),
            AddressSecondAddress::fromValue($secondAddress),
            AddressZipCode::fromValue($zipCode),
            AddressCountryUUID::fromValue($countryUUID),
            AddressCityUUID::fromValue($cityUUID),
            AddressDistrict::fromValue($district),
            $isActive            
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'title' => $this->title->value,
            'client_uuid' => $this->clientUUID->value,
            'full_name' => $this->fullName->value,
            'first_address' => $this->firstAddress->value,
            'second_address' => $this->secondAddress->value,
            'zip_code' => $this->zipCode->value,
            'country_uuid' => $this->countryUUID->value,
            'city_uuid' => $this->cityUUID->value,
            'district' => $this->district->value,
            'is_active' => $this->isActive,
        ];
    }
}
