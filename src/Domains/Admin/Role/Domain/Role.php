<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Domain;

use Project\Domains\Admin\Role\Domain\ValueObjects\RoleId;
use Project\Domains\Admin\Role\Domain\ValueObjects\RoleValue;
use Project\Shared\Domain\Aggregate\AggregateRoot;

class Role extends AggregateRoot
{
    private function __construct(
        public readonly RoleId $id,
        public readonly RoleValue $value,
        public array $permissions = [],
        public readonly bool $isActive = true,
        // public readonly DateTimeInterface $createdAt,
        // public readonly DateTimeInterface $updatedAt,
    )
    {   
        
    }

    public static function fromPrimitives(int $id, string $value, array $permissions = [], bool $isActive = true): self
    {
        return new self(
            RoleId::fromValue($id),
            RoleValue::fromValue($value),
            $permissions,
            $isActive,
            // new DateTime('Y-m-d H:i:s'),
            // new DateTime('Y-m-d H:i:s'),
        );
    }

    public static function create(RoleId $id, RoleValue $value, array $permissions = [], bool $isActive = true): self
    {
        $role = new self(
            $id,
            $value,
            $permissions,
            $isActive,
            // new DateTime('Y-m-d H:i:s'),
            // new DateTime('Y-m-d H:i:s'),
        );

        return $role;
    }

    public function setPermissions(array $permissions): self
    {
        $this->permissions = $permissions;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value,
            'value' => $this->value->value,
            'permissions' => $this->permissions,
            'is_active' => $this->isActive,
            // 'created_at' => $this->createdAt,
            // 'updated_at' => $this->updatedAt,
        ];
    }
}
