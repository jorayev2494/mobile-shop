<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Domain\Cart\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

final class CartWasConfirmedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $authorUuid,
        public readonly array $cartProducts,
        public readonly string $cardUuid,
        public readonly string $addressUuid,
        public readonly string $currencyUuid,
        public readonly ?string $email,
        public readonly ?string $phone,
        public readonly ?int $promoCode,
        public readonly ?string $note,
        $eventId = null,
        $occurredOn = null
    ) {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        [
            'cart_products' => $cartProducts,
            'author_uuid' => $authorUuid,
            'card_uuid' => $cardUuid,
            'address_uuid' => $addressUuid,
            'currency_uuid' => $currencyUuid,
            'email' => $email,
            'phone' => $phone,
            'promo_code' => $promoCode,
            'note' => $note,
        ] = $body;

        return new self($id, $authorUuid, $cartProducts, $cardUuid, $addressUuid, $currencyUuid, $email, $phone, $promoCode, $note, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'client_cart.was.confirmed';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->uuid,
            'body' => [
                'cart_products' => $this->cartProducts,
                'author_uuid' => $this->authorUuid,
                'card_uuid' => $this->cardUuid,
                'address_uuid' => $this->addressUuid,
                'currency_uuid' => $this->currencyUuid,
                'email' => $this->email,
                'phone' => $this->phone,
                'promo_code' => $this->promoCode,
                'note' => $this->note,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
