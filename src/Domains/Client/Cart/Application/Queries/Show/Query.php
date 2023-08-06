<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Application\Queries\Show;
use Project\Shared\Domain\Bus\Query\QueryInterface;

class Query implements QueryInterface
{
    public function __construct(
        public readonly string $uuid,
    )
    {
        
    }
}
