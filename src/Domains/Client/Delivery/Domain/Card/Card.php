<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Domain\Card;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\ClientUuid;
use Project\Domains\Client\Delivery\Domain\Card\ValueObjects\CVV;
use Project\Domains\Client\Delivery\Domain\Card\ValueObjects\ExpirationDate;
use Project\Domains\Client\Delivery\Domain\Card\ValueObjects\HolderName;
use Project\Domains\Client\Delivery\Domain\Card\ValueObjects\Number;
use Project\Domains\Client\Delivery\Domain\Card\ValueObjects\Type;
use Project\Domains\Client\Delivery\Domain\Card\ValueObjects\Uuid;
use Project\Domains\Client\Delivery\Domain\Customer\Customer;
use Project\Domains\Client\Delivery\Domain\Order\Order;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Card\Types\CVVType;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Card\Types\ExpirationDateType;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Card\Types\HolderNameType;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Card\Types\NumberType;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Card\Types\TypeType;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Card\Types\UuidType;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\Table(name: 'delivery_cards')]
class Card extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    // private ClientUuid $clientUuid;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'cards', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'client_uuid', referencedColumnName: 'uuid')]
    private Customer $author;

    #[ORM\Column(type: TypeType::NAME)]
    private Type $type;

    #[ORM\Column(type: HolderNameType::NAME)]
    private HolderName $holderName;

    #[ORM\Column(type: NumberType::NAME)]
    private Number $number;

    #[ORM\Column(type: CVVType::NAME)]
    private CVV $cvv;

    #[ORM\Column(type: ExpirationDateType::NAME)]
    private ExpirationDate $expirationDate;

    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'card', cascade: ['persist', 'remove'])]
    private Collection $orders;

    private function __construct(
        Uuid $uuid,
        Type $type,
        HolderName $holderName,
        Number $number,
        CVV $cvv,
        ExpirationDate $expirationDate,
    ) {
        $this->uuid = $uuid;
        $this->type = $type;
        $this->holderName = $holderName;
        $this->number = $number;
        $this->cvv = $cvv;
        $this->expirationDate = $expirationDate;
    }

    public static function fromPrimitives(
        string $uuid,
        string $type,
        string $holderName,
        string $number,
        int $cvv,
        string $expirationDate,
    ): self {
        return new self(
            Uuid::fromValue($uuid),
            Type::fromValue($type),
            HolderName::fromValue($holderName),
            Number::fromValue($number),
            CVV::fromValue($cvv),
            ExpirationDate::fromValue($expirationDate),
        );
    }

    public static function crate(
        Uuid $uuid,
        Type $type,
        HolderName $holderName,
        Number $number,
        CVV $cvv,
        ExpirationDate $expirationDate,
    ): self {
        return new self($uuid, $type, $holderName, $number, $cvv, $expirationDate);
    }

    public function setCustomer(Customer $author): void
    {
        $this->author = $author;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'author' => $this->author->toArray(),
            'type' => $this->type->value,
            'holder_name' => $this->holderName->value,
            'number' => $this->number->value,
            'cvv' => $this->cvv->value,
            'expiration_date' => $this->expirationDate->value,
        ];
    }
}
