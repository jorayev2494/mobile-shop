<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Domain\Cart\ValueObjects;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class OrderConfirmData
{
    #[ORM\Column(name: 'card_uuid', type: Types::STRING, nullable: true)]
    public readonly string $cardUuid;

    #[ORM\Column(name: 'address_uuid', type: Types::STRING, nullable: true)]
    public readonly string $addressUuid;

    #[ORM\Column(name: 'currency_uuid', type: Types::STRING, nullable: true)]
    public readonly string $currencyUuid;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    public readonly ?string $email;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    public readonly ?string $phone;

    #[ORM\Column(name: 'promo_code', type: Types::INTEGER, nullable: true)]
    public readonly ?int $promoCode;

    #[ORM\Column(name: 'note', type: Types::TEXT, nullable: true)]
    public readonly ?string $note;

    public function __construct(string $cardUuid, string $addressUuid, string $currencyUuid, ?string $email, ?string $phone, ?int $promoCode, ?string $note)
    {
        $this->cardUuid = $cardUuid;
        $this->addressUuid = $addressUuid;
        $this->currencyUuid = $currencyUuid;
        $this->email = $email;
        $this->phone = $phone;
        $this->promoCode = $promoCode;
        $this->note = $note;
    }
}
