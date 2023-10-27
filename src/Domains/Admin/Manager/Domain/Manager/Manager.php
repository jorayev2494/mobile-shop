<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Manager;

use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Project\Domains\Admin\Manager\Domain\Avatar\Avatar;
use Project\Domains\Admin\Manager\Domain\Manager\Events\ManagerRoleWasChangedDomainEvent;
use Project\Domains\Admin\Manager\Domain\Manager\Events\ManagerWasCreatedDomainEvent;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerEmail;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerFirstName;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerLastName;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerPhone;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerUuid;
use Project\Domains\Admin\Manager\Infrastructure\Doctrine\Manager\Types\EmailType;
use Project\Domains\Admin\Manager\Infrastructure\Doctrine\Manager\Types\FirstNameType;
use Project\Domains\Admin\Manager\Infrastructure\Doctrine\Manager\Types\LastNameType;
use Project\Domains\Admin\Manager\Infrastructure\Doctrine\Manager\Types\PhoneType;
use Project\Domains\Admin\Manager\Infrastructure\Doctrine\Manager\Types\UuidType;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table('manager_managers')]
class Manager extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private ManagerUuid $uuid;

    #[ORM\Column(name: 'first_name', type: FirstNameType::NAME)]
    private ManagerFirstName $firstName;

    #[ORM\Column(name: 'last_name', type: LastNameType::NAME)]
    private ManagerLastName $lastName;

    #[ORM\Column(name: 'email', type: EmailType::NAME)]
    private ManagerEmail $email;

    #[ORM\Column(name: 'phone', type: PhoneType::NAME, nullable: true)]
    private ?ManagerPhone $phone;

    #[ORM\OneToOne(targetEntity: Avatar::class, inversedBy: 'author', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'avatar_uuid', referencedColumnName: 'uuid')]
    private ?Avatar $avatar;

    #[ORM\Column(name: 'role_id', nullable: true)]
    private ?int $roleId;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updatedAt;

    private function __construct(
        ManagerUuid $uuid,
        ManagerFirstName $firstName,
        ManagerLastName $lastName,
        ManagerEmail $email,
        ManagerPhone $phone = null,
    ) {
        $this->uuid = $uuid;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
        $this->roleId = null;
    }

    public static function create(
        ManagerUuid $uuid,
        ManagerFirstName $firstName,
        ManagerLastName $lastName,
        ManagerEmail $email,
    ) {
        $manager = new self($uuid, $firstName, $lastName, $email);
        $manager->record(
            new ManagerWasCreatedDomainEvent(
                $manager->uuid->value,
                $manager->lastName->value,
                $manager->firstName->value,
                $manager->email->value,
                $manager->phone?->value,
                $manager->roleId,
            )
        );

        return $manager;
    }

    public static function fromPrimitives(string $uuid, string $firstName, string $lastName, string $email): self
    {
        $manager = new self(
            ManagerUuid::fromValue($uuid),
            ManagerFirstName::fromValue($firstName),
            ManagerLastName::fromValue($lastName),
            ManagerEmail::fromValue($email),
        );

        return $manager;
    }

    public function getUuid(): ManagerUuid
    {
        return $this->uuid;
    }

    public function getFirstName(): ManagerFirstName
    {
        return $this->firstName;
    }

    public function setFirstName(ManagerFirstName $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getAvatar(): ?Avatar
    {
        return $this->avatar;
    }

    public function setAvatar(?Avatar $avatar): void
    {
        $this->avatar = $avatar;
    }

    public function changeFirstName(ManagerFirstName $firstName): void
    {
        if ($this->firstName->isNotEquals($firstName)) {
            $this->firstName = $firstName;
        }
    }

    public function getLastName(): ManagerLastName
    {
        return $this->lastName;
    }

    public function setLastName(ManagerLastName $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function changeLastName(ManagerLastName $lastName): void
    {
        if ($this->lastName->isNotEquals($lastName)) {
            $this->lastName = $lastName;
        }
    }

    public function getEmail(): ManagerEmail
    {
        return $this->email;
    }

    public function setEmail(ManagerEmail $email): void
    {
        $this->email = $email;
    }

    public function changeEmail(ManagerEmail $email): void
    {
        if ($this->email->isNotEquals($email)) {
            $this->email = $email;
        }
    }

    public function getPhone(): ManagerPhone
    {
        return $this->phone;
    }

    public function setPhone(ManagerPhone $phone): void
    {
        $this->phone = $phone;
    }

    public function changePhone(ManagerPhone $phone): void
    {
        if ($this->phone->isNotEquals($phone)) {
            $this->phone = $phone;
        }
    }

    public function setRoleId(?int $roleId): void
    {
        $this->roleId = $roleId;
    }

    public function getRoleId(): ?int
    {
        return $this->roleId;
    }

    public function changeRoleId(int $roleId): void
    {
        if ($this->roleId !== $roleId) {
            $this->roleId = $roleId;
            $this->record(new ManagerRoleWasChangedDomainEvent($this->uuid->value, $this->roleId));
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
            'first_name' => $this->firstName->value,
            'last_name' => $this->lastName->value,
            'email' => $this->email->value,
            'avatar' => $this->avatar?->toArray(),
            'role_id' => $this->roleId,
            'phone' => $this->phone->value,
            'created_at' => $this->createdAt?->getTimestamp(),
            'updated_at' => $this->updatedAt?->getTimestamp(),
        ];
    }
}
