<?php

declare(strict_types=1);

namespace Project\Domains\Client\Product\Application\Queries\Find;

use Project\Shared\Domain\Bus\Query\QueryInterface;

final class FindProductQuery implements QueryInterface
{
    public function __construct(
        public readonly string $uuid,
    )
    {
        
    }    
}
