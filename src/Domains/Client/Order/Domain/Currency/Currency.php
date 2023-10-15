<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Domain\Currency;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Illuminate\Contracts\Support\Arrayable;
use Project\Domains\Client\Order\Domain\Currency\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\Currency\ValueObjects\Value;
use Project\Domains\Client\Order\Domain\Order\Order;
use Project\Domains\Client\Order\Infrastructure\Doctrine\Currency\Types\UuidType;
use Project\Domains\Client\Order\Infrastructure\Doctrine\Currency\Types\ValueType;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'order_currencies')]
class Currency implements Arrayable
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(type: ValueType::NAME)]
    private Value $value;

    #[ORM\Column(name: 'is_active', type: Types::BOOLEAN)]
    private bool $isActive;

    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'address', cascade: ['persist', 'remove'])]
    private Collection $orders;

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
        $this->orders = new ArrayCollection();
    }

    public static function fromPrimitives(
        string $uuid,
        string $value,
        bool $isActive,
    ): self {
        return new self(Uuid::fromValue($uuid), Value::fromValue($value), $isActive);
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getValue(): Value
    {
        return $this->value;
    }

    public function setValue(Value $value): void
    {
        $this->value = $value;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
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
