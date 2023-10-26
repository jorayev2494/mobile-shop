<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Domain\Address;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Client\Delivery\Domain\Address\ValueObjects\AuthorUuid;
use Project\Domains\Client\Delivery\Domain\Address\ValueObjects\CityUuid;
use Project\Domains\Client\Delivery\Domain\Address\ValueObjects\CountryUuid;
use Project\Domains\Client\Delivery\Domain\Address\ValueObjects\District;
use Project\Domains\Client\Delivery\Domain\Address\ValueObjects\FirstAddress;
use Project\Domains\Client\Delivery\Domain\Address\ValueObjects\FullName;
use Project\Domains\Client\Delivery\Domain\Address\ValueObjects\SecondAddress;
use Project\Domains\Client\Delivery\Domain\Address\ValueObjects\Title;
use Project\Domains\Client\Delivery\Domain\Address\ValueObjects\Uuid;
use Project\Domains\Client\Delivery\Domain\Address\ValueObjects\ZipCode;
use Project\Domains\Client\Delivery\Domain\Order\Order;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\Types\AuthorUuidType;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\Types\CityUuidType;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\Types\CountryUuidType;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\Types\DistrictType;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\Types\FirstAddressType;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\Types\FullNameType;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\Types\SecondAddressType;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\Types\TitleType;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\Types\UuidType;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\Types\ZipCodeType;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\Table(name: 'delivery_addresses')]
class Address extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(type: TitleType::NAME)]
    private Title $title;

    #[ORM\Column(name: 'full_name', type: FullNameType::NAME)]
    private FullName $fullName;

    #[ORM\Column(name: 'author_uuid', type: AuthorUuidType::NAME)]
    private AuthorUuid $authorUuid;

    #[ORM\Column(name: 'first_address', type: FirstAddressType::NAME)]
    private FirstAddress $firstAddress;

    #[ORM\Column(name: 'second_address', type: SecondAddressType::NAME, nullable: true)]
    private SecondAddress $secondAddress;

    #[ORM\Column(name: 'zip_code', type: ZipCodeType::NAME, length: 10, nullable: true)]
    private ZipCode $zipCode;

    #[ORM\Column(name: 'country_uuid', type: CountryUuidType::NAME)]
    private CountryUuid $countryUuid;

    #[ORM\Column(name: 'city_uuid', type: CityUuidType::NAME)]
    private CityUuid $cityUuid;

    #[ORM\Column(type: DistrictType::NAME)]
    private District $district;

    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'address', cascade: ['persist', 'remove'])]
    private Collection $orders;

    private function __construct(
        Uuid $uuid,
        Title $title,
        FullName $fullName,
        AuthorUuid $authorUuid,
        FirstAddress $firstAddress,
        SecondAddress $secondAddress,
        ZipCode $zipCode,
        CountryUuid $countryUuid,
        CityUuid $cityUuid,
        District $district,
    ) {
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
        $this->orders = new ArrayCollection();
    }

    public static function create(
        Uuid $uuid,
        Title $title,
        FullName $fullName,
        AuthorUuid $authorUuid,
        FirstAddress $firstAddress,
        SecondAddress $secondAddress,
        ZipCode $zipCode,
        CountryUuid $countryUuid,
        CityUuid $cityUuid,
        District $district,
    ): self {
        return new self($uuid, $title, $fullName, $authorUuid, $firstAddress, $secondAddress, $zipCode, $countryUuid, $cityUuid, $district);
    }

    public static function fromPrimitives(
        string $uuid,
        string $title,
        string $fullName,
        string $authorUuid,
        string $firstAddress,
        ?string $secondAddress,
        int $zipCode,
        string $countryUuid,
        string $cityUuid,
        string $district,
    ): self {
        return new self(
            Uuid::fromValue($uuid),
            Title::fromValue($title),
            FullName::fromValue($fullName),
            AuthorUuid::fromValue($authorUuid),
            FirstAddress::fromValue($firstAddress),
            SecondAddress::fromValue($secondAddress),
            ZipCode::fromValue($zipCode),
            CountryUuid::fromValue($countryUuid),
            CityUuid::fromValue($cityUuid),
            District::fromValue($district),
        );
    }

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    /**
     * @return Title
     */
    public function getTitle(): Title
    {
        return $this->title;
    }

    public function changeTitle(Title $title): void
    {
        if ($this->title->isNotEquals($title)) {
            $this->title = $title;
        }
    }

    public function getFullName(): FullName
    {
        return $this->fullName;
    }

    public function changeFullName(FullName $fullName): void
    {
        if ($this->fullName->isNotEquals($fullName)) {
            $this->fullName = $fullName;
        }
    }

    public function getAuthorUuid(): AuthorUuid
    {
        return $this->authorUuid;
    }

    public function changeAuthorUuid(AuthorUuid $authorUuid): void
    {
        if ($this->authorUuid->isNotEquals($authorUuid)) {
            $this->authorUuid = $authorUuid;
        }
    }

    public function getFirstAddress(): FirstAddress
    {
        return $this->firstAddress;
    }

    public function changeFirstAddress(FirstAddress $firstAddress): void
    {
        if ($this->firstAddress->isNotEquals($firstAddress)) {
            $this->firstAddress = $firstAddress;
        }
    }

    public function getSecondAddress(): SecondAddress
    {
        return $this->secondAddress;
    }

    public function changeSecondAddress(SecondAddress $secondAddress): void
    {
        if ($this->secondAddress->isNotEquals($secondAddress)) {
            $this->secondAddress = $secondAddress;
        }
    }

    public function getZipCode(): ZipCode
    {
        return $this->zipCode;
    }

    public function changeZipCode(ZipCode $zipCode): void
    {
        if ($this->zipCode->isNotEquals($zipCode)) {
            $this->zipCode = $zipCode;
        }
    }

    public function getCountryUuid(): CountryUuid
    {
        return $this->countryUuid;
    }

    public function changeCountryUuid(CountryUuid $countryUuid): void
    {
        if ($this->countryUuid->isNotEquals($countryUuid)) {
            $this->countryUuid = $countryUuid;
        }
    }

    public function getCityUuid(): CityUuid
    {
        return $this->cityUuid;
    }

    public function changeCityUuid(CityUuid $cityUuid): void
    {
        if ($this->cityUuid->isNotEquals($cityUuid)) {
            $this->cityUuid = $cityUuid;
        }
    }

    public function getDistrict(): District
    {
        return $this->district;
    }

    public function changeDistrict(District $district): void
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
