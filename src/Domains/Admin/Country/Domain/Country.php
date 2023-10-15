<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Domain;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryISO;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryUuid;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryValue;
use Project\Domains\Admin\Country\Infrastructure\Doctrine\Types\Country\ISOType;
use Project\Domains\Admin\Country\Infrastructure\Doctrine\Types\Country\UuidType;
use Project\Domains\Admin\Country\Infrastructure\Doctrine\Types\Country\ValueType;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\Table(name: 'country_countries')]
#[HasLifecycleCallbacks]
class Country extends AggregateRoot
{
    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updatedAt;

    private function __construct(
        #[ORM\Id]
        #[ORM\Column(name: 'uuid', type: UuidType::TYPE)]
        public CountryUuid $uuid,
        #[ORM\Column(name: 'value', type: ValueType::TYPE)]
        public CountryValue $value,
        #[ORM\Column(name: 'iso', type: ISOType::TYPE, length: 3)]
        public CountryISO $iso,
        #[ORM\Column(name: 'is_active', type: Types::BOOLEAN)]
        public bool $isActive = true,
    ) {
        //
    }

    public static function create(CountryUuid $uuid, CountryValue $value, CountryISO $iso, bool $isActive = true): self
    {
        return new self($uuid, $value, $iso, $isActive);
    }

    public function getUuid(): CountryUuid
    {
        return $this->uuid;
    }

    public function setUuid(CountryUuid $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getValue(): CountryValue
    {
        return $this->value;
    }

    public function setValue(CountryValue $value): void
    {
        $this->value = $value;
    }

    public function getISO(): CountryISO
    {
        return $this->iso;
    }

    public function setISO(CountryISO $iso): void
    {
        $this->iso = $iso;
    }

    public function getActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    #[PrePersist]
    public function prePersisting(PrePersistEventArgs $event): void
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    #[PreUpdate]
    public function PreUpdating(PreUpdateEventArgs $event): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'value' => $this->value->value,
            'iso' => $this->iso->value,
            'is_active' => $this->isActive,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
