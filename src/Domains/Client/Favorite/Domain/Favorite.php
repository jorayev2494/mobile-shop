<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Domain;

use Project\Domains\Client\Favorite\Domain\Member\ValueObjects\MemberUUID;
use Project\Domains\Client\Favorite\Domain\Product\ValueObjects\ProductUUID;

final class Favorite
{
    public function __construct(
        public readonly MemberUUID $memberUUID,
        public readonly ProductUUID $productUUID,
    )
    {
        
    }
}
