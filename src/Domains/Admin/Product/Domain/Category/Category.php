<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Category;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Product\Domain\Category\Events\CategoryWasCreatedDomainEvent;
use Project\Domains\Admin\Product\Domain\Category\Events\CategoryWasDeletedDomainEvent;
use Project\Domains\Admin\Product\Domain\Category\ValueObjects\Uuid;
use Project\Domains\Admin\Product\Domain\Category\ValueObjects\Value;
use Project\Domains\Admin\Product\Domain\Product\Product;
use Project\Domains\Admin\Product\Infrastructure\Doctrine\Category\Types\UuidType;
use Project\Domains\Admin\Product\Infrastructure\Doctrine\Category\Types\ValueType;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\Table(name: 'category_categories')]
#[ORM\HasLifecycleCallbacks]
class Category extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(type: ValueType::NAME)]
    private Value $value;

    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'category')]
    private Collection $products;

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
        $this->products = new ArrayCollection();
    }

    public static function fromPrimitives(string $uuid, string $value, bool $isActive): self
    {
        return new self(
            Uuid::fromValue($uuid),
            Value::fromValue($value),
            $isActive,
        );
    }

    public static function create(Uuid $uuid, Value $value, bool $isActive): self
    {
        $category = new self($uuid, $value, $isActive);
        $category->record(new CategoryWasCreatedDomainEvent($category->uuid->value, $category->value->value, $category->isActive));

        return $category;
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

    public function changeValue(Value $value): void
    {
        if ($this->value->isNotEquals($value)) {
            $this->value = $value;
        }
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function getProducts(): array
    {
        return $this->products->toArray();
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function changeIsActive(bool $isActive): void
    {
        if ($this->isActive === $isActive) {
            $this->isActive = $isActive;
        }
    }

    public function delete()
    {
        $this->record(new CategoryWasDeletedDomainEvent($this->uuid->value));
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
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
