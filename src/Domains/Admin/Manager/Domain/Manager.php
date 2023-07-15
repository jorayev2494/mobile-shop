<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain;

use Project\Domains\Admin\Manager\Domain\ValueObjects\ManagerEmail;
use Project\Domains\Admin\Manager\Domain\ValueObjects\ManagerFirstName;
use Project\Domains\Admin\Manager\Domain\ValueObjects\ManagerLastName;
use Project\Domains\Admin\Manager\Domain\ValueObjects\ManagerPassword;
use Project\Domains\Admin\Manager\Domain\ValueObjects\ManagerUUID;
use Project\Shared\Domain\Aggregate\AggregateRoot;

class Manager extends AggregateRoot
{
    private ?ManagerPassword $password = null;

    private ?int $roleId;

    public function __construct(
        public readonly ManagerUUID $uuid,
        public readonly ManagerFirstName $firstName,
        public readonly ManagerLastName $lastName,
        public readonly ManagerEmail $email,
    )
    {
        
    }

    public static function create(
        ManagerUUID $uuid,
        ManagerFirstName $firstName,
        ManagerLastName $lastName,
        ManagerEmail $email,
    )
    {
        $manager = new self($uuid, $firstName, $lastName, $email);

        return $manager;
    }

    public static function fromPrimitives(string $uuid, string $firstName, string $lastName, string $email): self
    {
        $manager = new self(
            ManagerUUID::fromValue($uuid),
            ManagerFirstName::fromValue($firstName),
            ManagerLastName::fromValue($lastName),
            ManagerEmail::fromValue($email),
        );

        return $manager;
    }

    public function setPassword(ManagerPassword $password): void
    {
        $this->password = $password;
    }

    public function getPassword(): ?ManagerPassword
    {
        return $this->password;
    }

    public function setRoleId(?int $roleId): void
    {
        $this->roleId = $roleId;
    }

    public function getRoleId(): ?int
    {
        return $this->roleId;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'first_name' => $this->firstName->value,
            'last_name' => $this->lastName->value,
            'email' => $this->email->value,
            'password' => $this->password?->value,
            'role_id' => $this->roleId,
        ];
    }
}
