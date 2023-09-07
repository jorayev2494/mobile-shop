<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Domain;

use Doctrine\ORM\Mapping as ORM;
use Project\Shared\Domain\Aggregate\AggregateRoot;
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
use Project\Domains\Client\Address\Infrastructure\Doctrine\Types\AuthorUuidType;
use Project\Domains\Client\Address\Infrastructure\Doctrine\Types\CityUuidType;
use Project\Domains\Client\Address\Infrastructure\Doctrine\Types\CountryUuidType;
use Project\Domains\Client\Address\Infrastructure\Doctrine\Types\DistrictType;
use Project\Domains\Client\Address\Infrastructure\Doctrine\Types\FirstAddressType;
use Project\Domains\Client\Address\Infrastructure\Doctrine\Types\FullNameType;
use Project\Domains\Client\Address\Infrastructure\Doctrine\Types\SecondAddressType;
use Project\Domains\Client\Address\Infrastructure\Doctrine\Types\TitleType;
use Project\Domains\Client\Address\Infrastructure\Doctrine\Types\UuidType;
use Project\Domains\Client\Address\Infrastructure\Doctrine\Types\ZipCodeType;

#[ORM\Entity]
#[ORM\Table(name: 'address_addresses')]
final class Address extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private AddressUuid $uuid;

    #[ORM\Column(type: TitleType::NAME)]
    private AddressTitle $title;

    #[ORM\Column(name: 'full_name', type: FullNameType::NAME)]
    private AddressFullName $fullName;

    #[ORM\Column(name: 'author_uuid', type: AuthorUuidType::NAME)]
    private AddressAuthorUuid $authorUuid;

    #[ORM\Column(name: 'first_address', type: FirstAddressType::NAME)]
    private AddressFirstAddress $firstAddress;

    #[ORM\Column(name: 'second_address', type: SecondAddressType::NAME, nullable: true)]
    private AddressSecondAddress $secondAddress;

    #[ORM\Column(name: 'zip_code', type: ZipCodeType::NAME, length: 10, nullable: true)]
    private AddressZipCode $zipCode;

    #[ORM\Column(name: 'country_uuid', type: CountryUuidType::NAME)]
    private AddressCountryUuid $countryUuid;

    #[ORM\Column(name: 'city_uuid', type: CityUuidType::NAME)]
    private AddressCityUuid $cityUuid;

    #[ORM\Column(type: DistrictType::NAME)]
    private AddressDistrict $district;

    private function __construct(
        AddressUuid $uuid,
        AddressTitle $title,
        AddressFullName $fullName,
        AddressAuthorUuid $authorUuid,
        AddressFirstAddress $firstAddress,
        AddressSecondAddress $secondAddress,
        AddressZipCode $zipCode,
        AddressCountryUuid $countryUuid,
        AddressCityUuid $cityUuid,
        AddressDistrict $district,
    )
    {
        $this->uuid = $uuid;
        $this->title = $title;
        $this->fullName = $fullName;
        $this->authorUuid = $authorUuid;
        $this->firstAddress = $firstAddress;
        $this->firstAddress = $firstAddress;
        $this->secondAddress = $secondAddress;
        $this->zipCode = $zipCode;
        $this->countryUuid = $countryUuid;
        $this->cityUuid = $cityUuid;
        $this->district = $district;
    }

    public static function create(
        AddressUuid $uuid,
        AddressTitle $title,
        AddressFullName $fullName,
        AddressAuthorUuid $clientUuid,
        AddressFirstAddress $firstAddress,
        AddressSecondAddress $secondAddress,
        AddressZipCode $zipCode,
        AddressCountryUuid $countryUuid,
        AddressCityUuid $cityUuid,
        AddressDistrict $district,
    ): self
    {
        return new self($uuid, $title, $fullName, $clientUuid, $firstAddress, $secondAddress, $zipCode, $countryUuid, $cityUuid, $district);
    }

    public static function fromPrimitives(
        string $uuid,
        string $title,
        string $fullName,
        string $clientUuid,
        string $firstAddress,
        ?string $secondAddress,
        int $zipCode,
        string $countryUuid,
        string $cityUuid,
        string $district,
    ): self
    {
        return new self(
            AddressUuid::fromValue($uuid),
            AddressTitle::fromValue($title),
            AddressFullName::fromValue($fullName),
            AddressAuthorUuid::fromValue($clientUuid),
            AddressFirstAddress::fromValue($firstAddress),
            AddressSecondAddress::fromValue($secondAddress),
            AddressZipCode::fromValue($zipCode),
            AddressCountryUuid::fromValue($countryUuid),
            AddressCityUuid::fromValue($cityUuid),
            AddressDistrict::fromValue($district),
        );
    }

	/**
	 * @return AddressUuid
	 */
	public function getUuid(): AddressUuid
    {
		return $this->uuid;
	}

	/**
	 * @return AddressTitle
	 */
	public function getTitle(): AddressTitle
    {
		return $this->title;
	}
	
	public function changeTitle(AddressTitle $title): void
    {
        if ($this->title->isNotEquals($title)) {
            $this->title = $title;
        }
	}

	public function getFullName(): AddressFullName
    {
		return $this->fullName;
	}
	
	public function changeFullName(AddressFullName $fullName): void
    {
        if ($this->fullName->isNotEquals($fullName)) {
            $this->fullName = $fullName;
        }
	}

	public function getAuthorUuid(): AddressAuthorUuid
    {
		return $this->authorUuid;
	}
	
	public function changeAuthorUuid(AddressAuthorUuid $authorUuid): void
    {
        if ($this->authorUuid->isNotEquals($authorUuid)) {
            $this->authorUuid = $authorUuid;
        }
	}

	public function getFirstAddress(): AddressFirstAddress
    {
		return $this->firstAddress;
	}
	
	public function changeFirstAddress(AddressFirstAddress $firstAddress): void
    {
        if ($this->firstAddress->isNotEquals($firstAddress)) {
            $this->firstAddress = $firstAddress;
        }
	}

	public function getSecondAddress(): AddressSecondAddress
    {
		return $this->secondAddress;
	}
	
	public function changeSecondAddress(AddressSecondAddress $secondAddress): void
    {
        if ($this->secondAddress->isNotEquals($secondAddress)) {
            $this->secondAddress = $secondAddress;
        }
	}

	public function getZipCode(): AddressZipCode
    {
		return $this->zipCode;
	}
	
	public function changeZipCode(AddressZipCode $zipCode): void
    {
        if ($this->zipCode->isNotEquals($zipCode)) {
            $this->zipCode = $zipCode;
        }
	}

	public function getCountryUuid(): AddressCountryUuid
    {
		return $this->countryUuid;
	}
	
	public function changeCountryUuid(AddressCountryUuid $countryUuid): void
    {
        if ($this->countryUuid->isNotEquals($countryUuid)) {
            $this->countryUuid = $countryUuid;
        }
	}

	public function getCityUuid(): AddressCityUuid
    {
		return $this->cityUuid;
	}
	
	public function changeCityUuid(AddressCityUuid $cityUuid): void
    {
        if ($this->cityUuid->isNotEquals($cityUuid)) {
            $this->cityUuid = $cityUuid;
        }
	}

	public function getDistrict(): AddressDistrict
    {
		return $this->district;
	}
	
	public function changeDistrict(AddressDistrict $district): void
    {
        if ($this->district->isNotEquals($district)) {
            $this->district = $district;
        }
	}

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'title' => $this->title->value,
            'author_uuid' => $this->authorUuid->value,
            'full_name' => $this->fullName->value,
            'first_address' => $this->firstAddress->value,
            'second_address' => $this->secondAddress->value,
            'zip_code' => $this->zipCode->value,
            'country_uuid' => $this->countryUuid->value,
            'city_uuid' => $this->cityUuid->value,
            'district' => $this->district->value,
        ];
    }
}
