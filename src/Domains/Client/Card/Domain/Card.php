<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Domain;

use Project\Domains\Client\Card\Domain\ValueObjects\CardClientUUID;
use Project\Domains\Client\Card\Domain\ValueObjects\CardCVV;
use Project\Domains\Client\Card\Domain\ValueObjects\CardExpirationDate;
use Project\Domains\Client\Card\Domain\ValueObjects\CardHolderName;
use Project\Domains\Client\Card\Domain\ValueObjects\CardNumber;
use Project\Domains\Client\Card\Domain\ValueObjects\CardType;
use Project\Domains\Client\Card\Domain\ValueObjects\CardUUID;

final class Card
{
    private function __construct(
        public readonly CardUUID $uuid,
        public readonly CardClientUUID $clientUUID,
        public readonly CardType $type,
        public readonly CardHolderName $holderName,
        public readonly CardNumber $number,
        public readonly CardCVV $cvv,
        public readonly CardExpirationDate $expirationDate,
        public readonly bool $isActive = true,
    )
    {
        
    }

    public static function fromPrimitives(
        string $uuid,
        string $clientUUID,
        string $type,
        string $holderName,
        string $number,
        string $cvv,
        string $expirationDate,
        bool $isActive = true,
    ): self
    {
        return new self(
            CardUUID::fromValue($uuid),
            CardClientUUID::fromValue($clientUUID),
            CardType::fromValue($type),
            CardHolderName::fromValue($holderName),
            CardNumber::fromValue($number),
            CardCVV::fromValue($cvv),
            CardExpirationDate::fromValue($expirationDate),
            $isActive
        );
    }

    public static function crate(
        CardUUID $uuid,
        CardClientUUID $clientUUID,
        CardType $type,
        CardHolderName $holderName,
        CardNumber $number,
        CardCVV $cvv,
        CardExpirationDate $expirationDate,
        bool $isActive = true,
    ): self
    {
        return new self($uuid, $clientUUID, $type, $holderName, $number, $cvv, $expirationDate, $isActive);
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'client_uuid' => $this->clientUUID->value,
            'type' => $this->type->value,
            'holder_name' => $this->holderName->value,
            'number' => $this->number->value,
            'cvv' => $this->cvv->value,
            'expiration_date' => $this->expirationDate->value,
            'is_active' => $this->isActive,
        ];
    }
}
