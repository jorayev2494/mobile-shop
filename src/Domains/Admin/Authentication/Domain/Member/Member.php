<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Domain\Member;

use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Project\Domains\Admin\Authentication\Domain\Code\Code;
use Project\Domains\Admin\Authentication\Domain\Device\Device;
use Project\Domains\Admin\Authentication\Domain\Member\Events\MemberRestorePasswordLinkWasAddedDomainEvent;
use Project\Domains\Admin\Authentication\Domain\Member\Events\MemberWasRegisteredDomainEvent;
use Project\Infrastructure\Services\Authenticate\AuthenticatableInterface;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'auth_members')]
class Member extends AggregateRoot implements AuthenticatableInterface
{
    #[ORM\Id]
    #[ORM\Column(unique: true)]
    private string $uuid;

    #[ORM\Column(type: Types::STRING)]
    private string $email;

    #[ORM\Column(type: Types::STRING)]
    private string $password;

    #[ORM\Column(name: 'role_id', nullable: true)]
    private ?int $roleId;

    #[ORM\OneToMany(targetEntity: Device::class, mappedBy: 'author', cascade: ['persist', 'remove'])]
    private Collection $devices;

    #[ORM\OneToOne(targetEntity: Code::class, mappedBy: 'author', orphanRemoval: true, cascade: ['persist', 'remove'])]
    public ?Code $code;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updatedAt;

    public function __construct(string $uuid, string $email, string $password)
    {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->password = $password;
        $this->roleId = null;
    }

    public static function create(string $uuid, string $firstName, string $lastName, string $email, string $password): self
    {
        $client = new self($uuid, $email, $password);
        $client->record(new MemberWasRegisteredDomainEvent($client->uuid, $client->email));

        return $client;
    }

    public function addDevice(Device $device): void
    {
        $device->setAuthor($this);
        $this->devices->add($device);
        // $this->record(new MemberWasAddedDeviceDomainEvent($device->getUuid(), $device->getAuthor()->getUuid(), $device->getDeviceId()));
    }

    public function removeDevice(Device $device): void
    {
        $this->devices->removeElement($device);
    }

    public function addCode(Code $code): void
    {
        $code->setAuthor($this);
        $this->code = $code;
        $this->record(new MemberRestorePasswordLinkWasAddedDomainEvent($this->uuid, $code->getValue(), $this->email));
    }

	public function getUuid(): string
    {
		return $this->uuid;
	}

    public function changePassword(string $password): void
    {
		$this->password = $password;
	}

    #[PrePersist]
    public function prePersist(PrePersistEventArgs $event): void
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    #[PreUpdate]
    public function preUpdate(PreUpdateEventArgs $event): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'email' => $this->email,
        ];
    }
}
