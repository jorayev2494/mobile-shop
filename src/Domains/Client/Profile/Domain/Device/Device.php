<?php

declare(strict_types=1);

namespace Project\Domains\Client\Profile\Domain\Device;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Project\Domains\Client\Profile\Domain\Profile\Profile;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[HasLifecycleCallbacks]
#[ORM\Table('profile_devices')]
final class Device extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column(type: Types::STRING)]
    private string $uuid;

    #[ORM\Column(name: 'device_id', type: Types::STRING)]
    private string $deviceId;

    #[ORM\Column(name: 'device_name', type: Types::STRING, nullable: true)]
    private string $deviceName;

    #[ORM\Column(name: 'user_agent', type: Types::STRING, nullable: true)]
    private string $userAgent;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private string $os;

    #[ORM\Column(name: 'os_version', type: Types::STRING, nullable: true)]
    private string $osVersion;

    #[ORM\Column(name: 'app_version', type: Types::STRING, nullable: true)]
    private string $appVersion;

    #[ORM\Column(name: 'ip_address', type: Types::STRING, nullable: true)]
    private string $idAddress;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private string $location;

    #[ORM\Column(name: 'author_uuid', type: Types::STRING, nullable: false)]
    private string $authorUuid;

    #[ORM\ManyToOne(targetEntity: Profile::class, inversedBy: 'devices')]
    #[ORM\JoinColumn(name: 'author_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Profile $author;

    private function __construct(string $uuid, string $deviceId)
    {
        $this->uuid = $uuid;
        // $this->authorUuid = $authorUuid;
        $this->deviceId = $deviceId;
    }

    public static function create(string $uuid, string $deviceId): self
    {
        return new self($uuid, $deviceId);
    }

    public function setAuthor(Profile $author): void
    {
        $this->author = $author;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'author_uuid' => $this->authorUuid,
            'device_id' => $this->deviceId,
        ];
    }

	public function getDeviceId(): string
    {
		return $this->deviceId;
	}

	public function getUuid(): string
    {
		return $this->uuid;
	}
}
