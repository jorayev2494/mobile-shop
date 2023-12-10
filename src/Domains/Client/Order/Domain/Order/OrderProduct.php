<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Domain\Order;

final class OrderProduct
{
    private function __construct(
        public readonly string $uuid,
        public readonly string $order_uuid,
        public readonly string $product_uuid,
        public readonly int $quantity,
        public readonly float $sum,
        public readonly float $discardSum,
    ) {

    }

    public static function fromPrimitives(string $uuid, string $orderUUID, string $productUUID, int $quantity, float $sum, float $discardSum): self
    {
        return new self($uuid, $orderUUID, $productUUID, $quantity, $sum, $discardSum);
    }

    public static function createFromArray(array $data): self
    {
        list(
            'uuid' => $uuid,
            'order_uuid' => $orderUUID,
            'product_uuid' => $productUUID,
            '$quantity' => $quantity,
            'sum' => $sum,
            'discard_sum' => $discardSum
        ) = $data;

        return new self($uuid, $orderUUID, $productUUID, $quantity, (float) $sum, (float) $discardSum);
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'order_uuid' => $this->order_uuid,
            'product_uuid' => $this->product_uuid,
            'quality' => $this->quantity,
            'sum' => $this->sum,
            'discard_sum' => $this->discardSum,
        ];
    }
}
