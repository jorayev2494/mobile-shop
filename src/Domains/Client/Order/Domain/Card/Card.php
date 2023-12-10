<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Domain\Card;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\ClientUuid;
use Project\Domains\Client\Order\Domain\Card\Events\CardWasCreatedDomainEvent;
use Project\Domains\Client\Order\Domain\Card\Events\CardWasDeletedDomainEvent;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\CVV;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\ExpirationDate;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\HolderName;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\Number;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\Type;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\Client\Client;
use Project\Domains\Client\Order\Domain\Order\Order;
use Project\Domains\Client\Order\Infrastructure\Doctrine\Card\Types\ClientUuidType;
use Project\Domains\Client\Order\Infrastructure\Doctrine\Card\Types\CVVType;
use Project\Domains\Client\Order\Infrastructure\Doctrine\Card\Types\ExpirationDateType;
use Project\Domains\Client\Order\Infrastructure\Doctrine\Card\Types\HolderNameType;
use Project\Domains\Client\Order\Infrastructure\Doctrine\Card\Types\NumberType;
use Project\Domains\Client\Order\Infrastructure\Doctrine\Card\Types\TypeType;
use Project\Domains\Client\Order\Infrastructure\Doctrine\Card\Types\UuidType;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\Table(name: 'order_cards')]
class Card extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(name: 'client_uuid', type: ClientUuidType::NAME)]
    private ClientUuid $clientUuid;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'cards', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'client_uuid', referencedColumnName: 'uuid')]
    private Client $author;

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

    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'card', cascade: ['persist', 'remove'])]
    private Collection $orders;

    private function __construct(
        Uuid $uuid,
        Client $author,
        Type $type,
        HolderName $holderName,
        Number $number,
        CVV $cvv,
        ExpirationDate $expirationDate,
    ) {
        $this->uuid = $uuid;
        $this->author = $author;
        $this->type = $type;
        $this->holderName = $holderName;
        $this->number = $number;
        $this->cvv = $cvv;
        $this->expirationDate = $expirationDate;

        $this->orders = new ArrayCollection();
    }

    public static function create(
        Uuid $uuid,
        Client $author,
        Type $type,
        HolderName $holderName,
        Number $number,
        CVV $cvv,
        ExpirationDate $expirationDate,
    ): self
    {
        return new self($uuid, $author, $type, $holderName, $number, $cvv, $expirationDate);
    }

    public static function fromPrimitives(
        string $uuid,
        Client $author,
        string $type,
        string $holderName,
        string $number,
        int $cvv,
        string $expirationDate,
    ): self {
        return new self(
            Uuid::fromValue($uuid),
            $author,
            Type::fromValue($type),
            HolderName::fromValue($holderName),
            Number::fromValue($number),
            CVV::fromValue($cvv),
            ExpirationDate::fromValue($expirationDate),
        );
    }

    public static function crate(
        Uuid $uuid,
        Client $author,
        Type $type,
        HolderName $holderName,
        Number $number,
        CVV $cvv,
        ExpirationDate $expirationDate,
    ): self {
        $card = new self($uuid, $author, $type, $holderName, $number, $cvv, $expirationDate);
        $card->record(new CardWasCreatedDomainEvent(
            $card->uuid->value,
            $card->getAuthor()->getUuid()->value,
            $card->type->value,
            $card->holderName->value,
            $card->number->value,
            $card->cvv->value,
            $card->expirationDate->value,
        ));

        return $card;
    }

    public function getUuid(): UUid
    {
        return $this->uuid;
    }

    public function getAuthor(): Client
    {
        return $this->author;
    }

    public function changeAuthor(Client $author): void
    {
        $this->author = $author;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function changeType(Type $type): void
    {
        if ($this->type->isNotEquals($type)) {
            $this->type = $type;
        }
    }

    public function getHolderName(): HolderName
    {
        return $this->holderName;
    }

    public function changeHolderName(HolderName $holderName): void
    {
        if ($this->holderName->isNotEquals($holderName)) {
            $this->holderName = $holderName;
        }
    }

    public function getNumber(): Number
    {
        return $this->number;
    }

    public function changeNumber(Number $number): void
    {
        if ($this->number->isNotEquals($number)) {
            $this->number = $number;
        }
    }

    public function getCVV(): CVV
    {
        return $this->cvv;
    }

    public function changeCVV(CVV $cvv): void
    {
        if ($this->cvv->isNotEquals($cvv)) {
            $this->cvv = $cvv;
        }
    }

    public function getExpirationDate(): ExpirationDate
    {
        return $this->expirationDate;
    }

    public function changeExpirationDate(ExpirationDate $expirationDate): void
    {
        if ($this->expirationDate->isNotEquals($expirationDate)) {
            $this->expirationDate = $expirationDate;
        }
    }

    public function delete(): void
    {
        $this->record(
            new CardWasDeletedDomainEvent(
                $this->uuid->value,
                $this->author->getUuid()->value)
        );
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
