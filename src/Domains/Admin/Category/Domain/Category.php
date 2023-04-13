<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Domain;

use Project\Domains\Admin\Category\Domain\ValueObjects\CategoryUUID;
use Project\Domains\Admin\Category\Domain\ValueObjects\CategoryValue;
use Project\Shared\Domain\Aggregate\AggregateRoot;

final class Category extends AggregateRoot
{
    private function __construct(
        public readonly CategoryUUID $uuid,
        public readonly CategoryValue $value,
        public readonly bool $isActive,
    )
    {
        
    }

    public static function fromPrimitives(string $uuid, string $value, bool $isActive): self
    {
        return new self(
            CategoryUUID::fromValue($uuid),
            CategoryValue::fromValue($value),
            $isActive
        );
    }

    public static function create(CategoryUUID $uuid, CategoryValue $value, bool $isActive): self
    {
        return new self($uuid, $value, $isActive);
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
