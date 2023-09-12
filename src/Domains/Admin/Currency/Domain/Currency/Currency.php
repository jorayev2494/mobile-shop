<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Currency\Domain\Currency;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Illuminate\Contracts\Support\Arrayable;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\CurrencyUuid;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\CurrencyValue;
use Project\Domains\Admin\Currency\Infrastructure\Doctrine\Currency\Types\UuidType;
use Project\Domains\Admin\Currency\Infrastructure\Doctrine\Currency\Types\ValueType;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'currency_currencies')]
class Currency implements Arrayable
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private CurrencyUuid $uuid;

    #[ORM\Column(type: ValueType::NAME)]
    private CurrencyValue $value;

    #[ORM\Column(name: 'is_active', type: Types::BOOLEAN)]
    private bool $isActive;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]

    private DateTimeImmutable $updatedAt;

    private function __construct(
        CurrencyUuid $uuid,
        CurrencyValue $value,
        bool $isActive,
    )
    {
        $this->uuid = $uuid;
        $this->value = $value;
        $this->isActive = $isActive;
    }

    public static function create(
        CurrencyUuid $uuid,
        CurrencyValue $value,
        bool $isActive,
    ): self
    {
        return new self($uuid, $value, $isActive);
    }

    public function getUuid(): CurrencyUuid
    {
		return $this->uuid;
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
