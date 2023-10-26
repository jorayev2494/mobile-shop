<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Domain\Card;

use Project\Domains\Client\Delivery\Domain\Card\ValueObjects\Uuid;

interface CardRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Card;

    public function delete(Card $card): void;
}
