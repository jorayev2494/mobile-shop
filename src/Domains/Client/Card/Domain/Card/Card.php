<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Domain\Card;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Client\Card\Domain\Card\Events\CardWasCreatedDomainEvent;
use Project\Domains\Client\Card\Domain\Card\Events\CardWasDeleteDomainEvent;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\AuthorUuid;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\CVV;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\ExpirationDate;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\HolderName;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\Number;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\Type;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\Uuid;
use Project\Domains\Client\Card\Infrastructure\Repositories\Doctrine\Card\Types\AuthorUuidType;
use Project\Domains\Client\Card\Infrastructure\Repositories\Doctrine\Card\Types\CVVType;
use Project\Domains\Client\Card\Infrastructure\Repositories\Doctrine\Card\Types\ExpirationDateType;
use Project\Domains\Client\Card\Infrastructure\Repositories\Doctrine\Card\Types\HolderNameType;
use Project\Domains\Client\Card\Infrastructure\Repositories\Doctrine\Card\Types\NumberType;
use Project\Domains\Client\Card\Infrastructure\Repositories\Doctrine\Card\Types\TypeType;
use Project\Domains\Client\Card\Infrastructure\Repositories\Doctrine\Card\Types\UuidType;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\Table('card_cards')]
final class Card extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(name: 'author_uuid', type: AuthorUuidType::NAME)]
    private AuthorUuid $authorUuid;

    #[ORM\Column(type: TypeType::NAME)]
    private Type $type;

    #[ORM\Column(name: 'holder_name', type: HolderNameType::NAME)]
    private HolderName $holderName;

    #[ORM\Column(type: NumberType::NAME)]
    private Number $number;

    #[ORM\Column(type: CVVType::NAME)]
    private CVV $cvv;

    #[ORM\Column(name: 'expiration_date', type: ExpirationDateType::NAME)]
    private ExpirationDate $expirationDate;

    private function __construct(
        Uuid $uuid,
        AuthorUuid $authorUuid,
        Type $type,
        HolderName $holderName,
        Number $number,
        CVV $cvv,
        ExpirationDate $expirationDate,
    ) {
        $this->uuid = $uuid;
        $this->authorUuid = $authorUuid;
        $this->type = $type;
        $this->holderName = $holderName;
        $this->number = $number;
        $this->cvv = $cvv;
        $this->expirationDate = $expirationDate;
    }

    public static function fromPrimitives(
        string $uuid,
        string $authorUuid,
        string $type,
        string $holderName,
        string $number,
        int $cvv,
        string $expirationDate,
    ): self {
        return new self(
            Uuid::fromValue($uuid),
            AuthorUuid::fromValue($authorUuid),
            Type::fromValue($type),
            HolderName::fromValue($holderName),
            Number::fromValue($number),
            CVV::fromValue($cvv),
            ExpirationDate::fromValue($expirationDate),
        );
    }

    public static function crate(
        Uuid $uuid,
        AuthorUuid $authorUuid,
        Type $type,
        HolderName $holderName,
        Number $number,
        CVV $cvv,
        ExpirationDate $expirationDate,
    ): self {
        $card = new self($uuid, $authorUuid, $type, $holderName, $number, $cvv, $expirationDate);
        $card->record(new CardWasCreatedDomainEvent(
            $card->uuid->value,
            $card->authorUuid->value,
            $card->type->value,
            $card->holderName->value,
            $card->number->value,
            $card->cvv->value,
            $card->expirationDate->value,
        ));

        return $card;
    }

    public function changeType(Type $type): void
    {
        if ($this->type->isNotEquals($type)) {
            $this->type = $type;
        }
    }

    public function changeHolderName(HolderName $holderName): void
    {
        if ($this->holderName->isNotEquals($holderName)) {
            $this->holderName = $holderName;
        }
    }

    public function changeNumber(Number $number): void
    {
        if ($this->number->isNotEquals($number)) {
            $this->number = $number;
        }
    }

    public function changeCVV(CVV $cvv): void
    {
        if ($this->cvv->isNotEquals($cvv)) {
            $this->cvv = $cvv;
        }
    }

    public function changeExpirationDate(ExpirationDate $expirationDate): void
    {
        if ($this->expirationDate->isNotEquals($expirationDate)) {
            $this->expirationDate = $expirationDate;
        }
    }

    public function delete()
    {
        $this->record(new CardWasDeleteDomainEvent($this->uuid->value, $this->authorUuid->value));
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'type' => $this->type->value,
            'holder_name' => $this->holderName->value,
            'number' => $this->number->value,
            'cvv' => $this->cvv->value,
            'expiration_date' => $this->expirationDate->value,
        ];
    }
}
