<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Domain\Code;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
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

    #[ORM\Column(type: Types::INTEGER, unique: true)]
    private int $value;

    #[ORM\OneToOne(targetEntity: Member::class, inversedBy: 'code')]
    #[ORM\JoinColumn(name: 'author_uuid', referencedColumnName: 'uuid', unique: true)]
    private Member $author;

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

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
            'author' => $this->author->toArray(),
            'expired_at' => $this->expiredAt->getTimestamp(),
        ];
    }
}
