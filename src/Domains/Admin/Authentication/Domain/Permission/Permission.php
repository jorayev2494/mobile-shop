<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Domain\Permission;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Support\Arrayable;
use Project\Domains\Admin\Authentication\Domain\Permission\ValueObjects\Action;
use Project\Domains\Admin\Authentication\Domain\Permission\ValueObjects\Subject;
use Project\Domains\Admin\Authentication\Domain\Permission\ValueObjects\Value;
use Project\Domains\Admin\Authentication\Domain\Role\Role;
use Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Permission\Types\ActionType;
use Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Permission\Types\SubjectType;
use Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Permission\Types\ValueType;

#[ORM\Entity]
#[ORM\Table('auth_permissions')]
final class Permission implements Arrayable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(type: ValueType::NAME)]
    private Value $value;

    #[ORM\Column(type: SubjectType::NAME)]
    private Subject $subject;

    #[ORM\Column(type: ActionType::NAME)]
    private Action $action;

    #[ORM\ManyToMany(targetEntity: Role::class, mappedBy: 'permissions', cascade: ['persist', 'remove'])]
    // #[ORM\JoinTable('roles_permissions')]
    // #[ORM\JoinColumn('permission_id', referencedColumnName: 'id')]
    private Collection $roles;

    private function __construct(
        Subject $subject,
        Action $action,
        array $roles = [],
    ) {
        $this->subject = $subject;
        $this->action = $action;
        $this->value = Value::fromValue($subject->value . '_' . $action->value);
        $this->roles = new ArrayCollection($roles);
    }

    public static function create(
        Subject $subject,
        Action $action,
    ): self {
        return new self($subject, $action);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function fromPrimitives(string $subject, string $action): self
    {
        return new self(
            Subject::fromValue($subject),
            Action::fromValue($action),
        );
    }

    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(Role $role): void
    {
        $role->addPermission($this);
        $this->roles->add($role);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'value' => $this->value->value,
            'subject' => $this->subject->value,
            'action' => $this->action->value,
        ];
    }

}
