<?php

declare(strict_types=1);

namespace Project\Domains\PublicApi\Country\Domain;

use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Project\Domains\PublicApi\Country\Domain\ValueObjects\ISO;
use Project\Domains\PublicApi\Country\Domain\ValueObjects\Uuid;
use Project\Domains\PublicApi\Country\Domain\ValueObjects\Value;

#[ORM\Entity]
#[ORM\Table(name: 'country_countries')]
final class Country
{
    #[ORM\Id]
    #[ORM\Column]
    private Uuid $uuid;

    private Value $value;

    private ISO $iso;

    private bool $isActive = true;

    private ?int $createdAt = null;

    private ?int $updatedAt = null;


    private function __construct(
        Uuid $uuid,
        Value $value,
        ISO $iso,
        bool $isActive = true,
        ?int $createdAt = null,
        ?int $updatedAt = null,
    )
    {
        $this->uuid = $uuid;
        $this->value = $value;
        $this->iso = $iso;
        $this->isActive = $isActive = true;
        $this->createdAt = $createdAt = null;
        $this->updatedAt = $updatedAt = null;
        $this->createdAt ?? new DateTimeImmutable();
        $this->updatedAt ?? new DateTimeImmutable();
    }

    public static function fromPrimitives(string $uuid, string $value, string $iso, bool $isActive, ?int $createdAt = null, ?int $updatedAt = null): self
    {
        return new self(
            Uuid::fromValue($uuid),
            Value::fromValue($value),
            ISO::fromValue($iso),
            $isActive,
            $createdAt,
            $updatedAt
        );
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
