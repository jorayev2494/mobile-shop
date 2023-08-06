<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Queries\Find;

use Project\Shared\Domain\Bus\Query\QueryInterface;

final class FindAddressQuery implements QueryInterface
{
    public function __construct(
        public readonly string $uuid,
    )
    {
        
    }
}
