<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Domain\Category;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Category\Domain\Category\ValueObjects\CategoryUuid;
use Project\Domains\Admin\Category\Domain\Category\ValueObjects\CategoryValue;
use Project\Domains\Admin\Category\Infrastructure\Doctrine\Category\Types\UuidType;
use Project\Domains\Admin\Category\Infrastructure\Doctrine\Category\Types\ValueType;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\Table(name: 'category_categories')]
#[ORM\HasLifecycleCallbacks]
final class Category extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private CategoryUuid $uuid;

    #[ORM\Column(type: ValueType::NAME)]
    private CategoryValue $value;

    #[ORM\Column(name: 'is_active', type: Types::BOOLEAN)]
    private bool $isActive;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updatedAt;

    private function __construct(
        CategoryUuid $uuid,
        CategoryValue $value,
        bool $isActive,
    )
    {
        $this->uuid = $uuid;
        $this->value = $value;
        $this->isActive = $isActive;
    }

    public static function fromPrimitives(string $uuid, string $value, bool $isActive): self
    {
        return new self(
            CategoryUUID::fromValue($uuid),
            CategoryValue::fromValue($value),
            $isActive,
        );
    }

    public static function create(CategoryUUID $uuid, CategoryValue $value, bool $isActive): self
    {
        return new self($uuid, $value, $isActive);
    }

    public function getUuid(): CategoryUuid
    {
		return $this->uuid;
	}

	public function getValue(): CategoryValue
    {
		return $this->value;
	}

	public function setValue(CategoryValue $value): void
    {
		$this->value = $value;
	}

    public function changeValue(CategoryValue $value): void
    {
        if ($this->value->isNotEquals($value)) {
            $this->value = $value;
        }
	}

	public function getIsActive(): bool
    {
		return $this->isActive;
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
