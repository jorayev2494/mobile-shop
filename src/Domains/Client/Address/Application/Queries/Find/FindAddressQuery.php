<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Queries\Find;
use Project\Shared\Application\Query\Query;

final class FindAddressQuery extends Query
{
    public function __construct(
        public readonly string $uuid,
    )
    {
        
    }
}
