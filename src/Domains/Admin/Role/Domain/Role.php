<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Domain;

use DateTime;
use DateTimeInterface;
use Project\Domains\Admin\Role\Domain\Events\RoleCreatedEvent;
use Project\Domains\Admin\Role\Domain\ValueObjects\RoleId;
use Project\Domains\Admin\Role\Domain\ValueObjects\RoleValue;
use Project\Shared\Domain\Aggregate\AggregateRoot;

class Role extends AggregateRoot
{
    private function __construct(
        public readonly RoleId $id,
        public readonly RoleValue $value,
        public readonly bool $isActive,
        // public readonly DateTimeInterface $createdAt,
        // public readonly DateTimeInterface $updatedAt,
    )
    {   
        
    }

    public static function fromPrimitives(int $id, string $value, bool $isActive): self
    {
        return new self(
            RoleId::fromValue($id),
            RoleValue::fromValue($value),
            $isActive,
            // new DateTime('Y-m-d H:i:s'),
            // new DateTime('Y-m-d H:i:s'),
        );
    }

    public static function create(RoleId $id, RoleValue $value, bool $isActive): self
    {
        $role = new self(
            $id,
            $value,
            $isActive,
            // new DateTime('Y-m-d H:i:s'),
            // new DateTime('Y-m-d H:i:s'),
        );

        $role->record(new RoleCreatedEvent($role));

        return $role;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value,
            'value' => $this->value->value,
            'is_active' => $this->isActive,
            // 'created_at' => $this->createdAt,
            // 'updated_at' => $this->updatedAt,
        ];
    }
}
