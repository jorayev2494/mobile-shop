<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Domain;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Role\Domain\ValueObjects\RoleId;
use Project\Domains\Admin\Role\Domain\ValueObjects\RoleValue;
use Project\Domains\Admin\Role\Infrastructure\Doctrine\Types\ValueType;
use Project\Domains\Admin\Role\Domain\Permission\Permission;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\Table('role_roles')]
class Role extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(type: ValueType::NAME, unique: true)]
    private RoleValue $value;

    #[ORM\ManyToMany(targetEntity: Permission::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinTable(name: 'role_roles_permissions')]
    #[ORM\JoinColumn(name: 'role_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\InverseJoinColumn(name: 'permission_id', referencedColumnName: 'id', nullable: false)]
    private Collection $permissions;

    private DateTimeInterface $createdAt;
    private DateTimeInterface $updatedAt;

    private function __construct(
        RoleValue $value,
        array $permissions = [],
    )
    {   
        $this->value = $value;
        $this->permissions = new ArrayCollection($permissions);
    }

    public static function create(RoleValue $value, array $permissions = []): self
    {
        $role = new self($value, $permissions);

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

	public function getValue(): RoleValue {
		return $this->value;
	}
	
	public function changeValue(RoleValue $value): void
    {
        if ($this->value->isNotEquals($value)) {
            $this->value = $value;
        }
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
            // 'created_at' => $this->createdAt->getTimestamp(),
            // 'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
