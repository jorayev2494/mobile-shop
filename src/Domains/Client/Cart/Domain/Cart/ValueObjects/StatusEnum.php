<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Domain\Cart\ValueObjects;

enum StatusEnum : string
{
    case DRAFT = 'draft';

    case CONFIRM = 'confirm';

    public function isEquals(self $otherStatus): bool
    {
        return $this->value === $otherStatus->value;
    }

    public function isNotEquals(self $otherStatus): bool
    {
        return $this->value !== $otherStatus->value;
    }
}
