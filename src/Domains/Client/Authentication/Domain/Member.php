<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Domain;

use App\Models\Auth\JWTAuth;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Client\Authentication\Domain\Code\Code;
use Project\Domains\Client\Authentication\Domain\Events\MemberWasAddedDeviceDomainEvent;
use Project\Domains\Client\Authentication\Domain\Events\MemberWasRegisteredDomainEvent;
use Project\Domains\Client\Authentication\Domain\Events\MemberWasRequestedRestoreCodePasswordDomainEvent;
use Project\Domains\Client\Authentication\Domain\Device\Device;
use Project\Domains\Client\Authentication\Domain\Events\DeviceWasRemovedDomainEvent;
use Project\Shared\Domain\Aggregate\AggregateRoot;
use Project\Shared\Domain\Authenticator\AuthenticatableInterface;

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

    #[ORM\ManyToOne(targetEntity: Device::class, inversedBy: 'author', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'device_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Collection $devices;

    #[ORM\OneToOne(targetEntity: Code::class, inversedBy: 'member', orphanRemoval: true, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'code_id', referencedColumnName: 'id', unique: true)]
    public ?Code $code;

    private function __construct(string $uuid, string $email, string $password)
    {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->password = $password;
        $this->devices = new ArrayCollection();
    }

    public static function create(string $uuid, string $firstName, string $lastName, string $email, string $password): self
    {
        $client = new self($uuid, $email, $password);
        // $client->record(new MemberWasRegisteredDomainEvent($client->uuid, $firstName, $lastName, $client->email));

        return $client;
    }

    public function addDevice(Device $device): void
    {
        $this->devices->add($device);
        $this->record(new MemberWasAddedDeviceDomainEvent($device->getUuid(), $device->getAuthor()->getUuid(), $device->getDeviceId()));
    }

    public function removeDevice(Device $device): void
    {
        $this->devices->removeElement($device);
        $this->record(new DeviceWasRemovedDomainEvent($device->getUuid(), $device->getAuthorUuid()));
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
	
	public function setDevices(ArrayCollection $devices): void
    {
		$this->devices = $devices;
	}

    public function addCode(Code $code): void
    {
        $this->code = $code;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'email' => $this->email,
        ];
    }
}
