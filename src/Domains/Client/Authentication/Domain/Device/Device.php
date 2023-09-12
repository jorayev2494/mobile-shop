<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Domain\Device;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Client\Authentication\Domain\Member;
use Project\Shared\Domain\Authenticator\DeviceInterface;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'auth_device')]
final class Device implements DeviceInterface
{
    #[ORM\Id]
    #[ORM\Column(type: Types::STRING)]
    private string $uuid;

    #[ORM\Column(name: 'refresh_token', type: Types::STRING, unique: true)]
    private string $refreshToken;

    #[ORM\Column(name: 'device_id', type: Types::STRING)]
    private string $deviceId;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private string $os;

    #[ORM\Column(name: 'os_version', type: Types::STRING, nullable: true)]
    private string $osVersion;

    #[ORM\Column(name: 'app_version', type: Types::STRING, nullable: true)]
    private string $appVersion;

    #[ORM\Column(name: 'ip_address', type: Types::STRING, nullable: true)]
    private string $idAddress;

    #[ORM\Column(name: 'author_uuid', type: Types::STRING)]
    private string $authorUuid;

    #[ORM\ManyToOne(targetEntity: Member::class, inversedBy: 'devices', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'author_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Member $author;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updatedAt;

    private function __construct(
        string $uuid,
        string $refreshToken,
        string $deviceId,
    )
    {
        $this->uuid = $uuid;
        $this->refreshToken = $refreshToken;
        $this->deviceId = $deviceId;
    }

    public static function create(
        string $uuid,
        string $refreshToken,
        string $deviceId,
    ): self
    {
        $code = new self($uuid, $refreshToken,$deviceId);

        return $code;
    }

    public function delete(): void
    {
        
    }

    public function getUuid(): string
    {
		return $this->uuid;
	}

    public function getAuthor(): Member
    {
        return $this->author;
    }

    public function setAuthor(Member $author): void
    {
        $this->author = $author;
    }

    #[ORM\PrePersist]
    public function prePersisting(PrePersistEventArgs $event): void
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function preUpdating(PreUpdateEventArgs $event): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

	public function getAuthorUuid(): string
    {
		return $this->authorUuid;
	}

    public function getRefreshToken(): string
    {
		return $this->refreshToken;
	}
	
	public function setRefreshToken(string $refreshToken): void
    {
		$this->refreshToken = $refreshToken;
	}

    public function getDeviceId(): string
    {
		return $this->deviceId;
	}
	
	public function setDeviceId(string $deviceId): void
    {
		$this->deviceId = $deviceId;
	}

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'author_uuid' => $this->authorUuid,
            'author' => $this->author->toArray(),
        ];
    }
}
