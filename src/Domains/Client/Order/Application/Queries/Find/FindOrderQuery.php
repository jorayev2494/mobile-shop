<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Queries\Find;

use Project\Shared\Domain\Bus\Query\QueryInterface;

final class FindOrderQuery implements QueryInterface
{
    public function __construct(
        public readonly string $uuid,
    )
    {
        
    }    
}
