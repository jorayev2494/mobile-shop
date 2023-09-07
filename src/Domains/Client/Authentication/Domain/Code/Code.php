<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Domain\Code;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Client\Authentication\Domain\Code\Events\RestorePasswordCodeWasCreatedDomainEvent;
use Project\Domains\Client\Authentication\Domain\Member;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\Table('auth_codes')]
#[ORM\HasLifecycleCallbacks]
final class Code extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(name: 'member_uuid', type: Types::STRING)]
    private string $memberUuid;

    #[ORM\Column(type: Types::INTEGER, unique: true)]
    private int $value;

    #[ORM\Column(name: 'refresh_token', type: Types::STRING, unique: true)]
    private string $refreshToken;

    #[ORM\Column(name: 'device_id', type: Types::STRING)]
    private string $deviceId;

    #[ORM\OneToOne(targetEntity: Member::class, mappedBy: 'code')]
    private Member $member;

    #[ORM\Column(name: 'expired_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $expiredAt;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updatedAt;

    private function __construct(int $value, DateTimeImmutable $expiredAt)
    {
        $this->value = $value;
        $this->expiredAt = $expiredAt;
    }

    public static function create(int $value, DateTimeImmutable $expiredAt): self
    {
        $code = new self($value, $expiredAt);
        // $code->record(new RestorePasswordCodeWasCreatedDomainEvent($member->getUuid(), $member->getEmail(), $code->value));

        return $code;
    }

    public function setMember(Member $member): void
    {
        $this->member = $member;
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

	public function getValue(): int
    {
		return $this->value;
	}
	
	public function setValue(int $value): void
    {
		$this->value = $value;
	}

	public function getExpiredAt(): DateTimeImmutable
    {
		return $this->expiredAt;
	}
	
	public function setExpiredAt(int $value): void
    {
		$this->value = $value;
	}

	public function getMemberUuid(): string
    {
		return $this->memberUuid;
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
            'id' => $this->id,
            'member_uuid' => $this->memberUuid,
            'value' => $this->value,
            'member' => $this->member->toArray(),
            'expired_at' => $this->expiredAt->getTimestamp(),
        ];
    }
}