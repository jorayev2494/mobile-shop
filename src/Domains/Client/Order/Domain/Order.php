<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Domain;

use Project\Domains\Client\Order\Domain\ValueObjects\OrderClientUUID;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderCountryUUID;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderDescription;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderEmail;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderPhone;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderStreet;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderUUID;
use Project\Shared\Domain\Aggregate\AggregateRoot;

final class Order extends AggregateRoot
{
    private function __construct(
        public readonly OrderUUID $uuid,
        public readonly OrderClientUUID $orderClientUUID,
        public readonly OrderEmail $email,
        public readonly OrderPhone $phone,
        public readonly OrderCountryUUID $countryUUID,
        public readonly OrderStreet $street,
        public readonly OrderDescription $description,
        public readonly string $status,
        public readonly int $quality,
        public readonly float $sum,
        public readonly float $discardSum,
        public readonly bool $isActive,
    )
    {
        
    }

    public static function create(
        OrderUUID $uuid,
        OrderClientUUID $orderClientUUID,
        OrderEmail $email,
        OrderPhone $phone,
        OrderCountryUUID $countryUUID,
        OrderStreet $street,
        OrderDescription $description,
        string $status,
        int $quality,
        float $sum,
        float $discardSum,
    ): self
    {
        return new self($uuid, $orderClientUUID, $email, $phone, $countryUUID, $street, $description, $status, $quality, $sum, $discardSum, true);
    }

    // public static function fromPrimitives(
    //     OrderUUID $uuid,
    //     OrderClientUUID $orderClientUUID,
    //     OrderEmail $email,
    //     OrderPhone $phone,
    //     OrderCountryUUID $countryUUID,
    //     OrderStreet $street,
    //     OrderDescription $description,
    //     iterable $products,
    //     string $status,
    //     int $quality,
    //     float $sum,
    //     float $discardSum,
    //     bool $isActive,
    // ): self
    // {
    //     return new self(
    //         $uuid,
    //         $orderClientUUID,
    //         $email,
    //         $phone,
    //         $countryUUID,
    //         $street,
    //         $description,
    //         $products,
    //         $status,
    //         $quality,
    //         $sum,
    //         $discardSum,
    //         $isActive,
    //     );
    // }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'client_uuid' => $this->orderClientUUID->value,
            'email' => $this->email->value,
            'phone' => $this->phone->value,
            'country_uuid' => $this->countryUUID->value,
            'street' => $this->street->value,
            'description' => $this->description->value,
            'status' => $this->status,
            'quality' => $this->quality,
            'sum' => $this->sum,
            'discard_sum' => $this->discardSum,
            'is_active' => $this->isActive,
        ];
    }
}
