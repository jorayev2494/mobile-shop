<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Domain;

use Project\Domains\Client\Favorite\Domain\Member\ValueObjects\MemberUuid;
use Project\Domains\Client\Favorite\Domain\Product\ValueObjects\ProductUuid;

final class Favorite
{
    public function __construct(
        public readonly MemberUuid $memberUuid,
        public readonly ProductUuid $productUuid,
    )
    {
        
    }
}
