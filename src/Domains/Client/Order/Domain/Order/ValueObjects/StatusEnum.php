<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Domain\Order\ValueObjects;

enum StatusEnum : string
{
    case PENDING = 'pending';

    case APPROVED = 'approved';

    case DELIVERY = 'delivery';

    public function isEquals(self $otherStatus): bool
    {
        return $this->value === $otherStatus->value;
    }

    public function isNotEquals(self $otherStatus): bool
    {
        return $this->value !== $otherStatus->value;
    }
}
