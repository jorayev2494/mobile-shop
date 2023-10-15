<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Order\Domain\Order;

// use Project\Domains\Client\Order\Domain\Order\ValueObjects\OrderAddressUUID;
// use Project\Domains\Client\Order\Domain\Order\ValueObjects\OrderCardUUID;
// use Project\Domains\Client\Order\Domain\Order\ValueObjects\OrderClientUUID;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Description;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Email;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Phone;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\UUID;
use Project\Shared\Domain\Aggregate\AggregateRoot;

final class Order extends AggregateRoot
{
    private function __construct(
        public readonly UUID $uuid,
        public readonly Email $email,
        public readonly Phone $phone,
        // public readonly Description $description,
        public readonly string $status,
        public readonly int $quality,
        public readonly float $sum,
        public readonly float $discardSum,
        public readonly bool $isActive,
    )
    {
        
    }

    public static function create(
        UUID $uuid,
        Email $email,
        Phone $phone,
        // Description $description,
        string $status,
        int $quality,
        float $sum,
        float $discardSum,
    ): self
    {
        return new self($uuid, $email, $phone,
        // $description,
        $status, $quality, $sum, $discardSum, true);
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
            UUID::fromValue($uuid),
            Email::fromValue($email),
            Phone::fromValue($phone),
            // Description::fromValue($description),
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
            // 'description' => $this->description->value,
            'status' => $this->status,
            'quality' => $this->quality,
            'sum' => $this->sum,
            'discard_sum' => $this->discardSum,
            'is_active' => $this->isActive,
        ];
    }
}
