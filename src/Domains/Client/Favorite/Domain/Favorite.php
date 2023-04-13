<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Domain;

final class Favorite
{
    public function __construct(
        private readonly string $clientUUID,
        private readonly string $productUUID,
    )
    {
        
    }
}
