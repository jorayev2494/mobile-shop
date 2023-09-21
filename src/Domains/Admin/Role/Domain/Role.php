<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Domain;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Role\Domain\ValueObjects\RoleId;
use Project\Domains\Admin\Role\Domain\ValueObjects\RoleValue;
use Project\Domains\Admin\Role\Infrastructure\Doctrine\Types\ValueType;
use Project\Domains\Admin\Role\Domain\Permission\Permission;
use Project\Shared\Domain\Aggregate\AggregateRoot;

/**
 * @property-read Collection<array-key, Permission> $permissions
 */
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table('role_roles')]
class Role extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(type: ValueType::NAME, unique: true)]
    private RoleValue $value;

    #[ORM\Column(name: 'is_active', type: Types::BOOLEAN)]
    private bool $isActive;

    #[ORM\ManyToMany(targetEntity: Permission::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinTable(name: 'role_roles_permissions')]
    #[ORM\JoinColumn(name: 'role_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\InverseJoinColumn(name: 'permission_id', referencedColumnName: 'id', nullable: false)]
    private Collection $permissions;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;
    
    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updatedAt;

    private function __construct(
        RoleValue $value,
        array $permissions = [],
        bool $isActive = true,
    )
    {   
        $this->value = $value;
        $this->permissions = new ArrayCollection($permissions);
        $this->isActive = $isActive;
    }

    public static function create(RoleValue $value, array $permissions = [], bool $isActive = true): self
    {
        $role = new self($value, $permissions, $isActive);

        return $role;
    }

    public static function fromPrimitives(string $value, array $permissions = []): self
    {
        return new self(
            RoleValue::fromValue($value),
            $permissions,
        );
    }
    
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    public function addPermission(Permission $permission): void
    {
        $this->permissions->add($permission);
    }

    public function removePermission(Permission $permission): void
    {
        $this->permissions->removeElement($permission);
    }

    public function detachPermissions(): void
    {
        foreach ($this->permissions as $key => $permission) {
            $this->removePermission($permission);
        }
    }

	public function getValue(): RoleValue {
		return $this->value;
	}
	
	public function changeValue(RoleValue $value): void
    {
        if ($this->value->isNotEquals($value)) {
            $this->value = $value;
        }
	}

    #[ORM\PrePersist]
    public function prePersisting(PrePersistEventArgs $event): void
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function PreUpdating(PreUpdateEventArgs $event): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'value' => $this->value->value,
            'permissions' => array_map(
                static fn (Permission $permission): array => $permission->toArray(),
                $this->permissions->toArray()
            ),
            'is_active' => $this->isActive,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
