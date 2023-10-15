<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Currency\Application\Queries\Show;

use Project\Shared\Domain\Bus\Query\QueryInterface;

final class Query implements QueryInterface
{
    public function __construct(
        public readonly string $uuid,
    )
    {
        
    }
}
