<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Order\Domain;

use Project\Domains\Client\Order\Domain\ValueObjects\OrderAddressUUID;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderCardUUID;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderClientUUID;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderDescription;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderEmail;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderPhone;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderUUID;
use Project\Shared\Domain\Aggregate\AggregateRoot;

final class Order extends AggregateRoot
{
    private function __construct(
        public readonly OrderUUID $uuid,
        public readonly OrderEmail $email,
        public readonly OrderPhone $phone,
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
        OrderEmail $email,
        OrderPhone $phone,
        OrderDescription $description,
        string $status,
        int $quality,
        float $sum,
        float $discardSum,
    ): self
    {
        return new self($uuid, $email, $phone, $description, $status, $quality, $sum, $discardSum, true);
    }

    public static function fromPrimitives(
        string $uuid,
        string $email,
        string $phone,
        string $description,
        string $status,
        int $quality,
        float $sum,
        float $discardSum,
        bool $isActive,
    ): self
    {
        return new self(
            OrderUUID::fromValue($uuid),
            OrderEmail::fromValue($email),
            OrderPhone::fromValue($phone),
            OrderDescription::fromValue($description),
            $status,
            $quality,
            $sum,
            $discardSum,
            $isActive,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'email' => $this->email->value,
            'phone' => $this->phone->value,
            'description' => $this->description->value,
            'status' => $this->status,
            'quality' => $this->quality,
            'sum' => $this->sum,
            'discard_sum' => $this->discardSum,
            'is_active' => $this->isActive,
        ];
    }
}
