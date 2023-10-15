<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Currency\Domain\Currency;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Project\Domains\Admin\Currency\Domain\Currency\Events\CurrencyValueWasChangedDomainEvent;
use Project\Domains\Admin\Currency\Domain\Currency\Events\CurrencyWasCreatedDomainEvent;
use Project\Domains\Admin\Currency\Domain\Currency\Events\CurrencyWasDeletedDomainEvent;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\Uuid;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\Value;
use Project\Domains\Admin\Currency\Infrastructure\Doctrine\Currency\Types\UuidType;
use Project\Domains\Admin\Currency\Infrastructure\Doctrine\Currency\Types\ValueType;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'currency_currencies')]
class Currency extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(type: ValueType::NAME)]
    private Value $value;

    #[ORM\Column(name: 'is_active', type: Types::BOOLEAN)]
    private bool $isActive;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]

    private DateTimeImmutable $updatedAt;

    private function __construct(
        Uuid $uuid,
        Value $value,
        bool $isActive,
    ) {
        $this->uuid = $uuid;
        $this->value = $value;
        $this->isActive = $isActive;
    }

    public static function create(
        Uuid $uuid,
        Value $value,
        bool $isActive,
    ): self {
        $currency = new self($uuid, $value, $isActive);
        $currency->record(
            new CurrencyWasCreatedDomainEvent(
                $currency->getUuid()->value,
                $currency->getValue()->value,
                $currency->getIsActive()
            )
        );

        return $currency;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getValue(): Value
    {
        return $this->value;
    }

    public function changeValue(Value $value): void
    {
        if ($this->value->isNotEquals($value)) {
            $this->value = $value;
            $this->record(new CurrencyValueWasChangedDomainEvent($this->uuid->value, $this->value->value));
        }
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function changeIsActive(bool $isActive): void
    {
        if ($this->isActive !== $isActive) {
            $this->isActive = $isActive;
        }
    }

    public function delete(): void
    {
        $this->record(
            new CurrencyWasDeletedDomainEvent(
                $this->uuid->value
            )
        );
    }

    #[ORM\PrePersist]
    public function prePersist(PrePersistEventArgs $event): void
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function preUpdate(PreUpdateEventArgs $event): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'value' => $this->value->value,
            'is_active' => $this->isActive,
        ];
    }
}
