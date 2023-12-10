<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Domain\Address\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

final class AddressWasCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $title,
        public readonly string $fullName,
        public readonly string $authorUuid,
        public readonly string $firstAddress,
        public readonly ?string $secondAddress,
        public readonly int $zipCode,
        public readonly string $countryUuid,
        public readonly string $cityUuid,
        public readonly string $district,
        string $eventId = null,
        string $occurredOn = null,
    ) {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        [
            'title' => $title,
            'full_name' => $fullName,
            'author_uuid' => $authorUuid,
            'first_address' => $firstAddress,
            'second_address' => $secondAddress,
            'zip_code' => $zipCode,
            'country_uuid' => $countryUuid,
            'city_uuid' => $cityUuid,
            'district' => $district,
        ] = $body;

        return new self($id, $title, $fullName, $authorUuid, $firstAddress, $secondAddress, $zipCode, $countryUuid, $cityUuid, $district, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'client_address.was.created';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->uuid,
            'body' => [
                'title' => $this->title,
                'full_name' => $this->fullName,
                'author_uuid' => $this->authorUuid,
                'first_address' => $this->firstAddress,
                'second_address' => $this->secondAddress,
                'zip_code' => $this->zipCode,
                'country_uuid' => $this->countryUuid,
                'city_uuid' => $this->cityUuid,
                'district' => $this->district,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
