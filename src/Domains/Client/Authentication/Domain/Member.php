<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Client\Authentication\Domain\Code\Code;
use Project\Domains\Client\Authentication\Domain\Code\Events\RestorePasswordCodeWasCreatedDomainEvent;
use Project\Domains\Client\Authentication\Domain\Events\MemberWasAddedDeviceDomainEvent;
use Project\Domains\Client\Authentication\Domain\Events\MemberWasRegisteredDomainEvent;
use Project\Domains\Client\Authentication\Domain\Device\Device;
use Project\Domains\Client\Authentication\Domain\Events\DeviceWasRemovedDomainEvent;
use Project\Infrastructure\Services\Authenticate\AuthenticatableInterface;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\Table('auth_members')]
class Member extends AggregateRoot implements AuthenticatableInterface
{
    #[ORM\Id]
    #[ORM\Column(type: Types::STRING, unique: true)]
    private string $uuid;

    #[ORM\Column(type: Types::STRING, unique: true)]
    private string $email;

    #[ORM\Column(type: Types::STRING)]
    private string $password;

    #[ORM\OneToMany(targetEntity: Device::class, mappedBy: 'author', cascade: ['persist', 'remove'])]
    private Collection $devices;

    #[ORM\OneToOne(targetEntity: Code::class, mappedBy: 'author', orphanRemoval: true, cascade: ['persist', 'remove'])]
    public ?Code $code;

    private function __construct(string $uuid, string $email, string $password)
    {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->password = $password;
        $this->devices = new ArrayCollection();
    }

    public static function create(string $uuid, string $email, string $password): self
    {
        $client = new self($uuid, $email, $password);
        $client->record(new MemberWasRegisteredDomainEvent($client->uuid, $client->email));

        return $client;
    }

    public static function fromPrimitives(string $uuid, string $email, string $password): self
    {
        return new self($uuid, $email, $password);
    }

    public function addDevice(Device $device): void
    {
        $device->setAuthor($this);
        $this->devices->add($device);
        $this->record(new MemberWasAddedDeviceDomainEvent($device->getUuid(), $device->getAuthor()->getUuid(), $device->getDeviceId()));
    }

    public function removeDevice(Device $device): void
    {
        $this->devices->removeElement($device);
        $this->record(new DeviceWasRemovedDomainEvent($device->getUuid(), $this->uuid));
    }

    public function setRestorePasswordCode(Code $code): void
    {
        $this->code = $code;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function changePassword(string $password): void
    {
        $this->password = $password;
    }

    public function getDevices(): Collection
    {
        return $this->devices;
    }

    public function addCode(Code $code): void
    {
        $this->code = $code;
        $code->setAuthor($this);
        $this->record(new RestorePasswordCodeWasCreatedDomainEvent($this->uuid, $this->email, $this->code->getValue()));
    }

    public function getClaims(): array
    {
        return [];
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'email' => $this->email,
        ];
    }
}
