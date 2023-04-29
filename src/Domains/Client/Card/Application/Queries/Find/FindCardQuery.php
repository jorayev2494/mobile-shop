<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Application\Queries\Find;

use Project\Shared\Application\Query\Query;

final class FindCardQuery extends Query
{
    public function __construct(
        public readonly string $uuid,
    )
    {
        
    }
}