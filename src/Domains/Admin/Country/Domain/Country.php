<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Domain;

use DateTimeImmutable;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryISO;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryUUID;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryValue;

final class Country
{
    private function __construct(
        public readonly CountryUUID $uuid,
        public readonly CountryValue $value,
        public readonly CountryISO $iso,
        public readonly bool $isActive = true,
        public readonly ?int $createdAt = null,
        public readonly ?int $updatedAt = null,
    )
    {
        $this->createdAt ?? new DateTimeImmutable();
        $this->updatedAt ?? new DateTimeImmutable();
    }

    public static function fromPrimitives(string $uuid, string $value, string $iso, bool $isActive, ?int $createdAt = null, ?int $updatedAt = null): self
    {
        return new self(
            CountryUUID::fromValue($uuid),
            CountryValue::fromValue($value),
            CountryISO::fromValue($iso),
            $isActive,
            $createdAt,
            $updatedAt
        );
    }

    public static function create(CountryUUID $uuid, CountryValue $value, CountryISO $iso, bool $isActive): self
    {
        return new self($uuid, $value, $iso, $isActive);
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'value' => $this->value->value,
            'iso' => $this->iso->value,
            'is_active' => $this->isActive,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
